<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;

class PassportController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // 手机号，密码一致
        if ($token = auth()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return $this->response(error("账号和密码不匹配"));
    }

    protected function respondWithToken($token)
    {
        return $this->response(success([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], "登录成功!"))->header('Authorization', 'Bearer ' . $token);
    }

    public function emailCheck(Request $request)
    {
        return $this->response(success(Admin::EmailCheck($request->get('email'))));
    }

    public function logout()
    {
        auth()->logout();
        return $this->response(success('成功退出!'));
    }
}
