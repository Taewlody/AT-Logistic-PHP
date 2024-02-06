<?php

namespace App\Livewire\Page\Common\Saleman;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\Saleman;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public Saleman $data;

    public $userList = [];

    public function mount()
    {
        $this->userList = User::all();
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = Saleman::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new Saleman();
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
        // Saleman::upsert(['empCode'=>$this->data->empCode], $this->data->toArray());
        Saleman::upsert([$this->data->toArray()], ['empCode']);
        return redirect()->route('saleman');
    }
    public function render()
    {
        return view('livewire.page.common.saleman.form')->extends('layouts.main')->section('main-content');
    }
}
