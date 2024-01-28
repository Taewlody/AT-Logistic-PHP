<?php

namespace App\Livewire\Page\Common\ContainerSize;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\ContainerSize;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.container-size.page', [ 'data'=> ContainerSize::paginate(50)])->extends('layouts.main')->section('content');
    }
}
