<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$title}}</title>
    @if(isset($test)&&$test)
    <link rel="stylesheet" href="{{asset('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pdf/booking-job-order.css')}}">
    @else
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/main.css')}}">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf/booking-job-order.css')}}">
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
        @include('print.asset.header_two_lang')
        <div class="content">
            <div class="title"><b>BOOKING CONFIRMATION</b></div>
            <div class="detail">
                <table style="margin-top : 20px;">
                    <tr>
                        <th style="width: 5%;">REF : </th>
                        <td style="width: 55%;">
                            {{$data->documentID}}
                        </td>
                        <th style="width: 5%;">Date : </th>
                        <td style="width: 20%;">
                            {{Carbon\Carbon::parse($data->documentDate) == Carbon\Carbon::createFromTimestamp(0) ?
                            "00/00/0000": Carbon\Carbon::parse($data->documentDate)->format('d/m/Y')}}
                        </td>
                    </tr>
                </table>
                <table class="detail-block">
                    <tr>
                        <td style="width: 50%;">
                            <b>TO : </b>
                            {{$data->customerRefer != null ? $data->customerRefer->custNameEN : ""}}
                        </td>
                        <td style="width: 50%;">
                            <b>Tel : </b>
                            {{$data->customerRefer != null ? $data->customerRefer->tel : ""}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>ATTN : </b>
                            {{$data->customerRefer != null ? $data->cusContact : ""}}
                        </td>
                        <td>
                            <b>Fax : </b>
                            {{$data->customerRefer != null ? $data->customerRefer->fax : ""}}
                        </td>
                    </tr>
                </table>
                <div class="header-table">COMMODITY INFORMATION (DIRECT-FCL)</div>
                <table class="detail-block">
                    <tr>
                        <td>
                            <b>Commodity : </b>
                            {{join(',', $groupCommodity)}}
                        </td>
                        <td>
                            <b>Volum : </b>
                            {{join(',', $groupContainer)}}
                        </td>
                    </tr>
                </table>
                <div class="header-table">VESSEL INFORMATION</div>
                <table class="detail-block">
                    <tr>
                        <td>
                            <b>BOOKING NO. </b>
                            {{$data->bookingNo != '' ? $data->bookingNo : "N/A"}}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <b>Carrier : </b>
                            {{$data->agentRefer != null ? $data->agentRefer->supNameEN : "N/A"}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Feeder : </b>
                            {{$data->referFeeder != null ? $data->referFeeder->fName : "N/A"}}
                            {{$data->feederVOY ?? ''}}
                        </td>
                        <td>
                            <b>Vessel : </b>
                            {{$data->vesselFeeder != null ? $data->vesselFeeder->fName : ""}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>FOB AT : </b>
                            {{$data->PlaceFOB != null ? $data->PlaceFOB->pName : ""}}
                        </td>
                        <td>
                            <b>Paperless Code : </b>
                            {{$data->paperless}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Place of Receive : </b>
                            {{$data->receivePlace != null ? $data->receivePlace->pName : ""}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Port of Loading : </b>
                            {{$data->landingPort != null ? $data->landingPort->portNameEN : ""}}
                        </td>
                        <td>
                            <b>ETD : </b>
                            {{Carbon\Carbon::parse($data->etdDate) == Carbon\Carbon::createFromTimestamp(0) ?  "00/00/0000": Carbon\Carbon::parse($data->etdDate)->format('d/m/Y')}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Port of Discharge : </b>
                            {{$data->dischargePort != null ? $data->dischargePort->portNameEN : ""}}
                        </td>
                        <td>
                            <b>ETA : </b>
                            {{Carbon\Carbon::parse($data->etaDate) == Carbon\Carbon::createFromTimestamp(0) ?  "00/00/0000": Carbon\Carbon::parse($data->etaDate)->format('d/m/Y')}}
                        </td>
                    </tr>
                </table>
                <div class="header-table">STUFFING INFORMATION</div>
                <table class="detail-block">
                    <tr>
                        <td>
                            <b>Stuffing AT : </b>
                            {{$data->stu_location}}
                        </td>
                        <td>
                            <b>Stuffing Date : </b>
                            {{Service::DateFormat($data->stu_date, true)}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>CONTACT : </b>
                            {{$data->stu_contact}}
                        </td>
                        <td>
                            <b>TEL : </b>
                            {{$data->stu_mobile}}
                        </td>
                    </tr>
                </table>
                <div class="header-table">CYAND RTN INFORMATION</div>
                <table class="detail-block">
                    <tr>
                        <td>
                            <b>CY AT : </b>
                            {{$data->cy_location}}
                        </td>
                        <td>
                            <b>CY Date : </b>
                            {{Service::DateFormat($data->cy_date, true)}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>CONTACT : </b>
                            {{$data->cy_contact}}
                        </td>
                        <td>
                            <b>TEL : </b>
                            {{$data->cy_mobile}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>RTN AT : </b>
                            {{$data->rtn_location}}
                        </td>
                        <td>
                            <b>RTN Date : </b>
                            {{Service::DateFormat($data->rtn_date, true)}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>CONTACT : </b>
                            {{$data->rtn_contact}}
                        </td>
                        <td>
                            <b>TEL : </b>
                            {{$data->rtn_mobile}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>CLOSTING TIME : </b>
                            {{Service::DateFormat($data->closingDate)." ".($data->closingTime)}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Remark : </b>
                            {{$data->note}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>