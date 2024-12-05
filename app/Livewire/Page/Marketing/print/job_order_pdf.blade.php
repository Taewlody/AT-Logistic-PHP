<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$title}}</title>
    @if(isset($test)&&$test)
    <link rel="stylesheet" href="{{asset('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pdf/job-order.css')}}">
    @else
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/job-order.css')}}">
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
        @include('print.asset.header_en')
        <div class="content" style="margin-top: -8px;">
            <div class="title" style="font-size: 22px;">
                <b>ใบสั่งงาน<br>
                    Joborder</b>
            </div>
            <div class="detail" style="margin-top: -20px;">
                <table style="width: 100%;">
                    <tr>

                        <td style="color: red; font-size: 22px; font-weight: 700; padding: 0;">
                            @if($data->bound == null || $data->bound == '')
                            
                            @elseif ($data->bound == 1)
                            Bill of lading: {{$data->bill_of_landing ? $data->bill_of_landing : '' }}
                            @else
                            Booking No: {{$data->bookingNo ? $data->bookingNo : ''}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="color: blue; font-size: 22px; font-weight: 700; padding: 0; width:50%;">
                            Bound :
                            @if($data->bound == null || $data->bound == '')
                            N/A
                            @elseif ($data->bound == 1)
                            IN BOUND
                            @else
                            OUT BOUND
                            @endif
                        </td>
                        <td
                            style="color: blue; font-size: 22px; font-weight: 700; text-align: right; padding: 0;width:50%;">
                            Port of Discharge : {{$data->dischargePort != null ? $data->dischargePort->portNameEN :
                            "N/A"}}
                        </td>
                    </tr>
                </table>
                <table class="detail-job" style="margin-top: 5px;">
                    <tr>
                        <th style="width: 10%;">Saleman</th>
                        <td style="width: 32%;">: {{$data->salemanRefer != null ? $data->salemanRefer->empName : "N/A"}}</td>

                        <th style="text-align: left;" colspan="2">เลขที่ IV ที่ลูกค้าวาง</th>
                        <td style="width: 22%;">: {{$data->invoice != null ? $data->invoice->documentID : ""}}</td>

                        <th style="width: 5%;" text-align: right;>Job No.</th>
                        <td style="width: 12%;">: {{$data->documentID}}</td>

                    </tr>
                    <tr>
                        <th>Customer</th>
                        <td colspan="4">: {{$data->customerRefer != null ? $data->customerRefer->custNameEN : "N/A"}}</td>

                        <th style="text-align: left;">LOAD</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>C/O</th>
                        <td>: {{$data->co}}</td>
                        <th style="width: 2%">CY/RTN</th>
                        <td colspan="2" style="width: 23%; font-weight: 700;">: {{Carbon\Carbon::parse($data->cy_date) == Carbon\Carbon::createFromTimestamp(0) ?  "00/00/0000": Carbon\Carbon::parse($data->cy_date)->format('d/m/Y')}} , {{Carbon\Carbon::parse($data->rtn_date) == Carbon\Carbon::createFromTimestamp(0) ?  "00/00/0000": Carbon\Carbon::parse($data->rtn_date)->format('d/m/Y')}}</td>
                        <th>INV. No</th>
                        <td>: {{$data->invNo}}</td>
                    </tr>
                    <tr>
                        <th>Contact</th>
                        <td>: {{$data->cusContact}}</td>
                        <th>Tel</th>
                        <td colspan="2">{{$data->customerRefer != null ? $data->customerRefer->tel : ""}}</td>
                        <th style="text-align: left;">Fax</th>
                        <td>{{$data->customerRefer != null ? $data->customerRefer->fax : ""}}</td>
                    </tr>
                    <tr>
                        <th>Agent</th>
                        <td colspan="4">: {{$data->agentRefer != null ? $data->agentRefer->supNameEN : "N/A"}}</td>
                        <th style="text-align: left;">CTC.</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Tel.</th>
                        <td>{{$data->agentRefer != null ? $data->agentRefer->tel : ""}}</td>
                        <th style="text-align: left;" colspan="3">Fax.</th>
                        <td>{{$data->agentRefer != null ? $data->agentRefer->fax : ""}}</td>
                    </tr>
                    <tr>
                        <th>Feeder</th>
                        <td colspan="4">: {{$data->referFeeder != null ? $data->referFeeder->fName : "N/A"}}</td>
                        <th style="text-align: left;">ETD</th>
                        <td>: {{Carbon\Carbon::parse($data->etdDate) == Carbon\Carbon::createFromTimestamp(0) ?  "00/00/0000": Carbon\Carbon::parse($data->etdDate)->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <th>Vessel</th>
                        <td colspan="4">: {{$data->vesselFeeder != null ? $data->vesselFeeder->fName : ""}}</td>
                        <th style="text-align: left;">ETA</th>
                        <td>: {{Carbon\Carbon::parse($data->etaDate) == Carbon\Carbon::createFromTimestamp(0) ?  "00/00/0000": Carbon\Carbon::parse($data->etaDate)->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left">FCL</th>
                        <td>{{join(',', $groupContainer)}}</td>
                        
                    </tr>
                </table>
            </div>
            <div class="table-job">
                <table class="table-containers">
                    <thead>
                        <th>ตู้บรรจุ: {{$data->stu_location}}</th>
                        <th>ลากตู้ที่: {{$data->cy_location}}</th>
                        <th>คืนตู้ที่: {{$data->rtn_location}}</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                ติดต่อ: {{$data->stu_contact}}
                            </td>
                            <td>
                                ติดต่อ: {{$data->cy_contact}}
                            </td>
                            <td>
                                ติดต่อ: {{$data->rtn_contact}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                โทร: {{$data->stu_mobile}}
                            </td>
                            <td>
                                โทร: {{$data->cy_mobile}}
                            </td>
                            <td>
                                โทร: {{$data->rtn_mobile}}
                            </td>
                    </tbody>
                </table>
                <table class="table-charges">
                    <thead>
                        <th>CHARGES</th>
                        <th>PAID</th>
                        <th>RECEIVE</th>
                        <th>BILL OF RECEIPT</th>
                    </thead>
                    <tbody>
                        @foreach ($data->charge->groupBy('detail') as $index => $charge)
                        <tr>
                            <td style="padding-left: 4px;">{{$index}}</td>
                            <td class="money">{{Service::MoneyFormat($charge->sum('chargesCost'))}}</td>
                            <td class="money">{{Service::MoneyFormat($charge->sum('chargesReceive'))}}</td>
                            <td class="money">{{Service::MoneyFormat($charge->sum('chargesbillReceive'))}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td align="center">Vat 7%</td>
                            <td></td>
                            <td class="money">{{Service::MoneyFormat($calCharge->vat7)}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="center">Commission Sale</td>
                            <td class="money">{{Service::MoneyFormat($data->commission_sale)}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="center">Commission Customers</td>
                            <td class="money">{{Service::MoneyFormat($data->commission_customers)}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="center">รวม</td>
                            <td class="money">{{Service::MoneyFormat($calCharge->totalPaid+ $data->commission_sale + $data->commission_customers)}}</td>
                            <td class="money">{{Service::MoneyFormat($calCharge->totalReceive+$calCharge->vat7)}}</td>
                            <td class="money">{{Service::MoneyFormat($calCharge->totalBill)}}</td>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan="5"></td>
                            <td class="sum-block header"><b>รวม</b></td>
                            <td class="money sum-block"><b>{{Service::MoneyFormat($calCharge->total)}}</b></td>
                        </tr>
                        <tr>
                            <td class="sum-block header"><b>ค่าขนส่ง 3%</b></td>
                            <td class="money sum-block"><b>{{Service::MoneyFormat($calCharge->tax3)}}</b></td>
                        </tr>
                        <tr>
                            <td class="sum-block header"><b>ค่าขนส่ง 1%</b></td>
                            <td class="money sum-block"><b>{{Service::MoneyFormat($calCharge->tax1)}}</b></td>
                        </tr>
                        <tr>
                            <td class="sum-block header"><b>ลูกค้าสำรองจ่าย</b></td>
                            <td class="money sum-block"><b>{{Service::MoneyFormat($calCharge->cusPaid)}}</b></td>
                        </tr>
                        <tr>
                            <td class="sum-block-last header"><b>คงเหลือจ่ายจริง</b></td>
                            <td class="money sum-block-last"><b>{{Service::MoneyFormat($calCharge->netTotal)}}</b></td>
                    </tbody>
                </table>
            </div>
            <div class="footer">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%">
                            <div><b>RECEVING BY : </b></div>
                        </td>
                        
                        <td style="width: 50%">
                            <div><b>SALE BY : </b>{{$data->salemanRefer != null ? $data->salemanRefer->empName : ""}}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div><b>หมายเหตุ : </b>{{$data->note}}</div>
                        </td>
                        <td>
                            <div><b>APPROVED BY : </b></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>