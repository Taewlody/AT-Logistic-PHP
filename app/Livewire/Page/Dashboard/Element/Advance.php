<?php

namespace App\Livewire\Page\Dashboard\Element;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Models\Payment\AdvancePayment;
use App\Models\Marketing\JobOrder;

class Advance extends Component
{ 
    use WithPagination;
    
    public function mount()
    {
        
    }

    public function render()
    {
        $data_advance_pyment_table = AdvancePayment::selectRaw('Sum(advance_payment.sumTotal) AS sumTotal, advance_payment.cusCode, common_customer.custNameTH, COUNT(*) AS recordCount')
            ->join('joborder', function($join) {
                $join->on('advance_payment.comCode', 'joborder.comCode');
                $join->on('advance_payment.refJobNo', 'joborder.documentID');
            })
            ->leftJoin('invoice', function($join) {
                $join->on('joborder.comCode', 'invoice.comCode');
                $join->on('joborder.documentID', 'invoice.ref_jobNo');
            })
            ->join('common_customer', function($join) {
                $join->on('advance_payment.comCode', 'common_customer.comCode');
                $join->on('advance_payment.cusCode', 'common_customer.cusCode');
            })
            ->whereRaw('invoice.documentID IS NULL')
            ->groupBy('advance_payment.cusCode', 'common_customer.custNameTH');

        $data_advance_pyment_table_total = $data_advance_pyment_table->get();
        
        $sum_advance_total = 0;
        foreach($data_advance_pyment_table_total as $advance) {
            $sum_advance_total += $advance['sumTotal'];
        }
        
        return view('livewire.page.dashboard.element.advance', [
            'sum_advance_total'=> $sum_advance_total,
            'data_advance_pyment_table' => $data_advance_pyment_table->paginate(10),
        ]);
    }
}