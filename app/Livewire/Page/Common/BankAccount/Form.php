<?php

namespace App\Livewire\Page\Common\BankAccount;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\BankAccount;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
// use App\Models\Common\ChargesType;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public BankAccount $data;

    // public $ChargesTypeList = [];

    public function mount()
    {
        $check = BankAccount::find($this->id);
        // $this->ChargesTypeList = ChargesType::all();
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }

        if($this->id!=''){
            $this->data = BankAccount::find($this->id);
        }else if( $this->id === '' && $this->action === 'edit' && $check !== null) {
            
            $this->data = BankAccount::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new BankAccount();
        }
        
    }

    public function save()
    {
        if($this->action=='create'){
            if($this->data->accountCode==''){
                $this->data->accountCode = 'C-' . str_pad(BankAccount::count() + 1, 8, '0', STR_PAD_LEFT);
            }
            $this->data->createID = Auth::user()->usercode;
            $this->data->createTime = Carbon::now()->format('Y-m-d H:i:s');
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }else{
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }
        BankAccount::upsert([$this->data->toArray()], ['accountCode']);
        return $this->redirect(Page::class);
    }
    public function render()
    {
        return view('livewire.page.common.bank-account.form')->extends('layouts.main')->section('main-content');
    }
}
