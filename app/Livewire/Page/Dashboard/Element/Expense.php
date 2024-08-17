<?php

namespace App\Livewire\Page\Dashboard\Element;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Models\Payment\PaymentVoucher;
use App\Models\Payment\PaymentVoucherItems;
use App\Functions\EngDate;
use App\Models\Common\Supplier;

class Expense extends Component
{ 
    public $yearExpensePaymentSearch;
    public $expense_payment;
    public $yearOptions;

    public function mount()
    {
        $this->yearExpensePaymentSearch =  date('Y');
        $this->yearOptions = PaymentVoucher::selectRaw('YEAR(documentDate) as year')->whereRaw('YEAR(documentDate) > 0')->groupBy('year')->get();

        $this->getExpensePayment();
    }

    public function getNameSup($sup)
    {
        $name = Supplier::find($sup);
        return $name->supNameTH;
        // dd($name);
    }

    public function searchYearExpensePayment() {
        if($this->yearExpensePaymentSearch) {
            $this->getExpensePayment();
        }
    }

    public function getExpensePayment()
    {
        // $this->expense_payment = PaymentVoucher::whereNull('refJobNo')->whereYear('documentDate', $this->yearExpensePaymentSearch)->get();
        $yearSearch = $this->yearExpensePaymentSearch;

        // $this->expense_payment = Cache::remember('expense_payment_' . $yearSearch, 60, function () use ($yearSearch) {
        //     return PaymentVoucher::selectRaw('supCode, MONTH(documentDate) as month, SUM(sumTotal) as sumTotal')
        //         ->whereRaw("(refJobNo IS NULL OR refJobNo = '')")
        //         ->whereYear('documentDate', $yearSearch)
        //         ->groupBy('supCode', 'month')
        //         ->orderBy('supCode')
        //         ->orderBy('month')
        //         ->get()
        //         ->mapToGroups(function ($item) {
        //             return [$item->supCode => $item];
        //         });
        // });


        $test = PaymentVoucher::with('items')->select('documentID', 'documentDate')
        ->selectRaw('MONTH(documentDate) as month')
        ->whereRaw("(refJobNo IS NULL OR refJobNo = '')")
        ->whereYear('documentDate', $yearSearch)
        ->get()
        ->mapToGroups(function ($item) {
            $result = [];
            foreach ($item->items as $data) {
                $result[$data->chartDetail] = [
                    'amount' => $data['amount'],
                    'documentID' => $item->documentID,
                    'documentDate' => $item->documentDate,
                    'month' => $item->month,
                    // Add more fields as needed
                ];
            }
            return $result;
        });
        
        // dd($test);
        $this->expense_payment = $test->toArray();

    }

    public function render()
    {
        // dd($this->expense_payment);
        return view('livewire.page.dashboard.element.expense');
    }
}