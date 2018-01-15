<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// Create new user.
$router->post('/users', function () use ($router) {
  $user = new \App\User;
  $user->name = 'Dan';
  $user->email = sprintf('dan+%d@test.com', time());
  $user->save();

  return $user;
});

// List all users.
$router->get('/users', function () use ($router) {
    return \App\User::all();
});
