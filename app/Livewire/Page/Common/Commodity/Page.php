<?php

namespace App\Livewire\Page\Common\Commodity;

use App\Models\Common\Commodity;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;
    
    public $searchText = "";

    public function delete($id)
    {
        Commodity::find($id)->delete();
        $this->dispatch('refresh');
    }

    public function render()
    {
        return view('livewire.page.common.commodity.page', [
            'data'=> Commodity::where('commodityCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('commodityNameTH', 'like', '%'.$this->searchText.'%')
            ->paginate(20),
        ])->extends('layouts.main')->section('main-content');;
    }
}
