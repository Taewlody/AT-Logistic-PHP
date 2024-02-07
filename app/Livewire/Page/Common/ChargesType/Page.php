<?php

namespace App\Livewire\Page\Common\ChargesType;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\ChargesType;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";
    
    public function delete($id)
    {
        ChargesType::find($id)->delete();
        $this->dispatch('refresh');
    }
    public function render()
    {
        return view('livewire.page.common.charges-type.page', [ 
            'data'=> ChargesType::where('typeCode', 'like', '%'.$this->searchText.'%')->orWhere('typeName', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
