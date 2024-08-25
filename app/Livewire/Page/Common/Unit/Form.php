<?php

namespace App\Livewire\Page\Common\Unit;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\Unit;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public Unit $data;

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
            $this->data = Unit::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new Unit();
        }
        
    }

    public function save()
    {
        if($this->data->unitCode==''){
            $this->data->unitCode = 'U-' . str_pad(Unit::count() + 1, 3, '0', STR_PAD_LEFT);
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
        Unit::upsert([$this->data->toArray()], ['unitCode']);
        return $this->redirect(Page::class);
    }

    public function render()
    {
        return view('livewire.page.common.unit.form')->extends('layouts.main')->section('main-content');
    }
}
