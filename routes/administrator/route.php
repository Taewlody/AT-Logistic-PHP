<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Page\Administrator\User\Page as Users;
use App\Livewire\Page\Administrator\UserType\Page as UserType;

Route::group(['prefix'=> 'administrator',], function() {
    Route::get("/users", Users::class)->name('user');

    Route::get("/user-type", UserType::class)->name('user-type');
});