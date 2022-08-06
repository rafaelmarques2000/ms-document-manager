<?php

use App\Api\V1\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::prefix("/files")->group(function() {
    Route::get("/", [FileController::class, "uploadFile"]);
});
