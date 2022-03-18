<?php

namespace App\Http\Controllers\Auth;

use App\Http\Models\User;
use App\Http\Models\SocialUser;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use DB;
use Illuminate\Support\Facades\Log;

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
     *
     * @param string $social: SNSの名称
     * @return object
     */
    public function socialLogin(string $social): object
    {
        return Socialite::with($social)->redirect();
    }

    /**
     * ソーシャル認証 コールバック
     *
     * @param string $social: SNSの名称
     * @return object
     */
    public function socialCallback(string $social): object
    {
        try {
            $providerUser = Socialite::driver($social)->user();

            // 既に存在するユーザーかを確認
            $socialUser = SocialUser::where('provider_user_id', $providerUser->id)
                ->where('provider', $social)
                ->first();

            if ($socialUser) {
                // 既存のユーザーはログインしてトップページへ
                Auth::login($socialUser->user, true);
                return redirect()->secure('/index#');
            }

            // 新しいユーザーを作成
            $user = new User();
            $user->unique_id = $providerUser->getNickname();
            $user->name = $providerUser->getName();
            $user->avatar = $providerUser->getAvatar();

            $socialUser = new SocialUser();
            $socialUser->provider = $social;
            $socialUser->provider_user_id = $providerUser->id;

            DB::transaction(function () use ($user, $socialUser) {
                $user->save();
                $user->socialUsers()->save($socialUser);
            });

            Auth::login($user, true);
            return redirect()->secure('/index#');
        } catch (\Exception $e) {
            Log::warning($e);
            return redirect()->secure('/login');
        }
    }
}
