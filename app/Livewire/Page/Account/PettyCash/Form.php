<?php

namespace App\Livewire\Page\Account\PettyCash;

use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.page.account.petty-cash.form')->extends('layouts.main')->section('main-content');
    }
}
