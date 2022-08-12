<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Aws\Sqs\SqsClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Aws\Exception\AwsException;
use Aws\Credentials\Credentials;

class SqsController extends Controller
{
    public function createMessage(Request $request) : JsonResponse {
        phpinfo();
        exit();
        $credentials = new Credentials(env("AWS_ACCESS_KEY_ID"), env("AWS_SECRET_ACCESS_KEY"));
        $client = new SqsClient([
            "region" => env("AWS_REGION"),
            "credentials" => $credentials,
            "version" => "2012-11-05"
        ]);

        $params = [
            "MessageBody" => json_encode($request->all()),
            "QueueUrl" => env("AWS_SQS_QUEUE")
        ];

        try {
            $result = $client->sendMessage($params);
            return response()->json($result->toArray(), 203);
        }catch (AwsException $exception) {
            return response()->json(["msg" => $exception->getMessage()], 500);
        }
    }
}
