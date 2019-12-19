<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\SocialUser;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        return $user;
    }

    protected function loggedOut(Request $request)
    {
        // セッションを再生成する
        $request->session()->regenerate();

        return response()->json();
    }

    /**
     * ソーシャル認証 リクエスト
     * @return mixed
     */
    public function socialLogin()
    {
        $social = basename(parse_url($this->getUrl(), PHP_URL_PATH));
        return Socialite::with($social)->redirect();
    }

    private function getUrl()
    {
        return (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    }

    public function socialCallback()
    {
        $social = basename(parse_url($this->getUrl(), PHP_URL_PATH));
        $providerUser = Socialite::driver($social)->user();

        // 既に存在するユーザーかを確認
        $socialUser = SocialUser::where('provider_user_id', $providerUser->id)->first();

        if ($socialUser) {
            // 既存のユーザーはログインしてトップページへ
            Auth::login($socialUser->user, true);
            return redirect('/index');
        }

        // 新しいユーザーを作成
        $user = new User();
        $user->unique_id = $providerUser->nickname;
        $user->name = $providerUser->name;
        $user->avatar = $providerUser->user['profile_image_url_https'];
        $user->bio = $providerUser->user['description'];

        $socialUser = new SocialUser();
        $socialUser->provider_user_id = $providerUser->id;

        DB::transaction(function () use ($user, $socialUser) {
            $user->save();
            $user->socialUsers()->save($socialUser);
        });

        Auth::login($user, true);
        return redirect('/index');
    }
}
