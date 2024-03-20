<?php

namespace App\Livewire\Page\Marketing\JobOrder;

use App\Functions\CalculatorPrice;
use App\Models\AttachFile;
use App\Models\Common\Charges;
use App\Models\Marketing\JobOrder;
use App\Models\Marketing\JobOrderAttach;
use App\Models\Marketing\JobOrderCharge;
use App\Models\Marketing\JobOrderContainer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
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

    public Collection $containerList;

    public Collection $packagedList;

    public Collection $goodsList;

    public Collection $chargeList;

    public Collection $advancePayment;

    public Collection $attachs;

    public $file;

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

    }

    public function mount()
    {
        $this->data = new JobOrder;
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = JobOrder::find($this->id);
            if ($this->data == null) {
                $this->data = new JobOrder;
            }
            // dd($this->data);
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
            // $this->data->documentID = JobOrder::GenKey();
            // dd($this->data);
        }
        // dd($this->data, new JobOrder);
        $this->job = $this->data->withoutRelations();
        // if($this->job->good_total_num_package == null) $this->job->good_total_num_package = '';
        // if($this->job->good_commodity == null) $this->job->good_commodity = '';
        $this->createBy = $this->data->userCreate;
        $this->editBy = $this->data->userEdit;
        $this->containerList = $this->data->containerList;
        $this->packagedList = $this->data->packedList;
        $this->goodsList = $this->data->goodsList;
        $this->chargeList = $this->data->charge;
        $this->advancePayment = $this->data->AdvancePayment;
        $this->attachs = $this->data->attachs;
        // dd($this->job->toArray());
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
        // $this->skipRender();
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

    #[On('Update-Good-Total-Num-Package')]
    public function GoodTotalPackage($value)
    {
        $this->job->good_total_num_package = $value;
        $this->skipRender();
    }

    #[On('Update-Good-Commodity')]
    public function GoodCommodity($value)
    {
        $this->job->good_commodity = $value;
        $this->skipRender();
    }

    #[On('Add-Charge')]
    public function addCharge($chargeCode)
    {
        $charge = new JobOrderCharge;
        $charge->documentID = $this->job->documentID;
        $charge->comCode = 'C01';
        $charge->chargeCode = $chargeCode;
        $getCharge = Charges::find($chargeCode);
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

    #[Computed]
    public function groupedContainer()
    {
        if ($this->containerList->isNotEmpty()) {
            return $this->containerList->groupBy('referContainerSize.containersizeName')->map(function ($item, $key) {
                return collect($item)->count().'x'.$key;
            })->toArray();
        } else {
            return [];
        }

    }

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
        $calCharge = (object) CalculatorPrice::cal_charge($this->value);
        $this->job->total_vat = $calCharge->tax7;
        $this->job->tax3 = $calCharge->tax3;
        $this->job->tax1 = $calCharge->tax1;
        $this->job->total_amt = ($this->job->charge->sum('chargesReceive') + $this->job->total_vat) + $this->job->charge->sum('chargesbillReceive');
        $this->job->total_netamt =  $this->job->total_amt - ($this->job->tax3 + $this->job->tax1);
        $this->job->cus_paid = CalculatorPrice::cal_customer_piad($this->documentID)->sum('sumTotal');
        $this->job->save();
        $this->job->containerList()->saveMany($this->containerList->map(function (JobOrderContainer $item) {
            if ($item->documentID == null || $item->documentID == '') {
                $item->documentID = $this->job->getKey();
            }
            return $item;
        }));
        $this->job->packedList()->saveMany($this->packagedList->map(function (JobOrderPacked $item) {
            if ($item->documentID == null || $item->documentID == '') {
                $item->documentID = $this->job->getKey();
            }
            return $item;
        }));
        $this->job->goodsList()->saveMany($this->goodsList->map(function (JobOrderGoods $item) {
            if ($item->documentID == null || $item->documentID == '') {
                $item->documentID = $this->job->getKey();
            }
            return $item;
        }));
        $this->job->charge()->saveMany($this->chargeList->map(function (JobOrderCharge $item) {
            if ($item->documentID == null || $item->documentID == '') {
                $item->documentID = $this->job->getKey();
            }
            return $item;
        }));
        $this->job->attachs()->saveMany($this->attachs->map(function (JobOrderAttach $item) {
            if ($item->documentID == null || $item->documentID == '') {
                $item->documentID = $this->job->getKey();
            }
            return $item;
        }));
        $this->redirectRoute('job-order');
    }

    public function render()
    {
        return view('livewire.page.marketing.job-order.form')->extends('layouts.main')->section('main-content');
    }
}
