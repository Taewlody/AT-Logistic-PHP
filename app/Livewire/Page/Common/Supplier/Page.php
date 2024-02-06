<?php

namespace App\Livewire\Page\Common\Supplier;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Supplier;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";

    public function delete($id)
    {
        Supplier::find($id)->delete();
        redirect()->route('supplier');
    }

    public function render()
    {
        return view('livewire.page.common.supplier.page', [ 
            'data'=> Supplier::where('supCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('supNameTH', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
