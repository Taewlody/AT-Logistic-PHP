<?php

namespace App\Livewire\Page\Common\ContainerSize;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\ContainerSize;

class Page extends Component
{
    use WithPagination;
    public $searchText = "";

    public function delete($id)
    {
        ContainerSize::find($id)->delete();
        $this->dispatch('refresh');
    }

    public function render()
    {
        return view('livewire.page.common.container-size.page', [ 
            'data'=> ContainerSize::where('containersizeCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('containersizeName', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
