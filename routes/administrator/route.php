<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Page\Administrator\User\Page as Users;
use App\Livewire\Page\Administrator\User\Form as UserForm;
use App\Livewire\Page\Administrator\UserType\Page as UserType;
use App\Livewire\Page\Administrator\UserType\Form as UserTypeForm;

Route::group(['prefix'=> 'administrator',], function() {
    Route::get("/users", Users::class)->name('user');
    Route::get("/users/form", UserForm::class)->name('user.form');

    Route::get("/user-type", UserType::class)->name('user-type');
    Route::get("/user-type/form", UserTypeForm::class)->name('user-type.form');
});