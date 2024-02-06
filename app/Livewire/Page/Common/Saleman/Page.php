<?php

namespace App\Livewire\Page\Common\Saleman;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Saleman;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";

    public function delete($id)
    {
        Saleman::find($id)->delete();
        redirect()->route('supplier');
    }

    public function render()
    {
        return view('livewire.page.common.saleman.page', [ 
            'data'=> Saleman::where('empCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('empName', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
