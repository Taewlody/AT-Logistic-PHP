<?php

namespace App\Livewire\Page\Common\Place;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Place;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";

    public function delete($id)
    {
        Place::find($id)->delete();
        $this->dispatch('refresh');
    }
    
    public function render()
    {
        return view('livewire.page.common.place.page', [ 
            'data'=> Place::where('pCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('pName', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
        ])->extends('layouts.main')->section('main-content');
    }
}
