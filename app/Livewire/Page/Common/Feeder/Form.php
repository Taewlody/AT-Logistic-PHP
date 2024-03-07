<?php

namespace App\Livewire\Page\Common\Feeder;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\Feeder;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public Feeder $data;

    public function mount()
    {
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = Feeder::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new Feeder();
        }
    }

    public function save()
    {
        if($this->action=='create'){
            $this->data->fCode = Feeder::genarateKey();
            $this->data->createID = Auth::user()->usercode;
            $this->data->createTime = Carbon::now()->format('Y-m-d H:i:s');
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }else{
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }
        Feeder::upsert([$this->data->toArray()], ['fCode']);
        return $this->redirect(Page::class);
    }

    public function render()
    {
        return view('livewire.page.common.feeder.form')->extends('layouts.main')->section('main-content');
    }
}
