<?php
require_once( 'class.php' );
require_once( 'function.php' );

$db=new cl;
$db->connect();


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
              window.prompt('',data);
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
    <h2>Trailer Booking / ใบจองหัวราก</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Marketing</a></li>
      <li class="breadcrumb-item"> <a>Trailer Booking</a></li>
    </ol>
  </div>
  <div class="col-lg-2"> </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight ecommerce">

  <div class="ibox-title">
          <h5>Search Condition</h5>
          <div class="ibox-tools"> 
			  <a href="trailer_booking_form?action=add" class="btn btn-primary btn-xs"><i class="fa fa-plus "> </i> Create new </a> 
	  
	  
	  
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
                  <th data-hide="phone" width="15%">Date</th>
                  <th data-toggle="true" width="35%">Customer</th>
                  <th data-hide="phone,tablet" width="10%">ref Job</th>
                  <th data-hide="phone,tablet" width="10%">Sale</th>
                  <th  width="10%">Status</th>
                  <th data-hide="phone,tablet"  data-sort-ignore="true" width="15%">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
$sql="SELECT
j.documentID,
date_format(j.documentDate,'%d/%m/%Y') as documentDate,
j.documentstatus,
c.custNameTH,
j.ref_jobID,
s.empName,
rf.status_name
FROM $db->dbname.trailer_booking AS j
INNER JOIN $db->dbname.joborder AS jo ON j.comCode = jo.comCode AND j.ref_jobID = jo.documentID
INNER JOIN $db->dbname.common_customer AS c ON j.comCode = c.comCode AND j.cusCode = c.cusCode
INNER JOIN $db->dbname.common_saleman AS s ON jo.comCode = s.comCode AND jo.saleman = s.usercode
INNER JOIN $db->dbname.ref_documentstatus AS rf ON j.comCode = rf.comCode AND j.documentstatus = rf.status_code
WHERE (j.documentDate BETWEEN  '$var_dateStart' AND '$var_dateEnd') 
AND j.cusCode LIKE'$cusCode%' 
AND jo.saleman LIKE '$saleman%'";
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
                  <td><?php echo $r['custNameTH'];?></td>
                  <td><a href="job_form?action=view&documentID=<?php echo $r['ref_jobID'];?>" target="blank"><?php echo $r['ref_jobID'];?></a></td>
                  <td><?php echo $r['empName'];?></td>
                  <td class="center"> <span class="label label-<?php echo $isActiveStype;?>"><?php echo $r['status_name']; ?></span></td>
                  <td class="center">
                    <div class="btn-group">
                      <button class="btn-white btn btn-xs" onClick="location.href='trailer_booking_form?action=view&documentID=<?php echo $r['documentID'];?>' ">View</button>
                      <button class="btn-white btn btn-xs" onClick="location.href='trailer_booking_form?action=edit&documentID=<?php echo $r['documentID'];?>' ">Edit</button>
                      <button class="btn-white btn btn-xs" onClick="return confirmDel('<?php echo $r['documentID']; ?>','trailer_booking_action.php');">Delete</button>
                    </div>
                  </td>
                </tr>
                <?php  
}
?>
      
      
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="9"><ul class="pagination float-left">
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