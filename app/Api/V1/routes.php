<?php

use App\Api\V1\Controllers\FileController;
use Illuminate\Support\Facades\Route;
use App\Api\V1\Controllers\SqsController;

Route::prefix("/files")->group(function() {
    Route::get("/", [FileController::class, "uploadFile"]);
});

Route::prefix("/sqs")->group(function() {
    Route::post("/", [SqsController::class, "createMessage"]);
});
