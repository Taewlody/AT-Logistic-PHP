<?php

namespace App\Livewire\Page\Common\ChargesType;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\ChargesType;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Common\VatType;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public ChargesType $data;

    public $vatTypeList = [];

    public function mount()
    {
        $this->vatTypeList = VatType::all();
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = ChargesType::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new ChargesType();
        }
        
    }

    public function save()
    {
        if($this->data->typeCode==''){
            $this->data->typeCode = 'V-' . str_pad(ChargesType::count() + 1, 3, '0', STR_PAD_LEFT);
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
        ChargesType::upsert([$this->data->toArray()], ['typeCode']);
        return $this->redirect(Page::class);
    }
    public function render()
    {
        return view('livewire.page.common.charges-type.form')->extends('layouts.main')->section('main-content');
    }
}
