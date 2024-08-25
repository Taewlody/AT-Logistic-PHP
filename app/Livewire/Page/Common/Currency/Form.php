<?php

namespace App\Livewire\Page\Common\Currency;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\Currency;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public Currency $data;

    // public $ChargesTypeList = [];

    public function mount()
    {
        // $this->ChargesTypeList = ChargesType::all();
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = Currency::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new Currency();
        }
        
    }

    public function save()
    {
        if($this->data->currencyCode==''){
            $this->data->currencyCode = 'C-' . str_pad(Currency::count() + 1, 3, '0', STR_PAD_LEFT);
        }
        if($this->action=='create'){
            $this->data->createID = Auth::user()->usercode;
            $this->data->createTime = Carbon::now()->format('Y-m-d H:i:s');
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }else{
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }
        Currency::upsert([$this->data->toArray()], ['currencyCode']);
        return $this->redirect(Page::class);
    }

    public function render()
    {
        return view('livewire.page.common.currency.form')->extends('layouts.main')->section('main-content');
    }
}
