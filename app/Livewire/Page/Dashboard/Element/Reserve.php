<?php

namespace App\Livewire\Page\Dashboard\Element;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Collection;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Models\Payment\AdvancePayment;
use App\Models\Marketing\JobOrder;

class Reserve extends Component
{ 
    use WithPagination;
    public $yearOptions;
    public $yearBillSearch;
    public $dataBill;
    
    public function mount()
    {
        $this->yearBillSearch = date('Y');
        $this->getReserve();
    }

    public function getReserve()
    {
        $this->yearOptions = JobOrder::selectRaw('YEAR(documentDate) as year')->whereRaw('YEAR(documentDate) > 0')->groupBy('year')->get();
        

        // $jobAll = JobOrder::selectRaw('documentID, MONTH(documentDate) as month')
        // ->where('documentstatus', 'A')
        // ->whereYear('documentDate', $this->yearBillSearch)
        // ->groupBy('documentID', 'month')
        // ->get()
        // ->mapToGroups(function ($item) {
        //     return [$item->month => $item];
        // });
        $jobAll = Joborder::with('invoice', 'charge')->select('documentID', 'documentDate')
            ->selectRaw('MONTH(documentDate) as month')
            // ->where('documentstatus', 'A')
            ->whereHas('invoice', function($query) {
                $query->whereNull('taxivRef');
            })
            ->whereYear('documentDate', $this->yearBillSearch)
            ->get();
        $year = array_fill(1, 12, 0);

        foreach ($jobAll as $job) {
            if ($job->month >= 1 && $job->month <= 12) { 
                if($job->invoice && ($job->invoice->taxivRef === '' || $job->invoice->taxivRef === null)) {
                    // dd($jobs->charge);
                    $year[$job->month] += $job->charge->sum('chargesbillReceive');
                }
                
            }
        }
        $this->dataBill = $year;
        // dd($this->dataBill);
    }

    public function searchYearReservePayment() {
        if($this->yearBillSearch) {
            $this->getReserve();
        }
    }

    public function render()
    {
        return view('livewire.page.dashboard.element.reserve');
    }
}