<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function successResponse($message, $result, $code = 200){
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $result,
        ], $code);
    }
    public function errorResponse($error, $code = 400){
        return response()->json([
            'success' => false,
            'error' => $error,
        ], $code);
    }

}
