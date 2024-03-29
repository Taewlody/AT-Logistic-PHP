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
</head>

<body>
    <div class="page">
        {{-- TODO: create dpf template --}}
        @include('print.asset.header_two_withtype', ['type' => 'ORIGINAL / ต้นฉบับ'])
        <div class="content">
            <div class="title">
                <b>ใบเสร็จรับเงิน / ใบกำกับภาษี</b>
            </div>

            <div class="detail">
                <table>
                    <td style="width: 65%;">
                        <div>
                            <span><b>Received Form</b>: </span>
                            <span><b>ได้รับเงินจาก</b></span>
                            <span><b>Address</b>: </span>
                            <span><b>ที่อยู่</b></span>
                            <span><b>เลขประจำตัวผู้เสียภาษี </b>:</span>
                        </div>
                    </td>
                    <td style="width: 20%; padding-left: 5px;">
                        <div>
                            <span><b>No.</b> </span>
                            <span><b>เลขที่</b> </span>
                            <span><b>Date</b>: </span>
                            <span><b>วันที่</b> </span>
                        </div>
                    </td>
                </table>
            </div>

            <div class="table">
                <table>
                    <thead>
                        <th>
                            Description / รายการ 
                        </th>
                        <th>
                            Amount
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($data->items as $item)
                            <tr>
                                <td>
                                    {{$item->detail}}
                                </td>
                                <td>
                                    {{$item->amount}}
                                </td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>