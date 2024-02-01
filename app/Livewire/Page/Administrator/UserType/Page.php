<?php

namespace App\Livewire\Page\Administrator\UserType;

use App\Models\UserType;
use Livewire\Component;

class Page extends Component
{
    public function render()
    {
        return view('livewire.page.administrator.user-type.page',[ 'data'=> UserType::paginate(50)->withQueryString()])->extends('layouts.main')->section('main-content');
    }
}
