<?php

namespace App\Livewire\Page\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Functions\EngDate;
use App\Models\Account\Invoice;
use App\Models\Account\TaxInvoice;
use App\Models\PettyCash\PettyCash;
use App\Models\Payment\PaymentVoucher;
use App\Models\Payment\AdvancePayment;
use App\Models\Marketing\JobOrder;
use Illuminate\Support\Facades\DB;

class Page extends Component
{
    public $data_invoice = null;
    public $data_vat = null;
    public $data_income = null;
    public $data_balance = null;
    public $data_total_balance = null;
    public $data_total_income = null;
    public $data_advance_payment = null;
    public $data_tax_invoice = null;
    public $data_petty_cash = null;
    public $data_payment_voucher = null;

    public $monthSearch;
    public $yearSearch;
    public $yearOptions;

    public $monthVatDifferent;
    public $totalMonthVatSale;
    public $totalMonthVatBuy;
    public $monthVatBuy;
    public $monthVatSale;
    public $monthCategory;

    public $monthList;

    public $yearVatTotal;
    public $yearVatBuy;
    public $yearVatSale;
    public $yearCategory;
    
    public $totalVatDifferent;

    public $netProfit;
    public $totalYearNetProfit;
    public $yearTaxTotal;
    public $totalYearTax1;
    public $totalYearTax3;
    public $billingSummary;
    public $billingSummaryChart;
    public $billingSummaryTotal;

    public $yearTaxSearch;

    public $data_invoice_table;
    public $sum_invoice_total;
    // public $data_advance_pyment_table;
    // public $sum_advance_total;
    // public $data_payment_voucher_table;
    // public $sum_payment_voucher_total;

    public function boot()
    {
        

    }
    

    #[On('post-searchYearTax')] 
    public function searchYearTax() {
        if($this->yearTaxSearch) {
            $this->getTaxYear();
        }
    }

