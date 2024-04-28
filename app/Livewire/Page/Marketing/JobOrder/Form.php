<?php

namespace App\Livewire\Page\Marketing\JobOrder;

use App\Functions\CalculatorPrice;
use App\Jobs\InvoiceService;
use App\Models\Account\Invoice;
use App\Models\AttachFile;
use App\Models\Common\Charges;
use App\Models\Marketing\BillOfLading;
use App\Models\Marketing\JobOrder;
use App\Models\Marketing\JobOrderAttach;
use App\Models\Marketing\JobOrderCharge;
use App\Models\Marketing\JobOrderContainer;
use App\Models\Marketing\TrailerBooking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
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

    public $job;

    public $createBy;

    public $editBy;

    public $qty = '';

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

    public String $chargeCode = '';

    public ?Invoice $invoice = null;

    public ?BillOfLading $billOfLanding = null;

    public ?TrailerBooking $trailerBooking= null;

    protected array $rules = [
        'file' => 'mimes:png,jpg,jpeg,pdf|max:102400',
        'containerList.*' => 'unique:App\Models\Marketing\JobOrderContainer',
        'chargeCode' => 'string',
        'listCommodity' => 'array',
        // 'job.stu_location' => 'string',
        // 'job.stu_contact' => 'string',
        // 'job.stu_mobile' => 'string',
        // 'job.stu_date' => 'unique:Casts\CustomDate',
        // 'job.cy_location' => 'string',
        // 'job.cy_contact' => 'string',
        // 'job.cy_mobile' => 'string',
        // 'job.cy_date' => 'unique:Casts\CustomDate',
        // 'job.rtn_location' => 'string',
        // 'job.rtn_contact' => 'string',
        // 'job.rtn_mobile' => 'string',
        // 'job.rtn_date' => 'unique:Casts\CustomDate',
        // 'job.trailer_booking' => 'unique:App\Models\Marketing\TrailerBooking',
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
        'containerList.*.refer_container_size' => 'unique:App\Models\Common\ContainerSize',
        'containerList.*.refer_container_size.comCode' => 'string',
        'containerList.*.refer_container_size.containersizeCode' => 'string',
        'containerList.*.refer_container_size.containersizeName' => 'string',
        'containerList.*.refer_container_size.isActive' => 'boolean',
        'containerList.*.refer_container_size.createID' => 'string',
        'containerList.*.refer_container_size.createTime' => 'string',
        'containerList.*.refer_container_size.editID' => 'string',
        'containerList.*.refer_container_size.editTime' => 'string',
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
        'chargeList.*.chargesCost' => 'string',
        'chargeList.*.chargesReceive' => 'string',
        'chargeList.*.chargesbillReceive' => 'string',
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
            $this->job = $this->data->withoutRelations();
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
            $this->data->documentDate = Carbon::now()->format('Y-m-d');
            // $this->data->documentID = JobOrder::GenKey();
            // dd($this->data);
        }
        $this->job = $this->data->withoutRelations();
        $this->containerList = $this->data->containerList ?? new Collection;
        $this->packagedList = $this->data->packedList ?? new Collection;
        $this->goodsList = $this->data->goodsList ?? new Collection;
        $this->chargeList = $this->data->charge ?? new Collection;
        $this->advancePayment = $this->data->AdvancePayment ?? new Collection;
        $this->attachs = $this->data->attachs ?? new Collection;
        // $this->qty = $this->groupedContainer();
        $this->commodity = $this->data->commodity;
        $this->listCommodity = $this->data->commodity->map(function ($item) {
            return $item->commodityCode;
        })->toArray();
        $this->trailerBooking = $this->data->trailerBooking;
        $this->invoice = $this->data->invoice;
        $this->billOfLanding = $this->data->billOfLanding;
        $this->createBy = $this->data->userCreate;
        $this->editBy = $this->data->userEdit;
    }

    public function mount()
    {
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
        if($this->data->AdvancePayment->where('documentstatus', 'P')->count() > 0) {
            return false;
        }
        return true;

    }

    public function copyCyToRtn() {
        if($this->job->cy_location ?? "" != "")
            $this->job->rtn_location = $this->job->cy_location;
        if($this->job->cy_contact ?? "" != "")
            $this->job->rtn_contact = $this->job->cy_contact;
        if($this->job->cy_mobile ?? "" != "")
            $this->job->rtn_mobile = $this->job->cy_mobile;
        if($this->job->cy_date ?? "" != "")
            $this->job->rtn_date = $this->job->cy_date;
    }

    #[On('Add-Container')]
    public function addContainer($typeContainer, $sizeContainer, $quantityContainer)
    {
        $dataContainer = new JobOrderContainer;
        $dataContainer->documentID = $this->job->documentID;
        $dataContainer->comCode = 'C01';
        $dataContainer->containerType = $typeContainer;
        $dataContainer->containerSize = $sizeContainer;
        for ($i = 1; $i <= $quantityContainer; $i++) {
            $this->containerList->push($dataContainer);
        }
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
        $dataPacked->documentID = $this->job->documentID;
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
        $goods->documentID = $this->job->documentID;
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
    }

    #[On('Remove-Charge')]
    public function removeCharge($index)
    {
        $this->chargeList->forget($index);
        $this->chargeList = $this->chargeList->values();
    }

    // public function groupedContainer()
    // {
    //     if ($this->containerList->isNotEmpty()) {
    //         return join(", ", $this->containerList->groupBy('referContainerSize.containersizeName')->map(function ($item, $key) {
    //             return collect($item)->count().'x'.$key;
    //         })->toArray());
    //     } else {
    //         return "";
    //     }
    // }

    public function removePreFile() {
        $this->reset('file');
    }

    public function uploadFile() {
        // dd($this->file->extension());
        if($this->job->cusCode == null|| $this->job->cusCode == '') {
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
        $filename = $new_attach->cusCode.'-'.$date->format('ymd').$date->timestamp.'.'.$this->file->extension();
        $new_file->filename = $filename;
        $new_attach->fileName = $filename;
        $new_attach->save();
        $new_file->save();
        $this->attachs->push($new_attach->refresh());
        $this->reset('file');
    }

    public function removeFile(int $index) {
        $removeFile = $this->attachs->get($index);
        $removeFile->delete();
        $this->attachs->forget($index);
        $this->attachs = $this->attachs->values();
    }

    public function save()
    {
        $this->job->editID = Auth::user()->usercode;
        $calCharge = (object) CalculatorPrice::cal_charge($this->chargeList);
        $this->job->total_vat = $calCharge->tax7;
        $this->job->tax3 = $calCharge->tax3;
        $this->job->tax1 = $calCharge->tax1;
        $this->job->total_amt = ($this->job->charge->sum('chargesReceive') + $this->job->total_vat) + $this->job->charge->sum('chargesbillReceive');
        $this->job->total_netamt =  $this->job->total_amt - ($this->job->tax3 + $this->job->tax1);
        $this->job->cus_paid =  CalculatorPrice::cal_customer_piad($this->id)->sum('sumTotal');
        $this->job->save();
        $this->job->containerList->filter(function($item){
            return !collect($this->containerList->pluck('items'))->contains($item->items);
        })->each->delete();
        $this->job->containerList()->saveMany($this->containerList);
        $this->job->packedList->filter(function($item){
            return !collect($this->packagedList->pluck('items'))->contains($item->items);
        })->each->delete();
        $this->job->packedList()->saveMany($this->packagedList);
        $this->job->goodsList->filter(function($item){
            return !collect($this->goodsList->pluck('items'))->contains($item->items);
        })->each->delete();
        $this->job->goodsList()->saveMany($this->goodsList);
        $this->job->charge->filter(function($item){
            return !collect($this->chargeList->pluck('items'))->contains($item->items);
        })->each->delete();
        $this->job->charge()->saveMany($this->chargeList);
        $this->job->attachs()->saveMany($this->attachs);
        // dd($this->listCommodity);
        // $this->job->commodity()->delete();
        $this->job->commodity()->detach();
        $this->job->commodity()->syncWithoutDetaching($this->listCommodity);
        // $this->job->commodity()->
        // })->each->detach();
        // dd($this->listCommodity);
        $this->redirectRoute(name: 'job-order', navigate: true);
    }

    public function approve()
    {
        $this->job->update([
            'documentstatus' => 'A',
        ]);
        dispatch(new InvoiceService(JobOrder::find($this->job->documentID), Auth::user()->usercode))->onQueue('job-order');
        
        $this->redirectRoute(name: 'job-order', navigate: true);
    }

    public function render()
    {
        return view('livewire.page.marketing.job-order.form')->extends('layouts.main')->section('main-content');
    }
}
