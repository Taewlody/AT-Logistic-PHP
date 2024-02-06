<?php

namespace App\Livewire\Page\Common\Charges;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Charges;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";

    public function delete($id)
    {
        Charges::find($id)->delete();
        redirect()->route('charges');
    }

    public function render()
    {
        return view('livewire.page.common.charges.page',[ 
            'data'=> Charges::where('chargeCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('chargeName', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
        ])->extends('layouts.main')->section('main-content');
    }
}
