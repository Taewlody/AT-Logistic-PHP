<?php

namespace App\Livewire\Page\Dashboard\Element;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Models\Marketing\JobOrder;

class JobInprocess extends Component
{ 
    use WithPagination;

    public function render()
    {
        // dd($this->expense_payment);
        return view('livewire.page.dashboard.element.job-inprocess', ['data_job_inprocess'=> JobOrder::where('documentstatus', 'P')->paginate(10)]);
    }
}