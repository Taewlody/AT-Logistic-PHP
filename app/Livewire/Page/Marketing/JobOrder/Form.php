<?php

namespace App\Livewire\Page\Marketing\JobOrder;

use App\Functions\CalculatorPrice;
use App\Jobs\InvoiceService;
use App\Models\Account\Invoice;
use App\Models\Account\InvoiceItems;
use App\Models\AttachFile;
use App\Models\Common\Charges;
use App\Models\Marketing\BillOfLading;
use App\Models\Marketing\JobOrder;
use App\Models\Marketing\JobOrderAttach;
use App\Models\Marketing\JobOrderCharge;
use App\Models\Marketing\JobOrderContainer;
use App\Models\Marketing\JobOrderWithoutRef;
use App\Models\Marketing\TrailerBooking;
use App\Models\Payment\AdvancePayment;
use App\Models\Payment\AdvancePaymentItems;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\Attributes\WithoutRelations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Marketing\JobOrderPacked;
use App\Models\Marketing\JobOrderGoods;
use Livewire\Features\SupportFileUploads\WithFileUploads;


class Form extends Component
{
    use WithFileUploads;

    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    private ?JobOrder $data = null;

    // #[WithoutRelations]
    public ?JobOrderWithoutRef $job = null;

    public ?User $createBy;

    public ?User $editBy;

    // #[Validate('string')]
    public string $typeContainer = '';
    // #[Validate('string')]
    public string $sizeContainer = '';

    // #[Validate('numeric|min:0')]
    public int $quantityContainer = 0;

    public Collection $containerList;

    public Collection $packagedList;

    public Collection $goodsList;

    public Collection $chargeList;

    public Collection $advancePayment;

    public Collection $attachs;

    public Collection $commodity;

    public $listCommodity = [];

    public $file;

    public $checkApprove = true;

    public string $chargeCode = '';

    public ?Invoice $invoice = null;

    public ?BillOfLading $billOfLanding = null;

    public ?TrailerBooking $trailerBooking = null;

    protected array $rules = [
        'file' => 'mimes:png,jpg,jpeg,pdf|max:102400',
        'containerList.*' => 'unique:App\Models\Marketing\JobOrderContainer',
        'containerList.*.items' => 'integer',
        'containerList.*.comCode' => 'string',
        'containerList.*.documentID' => 'required|string',
        'containerList.*.containerType' => 'string',
        'containerList.*.containerSize' => 'string',
        'containerList.*.containerNo' => 'string',
        'containerList.*.containerSealNo' => 'string',
        'containerList.*.containerGW' => 'string',
        'containerList.*.containerGW_unit' => 'string',
        'containerList.*.containerNW' => 'string',
        'containerList.*.containerNW_Unit' => 'string',
        'containerList.*.containerTareweight' => 'string',
        'containerList.*.size' => 'unique:App\Models\Common\ContainerSize',
        'containerList.*.size.comCode' => 'string',
        'containerList.*.size.containersizeCode' => 'string',
        'containerList.*.size.containersizeName' => 'string',
        'containerList.*.size.isActive' => 'boolean',
        'containerList.*.size.createID' => 'string',
        'containerList.*.size.createTime' => 'string',
        'containerList.*.size.editID' => 'string',
        'containerList.*.size.editTime' => 'string',
        'containerList.*.type' => 'unique:App\Models\Common\ContainerType',
        'containerList.*.type.comCode' => 'string',
        'containerList.*.type.containerTypeCode' => 'string',
        'containerList.*.type.containerTypeName' => 'string',
        'containerList.*.type.isActive' => 'boolean',
        'containerList.*.type.createID' => 'string',
        'containerList.*.type.createTime' => 'string',
        'containerList.*.type.editID' => 'string',
        'containerList.*.type.editTime' => 'string',
        'packagedList.*' => 'unique:App\Models\Marketing\JobOrderPacked',
        'packagedList.*.items' => 'integer',
        'packagedList.*.comCode' => 'string',
        'packagedList.*.documentID' => 'required|string',
        'packagedList.*.packaed_width' => 'string',
        'packagedList.*.packaed_length' => 'string',
        'packagedList.*.packaed_height' => 'string',
        'packagedList.*.packaed_qty' => 'string',
        'packagedList.*.packaed_weight' => 'string',
        'packagedList.*.packaed_unit' => 'string',
        'packagedList.*.packaed_totalCBM' => 'string',
        'packagedList.*.packaed_totalWeight' => 'string',
        'goodsList.*' => 'unique:App\Models\Marketing\JobOrderGoods',
        'goodsList.*.items' => 'integer',
        'goodsList.*.comCode' => 'string',
        'goodsList.*.documentID' => 'required|string',
        'goodsList.*.goodNo' => 'string',
        'goodsList.*.goodDec' => 'string',
        'goodsList.*.goodWeight' => 'string',
        'goodsList.*.good_unit' => 'string',
        'goodsList.*.goodUnit' => 'string',
        'goodsList.*.goodSize' => 'string',
        'goodsList.*.goodKind' => 'string',
        'chargeList.*' => 'unique:App\Models\Marketing\JobOrderCharge',
        'chargeList.*.items' => 'integer',
        'chargeList.*.comCode' => 'string',
        'chargeList.*.documentID' => 'required|string',
        'chargeList.*.ref_paymentCode' => 'string',
        'chargeList.*.chargeCode' => 'string',
        'chargeList.*.detail' => 'string',
        'chargeList.*.price' => 'integer',
        'chargeList.*.volume' => 'integer',
        'chargeList.*.exchange' => 'integer',
        'chargeList.*.chargesCost' => 'numeric',
        'chargeList.*.chargesReceive' => 'numeric',
        'chargeList.*.chargesbillReceive' => 'numeric',
        'attachs.*' => 'unique:App\Models\Marketing\JobOrderAttach',
        'attachs.*.items' => 'integer',
        'attachs.*.comCode' => 'string',
        'attachs.*.documentID' => 'string',
        'attachs.*.cusCode' => 'string',
        'attachs.*.fileDetail' => 'string',
        'attachs.*.fileName' => 'string',
    ];

