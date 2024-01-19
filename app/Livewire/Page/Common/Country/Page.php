<?php

namespace App\Livewire\Page\Common\Country;

use Livewire\Attributes\Computed;
use Livewire\Component;
use \App\Models\Common\Country;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;
    // public $countries;

    // public function mount()
    // {
    //     $this->countries;
    // }

    public function render()
    {
        return view('livewire.page.common.country.page',[ 'countries'=> Country::paginate(50)])->extends('layouts.main')->section('content');
    }
}
