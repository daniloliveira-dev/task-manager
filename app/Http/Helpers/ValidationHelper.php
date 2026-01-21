<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationHelper
{

    public function validation(Request $request, $array): array | JsonResponse
    {
        $validator = Validator::make($request->all(), $array);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        return $validator->validated();
    }
}