    public function boot()
    {
        $this->data = new JobOrder;
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '' && JobOrder::find($this->id) != null) {
            $this->data = JobOrder::find($this->id);
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
            $this->data->documentDate = Carbon::now()->format('Y-m-d');
        }
        $this->createBy = User::find($this->data->createID);
        $this->editBy = User::find($this->data->editID);
    }

    public function mount()
    {
        $this->job = new JobOrderWithoutRef($this->data->withoutRelations()->toArray());
        $this->job->exists = $this->data->exists;
        $this->containerList = $this->data->containerList ?? new Collection;
        $this->packagedList = $this->data->packedList ?? new Collection;
        $this->goodsList = $this->data->goodsList ?? new Collection;
        $this->chargeList = $this->data->charge ?? new Collection;
        $this->advancePayment = $this->data->AdvancePayment ?? new Collection;
        $this->attachs = $this->data->attachs ?? new Collection;
        $this->commodity = $this->data->commodity;
        $this->listCommodity = $this->data->commodity->map(function ($item) {
            return $item->commodityCode;
        })->toArray();
        $this->trailerBooking = $this->data->trailerBooking;
        $this->invoice = $this->data->invoice;
        $this->billOfLanding = $this->data->billOfLanding;
        $this->checkApprove = $this->checkApprove();
    }

    private function checkApprove()
    {
        if ($this->data->documentstatus == 'A') {
            return false;
        }
        if ($this->data->PaymentVoucher->where('documentstatus', 'P')->count() > 0) {
            return false;
        }
        if ($this->data->PettyCash->where('documentstatus', 'P')->count() > 0) {
            return false;
        }
        if ($this->data->AdvancePayment->where('documentstatus', 'P')->count() > 0) {
            return false;
        }
        return true;

    }

    public function copyCyToRtn()
    {
        if ($this->job->cy_location ?? "" != "")
            $this->job->rtn_location = $this->job->cy_location;
        if ($this->job->cy_contact ?? "" != "")
            $this->job->rtn_contact = $this->job->cy_contact;
        if ($this->job->cy_mobile ?? "" != "")
            $this->job->rtn_mobile = $this->job->cy_mobile;
        if ($this->job->cy_date ?? "" != "")
            $this->job->rtn_date = $this->job->cy_date;
    }

    #[On('Add-Container')]
    public function addContainer()
    {
        $dataContainer = new JobOrderContainer;
        $dataContainer->containerType = $this->typeContainer;
        $dataContainer->containerSize = $this->sizeContainer;
        for ($i = 1; $i <= $this->quantityContainer; $i++) {
            $this->containerList->push($dataContainer);
        }
        $this->reset('typeContainer', 'sizeContainer', 'quantityContainer');
        $this->dispatch('reset-select2-typeContainer');
        $this->dispatch('reset-select2-sizeContainer');
    }

    #[On('Remove-Container')]
    public function removeContainer(int $index)
    {
        $this->containerList->forget($index);
        $this->containerList = $this->containerList->values();
    }

    #[On('Add-Packaged')]
    public function addRowPacked()
    {
        $dataPacked = new JobOrderPacked;
        $dataPacked->documentID = $this->data->documentID;
        $dataPacked->comCode = 'C01';
        $this->packagedList->push($dataPacked);
    }

    #[On('Remove-Packaged')]
    public function removeRowPacked(int $index)
    {
        $this->packagedList->forget($index);
        $this->packagedList = $this->packagedList->values();
    }

    #[On('Add-Goods')]
    public function addGoods()
    {
        $goods = new JobOrderGoods;
        $goods->documentID = $this->data->documentID;
        $goods->comCode = 'C01';
        $this->goodsList->push($goods);
    }

    #[On('Remove-Goods')]
    public function removeGoods(int $index)
    {
        $this->goodsList->forget($index);
        $this->goodsList = $this->goodsList->values();
    }

    #[On('Add-Charge')]
    public function addCharge()
    {
        $charge = new JobOrderCharge;
        $charge->chargeCode = $this->chargeCode;
        $getCharge = Charges::find($this->chargeCode);
        if ($getCharge != null) {
            $charge->detail = $getCharge->chargeName;
        }
        $this->chargeList->push($charge);
        $this->reset('chargeCode');
        $this->dispatch('reset-select2-chargeCode');
    }

    #[On('Remove-Charge')]
    public function removeCharge($index)
    {
        $this->chargeList->forget($index);
        $this->chargeList = $this->chargeList->values();
    }

    #[On('commission-sale')]
    public function commissionSale(string $value)
    {
        // dd($value);
        $this->job->commission_sale = $value;
    }

    #[On('commission-customers')]
    public function commissionCustomers(string $value)
    {
        // dd($value);
        $this->job->commission_customers = $value;
        // dd($this->job->commission_customers);
    }

    #[Computed]
    public function groupedContainer()
    {
        if ($this->containerList->isNotEmpty()) {
            return join(", ", $this->containerList->groupBy('size.containersizeName')->map(function ($item, $key) {
                return collect($item)->count() . 'x' . $key;
            })->toArray());
        } else {
            return "";
        }
    }

    public function removePreFile()
    {
        $this->reset('file');
    }

    public function uploadFile()
    {
        if ($this->job->cusCode == null || $this->job->cusCode == '') {
            $this->addError('cusCodeEmpty', 'Please select customer');
            return;
        }
        $date = Carbon::now();
        $new_attach = new JobOrderAttach;
        $new_file = new AttachFile;
        $new_attach->documentID = $this->job->documentID;
        $new_attach->cusCode = $this->job->cusCode ?? '';
        $new_file->mimetype = $this->file->getMimeType();
        $new_file->blobfile = file_get_contents($this->file->getRealPath());
        $filename = $new_attach->cusCode . '-' . $date->format('ymd') . $date->timestamp . '.' . $this->file->extension();
        $new_file->filename = $filename;
        $new_attach->fileName = $filename;
        $new_attach->save();
        $new_file->save();
        $this->attachs->push($new_attach->refresh());
        $this->reset('file');
    }

    public function removeFile(int $index)
    {
        $removeFile = $this->attachs->get($index);
        $removeFile->delete();
        $this->attachs->forget($index);
        $this->attachs = $this->attachs->values();
    }

    public function vaildJob()
    {
        // dd($this->job);
        if ($this->job->invNo == null || $this->job->invNo == '') {
            $this->addError('invNo', 'Please enter invoice no');
            return false;
        } else if ($this->job->bookingNo == null || $this->job->bookingNo == '') {
            $this->addError('bookingNo', 'Please enter booking no');
            return false;
        } else if ($this->job->cusCode == null || $this->job->cusCode == '') {
            $this->addError('cusCode', 'Please select customer');
            return false;
        } else if ($this->job->agentCode == null || $this->job->agentCode == '') {
            $this->addError('agentCode', 'Please select agent');
            return false;
        } else if ($this->job->feeder == null || $this->job->feeder == '') {
            $this->addError('feeder', 'Please enter feeder');
            return false;
        } else {
            return true;
        }
    }

    public function save(bool|null $approve = false)
    {
        if (!$this->vaildJob()) {
            return false;
        }
        $this->data = new JobOrder($this->job->toArray());

        // check delivery type to validate
        if ($this->data->deliveryType) {
            if ($this->data->deliveryType === 'FCL') {
                $this->resetValidation();
                if (count($this->containerList) == 0) {
                    $this->addError('containerList', 'Please enter container');
                    return false;
                }
            } else if ($this->data->deliveryType === 'LCL') {
                $this->resetValidation();
                if (count($this->packagedList) == 0) {
                    $this->addError('packagedList', 'Please enter packaged');
                    return false;
                }
            }
        }

        $this->data->exists = $this->job->exists;
        if ($approve) {
            $this->data->documentstatus = 'A';
        }
        $this->data->editID = Auth::user()->usercode;
        $calCharge = CalculatorPrice::cal_charge($this->chargeList);
        $this->data->total_vat = $calCharge->tax7;
        $this->data->tax3 = $calCharge->tax3;
        $this->data->tax1 = $calCharge->tax1;
        $this->data->total_amt = ($this->data->charge->sum('chargesReceive') + $this->data->total_vat) + $this->data->charge->sum('chargesbillReceive');
        $this->data->total_netamt = $this->data->total_amt - ($this->data->tax3 + $this->data->tax1);
        $this->data->cus_paid = CalculatorPrice::cal_customer_piad($this->id)->sum('sumTotal');
        // dd($this->data);
        $this->data->save();
        $this->data->containerList->filter(function ($item) {
            return !collect($this->containerList->pluck('items'))->contains($item->items);
        })->each->delete();
        $this->data->containerList()->saveMany($this->containerList);
        $this->data->packedList->filter(function ($item) {
            return !collect($this->packagedList->pluck('items'))->contains($item->items);
        })->each->delete();
        $this->data->packedList()->saveMany($this->packagedList);
        $this->data->goodsList->filter(function ($item) {
            return !collect($this->goodsList->pluck('items'))->contains($item->items);
        })->each->delete();
        $this->data->goodsList()->saveMany($this->goodsList);
        $this->data->charge->filter(function ($item) {
            return !collect($this->chargeList->pluck('items'))->contains($item->items);
        })->each->delete();
        $this->data->charge()->saveMany($this->chargeList);
        $this->data->attachs()->saveMany($this->attachs);
        $this->data->commodity()->detach();
        $this->data->commodity()->syncWithoutDetaching($this->listCommodity);
        return true;
    }

    public function submit()
    {
        $success = $this->save();
        if ($success) {
            // $this->redirectRoute(name: 'job-order', navigate: true);\
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
        } else {
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    public function approve()
    {
        $success = $this->save(true);
        if($success) {
            $this->createInvoice();
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'Approve สำเร็จ', type: 'success');
        }else {
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'Approve ไม่สำเร็จ', type: 'error');
        }
        // dispatch(new InvoiceService(JobOrder::find($this->data->documentID), Auth::user()->usercode))->onQueue('job-order');
        // $this->redirectRoute(name: 'job-order', navigate: true);
    }

    public function exception($e, $stopProgation)
    {
        dd($e, $stopProgation);
        // Log::error($e);
    }

    private function createInvoice()
    {
        $this->data->refresh();
        $Item_invoice = new Collection;
        $invoice = Invoice::where('ref_jobNo', $this->data->documentID)->firstOrCreate();
        // dd($invoice);
        $invoice->documentDate = $this->data->documentDate;
        $invoice->ref_jobNo = $this->data->documentID;
        $invoice->cusCode = $this->data->cusCode;
        $invoice->saleman = $this->data->saleman;
        $invoice->carrier = $this->data->agentCode;
        $invoice->bound = $this->data->bound;
        $invoice->freight = $this->data->freight;
        if ($invoice->exists) {
            $invoice->editID = Auth::user()->usercode;
            $invoice->editTime = Carbon::now();
        } else {
            $invoice->createID = Auth::user()->usercode;
            $invoice->createTime = Carbon::now();
        }
        $invoice->save();
        Log::info("Generate Invoice for Job Order ID: " . $invoice);
        if ($invoice->exists) {
            $invoice->items()->delete();
        }
            $this->data->charge->each(function (JobOrderCharge $item) use ($Item_invoice) {
                $i = new InvoiceItems;
                $i->documentID = $item->documentID;
                $i->chargeCode = $item->chargeCode;
                $i->detail = $item->detail;
                $i->chargesCost = $item->chargesCost ?? 0;
                $i->chargesReceive = $item->chargesReceive ?? 0;
                $i->chargesbillReceive = $item->chargesbillReceive ?? 0;
                $Item_invoice->push($i);
            });

            $this->data->AdvancePayment->each(function (AdvancePayment $advancePayment) use ($invoice, $Item_invoice) {
                $advancePayment->items->each(function (AdvancePaymentItems $item) use ($invoice, $Item_invoice) {
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
            $invoice->items()->saveMany($Item_invoice);
        
        Cache::forget('job-order-select');
    }

    public function render()
    {
        return view('livewire.page.marketing.job-order.form')->extends('layouts.main')->section('main-content');
    }
}
