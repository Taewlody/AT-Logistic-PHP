<?php

namespace App\Livewire\Page\Common\ContainerType;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\ContainerType;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.container-type.page', [ 'data'=> ContainerType::paginate(50)])->extends('theme.layout.master')->section('main-content');
    }
}
