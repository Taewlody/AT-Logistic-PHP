<?php

namespace App\Livewire\Page\Common\Port;

use Livewire\Component;
use \App\Models\Common\Port;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.port.page',[ 'data'=> Port::paginate(50)])->extends('layouts.main')->section('content');
    }
}
