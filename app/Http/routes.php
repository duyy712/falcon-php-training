<?php

use App\User;
use Illuminate\Http\Request;

Route::get('/', function () {
    //
    return view('user');
});

Route::post('/user', function (Request $request) {
    //
    // $validator = Validator::make($request->all(), [
    //     'name' => 'required|max:255',

    // ]);

    // if ($validator->fails()) {
    //     return redirect('/')
    //         ->withInput()
    //         ->withErrors($validator);
    // }

    $user = new User;
    $user->name = $request->name;
    $user->password = $request->password;
    $user->save();

    return redirect('/');
});

Route::delete('/user/{id}', function ($id) {
    //
});
