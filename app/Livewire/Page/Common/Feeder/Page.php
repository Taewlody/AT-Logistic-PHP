<?php

namespace App\Livewire\Page\Common\Feeder;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Feeder;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";

    public function render()
    {
        return view('livewire.page.common.feeder.page', [ 
            'data'=> Feeder::where('fCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('fName', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
