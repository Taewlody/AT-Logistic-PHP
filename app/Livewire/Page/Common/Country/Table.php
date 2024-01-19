<?php

namespace App\Livewire\Page\Common\Country;

use Livewire\Component;
use Log;
// use App\Models\Common\Country;
use Livewire\WithPagination;
class Table extends Component
{

    use WithPagination;

    public $data;

    public function mount($data)
    {
        Log::info("data: ".json_encode($data));
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.page.common.country.table');
    }
}
