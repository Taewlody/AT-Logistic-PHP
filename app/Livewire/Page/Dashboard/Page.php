<?php

namespace App\Livewire\Page\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Models\Account\Invoice;
use App\Models\Account\TaxInvoice;
use App\Models\PettyCash\PettyCash;
use App\Models\Payment\PaymentVoucher;
use App\Models\Payment\AdvancePayment;

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
    }
    public function render()
    {
        return view('livewire.page.dashboard.page')->extends('layouts.main')->section('main-content');
    }
}