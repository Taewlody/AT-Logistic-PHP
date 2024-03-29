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

    public $monthVatBuy;
    public $monthVatSale;
    public $monthCategory;

    public $monthList;

    public $yearVatTotal;
    public $yearVatBuy;
    public $yearVatSale;
    public $yearCategory;


    public $yearTaxTotal;
    public $totalYearTax1;
    public $totalYearTax3;
    public $billingSummary;
    public $billingSummaryChart;
    public $billingSummaryTotal;

    public function boot()
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
        $years = range($this->yearSearch, $this->yearSearch - 11);

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
            
        //end ยอดภาษีมูลค่าเพิ่ม ยอดขาย ยอดซื้อ

        //start ยอดถูกหักภาษี ณ ที่จ่าย vat 1% vat 3%
        
            //รายปี
            $yearTax1 = JobOrder::selectRaw('sum(tax1) as sumtax1, MONTH(documentDate) as month')
                ->whereYear('documentDate', $this->yearSearch)
                ->where('documentstatus', 'A')
                ->groupBy('month')
                ->pluck('sumtax1', 'month');
            $yearTax3 = JobOrder::selectRaw('sum(tax3) as sumtax3, MONTH(documentDate) as month')
                ->whereYear('documentDate', $this->yearSearch)
                ->where('documentstatus', 'A')
                ->groupBy('month')
                ->pluck('sumtax3', 'month');

            $billing = TaxInvoice::selectRaw('sum(total_vat) as total_vat, MONTH(documentDate) as month')->whereYear('documentDate', $this->yearSearch)->groupBy('month')->pluck('total_vat', 'month');

            $this->monthList = EngDate::full_month_list();
            $this->billingSummary = $this->setDataInYear($billing) ?? [];
            $this->billingSummaryChart = array_column($this->billingSummary , 'value');
            $this->billingSummaryTotal = array_sum($billing->toArray());
            

            $this->totalYearTax1 = array_sum($yearTax1->toArray());
            $this->totalYearTax3 = array_sum($yearTax3->toArray());
            
            $this->yearTaxTotal = $this->mergeDataWithMonth($yearTax1, $yearTax3) ?? [];

        //end ยอดถูกหักภาษี ณ ที่จ่าย vat 1% vat 3%


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
        // ->paginate(10);
        
        $data_invoice_table = Invoice::selectRaw('invoice.documentstatus, common_customer.custNameTH, sum(invoice.total_netamt) as total_netamt')
            ->join('common_customer', function($join) {
                $join->on('invoice.comCode', 'common_customer.comCode');
                $join->on('invoice.cusCode', 'common_customer.cusCode');
            })
            ->leftJoin('tax_invoice_items', function($join) {
                $join->on('invoice.comCode', 'tax_invoice_items.comCode');
                $join->on('invoice.documentID', 'tax_invoice_items.invNo');
            })
            ->where('invoice.documentstatus', 'A')
            ->whereRaw('tax_invoice_items.documentID IS NULL')
            ->groupBy('invoice.documentstatus', 'common_customer.custNameTH')
            ->orderBy('total_netamt', 'DESC');
        
        $data_invoice_table_total = $data_invoice_table->get();
        $sum_invoice_total = 0;
        foreach($data_invoice_table_total as $invoice) {
            $sum_invoice_total += $invoice['total_netamt'];
        }

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
                'data_invoice_table' => $data_invoice_table->paginate(10),
                'sum_invoice_total' => $sum_invoice_total,
                'sum_advance_total' => $sum_advance_total,
                'data_payment_voucher_table' => $data_payment_voucher_table->paginate(10),
                'sum_payment_voucher_total' => $sum_payment_voucher_total
            ]
            )->extends('layouts.main')->section('main-content');
    }
}