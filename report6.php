<?php
require_once( 'class.php' );
require_once( 'function.php' );

$db=new cl;
$db->connect();


$supCode=post('supCode');
$saleman=post('saleman');
$documentID=post('documentID');
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
                           // alert(data);
						if(data=='success'){
						 swal("Deleted!", "Your Data file has been deleted.", "success");
							setTimeout(function(){ 
							 window.location.reload(1);	
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
    <h2>รายงาน ใบสำคัญจ่าย</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item">Report</li>
      <li class="breadcrumb-item">รายงานใบสำคัญจ่าย</li>
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
                    <div class="form-group col-margin0" id="dateStart" style="width: 150px;">
                      <label class="font-normal">Date Range</label>
                      <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" name="dateStart" class="form-control" value="<?php echo $dateStart;?>" autocomplete="off">
                      </div>
                    </div>
                    <div class="form-group col-margin0 " id="dateEnd" style="width: 150px;">
                      <label class="font-normal">To</label>
                      <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" name="dateEnd" class="form-control " value="<?php echo $dateEnd;?>" autocomplete="off">
                      </div>
                    </div>
                <div class="form-group" >
                      <label class="font-normal">Document  No.</label>
                      <div class="input-group">
                        <input type="text" id="documentID" name="documentID" class="form-control" value="">
                      </div>
                    </div>
                    <div class="form-group col-margin0" >
                      <label class="font-normal">Supplier</label>
                      <div >
                        <select class="select2_single form-control select2" style="width:300px;" name="supCode" id="supCode">
                           <?php $db->s_supplier($supCode);?>
                        </select>
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
                  <th data-hide="phone" width="10%">Document Date</th>
                  <th data-toggle="true" width="15%">Supplier</th>
                  <th data-hide="phone,tablet" width="15%">Detail</th>
                  <th  width="10%">Amount</th>
                  <th data-hide="phone,tablet"  data-sort-ignore="true" width="10%">Ref. Bill No.</th>
                  <th data-hide="phone,tablet"  data-sort-ignore="true" width="10%">Ref. Job No.</th>
                </tr>
              </thead>
              <tbody>
              <?php
$sql="SELECT
j.documentID,
date_format(j.documentDate,'%d/%m/%Y') as documentDate,
j.documentstatus,
c.supNameTH,
j.refJobNo,
ji.invNo,
ji.chartDetail,
ji.amount,
rf.status_name
FROM $db->dbname.payment_voucher AS j
INNER JOIN $db->dbname.payment_voucher_items AS ji ON j.comCode = ji.comCode AND j.documentID = ji.documentID
INNER JOIN $db->dbname.common_supplier AS c ON j.comCode = c.comCode AND j.supCode = c.supCode
INNER JOIN $db->dbname.ref_documentstatus AS rf ON j.comCode = rf.comCode AND j.documentstatus = rf.status_code
WHERE (j.documentDate BETWEEN  '$var_dateStart' AND '$var_dateEnd') 
AND j.supCode LIKE'$supCode%' ";
$result=$db->query($sql);
$i=1;
$isActiveStype="";
while($r=mysqli_fetch_array($result)){

switch ($r['documentstatus']) {
  case 'A':
    $isActiveStype='primary';
    break;
  case 'P':
      $isActiveStype='warning';
     break; 
  case 'P':
      $isActiveStype='danger';
     break; 
  default:
  $isActiveStype='primary';
    break;
}

?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $r['documentID'];?></td>
                  <td><?php echo $r['documentDate'];?></td>
                  <td><?php echo $r['supNameTH'];?></td>
                  <td><?php echo $r['chartDetail'];?></td>
                  <td class="center"><?php echo number($r['amount'],2);?></td>
                   <td><?php echo $r['invNo'];?></td>
                <td><?php echo $r['refJobNo'];?></td>
                </tr>
                <?php  
}
?>
      
      
              </tbody>
              <tfoot>
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