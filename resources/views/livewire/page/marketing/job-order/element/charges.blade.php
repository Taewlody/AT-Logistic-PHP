<div>
    {{-- <div class="form-group  row">
        <div class="col-md-6">
            <livewire:element.select2 wire:model.live='chargeCode' name="chargeCode"
                :options="Service::ChargesSelecter()" itemKey="chargeCode" itemValue="chargeName" :searchable="true"
                :disabled="$action != 'create' && $action != 'edit'">
        </div>
        <div class="col-md-2" style="padding-left: 0px;">
            <button class="btn btn-primary " type="button" name="addCharge" wire:click="addCharge" id="addCharge"
                @disabled($chargeCode=='' )><i class="fa fa-plus"></i>
                Add</button>
        </div>
        @error('chargeCode') <span class="text-danger">{{ $message }}</span> @enderror
    </div> --}}
    <div class="form-group">
        <div class="table-responsive" id="containner_charge">
            <table class="table" id="table_charge" style="table-layout: fixed;">
                <thead>
                    <tr>
                        {{-- <th style="width:5%">No.</th>
                        <th style="width:10%;min-width: 190px;">Detail</th>
                        <th style="width:10%;min-width: 50px;">Price</th>
                        <th style="width:10%;min-width: 50px;">Volum</th>
                        <th style="width:10%;min-width: 50px;">Exchange</th>
                        <th style="width:10%;min-width: 150px;">Cost</th>
                        <th style="width:10%;min-width: 150px;">Receive</th>
                        <th style="width:10%;min-width: 150px;">Bill of receipt</th>
                        <th style="width:5%">Action</th> --}}
                        <th width="50px">No.</th>
                        <th width="300px">Detail</th>
                        <th width="80px">Price</th>
                        <th width="80px">Volum</th>
                        <th width="80px">Exchange</th>
                        <th width="130px">Cost</th>
                        <th width="130px">Receive</th>
                        <th width="130px">Bill of receipt</th>
                        <th width="70px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($value as $item)
                    <tr class='gradeX' wire:key="charge-field-{{ $item->items }}">
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <input type="text" class="form-control"
                                wire:model.live.debounce.500ms="value.{{ $loop->index }}.detail">
                        </td>
                        <td class="center">
                            <input type="number" class="form-control full" id="price-{{$loop->index}}"
                                wire:keyup="dispatch('call_price', {{$loop->index}})" value="1">
                        </td>
                        <td class="center">
                            <input type="number" class="form-control full" id="volum-{{$loop->index}}"
                                wire:keyup="dispatch('call_price', {{$loop->index}})" value="1">
                        </td>
                        <td class="center">
                            <input type="number" class="form-control full" id="exchange-{{$loop->index}}"
                                wire:keyup="dispatch('call_price', {{$loop->index}})" value="1">
                        </td>
                        <td class="center">
                            <livewire:element.currency key="chargesCost-{{$loop->index}}" class="form-control full"
                                name="chargesCost-{{$loop->index}}" type="number"
                                wire:model.live="value.{{ $loop->index }}.chargesCost"
                                :readonly="$item->ref_paymentCode" />
                        </td>
                        <td class="center">
                            <livewire:element.currency key="chargesReceive-{{$loop->index}}" class="form-control full"
                                name="chargesReceive-{{$loop->index}}" type="number"
                                wire:model.live="value.{{ $loop->index }}.chargesReceive" />
                        </td>
                        <td class="center">
                            <livewire:element.currency key="chargesbillReceive-{{$loop->index}}"
                                class="form-control full" index="{{$loop->index}}" changeEvent="checkBill"
                                name="chargesbillReceive-{{$loop->index}}" type="number"
                                wire:model.live="value.{{ $loop->index }}.chargesbillReceive" />
                        </td>
                        <td class='center'>
                            <button type='button' class='btn-danger btn btn-xs'
                                wire:click="$parent.removeCharge({{ $loop->index }})">Remove</button>
                        </td>
                    </tr>
                    @endforeach --}}
                    @foreach ($this->groupCharge as $group)
                    <tr class="header" id="{{$loop->iteration}}">
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <input type="text" class="form-control" value="{{$group->key}}" disabled>
                        </td>
                        <td class="center">

                        </td>
                        <td class="center">

                        </td>
                        <td class="center">
                        </td>
                        <td class="center">
                            <input type="text" class="form-control full" value="{{ Service::MoneyFormat($value->filter(function($item) use ($group) {
                                    return $item->detail == $group->key;
                                })->sum('chargesCost')) }}" disabled>
                        </td>
                        <td class="center">
                            <input type="text" class="form-control full" value="{{ Service::MoneyFormat($value->filter(function($item) use ($group) {
                                    return $item->detail == $group->key;
                                })->sum('chargesReceive')) }}" disabled>
                        </td>
                        <td class="center">
                            <input type="text" class="form-control full" value="{{ Service::MoneyFormat($value->filter(function($item) use ($group) {
                                    return $item->detail == $group->key;
                                })->sum('chargesbillReceive')) }}" disabled>
                        </td>
                        <td class='center'>
                            <button type='button' class='btn-info btn btn-xs' wire:click="dispatch('toggle-row', {{$loop->iteration}})">Expand</button>
                        </td>
                    </tr>
                        @foreach ($group->index as $indexItem)
                            <tr class="sub-row" id="{{$loop->parent->iteration}}" wire:key="charge-field-{{ $loop->parent->iteration }}.{{ $loop->iteration }}">
                                <td>
                                    {{ $loop->parent->iteration }}.{{ $loop->iteration }}
                                </td>
                                <td>
                                    {{-- <input type="text" class="form-control"
                                        wire:model.live.debounce.500ms="value.{{ $loop->index }}.detail"> --}}
                                </td>
                                <td class="center">
                                    <input type="number" class="form-control full" id="price-{{$indexItem}}"
                                        wire:keyup="dispatch('call_price', {{$indexItem}})" value="1">
                                </td>
                                <td class="center">
                                    <input type="number" class="form-control full" id="volum-{{$indexItem}}"
                                        wire:keyup="dispatch('call_price', {{$indexItem}})" value="1">
                                </td>
                                <td class="center">
                                    <input type="number" class="form-control full" id="exchange-{{$indexItem}}"
                                        wire:keyup="dispatch('call_price', {{$indexItem}})" value="1">
                                </td>
                                <td class="center">
                                    <livewire:element.currency wire:key="chargesCost-{{ $loop->parent->iteration }}.{{ $loop->iteration }}" class="form-control full"
                                        name="chargesCost-{{$indexItem}}" type="number"
                                        wire:model.live="value.{{ $indexItem }}.chargesCost"
                                        :readonly="$value[$indexItem]->ref_paymentCode" />
                                </td>
                                <td class="center">
                                    <livewire:element.currency wire:key="chargesReceive-{{ $loop->parent->iteration }}.{{ $loop->iteration }}" class="form-control full"
                                        name="chargesReceive-{{$indexItem}}" type="number"
                                        wire:model.live="value.{{ $indexItem }}.chargesReceive" />
                                </td>
                                <td class="center">
                                    <livewire:element.currency wire:key="chargesbillReceive-{{ $loop->parent->iteration }}.{{ $loop->iteration }}"
                                        class="form-control full" index="{{$indexItem}}" changeEvent="checkBill"
                                        name="chargesbillReceive-{{$indexItem}}" type="number"
                                        wire:model.live="value.{{ $indexItem }}.chargesbillReceive" />
                                </td>
                                <td class='center'>
                                    <button type='button' class='btn-danger btn btn-xs'
                                        wire:click="$parent.removeCharge({{ $indexItem }})">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td style="width:5%"></td>
                        <td style="width:50%;"><strong>Volum :
                                {{$groupTypeContainer}}
                            </strong></td>
                        <td style="width:10%">&nbsp;</td>
                        <td style="width:10%">&nbsp;</td>
                        <td style="width:10%">
                            <span style="width:50%; text-align: right;">Vat 7%</span>
                        </td>
                        <td style="width:10%">
                            <input type="hidden" name="vat_total_chargesCost" readonly class="form-control"
                                value="{{ Service::MoneyFormat($value->sum('chargesCost') * 0.07) }}"
                                id="vat_total_chargesCost">
                        </td>
                        <td style="width:10%">
                            <input type="text" name="vat_total_chargesReceive" readonly class="form-control"
                                value="{{ Service::MoneyFormat($this->call_price->tax7) }}"
                                id="vat_total_chargesReceive">
                        </td>
                        <td style="width:10%">
                            <input type="hidden" name="vat_total_chargesbillReceive" readonly class="form-control"
                                value="{{ Service::MoneyFormat($value->sum('chargesbillReceive')  * 0.07) }}"
                                id="vat_total_chargesbillReceive">
                        </td>
                        <td style="width:5%">
                        </td>
                    </tr>
                    <tr>
                        <td style="width:5%"></td>
                        <td style="width:50%; text-align: right;">&nbsp;</td>
                        <td style="width:10%">&nbsp;</td>
                        <td style="width:10%">&nbsp;</td>
                        <td style="width:10%"><span style="width:50%; text-align: right;">Total 7%</span>
                        </td>
                        <td style="width:10%">
                            <input type="text" name="total_chargesCost" readonly class="form-control"
                                value="{{ Service::MoneyFormat($value->sum('chargesCost')) }}" id="total_chargesCost">
                        </td>
                        <td style="width:10%">
                            <input type="text" name="total_chargesReceive" readonly class="form-control"
                                value="{{ Service::MoneyFormat($this->call_price->total) }}" id="total_chargesReceive">
                        </td>
                        <td style="width:10%">
                            <input type="text" name="total_chargesbillReceive" readonly class="form-control"
                                value="{{ Service::MoneyFormat($value->sum('chargesbillReceive'))}}"
                                id="total_chargesbillReceive">
                        </td>
                        <td style="width:5%"></td>
                    </tr>
                    @if(Auth::user()->hasRole('admin'))
                    <tr>
                        <td style="width:5%"></td>
                        <td style="width:50%; text-align: right;">&nbsp;</td>
                        <td style="width:10%">&nbsp;</td>

                        <td style="width:10%; text-align:end" colspan="2"><span
                                style="width:50%; text-align: right;">Commission Sale</span>
                        </td>
                        <td style="width:10%">
                            {{-- <input type="text" class="form-control"
                                wire:model.live.debounce.700ms='commissionSale'> --}}
                            <livewire:element.currency key="commissionSale" class="form-control full"
                                name="commissionSale" type="number" wire:model.live="commissionSale" />
                        </td>
                        <td style="width:10%"></td>
                        <td style="width:10%"></td>
                        <td style="width:5%"></td>
                    </tr>
                    <tr>
                        <td style="width:5%"></td>
                        <td style="width:50%; text-align: right;">&nbsp;</td>
                        <td style="width:10%">&nbsp;</td>
                        <td style="width:10%; text-align:end" colspan="2"><span
                                style="width:50%; text-align: right;">Commission Customers</span>
                        </td>
                        <td style="width:10%">
                            {{-- <input type="text" class="form-control"
                                wire:model.live.debounce.700ms='commissionCustomers'> --}}
                            <livewire:element.currency key="commissionCustomers" class="form-control full"
                                name="commissionCustomers" type="number" wire:model.live="commissionCustomers" />

                        </td>
                        <td style="width:10%"></td>
                        <td style="width:10%"></td>
                        <td style="width:5%"></td>
                    </tr>
                    @endif
                    {{--
                </tfoot>
            </table>
            <table class="table invoice-total">
                <tbody> --}}
                    <tr>
                        <td colspan="4" style="border: none;"></td>
                        <td colspan="3" style="border: none; text-align: end;"><strong>รวม :</strong></td>
                        <td colspan="2" style="text-align: end;">
                            <span id="total">{{ Service::MoneyFormat($this->call_price->total +
                                $value->sum('chargesbillReceive')) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border: none;"></td>
                        <td colspan="3" style="border: none; text-align: end;"><strong>ค่าบริการ Tax (3%) :</strong>
                        </td>
                        <td colspan="2" style="text-align: end;"><span id="tax3">{{
                                Service::MoneyFormat($this->call_price->tax3) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border: none;"></td>
                        <td colspan="3" style="border: none; text-align: end;"><strong>ค่าขนส่ง Tax (1%) :</strong></td>
                        <td colspan="2" style="text-align: end;"><span id="tax1">{{
                                Service::MoneyFormat($this->call_price->tax1) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border: none;"></td>
                        <td colspan="3" style="border: none; text-align: end;"><strong>รวม :</strong></td>
                        <td colspan="2" style="text-align: end;"><span
                                id="grand_total">{{Service::MoneyFormat(($this->call_price->total +
                                $value->sum('chargesbillReceive')) - $this->call_price->tax3 -
                                $this->call_price->tax1)}}</span>
                            {{-- <input type="hidden" id="h_grand_total" name="h_grand_total"
                                value="{{Service::MoneyFormat(($cal_charge['total'] + $data->charge->sum('chargesbillReceive')) - $cal_charge['tax3'] - $cal_charge['tax1']) }}">
                            --}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border: none;"></td>
                        <td colspan="3" style="border: none; text-align: end;"><strong>ลูกค้าสำรองจ่าย</strong></td>
                        <td colspan="2" style="text-align: end;"><span id="cus_paid">
                                {{Service::MoneyFormat($customer_piad?->sum('sumTotal'))}}
                            </span>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="border: none;"></td>
                        <td colspan="3" style="border: none; text-align: end;"><strong>คงเหลือจ่ายจริง</strong></td>
                        <td colspan="2" style="text-align: end;"><span
                                id="net_pad">{{Service::MoneyFormat((($this->call_price->total +
                                $value->sum('chargesbillReceive')) - $this->call_price->tax3 - $this->call_price->tax1)
                                - $customer_piad?->sum('sumTotal'))}}</span>

                        </td>
                    </tr>
                    {{--
                </tbody> --}}
                </tfoot>
            </table>
        </div>
    </div>
</div>

@script
<script>
    $(document).ready(function() {
        $('tr.sub-row').hide();        
    });
    
    Livewire.on('toggle-row', (index) => {
        console.log('tr#'+index+'.sub-row', $('tr#'+index+'.sub-row'));
            $('tr#'+index+'.sub-row').toggle();
    });


    Livewire.on('call_price', (index) => {
        let price = document.getElementById('price-'+index).value;
        let volum = document.getElementById('volum-'+index).value;
        let exchange = document.getElementById('exchange-'+index).value;
        let cost = price * volum * exchange;
        @this.set('value.'+index+'.chargesReceive', cost);
        $wire.dispatch('change-chargesReceive-'+index, {value: cost});
    });
</script>
@endscript
