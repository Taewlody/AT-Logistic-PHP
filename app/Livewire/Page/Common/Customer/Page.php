<?php

namespace App\Livewire\Page\Common\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Customer;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";
    
    public function delete($id)
    {
        Customer::find($id)->delete();
        redirect()->route('customer');
    }
    public function render()
    {
        return view('livewire.page.common.customer.page', [ 
            'data'=> Customer::where('cusCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('custNameEN', 'like', '%'.$this->searchText.'%')
            ->orWhere('custNameTH', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
