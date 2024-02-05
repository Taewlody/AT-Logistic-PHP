<?php

namespace App\Livewire\Page\Common\Port;

use Livewire\Component;
use \App\Models\Common\Port;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";

    public function delete($portCode)
    {
        Port::find($portCode)->delete();
        redirect()->route('port');
    }

    public function render()
    {
        return view('livewire.page.common.port.page',[ 
            'data'=> Port::where('portCode', 'like', '%'.$this->searchText.'%')->orWhere('portNameTH', 'like', '%'.$this->searchText.'%')->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
