<?php

namespace App\Livewire\Page\Common\TransportType;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\TransportType;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public TransportType $data;

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
            $this->data = TransportType::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new TransportType();
        }
        
    }

    public function save()
    {
        if($this->data->transportCode==''){
            $this->data->transportCode = 'T-' . str_pad(TransportType::count() + 1, 3, '0', STR_PAD_LEFT);
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
        TransportType::upsert([$this->data->toArray()], ['transportCode']);
        return $this->redirect(Page::class);
    }

    public function render()
    {
        return view('livewire.page.common.transport-type.form')->extends('layouts.main')->section('main-content');
    }
}
