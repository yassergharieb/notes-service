<?php

namespace App\Http\traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait ResponseHandeler
{
    public function successResponse($data, $code = 200)
    {
        return response()->json(['data' => $data, 'code' => $code], $code);
    }

    public function errorResponse($msg, $code = 400)
    {
        return response()->json(['msg' => $msg, 'code' => $code], $code);
    }

    public function validationfails($validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()->toArray(),
            ], 400)
        );
    }
}


 



