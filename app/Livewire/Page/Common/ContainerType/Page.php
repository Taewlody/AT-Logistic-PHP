<?php

namespace App\Livewire\Page\Common\ContainerType;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\ContainerType;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";

    public function render()
    {
        return view('livewire.page.common.container-type.page', [ 
            'data'=> ContainerType::where('containertypeCode', 'like', '%'.$this->searchText.'%')->orWhere('containertypeName', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
