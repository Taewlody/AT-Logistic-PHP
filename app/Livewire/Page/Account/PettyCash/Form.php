<?php

namespace App\Livewire\Page\Account\PettyCash;

use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public function render()
    {
        return view('livewire.page.account.petty-cash.form')->extends('layouts.main')->section('main-content');
    }
}
