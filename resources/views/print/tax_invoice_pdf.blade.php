<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$title}}</title>
    @if(isset($test)&&$test)
    <link rel="stylesheet" href="{{asset('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pdf/tax-invoice.css')}}">
    @else
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/tax-invoice.css')}}">
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
        .table-header {
            border: none;
            height: 100%;
            font-size: 19px;
            
        }
        .table-header tr {
            /* line-height: 1px; */
        }
        .table-header tr td{
            height: 14px;
            vertical-align: baseline;
        }
    </style>
</head>

<body>
    <div class="page">
        @include('print.asset.header_two_withtype', ['type' => 'ORIGINAL / ต้นฉบับ'])
        <div class="content">
            <div class="title">
                <b>ใบเสร็จรับเงิน / ใบกำกับภาษี</b>
            </div>

            <div class="detail">
                <table>
                    <td style="width: 65%;">
                        <div style="padding-left: 8px !important;">
                            {{-- <span><b>Received Form</b><b>:</b> {{($data->customer?->custNameTH).' สาขา '.($data->customer?->branchTH)}}</span>
                            <span><b>ได้รับเงินจาก</b></span>
                            <span><b>Address</b><b>:</b> {{$data->customer?->addressTH.' '.$data->customer?->zipCode}}555555555555555</span>
                            <span><b>ที่อยู่</b></span>
                            <span><b>เลขประจำตัวผู้เสียภาษี</b><b>:</b> {{$data->customer?->taxID}}</span> --}}
                            <table class="table-header">
                                <tbody>
                                <tr><td><b>Received Form : <br/>ได้รับเงินจาก</b></td>
                                    <td>{{($data->customer?->custNameTH)}} {{ $data->customer?->branchTH === '(สำนักงานใหญ่)' || $data->customer?->branchTH === 'สำนักงานใหญ่' ? $data->customer?->branchTH : ' สาขา '.($data->customer?->branchTH)}}</td>
                                </tr>
                                <tr>
                                    <td><b>Address : <br/>ที่อยู่</b></td>
                                    <td>{{$data->customer?->addressTH.' '.$data->customer?->zipCode}}</td>
                                </tr>
                                <tr>
                                    <td ><b>เลขประจำตัวผู้เสียภาษี : </b></td>
                                    <td>{{$data->customer?->taxID}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td style="width: 20%; padding-left: 5px;">
                        <div>
                             <span><b>No.</b><b>{{$data->documentID}}</b></span>
                            <span><b>เลขที่</b> </span>
                            <span><b>Date</b><b>:</b> {{Carbon\Carbon::parse($data->documentDate)->format('d/m/Y')}}</span>
                            <span><b>วันที่</b> </span>
                        </div>
                    </td>
                </table>
            </div>

            <div class="table" style="margin-left: 0px; margin-right: 0px">
                <table>
                    <thead>
                        <th>Description / รายการ</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        @foreach ($itemChargesReceive as $item)
                            <tr>
                                {{-- <td>{{$item->detail}}</td> --}}
                                <td>{{ str_replace("\u{200B}", " ", $item->detail) }}</td>
                                <td>{{Service::MoneyFormat($item->chargesReceive)}} </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style="height: {{{$heightChargesReceive}}}"></td>
                            <td style="height: {{{$heightChargesReceive}}}"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><b>TOTAL/จำนวนเงิน</b></td>
                            <td><b>{{Service::MoneyFormat($data->items->sum('chargesReceive'))}}</b></td>
                        </tr>
                        <tr>
                            <td><b>VAT 7% / ภาษีมูลค่าเพิ่ม 7%</b></td>
                            <td><b>{{Service::MoneyFormat($itemChargesReceive->sum('chargesReceive') * 0.07)}}</b></td>
                        </tr>
                        <tr>
                            <td><b>GRANDTOTAL / รวมเงินทั้งสิ้น</b></td>
                            <td rowspan="2" style="vertical-align: text-top"><b>{{Service::MoneyFormat($itemChargesReceive->sum('chargesReceive') + $itemChargesReceive->sum('chargesReceive') * 0.07)}}</b></td>
                        </tr>
                        <tr>
                            <td class="text-money">{{Service::ThaiBahtConversion($itemChargesReceive->sum('chargesReceive') + $itemChargesReceive->sum('chargesReceive') * 0.07)}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="footer">
                <table class="cash-input">
                   <tr>
                    <td>
                        <input type="checkbox" id="cash" @checked($data->payType == "c")>
                        <label for="cash" class="icon" /><label for="cash" class="label">เงินสด/cash จำนวน</label>
                    </td>
                    <td style="vertical-align: bottom; width: 80%;">
                        <div class="dotted-line"></div>
                    </td>
                    </tr>
                </table>

                <table class="cash-detail">
                    <thead>
                        <th style="width: 25%;">เช็คธนาคาร / Bank Cheque</th>
                        <th style="width: 25%;">เลขที่ / Cheque No.</th>
                        <th style="width: 25%;">ลงวันที่ / Date Due</th>
                        <th style="width: 25%;">จำนวน / Amount</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$data->branch}}</td>
                            <td>{{$data->chequeNo}}</td>
                            <td>{{Service::DateFormat($data->dueDate)}}</td>
                            <td>{{$data->dueTime ? Service::MoneyFormat($data->dueTime) : ''}}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="list-invoice">
                    <tr>
                        <td style="width: 25%;"><b>In payment Account No. / Invoice</b></td>
                        <td style="width: 80%;">{{join(',', $data->items?->filter(function ($item) {
                            return $item->chargesReceive > 0;
                        })->groupBy('invNo')->map(function ($item, $key) {
                            return $item->first()->invNo;
                        })->toArray())}}</td>
                    </tr>
                </table>

                <table class="sign-block">
                    <tr>
                        <td><div class="dotted-line"></div></td>
                        <td><div class="dotted-line"></div></td>
                    </tr>
                    <tr>
                        <td>Collector / ผู้รับเงิน</td>
                        <td>Authorized Signature / ผู้มีอำนาจลงนาม</td>
                    </tr>
                </table>

                <table class="remark">
                    <tr>
                        <td style="vertical-align: text-bottom; margin-bottom: -4px;"><span style="margin-right: 10px;">หมายเหตุ</span></td>
                        <td>
                            <span>1. ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ต้องมีลายเซ็นต์ผู้มีอำนาจลงนาม และผู้รับเงินพร้อมตราประทับบริษัทฯ</span>
                            <br>
                            <span>2. ใบกรณีชำระเงินด้วยเงินด้วยเช็ค ใบเสร็จรับเงินจะสมบูรณ์ก็ต่อเมื่อบริษัทฯ เก็บเงินตามเช็คได้เรียบร้อย</span>
                            <br>
                            <span>3. กรุณาตรวจสอบความถูกต้องของเอกสารที่ได้รับและแจ้งให้บริษัทฯ ทราบเพื่อแก้ไขภายใน 7 วัน นับจากวันที่ปรากฎใบใบกำกับภาษี
                                มิฉะนั้นถือว่าถูกต้องสมบูรณ์แล้ว</span>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

    <div class="cut-page"></div>

    <div class="page">
        @include('print.asset.header_two_withtype', ['type' => 'COPY / สำเนา'])
        <div class="content">
            <div class="title">
                <b>ใบเสร็จรับเงิน / ใบกำกับภาษี</b>
            </div>

            <div class="detail">
                <table>
                    <td style="width: 65%;">
                        <div style="padding-left: 8px !important;">
                            {{-- <span><b>Received Form</b><b>:</b> {{($data->customer?->custNameTH).' สาขา '.($data->customer?->branchTH)}}</span>
                            <span><b>ได้รับเงินจาก</b></span>
                            <span><b>Address</b><b>:</b> {{$data->customer?->addressTH.' '.$data->customer?->zipCode}}</span>
                            <span><b>ที่อยู่</b></span>
                            <span><b>เลขประจำตัวผู้เสียภาษี</b><b>:</b> {{$data->customer?->taxID}}</span> --}}

                            <table class="table-header">
                                <tbody>
                                    <tr><td><b>Received Form : <br/>ได้รับเงินจาก</b></td><td>{{($data->customer?->custNameTH)}} {{ $data->customer?->branchTH === '(สำนักงานใหญ่)' || $data->customer?->branchTH === 'สำนักงานใหญ่' ? $data->customer?->branchTH : ' สาขา '.($data->customer?->branchTH)}}</td></tr>
                                    <tr>
                                        <td><b>Address : <br/>ที่อยู่</b></td>
                                        <td>{{$data->customer?->addressTH.' '.$data->customer?->zipCode}}</td>
                                    </tr>
                                    <tr>
                                        <td ><b>เลขประจำตัวผู้เสียภาษี : </b></td>
                                        <td>{{$data->customer?->taxID}}</td>
                                    </tr>
                                    </tbody>
                            </table>
                        </div>
                        
                    </td>
                    <td style="width: 20%; padding-left: 5px;">
                        <div>
                             <span><b>No.</b><b>{{$data->documentID}}</b></span>
                            <span><b>เลขที่</b> </span>
                            <span><b>Date</b><b>:</b> {{Carbon\Carbon::parse($data->documentDate)->format('d/m/Y')}}</span>
                            <span><b>วันที่</b> </span>
                        </div>
                    </td>
                </table>
            </div>

            <div class="table" style="margin-left: 0px; margin-right: 0px">
                <table>
                    <thead>
                        <th>Description / รายการ</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        @foreach ($itemChargesReceive as $item)
                            <tr>
                                <td>{{ str_replace("\u{200B}", " ", $item->detail) }}</td>
                                <td>{{Service::MoneyFormat($item->chargesReceive)}} </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style="height: {{{$heightChargesReceive}}}"></td>
                            <td style="height: {{{$heightChargesReceive}}}"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><b>TOTAL/จำนวนเงิน</b></td>
                            <td><b>{{Service::MoneyFormat($data->items->sum('chargesReceive'))}}</b></td>
                        </tr>
                        <tr>
                            <td><b>VAT 7% / ภาษีมูลค่าเพิ่ม 7%</b></td>
                            <td><b>{{Service::MoneyFormat($itemChargesReceive->sum('chargesReceive') * 0.07)}}</b></td>
                        </tr>
                        <tr>
                            <td><b>GRANDTOTAL / รวมเงินทั้งสิ้น</b></td>
                            <td rowspan="2" style="vertical-align: text-top"><b>{{Service::MoneyFormat($itemChargesReceive->sum('chargesReceive') + $itemChargesReceive->sum('chargesReceive') * 0.07)}}</b></td>
                        </tr>
                        <tr>
                            <td class="text-money">{{Service::ThaiBahtConversion($itemChargesReceive->sum('chargesReceive') + $itemChargesReceive->sum('chargesReceive') * 0.07)}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="footer">
                <table class="cash-input">
                   <tr>
                    <td>
                        <input type="checkbox" id="cash" @checked($data->payType == "c")>
                        <label for="cash" class="icon" /><label for="cash" class="label">เงินสด/cash จำนวน</label>
                    </td>
                    <td style="vertical-align: bottom; width: 80%;">
                        <div class="dotted-line"></div>
                    </td>
                    </tr>
                </table>

                <table class="cash-detail">
                    <thead>
                        <th style="width: 25%;">เช็คธนาคาร / Bank Cheque</th>
                        <th style="width: 25%;">เลขที่ / Cheque No.</th>
                        <th style="width: 25%;">ลงวันที่ / Date Due</th>
                        <th style="width: 25%;">จำนวน / Amount</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$data->branch}}</td>
                            <td>{{$data->chequeNo}}</td>
                            <td>{{Service::DateFormat($data->dueDate)}}</td>
                            <td>{{$data->dueTime ? Service::MoneyFormat($data->dueTime) : ''}}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="list-invoice">
                    <tr>
                        <td style="width: 25%;"><b>In payment Account No. / Invoice</b></td>
                        <td style="width: 80%;">{{join(',', $data->items?->filter(function ($item) {
                            return $item->chargesReceive > 0;
                        })->groupBy('invNo')->map(function ($item, $key) {
                            return $item->first()->invNo;
                        })->toArray())}}</td>
                    </tr>
                </table>

                <table class="sign-block">
                    <tr>
                        <td><div class="dotted-line"></div></td>
                        <td><div class="dotted-line"></div></td>
                    </tr>
                    <tr>
                        <td>Collector / ผู้รับเงิน</td>
                        <td>Authorized Signature / ผู้มีอำนาจลงนาม</td>
                    </tr>
                </table>

                <table class="remark">
                    <tr>
                        <td style="vertical-align: text-bottom; margin-bottom: -4px;"><span style="margin-right: 10px;">หมายเหตุ</span></td>
                        <td>
                            <span>1. ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ต้องมีลายเซ็นต์ผู้มีอำนาจลงนาม และผู้รับเงินพร้อมตราประทับบริษัทฯ</span>
                            <br>
                            <span>2. ใบกรณีชำระเงินด้วยเงินด้วยเช็ค ใบเสร็จรับเงินจะสมบูรณ์ก็ต่อเมื่อบริษัทฯ เก็บเงินตามเช็คได้เรียบร้อย</span>
                            <br>
                            <span>3. กรุณาตรวจสอบความถูกต้องของเอกสารที่ได้รับและแจ้งให้บริษัทฯ ทราบเพื่อแก้ไขภายใน 7 วัน นับจากวันที่ปรากฎใบใบกำกับภาษี
                                มิฉะนั้นถือว่าถูกต้องสมบูรณ์แล้ว</span>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

    <div class="cut-page"></div>
    
    <div class="page">
        @include('print.asset.header_two_withtype', ['type' => 'COPY / สำเนา'])
        <div class="content">
            <div class="title">
                <b>ใบเสร็จรับเงิน / ใบกำกับภาษี</b>
            </div>

            <div class="detail">
                <table>
                    <td style="width: 65%;">
                        <div style="padding-left: 8px !important;">
                            {{-- <span><b>Received Form</b><b>:</b> {{($data->customer?->custNameTH).' สาขา '.($data->customer?->branchTH)}}</span>
                            <span><b>ได้รับเงินจาก</b></span>
                            <span><b>Address</b><b>:</b> {{$data->customer?->addressTH.' '.$data->customer?->zipCode}}</span>
                            <span><b>ที่อยู่</b></span>
                            <span><b>เลขประจำตัวผู้เสียภาษี</b><b>:</b> {{$data->customer?->taxID}}</span>
                             --}}

                             <table class="table-header">
                                <tbody>
                                    <tr><td><b>Received Form : <br/>ได้รับเงินจาก</b></td><td>{{($data->customer?->custNameTH)}} {{ $data->customer?->branchTH === '(สำนักงานใหญ่)' || $data->customer?->branchTH === 'สำนักงานใหญ่' ? $data->customer?->branchTH : ' สาขา '.($data->customer?->branchTH)}}</td></tr>
                                    <tr>
                                        <td><b>Address : <br/>ที่อยู่</b></td>
                                        <td>{{$data->customer?->addressTH.' '.$data->customer?->zipCode}}</td>
                                    </tr>
                                    <tr>
                                        <td ><b>เลขประจำตัวผู้เสียภาษี : </b></td>
                                        <td>{{$data->customer?->taxID}}</td>
                                    </tr>
                                    </tbody>
                            </table>
                        </div>
                        
                    </td>
                    <td style="width: 20%; padding-left: 5px;">
                        <div>
                             <span><b>No.</b><b>{{$data->documentID}}</b></span>
                            <span><b>เลขที่</b> </span>
                            <span><b>Date</b><b>:</b> {{Carbon\Carbon::parse($data->documentDate)->format('d/m/Y')}}</span>
                            <span><b>วันที่</b> </span>
                        </div>
                    </td>
                </table>
            </div>

            <div class="table" style="margin-left: 0px; margin-right: 0px">
                <table>
                    <thead>
                        <th>Description / รายการ</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        @foreach ($itemChargesReceive as $item)
                            <tr>
                                <td>{{ str_replace("\u{200B}", " ", $item->detail) }}</td>
                                <td>{{Service::MoneyFormat($item->chargesReceive)}} </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style="height: {{{$heightChargesReceive}}}"></td>
                            <td style="height: {{{$heightChargesReceive}}}"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><b>TOTAL/จำนวนเงิน</b></td>
                            <td><b>{{Service::MoneyFormat($data->items->sum('chargesReceive'))}}</b></td>
                        </tr>
                        <tr>
                            <td><b>VAT 7% / ภาษีมูลค่าเพิ่ม 7%</b></td>
                            <td><b>{{Service::MoneyFormat($itemChargesReceive->sum('chargesReceive') * 0.07)}}</b></td>
                        </tr>
                        <tr>
                            <td><b>GRANDTOTAL / รวมเงินทั้งสิ้น</b></td>
                            <td rowspan="2" style="vertical-align: text-top"><b>{{Service::MoneyFormat($itemChargesReceive->sum('chargesReceive') + $itemChargesReceive->sum('chargesReceive') * 0.07)}}</b></td>
                        </tr>
                        <tr>
                            <td class="text-money">{{Service::ThaiBahtConversion($itemChargesReceive->sum('chargesReceive') + $itemChargesReceive->sum('chargesReceive') * 0.07)}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="footer">
                <table class="cash-input">
                   <tr>
                    <td>
                        <input type="checkbox" id="cash" @checked($data->payType == "c")>
                        <label for="cash" class="icon" /><label for="cash" class="label">เงินสด/cash จำนวน</label>
                    </td>
                    <td style="vertical-align: bottom; width: 80%;">
                        <div class="dotted-line"></div>
                    </td>
                    </tr>
                </table>

                <table class="cash-detail">
                    <thead>
                        <th style="width: 25%;">เช็คธนาคาร / Bank Cheque</th>
                        <th style="width: 25%;">เลขที่ / Cheque No.</th>
                        <th style="width: 25%;">ลงวันที่ / Date Due</th>
                        <th style="width: 25%;">จำนวน / Amount</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$data->branch}}</td>
                            <td>{{$data->chequeNo}}</td>
                            <td>{{Service::DateFormat($data->dueDate)}}</td>
                            <td>{{$data->dueTime ? Service::MoneyFormat($data->dueTime) : ''}}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="list-invoice">
                    <tr>
                        <td style="width: 25%;"><b>In payment Account No. / Invoice</b></td>
                        <td style="width: 80%;">{{join(',', $data->items?->filter(function ($item) {
                            return $item->chargesReceive > 0;
                        })->groupBy('invNo')->map(function ($item, $key) {
                            return $item->first()->invNo;
                        })->toArray())}}</td>
                    </tr>
                </table>

                <table class="sign-block">
                    <tr>
                        <td><div class="dotted-line"></div></td>
                        <td><div class="dotted-line"></div></td>
                    </tr>
                    <tr>
                        <td>Collector / ผู้รับเงิน</td>
                        <td>Authorized Signature / ผู้มีอำนาจลงนาม</td>
                    </tr>
                </table>

                <table class="remark">
                    <tr>
                        <td style="vertical-align: text-bottom; margin-bottom: -4px;"><span style="margin-right: 10px;">หมายเหตุ</span></td>
                        <td>
                            <span>1. ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ต้องมีลายเซ็นต์ผู้มีอำนาจลงนาม และผู้รับเงินพร้อมตราประทับบริษัทฯ</span>
                            <br>
                            <span>2. ใบกรณีชำระเงินด้วยเงินด้วยเช็ค ใบเสร็จรับเงินจะสมบูรณ์ก็ต่อเมื่อบริษัทฯ เก็บเงินตามเช็คได้เรียบร้อย</span>
                            <br>
                            <span>3. กรุณาตรวจสอบความถูกต้องของเอกสารที่ได้รับและแจ้งให้บริษัทฯ ทราบเพื่อแก้ไขภายใน 7 วัน นับจากวันที่ปรากฎใบใบกำกับภาษี
                                มิฉะนั้นถือว่าถูกต้องสมบูรณ์แล้ว</span>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

    <div class="cut-page"></div>

    <div class="page">
        @include('print.asset.header_two_withtype', ['type' => 'COPY / สำเนา'])
        <div class="content">
            <div class="title">
                <b>Official Receipt (ใบรับเงิน)</b>
            </div>

            <div class="detail">
                <table>
                    <td style="width: 65%;">
                        <div>
                            {{-- <span><b>Received Form</b><b>:</b> {{($data->customer?->custNameTH).' สาขา '.($data->customer?->branchTH)}}</span>
                            <span><b>ได้รับเงินจาก</b></span>
                            <span><b>Address</b><b>:</b> {{$data->customer?->addressTH.' '.$data->customer?->zipCode}}</span>
                            <span><b>ที่อยู่</b></span>
                            <span><b>เลขประจำตัวผู้เสียภาษี</b><b>:</b> {{$data->customer?->taxID}}</span>
                             --}}

                             <table class="table-header">
                                <tbody>
                                    <tr><td><b>Received Form : <br/>ได้รับเงินจาก</b></td><td>{{($data->customer?->custNameTH)}} {{ $data->customer?->branchTH === '(สำนักงานใหญ่)' || $data->customer?->branchTH === 'สำนักงานใหญ่' ? $data->customer?->branchTH : ' สาขา '.($data->customer?->branchTH)}}</td></tr>
                                    <tr>
                                        <td><b>Address : <br/>ที่อยู่</b></td>
                                        <td>{{$data->customer?->addressTH.' '.$data->customer?->zipCode}}</td>
                                    </tr>
                                    <tr>
                                        <td ><b>เลขประจำตัวผู้เสียภาษี : </b></td>
                                        <td>{{$data->customer?->taxID}}</td>
                                    </tr>
                                    </tbody>
                            </table>
                        </div>
                    </td>
                    <td style="width: 20%; padding-left: 5px;">
                        <div>
                            <span><b>No.</b><b>{{$data->documentID}}</b></span>
                            <span><b>เลขที่</b> </span>
                            <span><b>Date</b><b>:</b> {{Carbon\Carbon::parse($data->documentDate)->format('d/m/Y')}}</span>
                            <span><b>วันที่</b> </span>
                        </div>
                    </td>
                </table>
            </div>

            <div class="table" style="margin-left: 0px; margin-right: 0px;">
                <table>
                    <thead>
                        <th>Description / รายการ</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        @foreach ($itemChargesbillReceive as $item)
                            <tr>
                                <td>{{ str_replace("\u{200B}", " ", $item->detail) }}</td>
                                <td>{{Service::MoneyFormat($item->chargesbillReceive)}} </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style="height: {{{$heightChargesbillReceive}}}"></td>
                            <td style="height: {{{$heightChargesbillReceive}}}"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><b>TOTAL/จำนวนเงิน</b></td>
                            <td rowspan="2" style="vertical-align: baseline;"><b>{{Service::MoneyFormat($data->items->sum('chargesbillReceive'))}}</b></td>
                        </tr>
                        {{-- <tr>
                            <td><b>VAT 7% / ภาษีมูลค่าเพิ่ม 7%</b></td>
                            <td><b>{{Service::MoneyFormat($itemChargesbillReceive->sum('chargesbillReceive') * 0.07)}}</b></td>
                        </tr>
                        <tr>
                            <td><b>GRANDTOTAL / รวมเงินทั้งสิ้น</b></td>
                            <td rowspan="2" style="vertical-align: text-top"><b>{{Service::MoneyFormat($itemChargesbillReceive->sum('chargesbillReceive') + $itemChargesReceive->sum('chargesbillReceive') * 0.07)}}</b></td>
                        </tr> --}}
                        <tr>
                            <td class="text-money">{{Service::ThaiBahtConversion($itemChargesbillReceive->sum('chargesbillReceive'))}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="footer">
                <table class="cash-input">
                   <tr>
                    <td>
                        <input type="checkbox" id="cash" @checked($data->payType == "c")>
                        <label for="cash" class="icon" /><label for="cash" class="label">เงินสด/cash จำนวน</label>
                    </td>
                    <td style="vertical-align: bottom; width: 80%;">
                        <div class="dotted-line"></div>
                    </td>
                    </tr>
                </table>

                <table class="cash-detail">
                    <thead>
                        <th style="width: 25%;">เช็คธนาคาร / Bank Cheque</th>
                        <th style="width: 25%;">เลขที่ / Cheque No.</th>
                        <th style="width: 25%;">ลงวันที่ / Date Due</th>
                        <th style="width: 25%;">จำนวน / Amount</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$data->branch}}</td>
                            <td>{{$data->chequeNo}}</td>
                            <td>{{Service::DateFormat($data->dueDate)}}</td>
                            <td>{{$data->dueTime ? Service::MoneyFormat($data->dueTime) : ''}}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="list-invoice">
                    <tr>
                        <td style="width: 25%;"><b>In payment Account No. / Invoice</b></td>
                        <td style="width: 80%;">{{join(',', $data->items?->filter(function ($item) {
                            return $item->chargesbillReceive > 0;
                        })->groupBy('invNo')->map(function ($item, $key) {
                            return $item->first()->invNo;
                        })->toArray())}}</td>
                    </tr>
                </table>

                <table class="sign-block">
                    <tr>
                        <td><div class="dotted-line"></div></td>
                        <td><div class="dotted-line"></div></td>
                    </tr>
                    <tr>
                        <td>Collector / ผู้รับเงิน</td>
                        <td>Authorized Signature / ผู้มีอำนาจลงนาม</td>
                    </tr>
                </table>

                <table class="remark">
                    <tr>
                        <td style="vertical-align: text-bottom; margin-bottom: -4px;"><span style="margin-right: 10px;">หมายเหตุ</span></td>
                        <td>
                            <span>1. ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ต้องมีลายเซ็นต์ผู้มีอำนาจลงนาม และผู้รับเงินพร้อมตราประทับบริษัทฯ</span>
                            <br>
                            <span>2. ใบกรณีชำระเงินด้วยเงินด้วยเช็ค ใบเสร็จรับเงินจะสมบูรณ์ก็ต่อเมื่อบริษัทฯ เก็บเงินตามเช็คได้เรียบร้อย</span>
                            <br>
                            <span>3. กรุณาตรวจสอบความถูกต้องของเอกสารที่ได้รับและแจ้งให้บริษัทฯ ทราบเพื่อแก้ไขภายใน 7 วัน นับจากวันที่ปรากฎใบใบกำกับภาษี
                                มิฉะนั้นถือว่าถูกต้องสมบูรณ์แล้ว</span>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>


</body>
</html>