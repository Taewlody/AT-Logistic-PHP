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
        .header {
            top: -30px;
            bottom: 30px;
            position: fixed;
            width: 100%
        }
        .header-title {
            font-weight: bold;
            font-size: 40px;
            line-height: 40px;
            text-align: center;
        }
        .header-date {
            font-size: 22px;
            line-height: 20px;
        }
        .table-font {
            font-size: 20px;
            line-height: 15px;
        }
        body {
            margin-top: 60px;
        }
    </style>
</head>
<body >
    <header class="header" >
        <div class="header-title">รายงานภาษีขาย</div>
        <div class="header-date">เดือน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$month}} {{$year}}</div>
    </header>
    
    <div class="page">
        <table class="table-font" width="100%" border="1" cellpadding="1" >
            <thead>
                <tr>
                    <td colspan="4" align="left" width="74%" >{{$company->comname}}</td>
                    <td colspan="2" align="center" width="26%">เลขประจำตัวผู้เสียภาษีอากร</td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left">{{$company->address}}</td>
                    <td colspan="2" align="center">{{$company->taxID}}</td>
                  </tr>
                  <tr>
                    <td width="7%" rowspan="2" align="center" >ลำดับ</td>
                    <td colspan="2" align="center" width="30%">ใบกำกับภาษี</td>
                    <td width="33%" rowspan="2" align="center" width="37%">ชื่อผู้ซื้อสินค้า/ผู้รับบริการ</td>
                    <td width="5%" rowspan="2" align="center" width="13%">ยอดก่อน<br>ภาษีมูลค่าเพิ่ม</td>
                    <td width="6%" rowspan="2" align="center" width="13%">ภาษี<br>มูลค่าเพิ่ม</td>
                  </tr>
                  <tr>
                    <td width="23%" align="center" width="15%">ว/ด/ป</td>
                    <td width="26%" align="center" width="15%">เลขที่/เล่มที่</td>
                  </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $item)
                <tr>
                    <td width="7%" align="center">{{$i+1}}</td>
                    <td width="15%" align="center">{{Service::DateFormat($item->documentDate, true)}}</td>
                    <td width="15%" align="center">{{$item->documentID}}</td>
                    <td width="37%" align="left">{{$item->customer != null ? $item->customer->custNameTH : ''}}</td>
                    <td width="13%" align="right">{{ number_format($item->items_sum_charges_receive, 2,'.', ',') }}</td>
                    <td width="13%" align="right" >{{ number_format($item->total_vat, 2, '.', ',') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right"><strong>รวม</strong></td>
                    <td align="right"><strong>{{ number_format($getTotalAmount, 2,'.', ',') }}</strong></td>
                    <td align="right"><strong>{{ number_format($getTotalVat, 2,'.', ',') }}</strong></td>
                  </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>