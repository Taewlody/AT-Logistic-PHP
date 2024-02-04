<?php

namespace App\Livewire\Page\Common\BankAccount;

use Livewire\Component;
use App\Models\Common\BankAccount;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";
    
    public function render()
    {
        return view('livewire.page.common.bank-account.page' ,[ 
            'data'=> BankAccount::where('accountName', 'like', '%'.$this->searchText.'%')
            ->orWhere('accountID', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
