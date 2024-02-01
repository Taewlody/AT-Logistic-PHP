<?php

namespace App\Livewire\Page\Administrator\User;

use App\Models\User;
use Livewire\Component;

class Page extends Component
{
    public function render()
    {
        return view('livewire.page.administrator.user.page',[ 'data'=> User::paginate(50)->withQueryString()])->extends('layouts.main')->section('main-content');
    }
}
