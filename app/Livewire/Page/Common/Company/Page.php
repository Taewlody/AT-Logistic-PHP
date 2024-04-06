<?php

namespace App\Livewire\Page\Common\Company;

use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.company.page');
    }
}
