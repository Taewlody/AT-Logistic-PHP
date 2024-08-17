<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $title }}</title>
    @if (isset($test) && $test)
    <link rel="stylesheet" href="{{ asset('assets/css/pdf/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pdf/invoice.css') }}">
    @else
    <link rel="stylesheet" href="{{ public_path('assets/css/pdf/main.css') }}">
    <link rel="stylesheet" href="{{ public_path('assets/css/pdf/invoice.css') }}">
    @endif

    <style>
        @font-face {
            font-family: 'TH-Sarabun';
            src: url('{{ base_path("THSarabunNew.ttf") }}');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: "TH-Sarabun";
            font-style: normal;
            font-weight: 700;
            src: url('{{ base_path("THSarabunNew Bold.ttf") }}');
        }
        @font-face {
            font-family: "TH-Sarabun";
            font-style: italic;
            font-weight: normal;
            src: url('{{ base_path("THSarabunNew Italic.ttf") }}');
        }
        body {
            font-family: 'TH-Sarabun', sans-serif;
        }

    </style>
</head>

<body>
    <div class="page">
        @include('print.asset.header_two_withtype', ['type' => 'ORIGINAL / ต้นฉบับ'])
        <div class="line" style="margin-left: 20px; margin-right: 20px;"></div>
        <div class="content">
            <div class="title">
                <b>ใบแจ้งหนี้ / INVOICE</b>
            </div>

            <div class="detail">
                <table>
                    <td style="width: 55%;">
                        <div>
                            <span><b>TO</b> : {{$data->jobOrder?->customerRefer?->custNameTH}} {{ $data->jobOrder?->customerRefer?->branchTH === '(สำนักงานใหญ่)' || $data->jobOrder?->customerRefer?->branchTH === 'สำนักงานใหญ่' ? $data->jobOrder?->customerRefer?->branchTH : ''}}</span>
                            <span
                                style="min-height: 20px; height: auto;">{{$data->jobOrder?->customerRefer?->addressTH}} {{$data->jobOrder?->customerRefer?->zipCode}}</span>
                            <span><b>เลขประจำตัวผู้เสียภาษี</b> : {{$data->jobOrder?->customerRefer?->taxID}}</span>
                            @if($data->jobOrder?->customerRefer?->branchTH === '(สำนักงานใหญ่)' || $data->jobOrder?->customerRefer?->branchTH === 'สำนักงานใหญ่')
                            <span></span>
                            @else
                            <span><b>สาขาที่</b>&nbsp; : &nbsp;{{$data->jobOrder?->customerRefer?->branchTH }}</span>
                            @endif
                        </div>
                    </td>
                    <td style="width: 30%; padding-left: 5px;">
                        <div>
                            <span><b>Date</b>{{Carbon\Carbon::parse($data->documentDate)->format('d/m/Y')}}</span>
                            <span><b>Innoive No.</b>{{$data->documentID}}</span>
                            <span><b>Credit Term</b>{{$credit}}</span>
                            <span><b>Your Ref. No</b>{{ $data->jobOrder->invNo }} </span>
                            <span><b>Sales Contact</b>{{$data->salemanRef?->empName}}</span>
                        </div>
                    </td>
                </table>
            </div>

            <div class="transport-detail">
                <table>
                    <tr>
                        <td><b>Bound</b>&nbsp;{{$data->jobOrder?->getBound}}</td>
                        <td><b>Commodity</b>&nbsp;{{join(',', $groupCommodity)}}
                        </td>
                        <td><b>Carrier</b>&nbsp;{{ $data->jobOrder?->agentRefer?->supNameEN }}</td>
                    </tr>
                    <tr>
                        <td><b>Freight</b>{{$data->transport?->transportName}}</td>
                        <td><b>Qty. / Measurement</b>&nbsp;{{join(',',$data->jobOrder?->qty ?? [])}}</td>
                        <td><b>B/L No.</b>&nbsp;{{$data->jobOrder?->bill_of_landing}}</td>
                    </tr>
                    <tr>
                        <td><b>JOB NO</b> &nbsp;{{$data->ref_jobNo}}</td>
                        <td><b>Origin / Destination</b>
                            &nbsp;{{$data->jobOrder?->landingPort?->portNameEN}}/{{$data->jobOrder?->dischargePort?->portNameEN}}
                        </td>
                        <td><b>On Board</b> &nbsp;{{Carbon\Carbon::parse($onBoard)->format('d/m/Y')}}</td>
                    </tr>
                </table>
            </div>

            <div class="table">
                <table>
                    <thead>
                        <th>No.</th>
                        <th colspan="3">Particulars</th>
                        <th>Your Behalf</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        @foreach ($data->items->groupBy('detail') as $index => $charges)
                        @if($index !== '')
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                                
                            </td>
                            <td colspan="3">
                                {{-- {{ $index }}  --}}
                                {{ str_replace("\u{200B}", " ", $index) }}
                            </td>
                            <td>
                                {{-- @foreach ($charges as $item)
                                    {{ $item->chargesbillReceive>=1 ? Service::MoneyFormat($item->chargesbillReceive) : '' }}
                                @endforeach --}}
                                {{ $charges->sum('chargesbillReceive') ? Service::MoneyFormat($charges->sum('chargesbillReceive')) : ''}}
                            </td>
                            <td>
                                {{-- @foreach ($charges as $item)
                                    {{ $item->chargesReceive>=1 ? Service::MoneyFormat($item->chargesReceive) : '' }}
                                @endforeach --}}
                                {{ $charges->sum('chargesReceive') ? Service::MoneyFormat($charges->sum('chargesReceive')) : ''}}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        
                        <tr>
                            <td style="height: {{{$heightItems}}}"></td>
                            <td colspan="3" style="height: {{{$heightItems}}}"></td>
                            <td style="height: {{{$heightItems}}}"></td>
                            <td style="height: {{{$heightItems}}}"></td>
                        </tr>
                    </tbody>
                    <tfoot style="border: 1px solid #dee2e6;">
                        <tr>
                            <td style="border: none; vertical-align: top;" rowspan="7">Remark</td>
                            <td colspan="3">Total</td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesbillReceive')) }}</td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive')) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">Vat 7%</td>
                            <td class="remove-border"></td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive') * 0.07) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">GRAND TOTAL</td>
                            <td class="remove-border"></td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive') +
                                ($data->items->sum('chargesReceive') * 0.07)) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">WH TAX 3 % ( จากยอด )</td>
                            <td class="remove-border">{{Service::MoneyFormat($data->itemsTax3Sum)}}</td>
                            <td>{{ Service::MoneyFormat($data->itemsTax3Sum * 0.03) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">WH TAX 1 % ( จากยอด )</td>
                            <td class="remove-border">{{Service::MoneyFormat($data->itemsTax1Sum)}}</td>
                            <td>{{ Service::MoneyFormat($data->itemsTax1Sum * 0.01) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">Advance payment / ลูกค้าสำรองจ่าย</td>
                            <td class="remove-border"></td>
                            <td>{{ Service::MoneyFormat($customer_piad) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">รวมจำนวนเงินที่ต้องชำระ / Net paid</td>
                            <td class="remove-border"></td>
                            
                            {{-- <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive') +
                                ($data->items->sum('chargesReceive') * 0.07) - ($data->itemsTax3Sum * 0.03) -
                                ($data->itemsTax1Sum * 0.01) - $data->cus_paid) }}</td> --}}
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive') +               $data->items->sum('chargesbillReceive') +
                                ($data->items->sum('chargesReceive') * 0.07) - ($data->itemsTax3Sum * 0.03) -
                                ($data->itemsTax1Sum * 0.01) - $customer_piad) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #dee2e6; text-align: center;" colspan="6">({{
                                Service::ThaiBahtConversion($data->items->sum('chargesReceive') + $data->items->sum('chargesbillReceive') +
                                ($data->items->sum('chargesReceive') * 0.07) - ($data->itemsTax3Sum * 0.03) -
                                ($data->itemsTax1Sum * 0.01) - $customer_piad) }})</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="footer">
                <div class="footer-sign">
                    <table>
                        <tr>
                            <td>
                                <div class="dotted-line"></div>
                            </td>
                            <td>
                                <div class="dotted-line"></div>
                            </td>
                            <td>
                                <div class="dotted-line"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Authorized Signature</td>
                            <td>Customer Authorized Signatured</td>
                            <td>Due Date</td>
                    </table>
                </div>
                <div class="footer-remark">
                    <div>
                        <span>Please Issue crssed cheque to order "AT LOGISTICS AND SERVICES CO., LTD." settlement to this
                            invoice.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cut-page"></div>

    <div class="page">
        @include('print.asset.header_two_withtype', ['type' => 'COPY / สำเนา'])
        <div class="line" style="margin-left: 20px; margin-right: 20px;"></div>
        <div class="content">
            <div class="title">
                <b>ใบแจ้งหนี้ / INVOICE</b>
            </div>

            <div class="detail">
                <table>
                    <td style="width: 55%;">
                        <div>
                            <span><b>TO</b> : {{$data->jobOrder?->customerRefer?->custNameTH}} {{ $data->jobOrder?->customerRefer?->branchTH === '(สำนักงานใหญ่)' || $data->jobOrder?->customerRefer?->branchTH === 'สำนักงานใหญ่' ? $data->jobOrder?->customerRefer?->branchTH : ''}}</span>
                            <span
                                style="min-height: 20px; height: auto;">{{$data->jobOrder?->customerRefer?->addressTH}} {{$data->jobOrder?->customerRefer?->zipCode}}</span>
                            <span><b>เลขประจำตัวผู้เสียภาษี</b> : {{$data->jobOrder?->customerRefer?->taxID}}</span>
                            @if($data->jobOrder?->customerRefer?->branchTH === '(สำนักงานใหญ่)' || $data->jobOrder?->customerRefer?->branchTH === 'สำนักงานใหญ่')
                            <span></span>
                            @else
                            <span><b>สาขาที่</b>&nbsp; : &nbsp;{{$data->jobOrder?->customerRefer?->branchTH }}</span>
                            @endif
                        </div>
                    </td>
                    <td style="width: 30%; padding-left: 5px;">
                        <div>
                            <span><b>Date</b>{{Carbon\Carbon::parse($data->documentDate)->format('d/m/Y')}}</span>
                            <span><b>Innoive No.</b>{{$data->documentID}}</span>
                            <span><b>Credit Term</b>{{$data->credit?->creditName}}</span>
                            <span><b>Your Ref. No</b> {{ $data->jobOrder->invNo }}</span>
                            <span><b>Sales Contact</b>{{$data->salemanRef?->empName}}</span>
                        </div>
                    </td>
                </table>
            </div>

            <div class="transport-detail">
                <table>
                    <tr>
                        <td><b>Bound</b>&nbsp;{{$data->jobOrder?->getBound}}</td>
                        <td><b>Commodity</b>&nbsp;{{$data->jobOrder != null ? $data->jobOrder->good_commodity : ''}}
                        </td>
                        <td><b>Carrier</b>&nbsp;{{ $data->jobOrder?->agentRefer?->supNameEN }}</td>
                    </tr>
                    <tr>
                        <td><b>Freight</b>{{$data->transport?->transportName}}</td>
                        <td><b>Qty. / Measurement</b>&nbsp;{{join(',',$data->jobOrder?->qty ?? [])}}</td>
                        <td><b>B/L No.</b>&nbsp;{{$data->jobOrder?->bill_of_landing}}</td>
                    </tr>
                    <tr>
                        <td><b>JOB NO</b> &nbsp;{{$data->ref_jobNo}}</td>
                        <td><b>Origin / Destination</b>
                            &nbsp;{{$data->jobOrder?->landingPort?->portNameEN}}/{{$data->jobOrder?->dischargePort?->portNameEN}}
                        </td>
                        <td><b>On Board</b> &nbsp;{{$data->jobOrder?->boud == '1' ?
                            Carbon\Carbon::parse($data->jobOrder?->etaDate)->format('d/m/Y') : ""}}
                            {{$data->jobOrder?->boud == '2' ?
                            Carbon\Carbon::parse($data->jobOrder?->etdDate)->format('d/m/Y') : ''}}</td>
                    </tr>
                </table>
            </div>

            <div class="table">
                <table>
                    <thead>
                        <th>No.</th>
                        <th colspan="3">Particulars</th>
                        <th>Your Behalf</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        {{-- @foreach ($data->items as $item)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td colspan="3">
                                {{ $item->detail }}
                            </td>
                            <td>
                                {{ $item->chargesbillReceive>=1 ? Service::MoneyFormat($item->chargesbillReceive) :
                                ''}}
                            </td>
                            <td>
                                {{ $item->chargesReceive>=1 ? Service::MoneyFormat($item->chargesReceive) : ''}}
                            </td>
                        </tr>
                        @endforeach --}}
                        @foreach ($data->items->groupBy('detail') as $index => $charges)
                        @if($index !== '')
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                                
                            </td>
                            <td colspan="3">
                                {{ $index }} 
                            </td>
                            <td>
                                {{-- @foreach ($charges as $item)
                                    {{ $item->chargesbillReceive>=1 ? Service::MoneyFormat($item->chargesbillReceive) : '' }}
                                @endforeach --}}
                                {{ $charges->sum('chargesbillReceive') ? Service::MoneyFormat($charges->sum('chargesbillReceive')) : ''}}
                            </td>
                            <td>
                                {{-- @foreach ($charges as $item)
                                    {{ $item->chargesReceive>=1 ? Service::MoneyFormat($item->chargesReceive) : '' }}
                                @endforeach --}}
                                {{ $charges->sum('chargesReceive') ? Service::MoneyFormat($charges->sum('chargesReceive')) : ''}}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td style="height: {{{$heightItems}}}"></td>
                            <td colspan="3" style="height: {{{$heightItems}}}"></td>
                            <td style="height: {{{$heightItems}}}"></td>
                            <td style="height: {{{$heightItems}}}"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="border: none; vertical-align: top;" rowspan="7">Remark</td>
                            <td colspan="3">Total</td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesbillReceive')) }}</td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive')) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">Vat 7%</td>
                            <td class="remove-border"></td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive') * 0.07) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">GRAND TOTAL</td>
                            <td class="remove-border"></td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive') +
                                ($data->items->sum('chargesReceive') * 0.07)) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">WH TAX 3 % ( จากยอด )</td>
                            <td class="remove-border">{{Service::MoneyFormat($data->itemsTax3Sum)}}</td>
                            <td>{{ Service::MoneyFormat($data->itemsTax3Sum * 0.03) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">WH TAX 1 % ( จากยอด )</td>
                            <td class="remove-border">{{Service::MoneyFormat($data->itemsTax1Sum)}}</td>
                            <td>{{ Service::MoneyFormat($data->itemsTax1Sum * 0.01) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">Advance payment / ลูกค้าสำรองจ่าย</td>
                            <td class="remove-border"></td>
                            <td>{{ Service::MoneyFormat($customer_piad) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">รวมจำนวนเงินที่ต้องชำระ / Net paid</td>
                            <td class="remove-border"></td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive') + $data->items->sum('chargesbillReceive') +
                                ($data->items->sum('chargesReceive') * 0.07) - ($data->itemsTax3Sum * 0.03) -
                                ($data->itemsTax1Sum * 0.01) - $customer_piad) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #dee2e6; text-align: center;" colspan="6">({{
                                Service::ThaiBahtConversion($data->items->sum('chargesReceive') +
                                $data->items->sum('chargesbillReceive') +
                                ($data->items->sum('chargesReceive') * 0.07) - ($data->itemsTax3Sum * 0.03) -
                                ($data->itemsTax1Sum * 0.01) - $customer_piad) }})</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="footer">
                <div class="footer-sign">
                    <table>
                        <tr>
                            <td>
                                <div class="dotted-line"></div>
                            </td>
                            <td>
                                <div class="dotted-line"></div>
                            </td>
                            <td>
                                <div class="dotted-line"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Authorized Signature</td>
                            <td>Customer Authorized Signatured</td>
                            <td>Due Date</td>
                    </table>
                </div>
                <div class="footer-remark">
                    <div>
                        <span>Please Issue crssed cheque to order "AT LOGISTICS AND SERVICES CO., LTD." settlement to this
                            invoice.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cut-page"></div>

    <div class="page">
        @include('print.asset.header_two_withtype', ['type' => 'COPY / สำเนา'])
        <div class="line" style="margin-left: 20px; margin-right: 20px;"></div>
        <div class="content">
            <div class="title">
                <b>ใบแจ้งหนี้ / INVOICE</b>
            </div>

            <div class="detail">
                <table>
                    <td style="width: 55%;">
                        <div>
                            <span><b>TO</b> : {{$data->jobOrder?->customerRefer?->custNameTH}} {{ $data->jobOrder?->customerRefer?->branchTH === '(สำนักงานใหญ่)' || $data->jobOrder?->customerRefer?->branchTH === 'สำนักงานใหญ่' ? $data->jobOrder?->customerRefer?->branchTH : ''}}</span>
                            <span
                                style="min-height: 20px; height: auto;">{{$data->jobOrder?->customerRefer?->addressTH}} {{$data->jobOrder?->customerRefer?->zipCode}}</span>
                            <span><b>เลขประจำตัวผู้เสียภาษี</b> : {{$data->jobOrder?->customerRefer?->taxID}}</span>
                            @if($data->jobOrder?->customerRefer?->branchTH === '(สำนักงานใหญ่)' || $data->jobOrder?->customerRefer?->branchTH === 'สำนักงานใหญ่')
                            <span></span>
                            @else
                            <span><b>สาขาที่</b>&nbsp; : &nbsp;{{$data->jobOrder?->customerRefer?->branchTH }}</span>
                            @endif
                        </div>
                    </td>
                    <td style="width: 30%; padding-left: 5px;">
                        <div>
                            <span><b>Date</b>{{Carbon\Carbon::parse($data->documentDate)->format('d/m/Y')}}</span>
                            <span><b>Innoive No.</b>{{$data->documentID}}</span>
                            <span><b>Credit Term</b>{{$data->credit?->creditName}}</span>
                            <span><b>Your Ref. No</b> {{$data->jobOrder->invNo}}</span>
                            <span><b>Sales Contact</b>{{$data->salemanRef?->empName}}</span>
                        </div>
                    </td>
                </table>
            </div>

            <div class="transport-detail">
                <table>
                    <tr>
                        <td><b>Bound</b>&nbsp;{{$data->jobOrder?->getBound}}</td>
                        <td><b>Commodity</b>&nbsp;{{$data->jobOrder != null ? $data->jobOrder->good_commodity : ''}}
                        </td>
                        <td><b>Carrier</b>&nbsp;{{ $data->jobOrder?->agentRefer?->supNameEN }}</td>
                    </tr>
                    <tr>
                        <td><b>Freight</b>{{$data->transport?->transportName}}</td>
                        <td><b>Qty. / Measurement</b>&nbsp;{{join(',',$data->jobOrder?->qty ?? [])}}</td>
                        <td><b>B/L No.</b>&nbsp;{{$data->jobOrder?->bill_of_landing}}</td>
                    </tr>
                    <tr>
                        <td><b>JOB NO</b> &nbsp;{{$data->ref_jobNo}}</td>
                        <td><b>Origin / Destination</b>
                            &nbsp;{{$data->jobOrder?->landingPort?->portNameEN}}/{{$data->jobOrder?->dischargePort?->portNameEN}}
                        </td>
                        <td><b>On Board</b> &nbsp;{{$data->jobOrder?->boud == '1' ?
                            Carbon\Carbon::parse($data->jobOrder?->etaDate)->format('d/m/Y') : ""}}
                            {{$data->jobOrder?->boud == '2' ?
                            Carbon\Carbon::parse($data->jobOrder?->etdDate)->format('d/m/Y') : ''}}</td>
                    </tr>
                </table>
            </div>

            <div class="table">
                <table>
                    <thead>
                        <th>No.</th>
                        <th colspan="3">Particulars</th>
                        <th>Your Behalf</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        {{-- @foreach ($data->items as $item)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td colspan="3">
                                {{ $item->detail }}
                            </td>
                            <td>
                                {{ $item->chargesbillReceive>=1 ? Service::MoneyFormat($item->chargesbillReceive) :
                                ''}}
                            </td>
                            <td>
                                {{ $item->chargesReceive>=1 ? Service::MoneyFormat($item->chargesReceive) : ''}}
                            </td>
                        </tr>
                        @endforeach --}}
                        @foreach ($data->items->groupBy('detail') as $index => $charges)
                        @if($index !== '')
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                                
                            </td>
                            <td colspan="3">
                                {{ $index }} 
                            </td>
                            <td>
                                {{-- @foreach ($charges as $item)
                                    {{ $item->chargesbillReceive>=1 ? Service::MoneyFormat($item->chargesbillReceive) : '' }}
                                @endforeach --}}
                                {{ $charges->sum('chargesbillReceive') ? Service::MoneyFormat($charges->sum('chargesbillReceive')) : ''}}
                            </td>
                            <td>
                                {{-- @foreach ($charges as $item)
                                    {{ $item->chargesReceive>=1 ? Service::MoneyFormat($item->chargesReceive) : '' }}
                                @endforeach --}}
                                {{ $charges->sum('chargesReceive') ? Service::MoneyFormat($charges->sum('chargesReceive')) : ''}}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td style="height: {{{$heightItems}}}"></td>
                            <td colspan="3" style="height: {{{$heightItems}}}"></td>
                            <td style="height: {{{$heightItems}}}"></td>
                            <td style="height: {{{$heightItems}}}"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="border: none; vertical-align: top;" rowspan="7">Remark</td>
                            <td colspan="3">Total</td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesbillReceive')) }}</td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive')) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">Vat 7%</td>
                            <td class="remove-border"></td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive') * 0.07) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">GRAND TOTAL</td>
                            <td class="remove-border"></td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive') +
                                ($data->items->sum('chargesReceive') * 0.07)) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">WH TAX 3 % ( จากยอด )</td>
                            <td class="remove-border">{{Service::MoneyFormat($data->itemsTax3Sum)}}</td>
                            <td>{{ Service::MoneyFormat($data->itemsTax3Sum * 0.03) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">WH TAX 1 % ( จากยอด )</td>
                            <td class="remove-border">{{Service::MoneyFormat($data->itemsTax1Sum)}}</td>
                            <td>{{ Service::MoneyFormat($data->itemsTax1Sum * 0.01) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">Advance payment / ลูกค้าสำรองจ่าย</td>
                            <td class="remove-border"></td>
                            <td>{{ Service::MoneyFormat($customer_piad) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">รวมจำนวนเงินที่ต้องชำระ / Net paid</td>
                            <td class="remove-border"></td>
                            <td>{{ Service::MoneyFormat($data->items->sum('chargesReceive') + $data->items->sum('chargesbillReceive') +
                                ($data->items->sum('chargesReceive') * 0.07) - ($data->itemsTax3Sum * 0.03) -
                                ($data->itemsTax1Sum * 0.01) - $customer_piad) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #dee2e6; text-align: center;" colspan="6">({{
                                Service::ThaiBahtConversion($data->items->sum('chargesReceive') + $data->items->sum('chargesbillReceive') +
                                ($data->items->sum('chargesReceive') * 0.07) - ($data->itemsTax3Sum * 0.03) -
                                ($data->itemsTax1Sum * 0.01) - $customer_piad) }})</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="footer">
                <div class="footer-sign">
                    <table>
                        <tr>
                            <td>
                                <div class="dotted-line"></div>
                            </td>
                            <td>
                                <div class="dotted-line"></div>
                            </td>
                            <td>
                                <div class="dotted-line"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Authorized Signature</td>
                            <td>Customer Authorized Signatured</td>
                            <td>Due Date</td>
                    </table>
                </div>
                <div class="footer-remark">
                    <div>
                        <span>Please Issue crssed cheque to order "AT LOGISTICS AND SERVICES CO., LTD." settlement to this
                            invoice.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>