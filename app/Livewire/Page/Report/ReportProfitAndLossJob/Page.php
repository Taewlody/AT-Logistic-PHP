<?php

namespace App\Livewire\Page\Report\ReportProfitAndLossJob;

use Livewire\Component;

use App\Models\Marketing\JobOrder;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;

    public $monthSearch = '';
    public $yearSearch = '';

    public function mount()
    {

        $this->monthSearch = date('m');
        $this->yearSearch = date('Y');

        $this->yearList = range(date('Y'), date('Y')-4);

    }

    public function render()
    {
        $data = JobOrder::with(['charge', 'customerRefer'])->orderBy('documentDate', 'DESC');
        
        return view('livewire.page.report.report-profit-and-loss-job.page', ['data'=> $data->paginate(20)
        ])->extends('layouts.main')->section('main-content');
    }
}
