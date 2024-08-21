<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$title}}</title>
    @if(isset($test)&&$test)
    <link rel="stylesheet" href="{{asset('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pdf/billing-summary.css')}}">
    @else
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/billing-summary.css')}}">
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
        <div class="content">
            <div>
                <table style="width: 100%; font-size: 20px">
                    <tbody>
                        <tr>
                            <td align="left"><b style="text-decoration: underline;">AT LOGISTICS AND SEVICES CO.,LTD</b></td>
                            <td>DATE: {{ $date }}</td>
                        </tr>
                        <tr>
                            <td>CUSTOMER NAME : {{ $customer->custNameEN }}</td>
                            <td>{{ $count }} ชุด</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="text-align: center; font-size: 24px"><b>BILLING SUMMARY</b></div>

            <div class="table" style="margin-left: 0px; margin-right: 0px; margin-top: 0px">
                <table style="width: 100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>INVOICE<br />CUSTOMER</th>
                            <th>INVOICE<br />AT LOGISTICS</th>
                            <th>BOOKING<br />NUMBER</th>
                            <th>B/L<br />NUMBER</th>
                            <th>SUBTOTAL</th>
                            <th>WHT 1%</th>
                            <th>WHT 3%</th>
                            <th>VAT 7%</th>
                            <th>BILL OF<br/>BEHALF</th>
                            <th>ADVANCE<br/>PAYMENT</th>
                            <th>GRAND<br/>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $data as $i => $item )
                        <tr>
                            <td align="right">{{ $i+1 }}</td>
                            <td>{{ $item->jobOrder->invNo }}</td>
                            <td>{{ $item->documentID }}</td>
                            <td>{{ $item->jobOrder->bookingNo }}</td>
                            <td>{{ $item->jobOrder->bill_of_landing}}</td>
                            <td align="center">{{ number_format($item->itemsSum, 2) }}</td>
                            <td align="center">{{ number_format($item->tax1, 2) }}</td>
                            <td align="center">{{ number_format($item->tax3, 2) }}</td>
                            <td align="center">{{ number_format( $item->itemsSum*0.07 , 2) }}</td>
                            <td align="center">{{ number_format( $item->itemsSumBillOfReceipt, 2) }}</td>
                            <td align="center">{{ $item->jobOrder->AdvancePayment != null ? number_format($item->jobOrder->AdvancePayment->sum('sumTotal'), 2) : '0.00' }}</td>
                            @php
                                $grandTotalItem = 0;
                                $advance = $item->jobOrder->AdvancePayment != null ? $item->jobOrder->AdvancePayment->sum('sumTotal') : '0.00';

                                $grandTotalItem = $item->itemsSum - ($item->tax1 + $item->tax3) + $item->itemsSum*0.07 + $item->itemsSumBillOfReceipt - $advance;
                            @endphp
                            <td align="center">{{ number_format($grandTotalItem, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="center">0.00</td>
                            <td align="center">0.00</td>
                            <td align="center">-</td>
                            <td align="center">-</td>
                            <td align="center">0.00</td>
                            <td align="center">0.00</td>
                            <td align="center">0.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="center">{{ number_format($data->sum('itemsSum'), 2) }}</td>
                            <td align="center">{{ number_format($data->sum('tax1'), 2) }}</td>
                            <td align="center">{{ number_format($data->sum('tax3'), 2) }}</td>
                            <td align="center">{{ number_format($data->sum('itemsSum')*0.07 , 2) }}</td>
                            <td align="center">{{ number_format($data->sum('itemsSumBillOfReceipt'), 2) }}</td>
                            <td align="center">{{ number_format($sum, 2) }} </td>
                            {{-- <td align="center">{{ number_format($data->sum('total_netamt'), 2) }}</td> --}}
                            @php
                                $grandTotal = 0;
                                $grandTotal = $data->sum('itemsSum') - ($data->sum('tax1') + $data->sum('tax3')) + $data->sum('itemsSum')*0.07 + $data->sum('itemsSumBillOfReceipt') - $sum
                            @endphp
                            <td align="center">{{ number_format( $grandTotal , 2) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="footer">
                <div style="font-size: 20px; text-decoration: underline">Note:</div><br>
                <table style="margin: 0; width: 100%">
                    <tbody>
                        
                        <tr class="sign-block">
                            <td width="40%" style="vertical-align: top; padding: 0; font-size: 18px">
                                <div style="text-align: left;">Name: AT LOGISTICS AND SERVICES CO.,LTD.</div>
                                <div style="text-align: left;">Bank: KASIKORNBANK</div>
                                <div style="text-align: left;">No. 4901018516 (Current Account)</div>
                            </td>
                            <td width="30%">
                                <span>ผู้วางบิล/Biller</span><br/><br/><br/>
                                <div class="dotted-line"></div><br/>
                                <div class="dotted-line"></div>
                            </td>
                            <td width="30%">
                                <span>ผู้วางบิล/Biller Pay</span><br/><br/><br/>
                                <div class="dotted-line"></div><br/>
                                <div class="dotted-line"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</body>

</html>