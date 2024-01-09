<?php
require_once( 'class.php' );
require_once( 'function.php' );

$db=new cl;
$db->connect();

$documentID=post('documentID');
$cusCode=post('cusCode');
$saleman=post('saleman');

/*
$dateStart=date('d/m/Y');
$dateEnd=date('d/m/Y');
*/
$dateStart=isset($_POST['dateStart'])?$_POST['dateStart']:date('1/n/Y');
$dateEnd=isset($_POST['dateEnd'])?$_POST['dateEnd']:date('j/n/Y');

$var_dateStart=formatDate_dash($dateStart);
$var_dateEnd=formatDate_dash($dateEnd);
?>

<!-- Data picker -->
<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script> 


<!-- FooTable --> 
<script src="js/plugins/footable/footable.all.min.js"></script> 
<!-- FooTable -->
<link href="css/plugins/footable/footable.core.css" rel="stylesheet">

<script>
 
function confirmDel(ID,URL){
  swal({
        title: "Are you sure?",
        text: "You will not be able to recover this Data !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function () {
	  
	  
  					var jsonObj={
						action:'del',
						documentID:ID
					}; 
					$.ajax({
					   	type: "POST",
					   	url: URL,
					   	data: jsonObj,
					   	success: function(data) {
						if(data=='success'){
						 swal("Deleted!", "Your Data file has been deleted.", "success");
							setTimeout(function(){ 
							 window.location.reload(1);	
                               //  console.log("SUCCESS : ", data);  
							}, 1000);
						  }else{
							 msgError();
							 console.log("Error : ", data);
						  }	 
					   }
					 });
    });

} 
        $(document).ready(function(){
			
			
			$('.select2_single').select2({});
			

			
			
$('.footable').footable();
			
			
			
      $('.input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
                
            });
      /*      
     var mem = $('#dateEnd .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
			*/
				
        });

    </script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>รายงาน แสดงกำไร-ขาดทุน ตาม JOB</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Report</a></li>
      <li class="breadcrumb-item">รายงาน แสดงกำไร-ขาดทุน ตามJob</li>
    </ol>
  </div>
  <div class="col-lg-2"> </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight ecommerce">

  <div class="ibox-title">
          <h5>Search Condition</h5>
          <div class="ibox-tools"> 
		
	  
	  
	  
	  </div>
        </div>
            <div class="ibox-content m-b-sm border-bottom">
				
              <form id="form" name="form" method="post">
              <div class="row m-b-sm m-t-sm">
                <div class="col-md-11">
                  <div class="input-group">

                     <div class="form-group col-margin0" >
                      <label class="font-normal">Job No.</label>
                      <div >
                     <input type="text" name="documentID" class="form-control" id="documentID" value="<?php echo $documentID; ?>">
                      </div>
                    </div>
                      
                    <div class="form-group col-margin0" >
                      <label class="font-normal">Customer</label>
                      <div >
                        <select class="select2_single form-control select2" style="width:300px;" name="cusCode" id="cusCode">
                           <?php $db->s_customer($cusCode);?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group col-margin0" >
                      <label class="font-normal">Sale</label>
                      <div class="input-group">
                        <div class="">
                          <select class="select2_single form-control select2" style="width: 200px;" name="saleman" id="saleman">
                           <?php  $db->s_saleman($saleman);?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-margin0" >
                      <label class="font-normal">Month</label>
                      <div class="input-group">
                        <div style="display: flex;">
                          <input class="form-control input-group date mr-1" type="text" name="s_date" autocomplete="off" value="<?php if(!empty($_POST['s_date'])){echo $_POST['s_date'];}?>" style="width: 110px;">
                          <div style="margin: 5px;">-</div>
                          <input class="form-control input-group date" type="text" name="e_date" autocomplete="off" value="<?php if(!empty($_POST['e_date'])){echo $_POST['e_date'];}?>" style="width: 110px;">
                        </div>
                      </div>
                    </div>

                    <div class="form-group" >
                      <label class="font-normal" style="color: wheat">.</label>
                      <div class="input-group">
                        <button type="submit" class="btn btn-primary">Search</button>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </form>

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
						
                        <div class="ibox-content">

                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
              <thead>
                <tr>
                  <th width="5%">No.</th>
                  <th data-toggle="true" width="10%">Document  No.</th>
                  <th data-hide="phone" width="15%"> Date</th>
                  <th data-toggle="true" width="25%">Customer</th>
                  <th data-hide="phone,tablet" width="10%">รายได้</th>
                  <th  width="10%">ค่าใช้จ่าย</th>
                  <th  width="10%">กำไร/ขาดทุน1</th>
                  <th  width="10%">กำไร/ขาดทุน2</th>
                  <th data-hide="phone,tablet"  data-sort-ignore="true" width="15%">Action</th>
                </tr>
              </thead>
              <tbody>
