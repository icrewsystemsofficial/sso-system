<?php

namespace Icrewsystems\SsoLogin\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class SsoLoginController extends Controller
{
    public function sso_callback(Request $request)
    {
        $key = $request->query('key');
        $sso_url = config('sso.sso_url');
        $homepage_route_name = config('sso.homepage_route_name');
        $sso_verify_url = $sso_url . '/api/v1/sso/verify-token/' . $key;
        $response = Http::get($sso_verify_url);
        $result = json_decode($response->getBody());
        // dd($sso_verify_url);
        $result_data = $result->data;
        if ($result && $result->status === 'ok') {
            $user = User::where('email', $result_data->email)->first();
            Auth::login($user);
            return redirect()->route($homepage_route_name)->withCookie(cookie('sso_token', $key, 60 * 24 * 30));
        } else {
            return response()->json([
                'message' => 'Unable to verify token',
                'code' => 500,
            ]);
        }
    }

    public function sso_login(Request $request)
    {
        $app_name = config('app.name');
        $redirect_url = base64_encode(config('app.url'));
        $sso_key = $request->cookie('sso_token');
        $sso_url = config('sso.sso_url');
        $homepage_route_name = config('sso.homepage_route_name');

        for ($i = 0; $i < 10; $i++) {
            $encoded_url = base64_encode($redirect_url);
        }

        $sso_verify_url = $sso_url . '/api/v1/sso/verify-token/' . $sso_key;
        $response = Http::get($sso_verify_url);

        $result = json_decode($response->getBody());
        // dd($result);
        if ($result) {
            if ($result->status === 'ok') {
                $result_data = $result->data;
                $user = User::where('email', $result_data->email)->first();
                Auth::login($user);
                return redirect()->route($homepage_route_name);
            } else {
                return redirect($sso_url . '/sso/login?Y21Wa2FYSmxZM1E=' . $encoded_url . '&app_name=' . $app_name);
            }
        } else {
            // $signed_url = Url::temporarySignedRoute('index', now()->minutes(2), ['Y21Wa2FYSmxZM1E' => $encoded_url], false);
            return redirect($sso_url . '/sso/login?Y21Wa2FYSmxZM1E=' . $encoded_url . '&app_name=' . $app_name);
        }
    }
}
