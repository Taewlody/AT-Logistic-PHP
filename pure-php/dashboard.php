

        <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title">
                  
                        <h5> Invoice</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">
						
						
<?php $sqlIV="select
sum(j.total_netamt) as total_netamt

FROM $db->dbname.invoice AS j
LEFT JOIN $db->dbname.tax_invoice_items AS tx ON j.comCode = tx.comCode AND j.documentID = tx.invNo
WHERE  j.documentstatus='A'
AND tx.documentID IS NULL";
$result_IV=$db->fetch($sqlIV);
echo n2($result_IV['total_netamt']);						
?>
						</h1>
              
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title">
                
                        <h5>Account Balance</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?php 
	
	
	
$sqlTIV="
select 
sum(t.tx+t.ap) as total_netamt

from(
SELECT
0 as  tx,
sum(t.sumTotal)  as ap
FROM advance_payment AS t
WHERE DATE_FORMAT(t.documentDate,'%Y%m')=DATE_FORMAT(NOW(),'%Y%m')  AND t.documentstatus='A'
UNION ALL

SELECT
sum(j.total_netamt) as  tx,
0 as ap
FROM
tax_invoice AS j
WHERE DATE_FORMAT(j.documentDate,'%Y%m')=DATE_FORMAT(NOW(),'%Y%m')) as t

";
$result_TIV=$db->fetch($sqlTIV);
							

							
							
							
$sql_pv="SELECT
sum(t.pc+t.pv) as amt
 from(
SELECT
sum(t.grandTotal) as  pc,
0 as pv
FROM petty_cash AS t
WHERE DATE_FORMAT(t.documentDate,'%Y%m')=DATE_FORMAT(NOW(),'%Y%m') AND t.documentstatus='A'
UNION ALL 
SELECT
0 as  pc,
sum(t.grandTotal)  as pv
FROM payment_voucher AS t
WHERE DATE_FORMAT(t.documentDate,'%Y%m')=DATE_FORMAT(NOW(),'%Y%m')  AND t.documentstatus='A'




) as t";						
$result_pv=$db->fetch($sql_pv);							
							
	$x=	($result_TIV['total_netamt']-$result_pv['amt']);				
							
							
if($x<0){
	echo "<span class='text-danger'>".n2($x)."</span>";
}else{
echo n2($x);	
}							

?>
						
							
						
						</h1>
                       
                      
                    </div>
                </div>
            </div>

              <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title">
   
                        <h5>income this month</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?php 
echo n2($result_TIV['total_netamt']);						
?></h1>
                    
                      
                    </div>
                </div>
            </div>
			            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-info float-right">Monthly</span>
                        <h5 >VAT</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins "><?php $sqlvat="SELECT sum(t.total_vat) as  total_vat FROM tax_invoice AS t WHERE DATE_FORMAT(t.documentDate,'%Y%m')=DATE_FORMAT(NOW(),'%Y%m')
";
$result_vat=$db->fetch($sqlvat);
echo n2($result_vat['total_vat']);						
?></h1>
              
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Advance Payment</h5>
                        <div class="ibox-tools">
                            
                        </div>
                    </div>
                    <div class="ibox-content no-padding" style="height: 70px; overflow: auto; "><table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
              <thead>
                <tr>
                  <th width="5%">No.</th>
                  <th data-hide="phone,tablet" width="50%">Customer Name</th>
                  <th data-hide="phone,tablet" width="15%">Total Net</th>
                </tr>
              </thead>
              <tbody>
              <?php
$sql="SELECT
Sum(ap.sumTotal) AS sumTotal,
ap.cusCode,
cs.custNameTH
FROM
advance_payment AS ap
INNER JOIN joborder AS j ON ap.comCode = j.comCode AND ap.refJobNo = j.documentID
LEFT JOIN invoice AS i ON j.comCode = i.comCode AND j.documentID = i.ref_jobNo
INNER JOIN common_customer AS cs ON ap.comCode = cs.comCode AND ap.cusCode = cs.cusCode
WHERE
i.documentID IS NULL
GROUP BY ap.cusCode

";
$result=$db->query($sql);
$i=1;
$total_ap=0;
 
                  
while($r=mysqli_fetch_array($result)){
    
    $total_ap+=$r['sumTotal'];

?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $r['custNameTH'];?></td>
                  <td><?php echo n2($r['sumTotal']);?></td>
                </tr>
                <?php  
	$i++;
}
?>
      
      
              </tbody>
              <tfoot>
                
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><strong><?php echo n2($total_ap);?></strong></td>
                </tr>  
               
              </tfoot>
            </table>
                        <div class="flot-chart m-t-lg" style="height: 40px;">
                            <div class="flot-chart-content" id="flot-chart1" hidden=""></div>
							
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="ibox ">
                    <div class="ibox-content">


                        <div class="m-t-sm">

                            <div class="row">
                               
                                        <canvas id="lineChart" height="94"></canvas>
                              
                                
                            </div>

                        </div>


                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                
                        <h5>ใบแจ้งหนี้ ค้างชำระ</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row" style=" overflow-x: auto; height: 295px;">
							
           <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
              <thead>
                <tr>
                  <th width="5%">No.</th>
                  <th data-hide="phone,tablet" width="50%">Customer Name</th>
                  <th data-hide="phone,tablet" width="15%">Total Net</th>
                </tr>
              </thead>
              <tbody>
              <?php
