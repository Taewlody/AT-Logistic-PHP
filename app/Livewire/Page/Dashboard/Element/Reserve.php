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
        

        $jobAll = JobOrder::selectRaw('documentID, MONTH(documentDate) as month')
        ->where('documentstatus', 'A')
        ->whereYear('documentDate', $this->yearBillSearch)
        ->groupBy('documentID', 'month')
        ->get()
        ->mapToGroups(function ($item) {
            return [$item->month => $item];
        });


        $year = array_fill(1, 12, 0); // Initialize the array with 12 elements, each set to 0

        foreach ($jobAll as $month => $jobs) {
            if ($month >= 1 && $month <= 12) { // Ensure the month index is valid
                $year[$month] = $jobs->sum(function($job) {
                    return $job->charge->sum('chargesbillReceive');
                });
            }
        }
        $this->dataBill = $year;
        
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