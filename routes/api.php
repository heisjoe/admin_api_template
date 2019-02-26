<?php

Route::post('/login', 'PassportController@login');
Route::post('/logout', 'PassportController@logout');

Route::post('/userList', 'UserController@userList');
Route::post('/emailCheck', 'PassportController@emailCheck');