<?php

namespace App\Jobs;

use App\Models\Account\Invoice;
use App\Models\Account\InvoiceItems;
use App\Models\Marketing\JobOrder;
use App\Models\Marketing\JobOrderCharge;
use App\Models\Payment\AdvancePayment;
use App\Models\Payment\AdvancePaymentItems;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class InvoiceService implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $item_change;
    protected $customer_piad;
    protected JobOrder $joborder;
    protected $usercode;

    /**
     * Create a new job instance.
     */
    public function __construct(JobOrder $joborder, $user)
    {
        // $this->onQueue('processing');
        $this->item_change = $joborder->charge;
        $this->customer_piad = $joborder->AdvancePayment;
        $this->joborder = $joborder->withoutRelations();
        $this->usercode = $user;
        // Log::info("Generate Invoice for Job Order ID: ".$joborder->documentID);
    }

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return $this->joborder->documentID;
    }

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    public $failOnTimeout = true;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Generate handle Invoice for User: ".print_r($this->usercode));
        $Item_invoice = new Collection;
        $invoice = new Invoice;
        $invoice->documentID = Invoice::genarateKey();
        $invoice->documentDate = $this->joborder->documentDate;
        $invoice->ref_jobNo = $this->joborder->documentID;
        $invoice->cusCode = $this->joborder->cusCode;
        $invoice->saleman = $this->joborder->saleman;
        $invoice->carrier = $this->joborder->agentCode;
        $invoice->bound = $this->joborder->bound;
        $invoice->freight = $this->joborder->freight;
        $invoice->createID = $this->usercode;
        $invoice->createTime = Carbon::now();
        $invoice->save();
        Log::info("Generate Invoice for Job Order ID: " . $invoice);
        $this->item_change->each(function (JobOrderCharge $item) use ($invoice, $Item_invoice) {
            $i = new InvoiceItems;
            $i->documentID = $item->documentID;
            $i->chargeCode = $item->chargeCode;
            $i->detail = $item->detail;
            $i->chargesCost = $item->chargesCost ?? 0;
            $i->chargesReceive = $item->chargesReceive ?? 0;
            $i->chargesbillReceive = $item->chargesbillReceive ?? 0;
            $Item_invoice->push($i);

        });

        $this->customer_piad->each(function(AdvancePayment $advancePayment) use ($invoice, $Item_invoice){
            $advancePayment->items->each(function(AdvancePaymentItems $item) use ($invoice, $Item_invoice){
                $i = new InvoiceItems;
                $i->documentID = $item->documentID;
                $i->chargeCode = $item->chargeCode;
                $i->detail = $item->detail;
                $i->chargesCost = $item->amount ?? 0;
                $Item_invoice->push($i);
                $item->update([
                    "invNo" => $invoice->documentID,
                ]);
            });
        });
        // Log::info("item_invoice" . print_r($Item_invoice, true));
        $invoice->items()->saveMany($Item_invoice);
        // $this->release();
    }

    /**
     * The job failed to process.
     */
    public function failed($exception): void
    {
        Log::error("Generate Invoice for Job Order ID: " . $this->joborder->documentID . " failed with exception: " . $exception->getMessage());
        // $this->release(delay: 60);
    }

    // public function retryUntil(): DateTime
    // {
    //     return now()->addMinutes(1);
    // }
}
