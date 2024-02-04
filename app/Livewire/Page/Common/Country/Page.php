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
    public $searchText = "";

    public function mount()
    {
        // $country = new Country;
        // $column = $country->getTableColumns();
        // dd($column);
    }
    // public function mount()
    // {
    //     $this->countries;
    // }

    public function delete($countryCode)
    {
        Country::find($countryCode)->delete();
        $this->refreshComponent();
    }

    protected function refreshComponent()
    {
        redirect()->route('country');
    }

    public function render()
    {
        return view('livewire.page.common.country.page',[ 
            'data'=> Country::where('countryCode', 'like', '%'.$this->searchText.'%')
            ->orWhere('countryNameTH', 'like', '%'.$this->searchText.'%')
            ->paginate(20)
            ]
            )->extends('layouts.main')->section('main-content');
    }
}
