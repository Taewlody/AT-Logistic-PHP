<?php
require_once( 'class.php' );
require_once( 'function.php' );

$db=new cl;
$db->connect();


$cusCode=post('cusCode');
$saleman=post('saleman');
$documentID=post('documentID');
$s_year=post('s_year');
$s_month=post('s_month');
if($s_month==''){$s_month=date('m');}
if($s_year==''){$s_year=date('Y');}
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
                              console.log("Result : ", data);
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

function openInNewTab(url) {

var vardocumentID=$("#documentID").val();
    if(vardocumentID=='')return false;
//var win = window.open('print/'+url+.php?documentID?documentID='+documentID, '_blank');
var win = window.open('print/'+url+'.php?s_year=<?php echo $s_year;?>&s_month=<?php echo $s_month;?>', '_blank');
win.focus();
}
    	
	
    </script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>รายงาน ภาษีซื้อ</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>รายงาน</a></li>
      <li class="breadcrumb-item"> <a>รายงาน ภาษีซื้อ</a></li>
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
                      <label class="font-normal">เดือน</label>
                      <div >
                        <select class="select2_single form-control select2" style="width:130px;" name="s_month" id="s_month">
                           <?php $db->s_month($s_month);?>
                        </select>
                      </div>
                    </div>

					  
                   <div class="form-group col-margin0" >
                      <label class="font-normal">ปี</label>
                      <div >
                        <select class="select2_single form-control select2" style="width:130px;" name="s_year" id="s_year">
                           <?php 
							
		if($s_year==''){
			echo "<option value='".date('Y')."' selected='selected'>".date('Y')."</option>";
		}	
			
		$i=0;					
		$i_year=date('Y');
		while($i<5){
			
			
			if($s_year==($i_year)){
			echo "<option value='".($i_year)."'selected='selected' >   ".($i_year)."</option>";
			}else{
			echo "<option value='".($i_year)."'>   ".($i_year)."</option>";
			}
			
			
			
			$i_year=($i_year-1);
			$i++;
		}					
							
							
							
							
							?>
                        </select>
                      </div>
                    </div>              


                    
                    <div class="form-group" >
                      <label class="font-normal" style="color: wheat">.</label>
                      <div class="input-group">
                        <button type="submit" class="btn btn-primary">Search</button>&nbsp;
						    <button class="btn btn-white " type="button" onclick="openInNewTab('<?php echo 'report9_pdf';?>');"  ><i class="fa fa-print"></i> Print</button>
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
                  <th data-toggle="true" width="15%">Bill  No.</th>
                  <th data-hide="phone" width="15%"> Date</th>
                  <th data-hide="" width="35%">Supplier Name</th>
                  <th data-hide="" width="15%">Amount</th>
                  <th data-hide="" width="10%">Vat</th>
                  
                  <th data-hide="phone,tablet"  data-sort-ignore="true" width="5%">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
$sql="SELECT
j.documentID,
date_format(j.documentDate,'%d/%m/%Y') AS documentDate,
c.supNameTH,
j.sumTotal,
p.invNo,
j.sumTax7
FROM $db->dbname.payment_voucher AS j
INNER JOIN $db->dbname.payment_voucher_items AS p ON j.comCode = p.comCode AND j.documentID = p.documentID
INNER JOIN $db->dbname.common_supplier AS c ON j.comCode = c.comCode AND j.supCode = c.supCode

WHERE year(j.documentDate)='$s_year' AND month(j.documentDate)='$s_month' 
AND j.purchasevat=1 AND j.documentstatus='A'
group by j.documentID
order by j.documentDate 
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
    
    $total_amt+=$r['sumTotal'];
    $total_vat+=$r['sumTax7'];
?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $r['invNo'];?></td>
                  <td><?php echo $r['documentDate'];?></td>
                  <td><?php echo $r['supNameTH'];?></td>
                  <td><?php echo n2($r['sumTotal']);?></td>
                <td><?php echo n2($r['sumTax7']);?></td>
                
                  <td class="center">
                    <div class="btn-group">
                      <button class="btn-white btn btn-xs" onClick="location.href='payment_voucher_form?action=view&documentID=<?php echo $r['documentID'];?>&sub=account' ">View</button>
               
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
                  <td><strong><?php echo n2($total_vat);?></strong></td>
                  
                  <td class="center">&nbsp;</td>
                </tr>  
                <tr>
                  <td colspan="14"><ul class="pagination float-left">
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