<?php

namespace App\Http\Middleware;

use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\IdTokenVerifier;
use Auth0\SDK\Helpers\Tokens\SymmetricVerifier;
use Closure;

class CheckIdToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // リクエストヘッダにBearerトークンが存在するか確認
        if (empty($request->bearerToken())) {
            return response()->json(["message" => "Token dose not exist"], 401);
        }

        $id_token = $request->bearerToken();

        // JWTのヘッダー部分を取得し、デコードしてalgを取り出す
        $id_token_header = explode('.', $id_token)[0];

        try {
            $token_alg = json_decode(base64_decode($id_token_header))->alg;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        }

        $token_issuer = 'https://' . config('const.auth0.domain') . '/';

        $signature_verifier = null;

        // id tokenを検証するためのVerifierクラスを呼び出す
        // RS256のみで検証したい場合はHS256の分岐を削除する
        if ('RS256' === $token_alg) {
            // 指定したissuerからjwksを取得し、証明書(CERTIFICATE)で取得する
            $jwks_fetcher = new JWKFetcher();
            $jwks = $jwks_fetcher->getKeys($token_issuer.'.well-known/jwks.json');
            $signature_verifier = new AsymmetricVerifier($jwks);
        } else if ('HS256' === $token_alg) {
            $signature_verifier = new SymmetricVerifier(config('const.auth0.client_secret'));
        } else {
            return response()->json(["message" => "Invalid alg"]);
        }

        $token_verifier = new IdTokenVerifier(
            $token_issuer,
            config('const.auth0.client_id'),
            $signature_verifier
        );

        // トークンを検証する
        try {
            $decoded_token = $token_verifier->verify($id_token);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        }

        // user_idを$requestに追加する。
        $request->merge([
            'auth0_email' => $decoded_token['email']
        ]);

        return $next($request);
    }
}