<?php

namespace App\Livewire\Page\Account\BillingSummary;

use App\Models\Account\Invoice;
use App\Models\Account\TaxInvoice;
use App\Models\Account\TaxInvoiceItems;
use App\Models\Common\BankAccount;
use App\Models\Common\Charges;
use App\Models\Common\CreditTerm;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Common\Supplier;
use App\Models\Common\TransportType;
use App\Models\Marketing\JobOrder;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Carbon\Carbon;
use App\Functions\CalculatorPrice;
use Illuminate\Support\Facades\DB;

use function Spatie\LaravelPdf\Support\pdf;
use Barryvdh\DomPDF\Facade\Pdf as DomPdf;
use Dompdf\Css\Stylesheet;

class Form extends Component
{
    #[Url]
    public string $action = '';
    #[Url]
    public string $id = '';

    public string $chargeCode = '';

    public ?TaxInvoice $data;

    public Collection $invoice;

    public Collection $invoiceNoTax;

    public Collection $payments;

    public Array $selectedInvoice = [];

    public $tax1;
    public $tax3;
    public $cus_paid;
    public $new_documentID;


    protected array $rules = [
        'payments.*' => 'unique:App\Models\Account\TaxInvoiceItems',
        'payments.*.items' => 'integer',
        'payments.*.comCode' => 'string',
        'payments.*.documentID' => 'string',
        'payments.*.chargeCode' => 'string',
        'payments.*.detail' => 'string',
        'payments.*.chargesCost' => 'float',
        'payments.*.chargesReceive' => 'float',
        'payments.*.chargesbillReceive' => 'float',
    ];

    public function mount()
    {
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        
        if($this->id!=''){
            $this->data = TaxInvoice::where('documentID', $this->id)->first();
            $this->new_documentID = $this->data->documentID;
            $this->payments = $this->data->items;
            $this->changeContact();
            $this->cus_paid = 0;
            if($this->payments) {
                $invNos = array_unique(array_column($this->payments->toArray(), 'invNo'));
                foreach($invNos as $in) {
                    $invoice = Invoice::where('documentID', $in)->first();
                    
                    $this->cus_paid += CalculatorPrice::cal_customer_piad($invoice->ref_jobNo)->sum('sumTotal');
                }
                
            }
            
            
        }else{
            $this->action = 'create';
            $this->data = new TaxInvoice;
            $this->data->createID = Auth::user()->usercode;
            $this->data->documentDate = Carbon::now()->format('Y-m-d');
            
            $this->payments = new Collection;
        }
    }

    #[On('updated-cusCode')]
    public function changeContact(){
        $checkInvoice = true;
        
        if($this->data->cusCode) {

                $this->invoiceNoTax = Invoice::with('taxInvoiceItems')
                    ->select('documentID', 'taxivRef', 'ref_jobNo', 'documentDate')
                    ->where('cusCode', $this->data->cusCode)
                    ->where(function ($query) {
                        $query->where('taxivRef', '')
                            ->orWhereNull('taxivRef');
                    })
                    ->whereDoesntHave('taxInvoiceItems')
                    ->get();
                    

        }
        
        $this->dispatch('updated-table-invoice',  $this->invoiceNoTax );
       
    }

    public function removePayment($index) {
        $this->payments->forget($index-1);
        $this->payments = $this->payments->values();
        $this->updatedInvoice();
    }

    public function addPayment(){
        // dd($this->selectedInvoice);
        $this->invoice = Invoice::whereIn('documentID', $this->selectedInvoice)->get();
        $this->payments = new Collection;
        $this->cus_paid = 0;
        foreach($this->invoice as $inv){
            $inv->items()->each(function($inv_item) use ($inv){
                $newItem = new TaxInvoiceItems([
                    'invNo' => $inv->documentID,
                    'chargeCode' => $inv_item->chargeCode,
                    'detail' => $inv_item->detail,
                    'chargesCost' => $inv_item->chargesCost,
                    'chargesReceive' => $inv_item->chargesReceive,
                    'chargesbillReceive' => $inv_item->chargesbillReceive,
                ]);
                $this->payments->push($newItem);

            });
            $this->cus_paid += CalculatorPrice::cal_customer_piad($inv->ref_jobNo)->sum('sumTotal');
            
        }
        
        
        $this->updatedInvoice();
    }

    public function getInvoiceItem(){
        $this->invoice = Invoice::where([['documentStatus', 'A'], ['taxivRef', null]])->get();
        $this->payments = new Collection;
        foreach($this->invoice as $inv){
            $inv->items()->each(function($inv_item) use ($inv){
                $newItem = new TaxInvoiceItems([
                    'invNo' => $inv->documentID,
                    'chargeCode' => $inv_item->chargeCode,
                    'detail' => $inv_item->detail,
                    'chargesCost' => $inv_item->chargesCost,
                    'chargesReceive' => $inv_item->chargesReceive,
                    'chargesbillReceive' => $inv_item->chargesReceive,
                ]);
                $this->payments->push($newItem);
            });
        }
    }

    #[On('updated-payments')]
    public function updatedInvoice() {
        
        $this->data->total_vat = $this->payments->sum('chargesReceive') * 0.07;
        $this->data->total_amt = $this->data->total_vat + ($this->payments->sum('chargesReceive') + $this->payments->sum('chargesbillReceive'));

        $this->data->tax1 = $this->payments->filter(function (TaxInvoiceItems $item) {
            if($item->chargeCode == null) return false;
            return $item->charges->chargesType->amount == 1;
        })->sum(function(TaxInvoiceItems $payment) {
            return $payment->chargesReceive*0.01;
        });
        $this->data->tax3 = $this->payments->filter(function (TaxInvoiceItems $item) {
            
            if($item->chargeCode == null) return false;
            return $item->charges->chargesType->amount == 3;
        })->sum(function(TaxInvoiceItems $payment) {
           
            return $payment->chargesReceive*0.03;
        });
        $this->data->total_netamt = $this->data->total_amt - ($this->data->tax1 + $this->data->tax3) - $this->cus_paid;
    }


    public function backRoute(){
        $this->redirectRoute(name: 'tax-invoice', navigate: true);
    }

    public function printBillingPDF()
    {
        dd($this->selectedInvoice);
        $pdf = DomPdf::loadView('print.billing_summary_pdf', [
            'title' => "Billing Summary",
        ]);
        // return $pdf->stream('billing-summary.pdf');
        // return view('print.billing_summary_pdf', [
        //     'title' => "billing summary", 
        //     'test' => true]);
        
        return view('print.billing_summary_pdf');
    }

    public function render()
    {
        return view('livewire.page.account.billing-summary.form')->extends('layouts.main')->section('main-content');
    }
}
