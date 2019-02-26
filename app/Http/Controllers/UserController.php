<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userList(Request $request)
    {
        return $this->response(success(User::UserList($request->get('filters'))));
    }
}
