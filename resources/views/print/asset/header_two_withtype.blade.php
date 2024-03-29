<table class="header-page">
    <tbody>
        <td class="company-detail">
            <b class="name-company">AT LOGISTICS AND SERVICES CO., LTD. (Head Office)</b>
            <span>29/59 Soi Chan 43 Yak 26-1-1, Bang Khlo , Bang Kho Laem District, Bangkok 10120</span>
            <b class="name-company">บริษัท เอที โลจิสติกส์ แอนด์ เซอร์วิสเซส จำกัด (สำนักงานใหญ่)</b>
            <span>29/59 ซอยจันทน์43 แยก26-1-1 แขวงบางโคล่ เขตบางคอแหลม กรุงเทพมหานคร 10120</span>
            <span><b>หมายเลขประจำตัวผู้เสียภาษี</b>   0105549135221</span>
            <span><b>Tel.</b>   02-096-6050 (AUTO)   <b>Fax.</b> 02-6749007</span>
        </td>
        <td class="company-logo" style="vertical-align: top;">
            @if(isset($test)&&$test)
            <img class="logo" src="{{asset('assets/images/logo/at-logo.png')}}" alt="">
            @else
            <img class="logo" src="{{public_path('assets/images/logo/at-logo.png')}}" alt="">
            @endif
            @if($type != null)
            <div class="type-page">{{$type}}</div>
            @endif
        </td>
    </tbody>
</table>