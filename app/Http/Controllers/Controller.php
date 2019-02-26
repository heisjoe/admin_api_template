<?php

namespace App\Http\Controllers;

use App\Library\Code;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($data)
    {
        if ($data['code'] === Code::SUCCESS) {
            return response()->json($data);
        } else {
            return response()->json($data, 422);
        }
    }
}
