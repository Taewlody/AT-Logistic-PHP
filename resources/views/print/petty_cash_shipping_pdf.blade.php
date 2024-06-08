<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$title}}</title>
    @if(isset($test)&&$test)
    <link rel="stylesheet" href="{{asset('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pdf/petty-cash.css')}}">
    @else
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/petty-cash.css')}}">
    @endif
</head>

<body>
    <div class="page">
        @include('print.asset.header')
        <div class="content">
            <div class="title">
                <div>
                    <b>เงินสดย่อย<br/>
                        Petty Cash</b>
                </div>
            </div>
            @if($checkInvoice !== null)
                <div style="text-align: center; color: red">ออก Invoice แล้ว</div>
            @endif
            <div class="detail">
                <table>
                    <tr>
                        <th style="width: 20%;">จ่ายให้/Paid To</th>
                        <td style="width: 40%;">{{$data->supplier != null? $data->supplier->supNameEN : ""}}</td>
                        <th style="width: 17%;">เลขที่เอกสาร/No</th>
                        <td>{{$data->documentID}}</td>
                    </tr>
                    <tr>
                        <th>เพื่อชำระ/Paid For</th>
                        <td>{{$data->refJobNo.'/'.($data->jobOrder != null ? $data->jobOrder->invNo : '')}}</td>
                        <th>วันที่/Date</th>
                        <td>{{Service::DateFormat($data->documentDate, true)}}</td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>{{$data->jobOrder != null&&$data->jobOrder->customerRefer != null ? $data->jobOrder->customerRefer->custNameEN : ''}}</td>
                    </tr>
                </table>
            </div>

            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>ลำดับ<br />No.</th>
                            <th>เลขที่บิล<br />Bill No.</th>
                            <th colspan="4">รายการ<br />Description</th>
                            <th>จำนวนเงิน<br />Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->items as $item)
                        <tr>
                            <td class="center">{{$loop->iteration}}</td>
                            <td>{{$item->invNo}}</td>
                            <td colspan="4">{{$item->chartDetail}}</td>
                            <td class="right">{{Service::MoneyFormat($item->amount)}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" rowspan="5"></td>
                            <td>Total</td>
                            <td class="right">{{Service::MoneyFormat($data->items->sum('amount'))}}</td>
                        </tr>
                        {{-- <tr>
                            <td>Tax 1%</td>
                            <td class="right">{{Service::MoneyFormat($tax1)}}</td>

                        </tr>
                        <tr>
                            <td>Tax 3%</td>
                            <td class="right">{{Service::MoneyFormat($tax3)}}</td>

                        </tr>
                        <tr>
                            <td>Vat Total</td>
                            <td class="right">{{Service::MoneyFormat($data->items->sum('amount') * 0.07)}}</td>
                        </tr> --}}
                        <tr>
                            <td>Grand Total</td>
                            {{-- <td class="right">{{Service::MoneyFormat($data->items->sum('amount') + ($data->items->sum('amount') * 0.07) - ($tax1 + $tax3))}}</td> --}}
                            <td class="right">{{Service::MoneyFormat($data->items->sum('amount'))}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="footer">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <div class="dotted-line" style="width: 120px;"></div>
                                <span>ผู้รับเงิน/Received By</span>
                            </td>
                            <td>
                                <div class="dotted-line" style="width: 120px;"></div>
                                <span>ผู้จัดทำ/Prepared By</span>
                            </td>
                            <td>
                                <div class="dotted-line" style="width: 120px;"></div>
                                <span>ผู้อนุมัติ/Authorized By</span>
                            </td>
                            <td>
                                <div class="dotted-line" style="width: 120px;"></div>
                                <span>สมุห์บัญชี/Accountant</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</body>
</html>