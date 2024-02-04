<?php

namespace App\Livewire\Page\Common\Country;

use Livewire\Attributes\Url;
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

    public function delete($countryCode)
    {
        Country::find($countryCode)->delete();
    }

    public function render()
    {
        return view('livewire.page.common.country.page',[ 'data'=> Country::paginate(50)->withQueryString()])->extends('layouts.main')->section('main-content');
    }
}
