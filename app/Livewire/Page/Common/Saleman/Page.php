<?php

namespace App\Livewire\Page\Common\Saleman;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Saleman;
use Illuminate\Support\Facades\DB;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";

    public function delete($empCode, $usercode)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Saleman::where('empCode',$empCode)->where('usercode', $usercode)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->dispatch('refresh');
    }

    public function render()
    {
        return view('livewire.page.common.saleman.page', [ 
            'data'=> Saleman::where('empCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('empName', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
