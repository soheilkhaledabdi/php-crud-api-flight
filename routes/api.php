<?php

use App\Controllers\UserController;

Flight::group('/users', function () {
    Flight::route('GET /', UserController::class . '->index');
    Flight::route('GET /@id:[0-9]+', UserController::class . '->show');
    Flight::route('POST /', UserController::class . '->store');
    Flight::route('PUT /@id:[0-9]+', UserController::class . '->update');
    Flight::route('DELETE /@id:[0-9]+', UserController::class . '->delete');
});
