<?php

namespace App\Livewire\Page;

use Livewire\Component;

class Test extends Component
{
    public $data = "";
    public function render()
    {
        return view('livewire.page.test')->extends('layouts.test')->section('main-content');
    }
}
