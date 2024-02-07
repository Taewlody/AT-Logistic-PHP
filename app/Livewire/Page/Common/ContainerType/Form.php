<?php

namespace App\Livewire\Page\Common\ContainerType;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\ContainerType;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public ContainerType $data;

    public function mount()
    {
        
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = ContainerType::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new ContainerType();
        }
    }

    public function save()
    {
        if($this->data->containertypeCode==''){
            $this->data->containertypeCode = 'T-' . str_pad(ContainerType::count() + 1, 8, '0', STR_PAD_LEFT);
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
        ContainerType::upsert([$this->data->toArray()], ['containertypeCode']);
        return $this->redirect(Page::class);
    }

    public function render()
    {
        return view('livewire.page.common.container-type.form')->extends('layouts.main')->section('main-content');
    }
}
