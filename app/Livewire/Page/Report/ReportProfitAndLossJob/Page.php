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
        // $data = JobOrder::with(['charge', 'customerRefer'])->orderBy('documentDate', 'DESC')->get();
        $data = JobOrder::select(
            'joborder.documentID',
            DB::raw("DATE_FORMAT(joborder.documentDate,'%d/%m/%Y') AS documentDate"),
            'joborder.total_amt',
            DB::raw('SUM(joborder_charge.chargesCost) as cost'),
            DB::raw('(joborder.total_amt - SUM(joborder_charge.chargesCost) - joborder.total_vat) AS profit'),
            DB::raw('(joborder.total_amt - SUM(joborder_charge.chargesCost) - joborder.total_vat - joborder.tax3 - joborder.tax1) AS netprofit'),
            'common_customer.custNameEN'
        )
        ->leftJoin('joborder_charge', function($join) {
            $join->on('joborder.comCode', '=', 'joborder_charge.comCode')
                 ->on('joborder.documentID', '=', 'joborder_charge.documentID');
        })
        ->leftJoin('common_customer', function($join) {
            $join->on('joborder.comCode', '=', 'common_customer.comCode')
                 ->on('joborder.cusCode', '=', 'common_customer.cusCode');
        })
        // ->where('joborder.documentID', 'like', '%' . $documentID . '%')
        // ->where('joborder.cusCode', 'like', $cusCode . '%')
        // ->where('joborder.saleman', 'like', $saleman . '%')
        // ->whereRaw($date_month)
        ->groupBy('joborder.documentID', 'joborder.documentDate', 'joborder.total_amt', 'joborder.total_vat', 'joborder.tax3', 'joborder.tax1', 'common_customer.custNameEN')
        ->orderByDesc('joborder.documentID');
        // ->get();
        // dd($data[0]);
        return view('livewire.page.report.report-profit-and-loss-job.page', ['data'=> $data->paginate(20)
        ])->extends('layouts.main')->section('main-content');
    }
}
