<?php

namespace App\Livewire\Page\Common\Currency;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Currency;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";
    
    public function render()
    {
        return view('livewire.page.common.currency.page', [ 
            'data'=> Currency::where('currencyCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('currencyName', 'like', '%'.$this->searchText.'%')
            ->orWhere('exchange_rate', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
