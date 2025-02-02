<?php

namespace App\Livewire\Page\Dashboard\Element;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Functions\EngDate;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Models\Payment\PaymentVoucher;
use App\Models\Account\TaxInvoice;
use App\Models\Marketing\JobOrder;

class Vat extends Component
{ 
    use WithPagination;

    public $yearVatTotal;
    public $yearVatBuy;
    public $yearVatSale;
    public $yearCategory;
    public $yearOptions;

    public $yearSearch;
    public $monthVatBuy;
    public $totalMonthVatBuy;
    public $monthVatSale;
    public $totalMonthVatSale;
    public $monthVatDifferent;
    public $totalVatDifferent;
    
    public function mount()
    {
        $this->yearSearch =  date('Y');
        $this->getVatYear();
    }

    public function getVatYear()
    {
        //start ยอดภาษีมูลค่าเพิ่ม ยอดขาย ยอดซื้อ
            $this->yearOptions = PaymentVoucher::selectRaw('YEAR(documentDate) as year')->whereRaw('YEAR(documentDate) > 0')->groupBy('year')->get();
                
            $yearVatBuy = PaymentVoucher::selectRaw('sum(sumTax7) as sum, MONTH(documentDate) as month')
                ->whereYear('documentDate', $this->yearSearch)
                ->groupBy('month')
                ->pluck('sum', 'month');
            
            //ภาษีขาย เดือนปัจจุบัน
            $yearVatSale = TaxInvoice::selectRaw('sum(total_vat)  as sum, MONTH(documentDate) as month')
                ->whereYear('documentDate', $this->yearSearch)
                ->groupBy('month')
                ->pluck('sum', 'month');

            $this->yearVatTotal = $this->mergeDataWithMonth($yearVatBuy, $yearVatSale) ?? [];
            $this->monthVatBuy = array_column($this->yearVatTotal , 'value1');
            $this->monthVatSale = array_column($this->yearVatTotal , 'value2');
            
            $this->totalMonthVatSale = array_sum($this->monthVatSale);
            $this->totalMonthVatBuy = array_sum($this->monthVatBuy);

            $this->monthVatDifferent = $this->Different($this->monthVatSale, $this->monthVatBuy);
            $this->totalVatDifferent = array_sum($this->monthVatDifferent);
            
            
        //end ยอดภาษีมูลค่าเพิ่ม ยอดขาย ยอดซื้อ
    }

    public function mergeDataWithMonth($data1, $data2)
    {
        
        if(count($data1) > 0 || count($data2) > 0) {
            $monthInYears = [];
            // $startMonth = 1;
            $endMonth = 12;
            $currentMonth = 1;

            while ($currentMonth <= $endMonth) {

                $monthInYears[$currentMonth-1] = (object) array(
                    'month' => $currentMonth,
                    'value1' => $data1[$currentMonth] ?? '0.00',
                    'value2' => $data2[$currentMonth] ?? '0.00'
                );

                $currentMonth++;
            }
            return $monthInYears;
        }
    }

    public function Different($data1, $data2)
    {
        // dd($data1, $data2);
        $result = [];
        if(count($data1) == 12 && count($data2) == 12) {
            foreach ($data1 as $key => $value) {
                $result[$key] = $value - $data2[$key];
            }
        }
        return $result;
    }

    public function searchYearVatPayment() {
        if($this->yearSearch) {
            $this->getVatYear();
        }
    }


    public function render()
    {
        return view('livewire.page.dashboard.element.vat');
    }
}