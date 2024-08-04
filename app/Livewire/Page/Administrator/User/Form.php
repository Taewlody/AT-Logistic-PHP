<?php

namespace App\Livewire\Page\Administrator\User;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public User $data;

    public $userTypeList = [];
    public $new_password = '';
    public $old_password = '';

    public function mount()
    {
        // $this->ChargesTypeList = ChargesType::all();
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = User::find($this->id);
            $this->old_password = $this->data->userpass;
            
        }else{
            $this->action = 'create';
            $this->data = new User();
            $this->data->createID = Auth::user()->usercode;
            // $this->data->userpass = md5($this->data->userpass);
        }

        $this->userTypeList = UserType::all();
        
    }

    public function save() 
    {
        DB::beginTransaction();
        try {
            $this->data->editID = Auth::user()->usercode;
            if($this->new_password !== '') {
                $this->data->userpass = md5($this->new_password);
            } else {
                $this->data->userpass = $this->old_password;
            }
            
            $this->data->save();

            \DB::commit();
            return true;
        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception->getMessage());
            return false;
        }
    }

    public function submit(){
        $success = $this->save();
        if($success){
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
            return redirect()->route('user.form', ['action' => 'edit', 'id' => $this->data->usercode]);
        }else{
            
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
            
        }
    }

    public function render()
    {
        return view('livewire.page.administrator.user.form')->extends('layouts.main')->section('main-content');
    }
}
