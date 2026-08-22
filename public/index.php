<?php

// Flight turns every reported PHP error into a thrown exception (see Engine::handleError),
// which would otherwise let a harmless E_DEPRECATED notice (e.g. from a dependency) blow up
// a request as a 500 instead of just being logged.
error_reporting(E_ALL & ~E_DEPRECATED);

require '../vendor/autoload.php';

Flight::map('notFound', function () {
    Flight::response()
        ->status(404)
        ->header('Content-Type', 'application/json')
        ->write(json_encode([
            'data' => [],
            'status' => false,
            'message' => getMessage('route_not_found'),
        ]))
        ->send();
});

Flight::map('error', function (Throwable $exception) {
    error_log($exception);

    Flight::response()
        ->status(500)
        ->header('Content-Type', 'application/json')
        ->write(json_encode([
            'data' => [],
            'status' => false,
            'message' => getMessage('internal_error'),
        ]))
        ->send();
});

require '../routes/api.php';

Flight::start();
