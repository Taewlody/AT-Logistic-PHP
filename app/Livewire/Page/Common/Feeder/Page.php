<?php

namespace App\Livewire\Page\Common\Feeder;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Feeder;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.feeder.page', [ 'data'=> Feeder::paginate(50)])->extends('layouts.main')->section('main-content');
    }
}