    public function getTaxYear()
    {
        //start ยอดถูกหักภาษี ณ ที่จ่าย vat 1% vat 3%
        
            //รายปี
            $yearTax1 = JobOrder::selectRaw('sum(tax1) as sumtax1, MONTH(documentDate) as month')
                ->whereYear('documentDate', $this->yearTaxSearch)
                ->where('documentstatus', 'A')
                ->groupBy('month')
                ->pluck('sumtax1', 'month');
            $yearTax3 = JobOrder::selectRaw('sum(tax3) as sumtax3, MONTH(documentDate) as month')
                ->whereYear('documentDate', $this->yearTaxSearch)
                ->where('documentstatus', 'A')
                ->groupBy('month')
                ->pluck('sumtax3', 'month');

            $yearProfit = JobOrder::selectRaw("MONTH(documentDate) as month, joborder.total_amt - SUM('joborder_charge.chargesCost') - joborder.total_vat - joborder.tax3 - joborder.tax1 as netprofit")
            ->join('joborder_charge', 'joborder_charge.documentID', 'joborder.documentID')
            ->whereYear('documentDate', $this->yearTaxSearch)
            ->where('documentstatus', 'A')
            ->groupBy('month', 'joborder.total_amt', 'joborder.total_vat', 'joborder.tax3', 'joborder.tax1')
            ->pluck('netprofit', 'month');

            $this->netProfit = $this->setDataInYear($yearProfit) ?? [];

            $billing = TaxInvoice::selectRaw('sum(total_vat) as total_vat, MONTH(documentDate) as month')->whereYear('documentDate', $this->yearTaxSearch)->groupBy('month')->pluck('total_vat', 'month');

            $this->monthList = EngDate::full_month_list();
            $this->billingSummary = $this->setDataInYear($billing) ?? [];
            $this->billingSummaryChart = array_column($this->billingSummary , 'value');
            $this->billingSummaryTotal = array_sum($billing->toArray());
            

            $this->totalYearNetProfit = array_sum($yearProfit->toArray());
            $this->totalYearTax1 = array_sum($yearTax1->toArray());
            $this->totalYearTax3 = array_sum($yearTax3->toArray());
            
            $this->yearTaxTotal = $this->mergeDataWithMonth($yearTax1, $yearTax3) ?? [];

        //end ยอดถูกหักภาษี ณ ที่จ่าย vat 1% vat 3%
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

    public function setDataInYear($data)
    {
        if(count($data) > 0) {
            $monthInYears = [];
            $endMonth = 12;
            $currentMonth = 1;
            while ($currentMonth <= $endMonth) {

                $monthInYears[$currentMonth-1] = (object) array(
                    'month' => $currentMonth,
                    'value' => $data[$currentMonth] ?? '0.00'
                );

                $currentMonth++;
            }
            return $monthInYears;
        }
    }

    public function mergeDataWithYear($data1, $data2)
    {
        if(count($data1) > 0 || count($data2) > 0) {

            $previousYear = [];
            $endYear = $this->yearSearch - 11;
            $currentYear = $this->yearSearch;
            $index = 0;
            while ($currentYear >= $endYear) {

                $previousYear[$index] = (object) array(
                    'year' => $currentYear,
                    'value1' => $data1[$currentYear] ?? '0.00',
                    'value2' => $data2[$currentYear] ?? '0.00'
                );
                $index++;
                $currentYear=$currentYear-1;
                
            }
            return $previousYear;
        }
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

    public function mergeDataWithDate($data1, $data2)
    {
        if(count($data1) > 0 || count($data2) > 0) {
            $year = $this->yearSearch;
            $month = $this->monthSearch;

            $daysInMonth = [];
            $startDay = Carbon::create($year, $month, 1);
            $endDay = Carbon::create($year, $month, 1)->endOfMonth();
            $currentDay = clone $startDay;

            while ($currentDay <= $endDay) {

                $daysInMonth[$currentDay->format('d')-1] = (object) array(
                    'date' => $currentDay->format('Y-m-d'),
                    'value1' => $data1[$currentDay->format('Y-m-d')] ?? '0.00',
                    'value2' => $data2[$currentDay->format('Y-m-d')] ?? '0.00'
                );

                $currentDay->addDay();
            }
            // dd($data1,$data2,$daysInMonth);
            return $daysInMonth;
        }
    }

    public function setDataCurrentMonthChart($items)
    {
        if(count($items) > 0) {
            $firstKey = array_key_first($items);
            $date = Carbon::createFromFormat('Y-m-d', $firstKey);
            $year = $this->yearSearch;
            $month = $this->monthSearch;
            $daysInMonth = [];
            $categorirs = [];
            $startDay = Carbon::create($year, $month, 1);
            $endDay = Carbon::create($year, $month, 1)->endOfMonth();
            $currentDay = clone $startDay;
            while ($currentDay <= $endDay) {
                $categorirs[] = $currentDay->format('Y-m-d');
                $daysInMonth[$currentDay->format('Y-m-d')] = "0.00";
                $currentDay->addDay();
            }
            $this->monthCategory = $categorirs;
            $mergedData = array_merge($daysInMonth, $items);
            
            return array_values($mergedData);
        } else {
            return [];
        }
    }

    public function setDataCurrentYearChart($items)
    {
        $this->yearCategory = range(1,12);
        if(count($items) > 0) {
            $monthInYear = [];

            for($i=0; $i<=11; $i++) {
                if(isset($items[$i])) {
                    $monthInYear[$i] = $items[$i];
                }else {
                    $monthInYear[$i] = '0.00';
                }

            }
            
            return $monthInYear;
        } else {
            return [];
        }
    }

    public function mount()
    {
        $this->data_invoice = Invoice::where('documentstatus', 'A')
        ->whereDoesntHave('taxInvoiceItems')
        ->sum('total_netamt');
        
        $this->data_vat = TaxInvoice::whereRaw("DATE_FORMAT(documentDate,'%Y%m') = DATE_FORMAT(NOW(),'%Y%m')")->sum('total_vat');

        // income this month
        $this->data_advance_payment = AdvancePayment::selectRaw('0 as tx, sum(sumTotal)  as ap')->whereRaw("DATE_FORMAT(documentDate,'%Y%m') = DATE_FORMAT(NOW(),'%Y%m')")
        ->where('documentstatus', 'A')
        ->first();

        $this->data_tax_invoice = TaxInvoice::selectRaw('sum(total_netamt) as  tx, 0 as ap')
        ->whereRaw("DATE_FORMAT(documentDate,'%Y%m') = DATE_FORMAT(NOW(),'%Y%m')")
        ->first();

        $this->data_income = collect([$this->data_advance_payment, $this->data_tax_invoice]);

        $total_tx = 0;
        $total_ap = 0;
        foreach ($this->data_income as $item) {
            $total_tx += $item->tx;
            $total_ap += $item->ap;
        }
        $this->data_total_income = $total_tx+$total_ap;
        // end income this month

        // account balance
        $this->data_petty_cash = PettyCash::selectRaw('sum(grandTotal) as  pc, 0 as pv')
        ->whereRaw("DATE_FORMAT(documentDate,'%Y%m') = DATE_FORMAT(NOW(),'%Y%m')")
        ->where('documentstatus', 'A')
        ->first();

        $this->data_payment_voucher = PaymentVoucher::selectRaw('0 as  pc, sum(grandTotal)  as pv')->whereRaw("DATE_FORMAT(documentDate,'%Y%m') = DATE_FORMAT(NOW(),'%Y%m')")
        ->where('documentstatus', 'A')
        ->first();

        $this->data_income = collect([$this->data_petty_cash, $this->data_payment_voucher]);
        $total_pc = 0;
        $total_pv = 0;
        foreach ($this->data_income as $item) {
            $total_pc += $item->pc;
            $total_pv += $item->pv;
        }
        $this->data_total_balance = $this->data_total_income - ($total_pc+$total_pv);
        // end account balance

        $this->monthSearch = (int) date('m');
        $this->yearSearch =  date('Y');

        $this->yearTaxSearch =  date('Y');

        $years = range($this->yearSearch, $this->yearSearch - 11);

        $this->getVatYear();
        $this->getTaxYear();


        // ใบแจ้งหนี้ค้างชำระ
        $group = Invoice::with(['customer'])
            ->whereDoesntHave('taxInvoiceItems')
            ->where('documentstatus', 'A')
            ->orderBy('documentID', 'DESC');
        $collection = collect($group->get()->toArray());
        // dd($collection);
        $this->data_invoice_table = $collection->groupBy('cusCode')->map(function ($row) {
            return [
                'cusCode' => $row->first()['cusCode'],
                'custNameTH' => $row->first()['customer']['custNameTH'],
                'custNameEN' => $row->first()['customer']['custNameEN'],
                'cus_paid' => $row->sum('cus_paid'),
                'total_netamt' => $row->sum('total_netamt'),
                'sum_total_netamt' => $row->sum('total_netamt') - $row->sum('cus_paid'),
                
            ];
        })->values();
        
        $this->sum_invoice_total = 0;
        foreach($this->data_invoice_table as $invoice) {
            $this->sum_invoice_total += $invoice['total_netamt'];
        }
    }

    public function render()
    {
        $data_advance_pyment_table = AdvancePayment::selectRaw('Sum(advance_payment.sumTotal) AS sumTotal, advance_payment.cusCode, common_customer.custNameTH')
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

        $data_payment_voucher_table = PaymentVoucher::selectRaw('sum(payment_voucher.sumTotal) as sumTotal, supCode')
        ->with(['supplier', 'docStatus'])->groupBy('supCode')->orderBy('sumTotal', 'DESC');
        $data_payment_voucher_table_total = $data_payment_voucher_table->get();
        $sum_payment_voucher_total = 0;
        foreach($data_payment_voucher_table_total as $payment) {
            $sum_payment_voucher_total += $payment['sumTotal'];
        }
        
        return view('livewire.page.dashboard.page',[ 
                'data_job_inprocess'=> JobOrder::where('documentstatus', 'P')->paginate(10),
                'data_advance_pyment_table' => $data_advance_pyment_table->paginate(10),
                'data_invoice_table' => $this->data_invoice_table,
                'sum_invoice_total' => $this->sum_invoice_total,
                'sum_advance_total' => $sum_advance_total,
                'data_payment_voucher_table' => $data_payment_voucher_table->paginate(10),
                'sum_payment_voucher_total' => $sum_payment_voucher_total
            ]
            )->extends('layouts.main')->section('main-content');
    }
}