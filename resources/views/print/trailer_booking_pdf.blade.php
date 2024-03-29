<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$title}}</title>
    @if(isset($test)&&$test)
    <link rel="stylesheet" href="{{asset('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pdf/trailer-booking.css')}}">
    @else
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/trailer-booking.css')}}">
    @endif
</head>

<body>
    <div class="page">
        @include('print.asset.trailer_book_header')
        <div class="content">
            <table>
                <tr class="col-2">
                    <td>
                        <span class="header">วันที่ : </span>{{Carbon\Carbon::parse($data->documentDate) == Carbon\Carbon::createFromTimestamp(0) ?  "00/00/0000": Carbon\Carbon::parse($data->documentDate)->format('d/m/Y')}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">ถึงบริษัท : </span>{{$data->tocompany}}
                    </td>
                    <td>
                        <span class="header">คุณ : </span>{{$data->companyContact}}
                    </td>
                </tr>
            </table>
            @include('print.asset.trailer_book_header2')
            <span class="margin-top: 25px; margin-left: 8px;"><b style="font-size: 22px !important;">กรุณาจัดรถหัวลากไปรับตู้/คืนตู้ ตามรายละเอียด ดังนี้</b></span>
            <table class="detail">
                <tr class="col-2">
                    <td>
                        <span class="header">บริษัท : </span>{{$data->customer != null ? $data->customer->custNameEN : ''}}
                    </td>
                    <td>
                        <span class="header">จำนวนตู้ : </span>{{join(',', $groupContainer)}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">รับตู้วันที่ : </span>{{$data->jobOrder != null ? Service::DateFormat($data->jobOrder->cy_date, true) : ''}}
                    <td>
                        <span class="header">สถานที่รับตู้ : </span>{{$data->jobOrder != null ? $data->jobOrder->cy_location : ''}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">ติดต่อคุณ : </span>{{$data->jobOrder != null ? $data->jobOrder->cy_contact : ''}}
                    </td>
                    <td>
                        <span class="header">โทรศัพท์ : </span>{{$data->jobOrder != null ? $data->jobOrder->cy_mobile : ''}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">คืนตู้วันที่ : </span>{{$data->jobOrder != null ? Service::DateFormat($data->jobOrder->rtn_date, true) : ''}}
                    </td>
                    <td>
                        <span class="header">สถานที่คืนตู้ : </span>{{$data->jobOrder != null ? $data->jobOrder->rtn_location : ''}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">ติดต่อคุณ : </span>{{$data->jobOrder != null ? $data->jobOrder->rtn_contact : ''}}
                    </td>
                    <td>
                        <span class="header">โทรศัพท์ : </span>{{$data->jobOrder != null ? $data->jobOrder->rtn_mobile : ''}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">ตู้บรรจุวันที่ : </span>{{$data->jobOrder != null ? Service::DateFormat($data->jobOrder->stu_date, true) : ''}}
                    </td>
                    <td>
                        <span class="header">สถานที่บรรจุ : </span>{{$data->jobOrder != null ? $data->jobOrder->stu_location : ''}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">ติดต่อคุณ : </span>{{$data->jobOrder != null ? $data->jobOrder->stu_contact : ''}}
                    </td>
                    <td>
                        <span class="header">โทรศัพท์ : </span>{{$data->jobOrder != null ? $data->jobOrder->stu_mobile : ''}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">Closing : </span>{{Service::DateFormat($data->closingDate, true)}}
                    </td>
                    <td>
                        <span class="header">Time : </span>{{$data->closingTime}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">บรรจุสินค้าวันที่ : </span>{{Service::DateFormat($data->packagingDate, true)}}
                    </td>
                    <td>
                        <span class="header">สถานที่โหลด : </span>{{$data->loadplace}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">ติดต่อคุณ : </span>
                    </td>
                    <td>
                        <span class="header">โทรศัพท์ : </span>
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">ชื่อเรือ : </span>{{(($data->jobOrder != null && $data->jobOrder->referFeeder != null) ? $data->jobOrder->referFeeder->fName : "").($data->jobOrder != null ? $data->feederVOY : "")}}
                    </td>
                    <td>
                        <span class="header">ETD : </span>{{$data->jobOrder != null ? Service::DateFormat($data->jobOrder->etdDate, true) : ""}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">Booking No. : </span>{{$data->jobOrder != null ? $data->jobOrder->bookingNo : ""}}
                    </td>
                    <td>
                        <span class="header">Agent : </span>{{$data->supplier != null ? $data->supplier->supNameEN : ""}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">Port: </span>{{$data->jobOrder != null&&$data->jobOrder->dischargePort != null ? $data->jobOrder->dischargePort->portNameEN : ""}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td>
                        <span class="header">Remark : </span>{{$data->jobOrder != null ? $data->jobOrder->note : ""}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="header">ผู้สั่งงาน : </span>{{$data->work_order}}
                    </td>
                </tr>
                <tr class="col-2">
                    <td style="padding-left: 0px; white-space: nowrap; font-size: 21px !important;">การวางบิลทุกครั้ง กรุณาแนบใบผ่านท่า พร้อมใบแจ้งลากตู้คอนเทนเนอร์ ฉบับนี้ด้วยทุครั้ง</td>
                </tr>
                <tr class="col-2">
                    <td style="padding-left: 0px;">
                        <span class="header">JOB REF : </span>{{$data->ref_jobID}}
                    </td>
                    <td>
                        <span class="header">INVOICE CUSTOMER REF : </span>{{$data->jobOrder != null&&$data->jobOrder->invoice != null ? $data->jobOrder->invoice->documentID : ""}}
                    </td>
                </tr>
            </table>
            <div class="footer">
                <table>
                    <tr>
                        <td>
                            <b>*** อย่าลืมรับซีลเอเยนต์ ตอนรับตู้ทุกครั้ง และกรุณารีบวางบิลด้วยค่ะ***</b>
                        </td>
                    </tr>
                    <tr style="margin-top: 10px;">
                        <td>
                            <b>ใบเสร็จค่าผ่านท่า คืนตู้ กรุณาออกตามที่อยู่ด้านล่างนี้</b>
                        </td>
                    </tr>
                </table>
                <table style="table-layout: fixed;">
                    <tr class="col-2">
                        <td style="text-align: right;">{{$data->jobOrder!= null&&$data->jobOrder->customerRefer!=null ? $data->jobOrder->customerRefer->custNameEN.$data->jobOrder->customerRefer->branchEN : '' }} taxID : </td>
                        <td style="text-align: left;"> {{$data->jobOrder!= null&&$data->jobOrder->customerRefer!=null ? $data->jobOrder->customerRefer->taxID : ''}}</td>
                        
                    </tr>
                    <tr class="col-2">
                        <td style="text-align: right;">Address : </td>
                        <td style="text-align: left;"> {{$data->jobOrder!= null&&$data->jobOrder->customerRefer!=null ? $data->jobOrder->customerRefer->addressEN.' '.$data->jobOrder->customerRefer->zipCode : ''}}</td>         
                    </tr>
                </table>
                <table style="margin-top: 10px;">
                    <tr>
                        <td>
                            <b>ถ้าใบเสร็จรับตู้-คืนตู้เกินหนี่งพันบาท รบกวนทำภาษีหัก ณ ที่จ่ายด้วย</b>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>