$sql="SELECT
j.documentID,
date_format(j.documentDate,'%d/%m/%Y') as documentDate,
j.documentstatus,
c.custNameTH,
j.total_amt,
j.total_vat,
j.tax3,
j.tax1,
j.cus_paid,
sum(j.total_netamt) as total_netamt

FROM $db->dbname.invoice AS j
INNER JOIN $db->dbname.common_customer AS c ON j.comCode = c.comCode AND j.cusCode = c.cusCode
LEFT JOIN $db->dbname.tax_invoice_items AS tx ON j.comCode = tx.comCode AND j.documentID = tx.invNo
WHERE  j.documentstatus='A'
AND tx.documentID IS NULL
group by j.cusCode
order by total_netamt desc
";
$result=$db->query($sql);
$i=1;
$total_amt=0;
$total_vat=0;
$tax3=0;
$tax1=0;
 $cus_paid=0;
$total_netamt=0;
                                           
                  
                  
while($r=mysqli_fetch_array($result)){
    
    $total_amt+=$r['total_amt'];
    $total_vat+=$r['total_vat'];
    $tax3+=$r['tax3'];
    $tax1+=$r['tax1'];
    $cus_paid+=$r['cus_paid'];
    $total_netamt+=$r['total_netamt'];
?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $r['custNameTH'];?></td>
                  <td><?php echo n2($r['total_netamt']);?></td>
                </tr>
                <?php  
	$i++;
}
?>
      
      
              </tbody>
              <tfoot>
                
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><strong><?php echo n2($total_netamt);?></strong></td>
                </tr>  
               
              </tfoot>
            </table>							
							
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="row">

        <div class="col-lg-12">
        <div class="ibox ">
        <div class="ibox-title">
            <h5>Job Inprocess</h5>
        </div>
        <div class="ibox-content">
     
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Job No.</th>
                        <th> Date </th>
                        <th>Customer </th>
                        <th>Port</th>
                        <th>Sales </th>
                        <th>Time period (Day) </th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        
       <?php
$sql="SELECT
j.comCode,
j.documentID,
date_format(j.documentDate,'%d/%m/%Y') AS documentDate,
DATEDIFF(NOW(),j.documentDate) as datediff,
j.documentstatus,
c.custNameEN,
j.port_of_landing,
p.portNameEN,
s.empName
FROM
joborder AS j
INNER JOIN common_customer AS c ON j.comCode = c.comCode AND j.cusCode = c.cusCode
LEFT JOIN common_port AS p ON j.comCode = p.comCode AND j.port_of_landing = p.portCode
INNER JOIN common_saleman AS s ON j.comCode = s.comCode AND j.saleman = s.usercode
WHERE
j.documentstatus = 'P'
order by datediff desc
";
$result=$db->query($sql);
$i=1;
$isActiveStype="";
while($r=mysqli_fetch_array($result)){



?>            
                        
                        
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $r['documentID'];?></td>
                        <td><?php echo $r['documentDate'];?></td>
                        <td><?php echo $r['custNameEN'];?></td>
                        <td><?php echo $r['portNameEN'];?></td>
                        <td><?php echo $r['empName'];?></td>
                        <td><?php echo $r['datediff'];?></td>
                        <td><a href="job_form?action=view&documentID=<?php echo $r['documentID'];?>" target="_blank"><i class="fa fa-search text-navy"></i></a></td>
                    </tr>
                        
 <?php $i++; } ?>                       
                    
                    </tbody>
                </table>
            </div>

        </div>
        </div>
        </div>

        </div>


        </div>


   

  

    <!-- Mainly scripts 
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	-->

	
	
	
    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="js/plugins/flot/curvedLines.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>
    <script src="js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript 
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
	-->
    <!-- jQuery UI -->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jvectormap -->
    <script src="js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="js/plugins/chartJs/Chart.min.js"></script>

    <script>
        $(document).ready(function() {


            var d1 = [[1262304000000, 6], [1264982400000, 3057], [1267401600000, 20434], [1270080000000, 31982], [1272672000000, 26602], [1275350400000, 27826], [1277942400000, 24302], [1280620800000, 24237], [1283299200000, 21004], [1285891200000, 12144], [1288569600000, 10577], [1291161600000, 10295]];
            var d2 = [[1262304000000, 5], [1264982400000, 200], [1267401600000, 1605], [1270080000000, 6129], [1272672000000, 11643], [1275350400000, 19055], [1277942400000, 30062], [1280620800000, 39197], [1283299200000, 37000], [1285891200000, 27000], [1288569600000, 21000], [1291161600000, 17000]];

            var data1 = [
                { label: "Data 1", data: d1, color: '#17a084'},
                { label: "Data 2", data: d2, color: '#127e68' }
            ];
            $.plot($("#flot-chart1"), data1, {
                xaxis: {
                    tickDecimals: 0
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 1
                            }, {
                                opacity: 1
                            }]
                        },
                    },
                    points: {
                        width: 0.1,
                        show: false
                    },
                },
                grid: {
                    show: false,
                    borderWidth: 0
                },
                legend: {
                    show: false,
                }
            });
