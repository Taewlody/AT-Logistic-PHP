<?php

namespace App\Livewire\Page\Common\Unit;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Unit;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";

    public function render()
    {
        return view('livewire.page.common.unit.page', [ 
            'data'=> Unit::where('unitCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('unitName', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
