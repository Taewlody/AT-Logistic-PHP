<?php

namespace App\Livewire\Page\Administrator\UserType;

use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.page.administrator.user-type.form')->extends('layouts.main')->section('main-content');
    }
}
