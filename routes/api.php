<?php

use App\Controllers\UserController;

Flight::route('GET /users', [new UserController(), 'index']);
Flight::route('GET /users/@id', [new UserController(), 'show']);
Flight::route('POST /users', [new UserController(), 'store']);
Flight::route('PUT /users/@id', [new UserController(), 'update']);
Flight::route('DELETE /users/@id', [new UserController(), 'delete']);
