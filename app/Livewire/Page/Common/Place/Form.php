<?php

namespace App\Livewire\Page\Common\Place;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\Place;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public Place $data;

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
            $this->data = Place::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new Place();
        }
        
    }

    public function save()
    {
        if($this->data->pCode==''){
            $this->data->pCode = 'P-' . str_pad(Place::count() + 1, 3, '0', STR_PAD_LEFT);
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
        Place::upsert([$this->data->toArray()], ['pCode']);
        return $this->redirect(Page::class);
    }

    public function render()
    {
        return view('livewire.page.common.place.form')->extends('layouts.main')->section('main-content');
    }
}
