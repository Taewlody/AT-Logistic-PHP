<?php

namespace App\Livewire\Page\Report\ReportJob;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Marketing\JobOrder;

class Page extends Component
{
    use WithPagination;
    
    public function render()
    {
        return view('livewire.page.report.report-job.page',[ 
            'data'=> JobOrder::with(['customerRefer', 'salemanRefer','docStatus' => function ($query) {
                $query->where('status_code', 'P');
            }])
            ->orderBy('documentID', 'DESC')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
