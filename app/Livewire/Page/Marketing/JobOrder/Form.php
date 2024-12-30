<?php

namespace App\Livewire\Page\Marketing\JobOrder;

use App\Functions\CalculatorPrice;
use App\Jobs\InvoiceService;
use App\Models\Account\Invoice;
use App\Models\Account\InvoiceItems;
use App\Models\Payment\PaymentVoucher;
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
use App\Models\PettyCash\PettyCash;
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
use Illuminate\Support\Facades\DB;


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

    public Collection $attachsPaymentVoucher;
    public Collection $attachsAdvancePayment;
    public Collection $attachs;
    public Collection $PaymentVoucher;

    public Collection $commodity;

    public $listCommodity = [];

    public $file;

    public $checkApprove = true;

    public string $chargeCode = '';

    public ?Invoice $invoice = null;

    public ?BillOfLading $billOfLanding = null;

    public ?TrailerBooking $trailerBooking = null;
    public $message = null;

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
        
    }

    public function mount()
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

        
        $this->job = new JobOrderWithoutRef($this->data->withoutRelations()->toArray());
        $this->job->exists = $this->data->exists;
        $this->containerList = $this->data->containerList ?? new Collection;
        $this->packagedList = $this->data->packedList ?? new Collection;
        $this->goodsList = $this->data->goodsList ?? new Collection;

        $this->chargeList = new Collection;
        foreach($this->data->charge as $item) {
            // if($item->ref_paymentCode) {
            //     $payment = PaymentVoucher::where('documentID', $item->ref_paymentCode)->first();
            //     // $petty = PettyCash::where('refJobNo', $this->data->documentID)->first();
            //     if($payment) {
            //         $this->chargeList->push($item);
            //     }else {
            //         $this->chargeList->push($item);
            //     }
            // }else {
                $this->chargeList->push($item);
            // }
        }

        $this->advancePayment = $this->data->AdvancePayment ?? new Collection;
        $this->attachs = $this->data->attachs ?? new Collection;
        
        $this->attachsPaymentVoucher = new Collection;
        foreach ($this->data->PaymentVoucher as $item) {
            foreach ($item->attachs as $attach) {
                $this->attachsPaymentVoucher->push($attach);
            }
        }
        $this->attachsAdvancePayment = new Collection;
        foreach ($this->data->AdvancePayment as $item) {
            foreach ($item->attachs as $attach) {
                $this->attachsAdvancePayment->push($attach);
            }
        }
        
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
        // if ($this->data->documentstatus == 'A') {
        //     return false;
        // }
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
        // $dataPacked->documentID = $this->data->documentID;
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
        // $goods->documentID = $this->data->documentID;
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
        $this->dispatch('update-charges');
    }

    #[On('Remove-Charge')]
    public function removeCharge($index)
    {
        // dd($index);
        $this->chargeList->forget($index);
        $this->chargeList = $this->chargeList->values();
        $this->dispatch('update-charges');
    }

    #[On('updated-commissionSale')]
    public function commissionSale(string $value)
    {
        
        $this->job->commission_sale = $value;
    }

    #[On('updated-commissionCustomers')]
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

    #[Computed]
    public function groupedPackage()
    {
        if ($this->packagedList->isNotEmpty()) {
            
            $total = null;
            foreach($this->packagedList as $pack) {
                $size = ($pack->packaed_width * $pack->packaed_length * $pack->packaed_height) / 1000000;
                $sum = $size * $pack->packaed_qty;
                $total += $sum;
            }
            
            return round($total, 2);
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

    public function checkBill($to) {
        
        if(count($this->chargeList) > 0) {

            $check = $this->chargeList->groupBy('detail')->filter(function($item) {
                // dd($item);
                if($item->sum('chargesbillReceive') < $item->sum('chargesCost')) {
                    return $item;
                }
            });
            // $check = $this->chargeList->filter(function($item) {
            //     if($item->chargesbillReceive < $item->chargesCost) {
            //         return $item;
            //     }
            // });
            
            if(count($check)>0) {
                $this->dispatch('modal.job-order.charges-alert', showModal: true, confirmTo: $to);

            }else {
                $this->dispatch($to);
            }
            
        }else {
            $this->dispatch($to);
        }
    }

    public function vaildJob()
    {
        // dd($this->job);
        if ($this->job->invNo == null || $this->job->invNo == '') {
            $this->addError('invNo', 'Please enter invoice no');
            // dd($this->addError('invNo', 'Please enter invoice no'));
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
        } else if ($this->job->bound == null || $this->job->bound == '') {
            $this->addError('bound', 'Please enter bound');
            return false;
        } else if($this->job->freight == null || $this->job->freight == '') {
            $this->addError('freight', 'Please enter freight');
            return false;
        } else if($this->job->deliveryType == null || $this->job->deliveryType == '') {
            $this->addError('deliveryType', 'Please enter delivery type');
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
        
        if($this->data->invNo) {
            $checkInv = JobOrder::where('invNo', $this->data->invNo)->where('invNo', '!=', 'N/A')->where('documentID', '!=', $this->data->documentID)->first();
            if($checkInv !== null) {
                $this->addError('invNo', 'INV No. is Duplicate');
                return false;
            }
        }

        if ($this->data->bookingNo !== null) {
            $checkBooking = JobOrder::where('bookingNo', $this->data->bookingNo)->where('bookingNo', '!=', 'N/A')->where('documentID', '!=', $this->data->documentID)->first();
            
            if($checkBooking) {
                $this->addError('bookingNo', 'Booking No. is Duplicate');
                return false;
            }
        }
        // dd($this->data->bound, $this->data->bill_of_landing);
        if($this->data->bound == 1){
            if ($this->data->bill_of_landing !== null) {
                $checkBillOfLanding = JobOrder::where('bill_of_landing', $this->data->bill_of_landing)->where('bill_of_landing', '!=', 'N/A')->where('documentID', '!=', $this->data->documentID)->first();
                
                if($checkBillOfLanding) {
                    $this->addError('bill_of_landing', 'Bill Of Lading. is Duplicate');
                    return false;
                }
            }else {
                $this->addError('bill_of_landing', 'Please enter Bill Of Lading');
                return false;
            }
        }

        \DB::beginTransaction();
        try {
            // dd($this->data);
            $this->data->exists = $this->job->exists;
            
            $calCharge = CalculatorPrice::cal_charge($this->chargeList, $this->job->commission_sale, $this->job->commission_customers);
            $calCusPaid = $this->id ? CalculatorPrice::cal_customer_piad($this->id)->sum('sumTotal') : 0.00;
            
            // dd($this->chargeList, $calCharge);

            $this->data->editID = Auth::user()->usercode;
            $this->data->total_vat = $calCharge->tax7;
            $this->data->tax3 = $calCharge->tax3;
            $this->data->tax1 = $calCharge->tax1;
            $this->data->total_amt = $calCharge->total;
            // $this->data->total_netamt = $this->data->total_amt - ($this->data->tax3 + $this->data->tax1);
            $this->data->total_netamt =  ($calCharge->total + $this->chargeList->sum('chargesbillReceive')) - ($calCharge->tax3 + $calCharge->tax1);
            $this->data->cus_paid = $calCusPaid;
            
            if ($approve) {
                
                $this->data->documentstatus = 'A';
                $this->message = '';
                if(!$this->checkApprove) {
                   
                    $this->message = 'กรุณา Approve Payment Voucher, Petty Cash, Advance Payment ให้เรียบร้อย';
                    return false;
                    
                }
            }
            $this->data->editTime = Carbon::now();
            
            $this->data->save();
        
            $this->data->containerList->filter(function ($item) {
                return !collect($this->containerList->pluck('items'))->contains($item->items);
            })->each->delete();
            $this->data->containerList()->saveMany($this->containerList);

            // $this->data->packedList->filter(function ($item) {
            //     return !collect($this->packagedList->pluck('items'))->contains($item->items);
            // })->each->delete();
            // $this->data->packedList()->saveMany($this->packagedList);

            $this->data->packedList()->delete();
            foreach( $this->packagedList as $pack ) {
                $data = new JobOrderPacked();
                $data->comCode = $pack->comCode;
                $data->documentID = $this->data->documentID;
                $data->packaed_width = $pack->packaed_width;
                $data->packaed_length = $pack->packaed_length;
                $data->packaed_height = $pack->packaed_height;
                $data->packaed_qty = $pack->packaed_qty;
                $data->packaed_weight = $pack->packaed_weight;
                $data->packaed_unit = $pack->packaed_unit;
                $data->packaed_totalCBM = $pack->packaed_totalCBM;
                $data->packaed_totalWeight = $pack->packaed_totalWeight;
                $this->data->packedList()->save($data);
            }


            // $this->data->goodsList->filter(function ($item) {
            //     return !collect($this->goodsList->pluck('items'))->contains($item->items);
            // })->each->delete();
            // $this->data->goodsList()->saveMany($this->goodsList);

            $this->data->goodsList()->delete();
            foreach( $this->goodsList as $good ) {
                $data = new JobOrderGoods();
                $data->comCode = $good->comCode;
                $data->documentID = $this->data->documentID;
                $data->goodNo = $good->goodNo;
                $data->goodDec = $good->goodDec;
                $data->goodWeight = $good->goodWeight;
                $data->good_unit = $good->good_unit;
                $data->goodSize = $good->goodSize;
                $data->goodKind = $good->goodKind;
                $this->data->goodsList()->save($data);
            }

            $this->data->charge()->delete();
            foreach( $this->chargeList as $charge ) {
                $data = new JobOrderCharge();
                $data->comCode = $charge->comCode;
                $data->chargesCost = $charge->chargesCost;
                $data->chargesReceive = $charge->chargesReceive;
                $data->chargesbillReceive = $charge->chargesbillReceive;
                $data->documentID = $charge->documentID;
                $data->ref_paymentCode = $charge->ref_paymentCode;
                $data->chargeCode = $charge->chargeCode;
                $data->detail = $charge->detail;
                $this->data->charge()->save($data);
            }
            // $this->data->charge()->saveMany($this->chargeList);
            // dd($this->data->charge, $this->chargeList);

            $this->data->attachs()->saveMany($this->attachs);
            $this->data->commodity()->detach();
            $this->data->commodity()->syncWithoutDetaching($this->listCommodity);
            // dd($this->data, $this->id);
            \DB::commit();
            // dd($this->data);
            return true;
        }catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception->getMessage());
            echo "Exception caught: " . $exception->getMessage();
            return false;
        }
    }

    public function submit()
    {
        $this->checkBill('submit-after-confirm-charge');
    }

    #[On('submit-after-confirm-charge')]
    public function submitAfterConfirmCharge()
    {
        $success = $this->save();
        
        if ($success) {
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
            return redirect()->route('job-order.form', ['action' => 'edit', 'id' => $this->data->documentID]);
        } else {
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    public function approve()
    {
        $this->checkBill('approve-after-confirm-charge');
    }

    #[On('approve-after-confirm-charge')]
    public function approveAfterConfirmCharge()
    {
        $success = $this->save(true);
        
        if($success) {
            $create = $this->createInvoice();
            // dd($create);
            if($create) {
                $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'Approve สำเร็จ', type: 'success');
                return redirect()->route('job-order.form', ['action' => 'edit', 'id' => $this->data->documentID]);

            }else {
                $this->dispatch('vaildated');
                $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: $this->message ? $this->message : 'Approve ไม่สำเร็จ', type: 'error');
            }

        }else {
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: $this->message ? $this->message : 'Approve ไม่สำเร็จ', type: 'error');
        }
    }

    public function update()
    {
        $this->checkBill('update-after-confirm-charge');
    }

    #[On('update-after-confirm-charge')]
    public function updateAfterConfirmCharge()
    {
        $success = $this->save(true);
        
        if($success) {
            $create = $this->createInvoice();
            // dd($create);
            if($create) {
                $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'Update สำเร็จ', type: 'success');
                return redirect()->route('job-order.form', ['action' => 'edit', 'id' => $this->data->documentID]);

            }else {
                $this->dispatch('vaildated');
                $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: $this->message ? $this->message : 'Update ไม่สำเร็จ', type: 'error');
            }
            
            
        }else {
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: $this->message ? $this->message : 'Update ไม่สำเร็จ', type: 'error');
        }
        
    }

    public function exception($e, $stopProgation)
    {
        dd($e, $stopProgation);
        // Log::error($e);
    }

    private function createInvoice()
    {
        DB::beginTransaction();
        try {
            $this->data->refresh();
            $Item_invoice = new Collection;
            $invoice = Invoice::where('ref_jobNo', $this->data->documentID)->firstOrNew();
            // dd($this->data, $invoice);
           
            if($invoice->documentID == null) {
                $invoice->documentDate = Carbon::now()->format('Y-m-d');
            }
            $invoice->ref_jobNo = $this->data->documentID;
            $invoice->cusCode = $this->data->cusCode;
            $invoice->saleman = $this->data->saleman;
            $invoice->carrier = $this->data->agentCode;
            $invoice->bound = $this->data->bound;
            $invoice->freight = $this->data->freight;
            $invoice->documentstatus = 'A';
            $invoice->total_amt = $this->data->total_amt;
            $invoice->total_vat = $this->data->total_vat;
            $invoice->tax3 = $this->data->tax3;
            $invoice->tax1 = $this->data->tax1;
            $invoice->cus_paid = $this->data->cus_paid;
            $invoice->total_netamt = $this->data->total_netamt;

            $invoice->creditterm = $this->data->customerRefer !== null ? $this->data->customerRefer->creditDay : 0;
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

                DB::commit();

            Cache::forget('job-order-select');
            return true;

        } catch (\Exception $exception) {
            DB::rollBack();
            echo "Exception caught: " . $exception->getMessage();
            dd($exception->getMessage());
            return false;
        }
    }
    public function render()
    {
        return view('livewire.page.marketing.job-order.form')->extends('layouts.main')->section('main-content');
    }
}
