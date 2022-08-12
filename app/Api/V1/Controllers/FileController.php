<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function getById(Request $request) : JsonResponse {
        return response()->json([]);
    }

    public function upload(Request $request): JsonResponse {
       return response()->json([]);
    }

    public function download(Request $request) : JsonResponse {
        return response()->json([]);
    }
}
