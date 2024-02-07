<?php

namespace App\Livewire\Page\Common\TransportType;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\TransportType;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";


    public function delete($id)
    {
        TransportType::find($id)->delete();
        $this->dispatch('refresh');
    }
    
    public function render()
    {
        return view('livewire.page.common.transport-type.page', [ 
            'data'=> TransportType::where('transportCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('transportName', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
