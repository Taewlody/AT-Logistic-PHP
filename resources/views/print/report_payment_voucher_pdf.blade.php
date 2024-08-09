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
            position: fixed;
            top: -30px;
            bottom: 30px;
            width: 100%;
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
        table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-title">รายงานภาษีซื้อ</div>
        <div class="header-date">เดือน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$month}} {{$year}}</div>
    </header>
    
    <div class="page">
        <table class="table-font" border="1" cellpadding="1">
            <thead>
                <tr>
                    <td colspan="4" align="left" width="74%">{{$company->comname}}</td>
                    <td colspan="2" align="center" width="26%">เลขประจำตัวผู้เสียภาษีอากร</td>
                </tr>
                <tr>
                    <td colspan="4" align="left">{{$company->address}}</td>
                    <td colspan="2" align="center">{{$company->taxID}}</td>
                </tr>
                <tr>
                    <td width="7%" rowspan="2" align="center">ลำดับ</td>
                    <td colspan="2" align="center" width="30%">เลขที่บิล</td>
                    <td width="37%" rowspan="2" align="center">ชื่อผู้ขายสินค้า/ผู้ให้บริการ</td>
                    <td width="13%" rowspan="2" align="center">ยอดก่อน<br>ภาษีมูลค่าเพิ่ม</td>
                    <td width="13%" rowspan="2" align="center">ภาษี<br>มูลค่าเพิ่ม</td>
                </tr>
                <tr>
                    <td width="15%" align="center">ว/ด/ป</td>
                    <td width="15%" align="center" style="word-break: break-all">เลขที่/เล่มที่</td>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $item)
                <tr>
                    <td align="center">{{$i+1}}</td>
                    <td align="center">{{Service::DateFormat($item->documentDate, true)}}</td>
                    <td align="center" style="word-break: break-all">{{$item->items[0] != null ? $item->items[0]->invNo : ''}}</td>
                    <td align="left">{{$item->supplier != null ? $item->supplier->supNameTH : ''}}</td>
                    <td align="right">{{ number_format($item->sumTotal, 2,'.', ',') }}</td>
                    <td align="right">{{ number_format($item->sumTax7, 2,'.', ',') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right"><strong>รวม</strong></td>
                    <td align="right"><strong>{{ number_format($getSumTotal, 2,'.', ',') }}</strong></td>
                    <td align="right"><strong>{{ number_format($getSumTax7, 2,'.', ',') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