<?php
$infoChart1= $db->fetch("SELECT
sum(i.chargesReceive) as priceBeforevat,
sum(if(month(j.documentDate)=1,i.chargesReceive,0)) as m1,
sum(if(month(j.documentDate)=2,i.chargesReceive,0)) as m2,
sum(if(month(j.documentDate)=3,i.chargesReceive,0)) as m3,
sum(if(month(j.documentDate)=4,i.chargesReceive,0)) as m4,
sum(if(month(j.documentDate)=5,i.chargesReceive,0)) as m5,
sum(if(month(j.documentDate)=6,i.chargesReceive,0)) as m6,
sum(if(month(j.documentDate)=7,i.chargesReceive,0)) as m7,
sum(if(month(j.documentDate)=8,i.chargesReceive,0)) as m8,
sum(if(month(j.documentDate)=9,i.chargesReceive,0)) as m9,
sum(if(month(j.documentDate)=10,i.chargesReceive,0)) as m10,
sum(if(month(j.documentDate)=11,i.chargesReceive,0)) as m11,
sum(if(month(j.documentDate)=12,i.chargesReceive,0)) as m12
FROM tax_invoice AS j
INNER JOIN tax_invoice_items AS i ON j.comCode = i.comCode AND j.documentID = i.documentID
WHERE year(j.documentDate)=year(NOW())   /*AND j.documentstatus='A'*/  ");

$infochart2=$db->fetch("SELECT

count(if(month(j.documentDate)=1,1,NULL)) as m1,
count(if(month(j.documentDate)=2,1,NULL)) as m2,
count(if(month(j.documentDate)=3,1,NULL)) as m3,
count(if(month(j.documentDate)=4,1,NULL)) as m4,
count(if(month(j.documentDate)=5,1,NULL)) as m5,
count(if(month(j.documentDate)=6,1,NULL)) as m6,
count(if(month(j.documentDate)=7,1,NULL)) as m7,
count(if(month(j.documentDate)=8,1,NULL)) as m8,
count(if(month(j.documentDate)=9,1,NULL)) as m9,
count(if(month(j.documentDate)=10,1,NULL)) as m10,
count(if(month(j.documentDate)=11,1,NULL)) as m11,
count(if(month(j.documentDate)=12,1,NULL)) as m12
FROM joborder AS j
WHERE year(j.documentDate)=year(NOW()) ");




?>
            var lineData = {
                labels: ["January", "February", "March", "April", "May", "June", "July","august","september","october","november","december"],

                datasets: [
                    {
                        label: "ยอดขาย",
                        backgroundColor: "rgba(26,179,148,0.5)",
                        borderColor: "rgba(26,179,148,0.7)",
                        pointBackgroundColor: "rgba(26,179,148,1)",
                        pointBorderColor: "#fff",
                        data: [
                        <?php echo $infoChart1['m1'];?>, 
                        <?php echo $infoChart1['m2'];?>,
                        <?php echo $infoChart1['m3'];?>,
                        <?php echo $infoChart1['m4'];?>,
                        <?php echo $infoChart1['m5'];?>,
                        <?php echo $infoChart1['m6'];?>,
                        <?php echo $infoChart1['m7'];?>,
                        <?php echo $infoChart1['m8'];?>,
                        <?php echo $infoChart1['m9'];?>,
                        <?php echo $infoChart1['m10'];?>,
                        <?php echo $infoChart1['m11'];?>,
                        <?php echo $infoChart1['m12'];?>
                        ]
                    },
                    {
                        label: "จำนวน JOB",
                        backgroundColor: "rgba(220,220,220,0.5)",
                        borderColor: "rgba(220,220,220,1)",
                        pointBackgroundColor: "rgba(220,220,220,1)",
                        pointBorderColor: "#fff",
                        data: [
                        <?php echo $infochart2['m1'];?>, 
                        <?php echo $infochart2['m2'];?>,
                        <?php echo $infochart2['m3'];?>,
                        <?php echo $infochart2['m4'];?>,
                        <?php echo $infochart2['m5'];?>,
                        <?php echo $infochart2['m6'];?>,
                        <?php echo $infochart2['m7'];?>,
                        <?php echo $infochart2['m8'];?>,
                        <?php echo $infochart2['m9'];?>,
                        <?php echo $infochart2['m10'];?>,
                        <?php echo $infochart2['m11'];?>,
                        <?php echo $infochart2['m12'];?>
                    ]
                    }
                ]
            };

            var lineOptions = {
                responsive: true
            };


            var ctx = document.getElementById("lineChart").getContext("2d");
            new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});


        });
    </script>
