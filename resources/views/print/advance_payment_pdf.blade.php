<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$title}}</title>
    @if(isset($test)&&$test)
    <link rel="stylesheet" href="{{asset('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pdf/advance-payment.css')}}">
    @else
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/advance-payment.css')}}">
    @endif
</head>

<body>
    <div class="page">
        @include('print.asset.header')
        <div class="content">
            <div class="title">
                <b>เงินสำรองจ่ายล่วงหน้า<br>
                    ADVANCE PAYMENT</b>

            </div>
            <div class="detail">
                <table>
                    <td>
                        <table class="col-left">
                            <thead>
                                <tr>
                                    <th>
                                        ลูกค้า
                                    </th>
                                    <td>
                                        {{ $data->customer != null ? $data->customer->custNameTH : ""}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        เพื่อชำระ/Paid For
                                    </th>
                                    <td>
                                        {{$data->refJobNo}}{{$data->jobOrder != null ?   '/'.$data->jobOrder->invNo : ""}}
                                    </td>
                            </thead>
                        </table>
                    </td>
                    <td>
                        <table class="col-right">
                            <tr>
                                <th>
                                    เลขที่เอกสาร/No
                                </th>
                                <td>
                                    {{$data->documentID}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    วันที่/Date
                                </th>
                                <td>
                                    {{Carbon\Carbon::parse($data->documentDate)->format('d/m/Y')}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    ชื่อบัญชี
                                </th>
                                <td>
                                    {{$data->accountBank != null ? $data->accountBank->accountName.$data->accountBank->accountID : ""}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </table>
            </div>
            <div class="table">
                <table  style="width: 100%">
                    <thead>
                        <th  style="width: 5%">
                            ลำดับ<br>No.
                        </th>
                        <th>
                            เลขที่บิล<br>Bill No.
                        </th>
                        <th style="width: 70%">
                            รายการ<br>Particulars
                        </th>
                        <th>
                            จำนวน<br>Amount
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($data->items as $item)
                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    {{$item->invNo}}
                                </td>
                                <td>
                                    {{$item->chartDetail}}
                                </td>
                                <td>
                                    {{Service::MoneyFormat($item->amount)}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                รวม/Total
                            </td>
                            <td>
                                {{Service::MoneyFormat($data->items->sum('amount'))}}
                            </td>
                        </tr>
                    </tfoot>
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