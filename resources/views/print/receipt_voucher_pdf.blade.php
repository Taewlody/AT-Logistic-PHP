<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$title}}</title>
    @if(isset($test)&&$test)
    <link rel="stylesheet" href="{{asset('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pdf/receipt-voucher.css')}}">
    @else
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/receipt-voucher.css')}}">
    @endif
</head>

<body>
    <div class="page">
        @include('print.asset.header')
        <div class="content">
            <div class="title">
                <div>
                    <b>ใบสำคัญรับ<br/>
                        Receipt VOUCHER</b>
                </div>
            </div>

            <div class="detail">
                <table>
                    <tr>
                        <th style="width: 20%;">รับจาก</th>
                        <td style="width: 40%;">{{$data->supplier != null? $data->supplier->supNameEN : ""}}</td>
                        <th style="width: 17%;">บัญชีธนาคาร</th>
                        <td>{{$data->account != null ? $data->account->accountName : ''}}</td>
                    </tr>
                    <tr>
                        <th></th>
                        <td></td>
                        <th>เลขที่เอกสาร/No</th>
                        <td>{{$data->documentID}}</td>
                    </tr>
                    <tr>
                        <th>เพื่อชำระ/Paid For</th>
                        <td>{{$data->refJobNo.($data->jobOrder != null ? ','.$data->jobOrder->invNo : '')}}</td>
                        <th>วันที่/Date</th>
                        <td>{{Service::DateFormat($data->documentDate, true)}}</td>
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
                            <td class="right">{{Service::MoneyFormat($data->sumTotal)}}</td>
                        </tr>
                        <tr>
                            <td>Tax 1%</td>
                            <td class="right">{{Service::MoneyFormat($data->sumTax1)}}</td>

                        </tr>
                        <tr>
                            <td>Tax 3%</td>
                            <td class="right">{{Service::MoneyFormat($data->sumTax3)}}</td>

                        </tr>
                        <tr>
                            <td>Vat Total</td>
                            <td class="right">{{Service::MoneyFormat($data->sumTax7)}}</td>
                        </tr>
                        <tr>
                            <td>Grand Total</td>
                            <td class="right">{{Service::MoneyFormat($data->grandTotal)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="footer">
                <table>
                    <thead>
                        <th style="width: 25%;">
                            โดย/By
                        </th>
                        <th style="width: 25%;">
                            สาขา/Branch
                        </th>
                        <th style="width: 25%;">
                            เลขที่เช็ค/Cheque
                        </th>
                        <th style="width: 25%;">
                            ลงวันที่/DueDate
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" id="cash" @checked($data->payType == "c")><label for="cash" class="icon"></label><label for="cash" class="label">เงินสด/cash</label>
                                <br>
                                <input type="checkbox" id="bank" @checked($data->payType == "b")><label for="bank" class="icon"></label><label for="bank" class="label">เช็คธนาคาร/Bank</label>
                                <br>
                                <input type="checkbox" id="other" @checked($data->payType == "o")><label for="other" class="icon"></label><label for="other" class="label">อื่นๆ</label>
                            </td>
                            <td colspan="2"></td>
                            <td>{{Carbon\Carbon::parse($data->documentDate)->format('d/m/Y')}}</td>
                        </tr>
                        <tr class="sign-block">
                            <td>
                                <div class="dotted-line"></div>
                                <span>ผู้รับเงิน/Received By</span>
                            </td>
                            <td>
                                <div class="dotted-line"></div>
                                <span>ผู้จัดทำ/Prepared By</span>
                            </td>
                            <td>
                                <div class="dotted-line"></div>
                                <span>ผู้อนุมัติ/Authorized By</span>
                            </td>
                            <td>
                                <div class="dotted-line"></div>
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