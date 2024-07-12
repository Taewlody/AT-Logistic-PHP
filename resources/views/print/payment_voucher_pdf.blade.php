<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$title}}</title>
    @if(isset($test)&&$test)
    <link rel="stylesheet" href="{{asset('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pdf/peyment-voucher.css')}}">
    @else
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/peyment-voucher.css')}}">
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
        @include('print.asset.header')
        <div class="content">
            <div class="title">
                <div>
                    <b>ใบสำคัญจ่าย<br />
                        PAYMENT VOUCHER</b>
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
                        <th>ชื่อบัญชี </th>
                        <td>{{$data->account != null ? $data->account->accountName : '' }}</td>
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
                            <td colspan="5"></td>
                            <td>Total</td>
                            <td class="right">{{Service::MoneyFormat($data->items->sum('amount'))}}</td>
                        </tr>
                        <tr>

                            <td colspan="4" rowspan="2"></td>
                            <td>{{Service::MoneyFormat($tax1->sumAmount)}}</td>
                            <td>Tax 1%</td>
                            <td class="right">{{Service::MoneyFormat($tax1->sumTax)}}</td>

                        </tr>
                        <tr>

                            {{-- <td colspan="4"></td> --}}
                            <td>{{Service::MoneyFormat($tax3->sumAmount)}}</td>
                            <td>Tax 3%</td>
                            <td class="right">{{Service::MoneyFormat($tax3->sumTax)}}</td>

                        </tr>
                        <tr>
                            <td colspan="5" rowspan="2"></td>
                            <td>Vat Total</td>
                            <td class="right">{{Service::MoneyFormat($vatTotal)}}</td>
                        </tr>
                        <tr>
                            {{-- <td colspan="5"></td> --}}
                            <td>Grand Total</td>
                            <td class="right">{{Service::MoneyFormat($data->items->sum('amount') +
                                ($data->items->sum('amount') * 0.07) - ($tax1->sumTax + $tax3->sumTax))}}</td>
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
</body>

</html>