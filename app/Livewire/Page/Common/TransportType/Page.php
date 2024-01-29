<?php

namespace App\Livewire\Page\Common\TransportType;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\TransportType;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.transport-type.page', [ 'data'=> TransportType::paginate(50)])->extends('layouts.main')->section('main-content');
    }
}