<?php
// print_r($_POST);
$date_month = null;
if (!empty($_POST['s_date']) && !empty($_POST['e_date'])) {
  $s_date = str_replace('/', '-', $_POST['s_date']);
  $e_date = str_replace('/', '-', $_POST['e_date']);
  $s_date_ = date('Y-m-d', strtotime($s_date));
  $e_date_ = date('Y-m-d', strtotime($e_date));
  $date_month = " AND date(j.documentDate) BETWEEN '$s_date_' AND '$e_date_' ";
}

$sql="SELECT
j.documentID,
DATE_FORMAT(j.documentDate,'%d/%m/%Y') AS documentDate,
j.total_amt,
Sum(i.chargesCost) as cost,
(j.total_amt-Sum(i.chargesCost)-j.total_vat) AS profit,
(j.total_amt-Sum(i.chargesCost)-j.total_vat-j.tax3-j.tax1) AS netprofit,
c.custNameEN
FROM
joborder AS j
INNER JOIN joborder_charge AS i ON j.comCode = i.comCode AND j.documentID = i.documentID
INNER JOIN common_customer AS c ON j.comCode = c.comCode AND j.cusCode = c.cusCode
WHERE 
j.documentID like '%$documentID%'
AND j.cusCode LIKE'$cusCode%' 
AND j.saleman LIKE '$saleman%' 
$date_month 
group by j.documentID
order by j.documentID desc" ;
$result=$db->query($sql);
$i=1;
$isActiveStype="";

$total_amt    = 0;
$cost         = 0;
$profit       = 0;
$netprofit    = 0;

while($r=mysqli_fetch_array($result)){

  $total_amt    += $r['total_amt'];
  $cost         += $r['cost'];
  $profit       += $r['profit'];
  $netprofit    += $r['netprofit'];

 if($r['profit']>0){
      $isActiveStype='primary';
 } else{
     $isActiveStype='danger'; 
 }   
?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $r['documentID'];?></td>
                  <td><?php echo $r['documentDate'];?></td>
                  <td><?php echo $r['custNameEN'];?></td>
                  <td class="center"><?php echo n2($r['total_amt']); ?></td>
                  <td class="center"><?php echo n2($r['cost']); ?></td>
                  <td class="center"><span class="label label-<?php echo $isActiveStype;?>"><?php echo n2($r['profit']); ?></span></td>
                  <td class="center"><span class="label label-<?php echo $isActiveStype;?>"><?php echo n2($r['netprofit']); ?></span></td>
                  <td class="center">
                    <div class="btn-group">
                      <button class="btn-white btn btn-xs" onClick="location.href='job_form?action=view&documentID=<?php echo $r['documentID'];?>' ">View</button>
                 
                  
                    </div>
                  </td>
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
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><strong><?php echo n2($total_amt);?></strong></td>
                  <td><strong><?php echo n2($cost);?></strong></td>
                  <td><strong><?php echo n2($profit);?></strong></td>
                  <td><strong><?php echo n2($netprofit);?></strong></td>
                  <td class="center">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="10"><ul class="pagination float-left">
                    </ul></td>
                </tr>
              </tfoot>
            </table>

                        </div>
                    </div>
                </div>
            </div>


        </div>

<!--  END Body-->