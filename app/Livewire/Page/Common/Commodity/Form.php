<?php

namespace App\Livewire\Page\Common\Commodity;

use App\Models\Common\Commodity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;

class Form extends Component
{

    #[URL] 
    public $action = '';
    #[Url]
    public $id = '';

    public Commodity $data;

    public function mount()
    {
        if($this->action==''){
            $this->action = 'view';
        }
        if($this->id != ''){
            $this->data = Commodity::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new Commodity();
        }
    }

    public function save()
    {
        if($this->action=='create'){
            $this->data->createID = Auth::user()->usercode;
            $this->data->createTime = Carbon::now()->format('Y-m-d H:i:s');
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }else{
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }
        $this->data->save();
        return $this->redirect(Page::class);
    }
    
    public function render()
    {
        return view('livewire.page.common.commodity.form')->extends('layouts.main')->section('main-content');
    }
}

