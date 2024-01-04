<?php
//session_start();
unset($_SESSION['chargeCode']);
require_once('class.php');
require_once('function.php');
$db = new cl;
$acton = get('action');
$documentID = get('documentID');
$documentDate = date('d/m/Y');
$on_board = date('d/m/Y');


$cusCode="";
$cus_address="";
$carrier="";
$creditterm="";
$your_RefNo="";
$bound="";
$commodity="";
$freight="";
$qty_measurement="";
$bl_No="";
$ref_jobNo="";
$origin_desc="";
$note="";
$documentstatus="";
 
$total_amt=0;
$total_vat=0;
$tax3=0;
$tax1=0;
$cus_paid=0;
$total_netamt=0;
$remark='';

if ($acton == 'view') {
  $disabled = 'disabled';
} else {
  $disabled = '';
}


if($acton=="add"){
  $ref_jobID=get('jobID');
  $cusCode=get('cusCode');
     $disabled = '';
}elseif ($acton == 'view'){
  $disabled = 'disabled';  
}else{
     $disabled = '';
}


$sql="SELECT
i.comCode,
i.documentID,
date_format(i.documentDate,'%d/%m/%Y') as documentDate,
i.cusCode,
i.cus_address,
i.carrier,
i.saleman,
i.creditterm,
i.your_RefNo,
i.bound,
i.commodity,
date_format(i.on_board,'%d/%m/%Y') as on_board,
i.freight,
i.qty_measurement,
i.bl_No,
i.ref_jobNo,
i.origin_desc,
i.note,
i.documentstatus,
i.createID,
i.createTime,
i.editID,
i.editTime,
i.total_amt,
i.total_vat,
i.tax3,
i.tax1,
i.remark,
i.cus_paid,
i.total_netamt
FROM $db->dbname.invoice AS i
WHERE i.comCode='$db->comCode' AND i.documentID='$documentID' ";
if($r=$db->fetch($sql)){

$documentID=$r['documentID'];
$documentDate=$r['documentDate'];
$cusCode=$r['cusCode'];
$cus_address=$r['cus_address'];
$carrier=$r['carrier'];
$saleman=$r['saleman'];
$creditterm=$r['creditterm'];
$your_RefNo=$r['your_RefNo'];
$bound=$r['bound'];
$commodity=$r['commodity'];
$on_board=$r['on_board'];
$freight=$r['freight'];
$qty_measurement=$r['qty_measurement'];
$bl_No=$r['bl_No'];
$ref_jobNo=$r['ref_jobNo'];
$origin_desc=$r['origin_desc'];
$note=$r['note'];
$documentstatus=$r['documentstatus'];
$createID=$r['createID'];
$createTime=$r['createTime'];
$editID=$r['editID'];
$editTime=$r['editTime'];
$readonly='readonly';	   
$total_amt=$r['total_amt'];
$total_vat=$r['total_vat'];
$tax3=$r['tax3'];
$tax1=$r['tax1'];
$cus_paid=$r['cus_paid'];
$total_netamt=$r['total_netamt'];
$remark=$r['remark'];
}


?>

<!-- Jasny -->
<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>

<link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">

<!-- Data picker --> 
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

<!-- Clock picker --> 
<script src="js/plugins/clockpicker/clockpicker.js"></script>
<link href="css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
<script>
$(document).ready(function () {
	
	$('.select2_single').select2({
    });
    
    $("#form").validate({
                 rules: {
                  cusCode: {required: true }
                  
                 }
     });

    
    
       $("#cusCode").change(function() {
  
  
    		
  					var jsonObj={
						cusCode: $("#cusCode").val()
					}; 
					
					$.ajax({
					   	type: "POST",
					   	url: "load_address_customer.php",
					   	data: jsonObj,
					   	success: function(result) {
					 var obj = jQuery.parseJSON(result);

                        $("#cus_address").val(obj.address);   
                            
                            
					   }
                        
                        
                        
					 });
           
           
        
    });
    
    
    $("#save").click(function(event) {
  
      event.preventDefault();
      if ($('#form').valid()) {
        var form = $('#form')[0];
        var data = new FormData(form);
        data.append("CustomField", "This is some extra data, testing");
        // disabled the submit button
        $("#save").prop("disabled", true);
        $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "invoice_action.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(data) {

    console.log("SUCCESS : ", data);
            //window.prompt('',data);
            var obj = jQuery.parseJSON(data);
            // $("#chargeCode").val(obj.result);
            var dataresult = obj.result;
            if (dataresult == 'success') {
              $("#documentID").val(obj.documentID);
              $("#action").val('edit');
              console.log("SUCCESS : ", data);
              msgSuccess();
            } else {
              msgError();
            }
            console.log("SUCCESS : ", dataresult);
            $("#save").prop("disabled", false);


          },
          error: function(e) {
            msgError();
            console.log("ERROR : ", e);
            $("#save").prop("disabled", false);

          }



        });


      }

    });
   
	
    $("#approve").click(function(event) {
      event.preventDefault();
      if ($('#form').valid()) {
        $("#action").val('approve');
        var form = $('#form')[0];
        var data = new FormData(form);
        data.append("CustomField", "This is some extra data, testing");
        // disabled the submit button
        $("#save").prop("disabled", true);
        $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
         url: "invoice_action.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(data) {

            var obj = jQuery.parseJSON(data);
            // $("#chargeCode").val(obj.result);
            var dataresult = obj.result;
            if (dataresult == 'success') {
              $("#documentID").val(obj.documentID);
              $("#action").val('approve');
              msgSuccess();
            $("#save,#approve").prop("disabled", true);

            } else {
              msgError();
            }
            console.log("SUCCESS : ", dataresult);
         


          },
          error: function(e) {
            msgError();
            console.log("ERROR : ", e);
            $("#save").prop("disabled", false);

          }



        });


      }

    });		
    
    var rowIdx = 1;
    $("#addCharge").click(function(event) {


      
      $("#table_charge").append(" <tr class='gradeX' id='tr" + rowIdx + "'> " +
        " <td>" + rowIdx + "<input type='hidden' name='chargeitems[]'  value='" + $("#chargeCode").val() + "' id='chargeitems" + rowIdx + "'></td> " +
        " <td><input type='text' name='chargesDetail[]' class='form-control' value='" + $("#chargeCode option:selected" ).text()+ "' id='chargesDetail" + rowIdx + "'></td>  " +

" <td class='center'><input type='number' name='paid[]'  onkeyup='call_price()'  class='form-control' value='0' id='paid" + rowIdx + "'></td>  " +       " <td class='center'><input type='number' name='receive[]'  onkeyup='call_price()'  class='form-control' value='0' id='receive" + rowIdx + "'></td>  " +
" <td class='center'><input type='number' name='chargesPrice[]'  onkeyup='call_price()'  class='form-control' value='0' id='chargesPrice" + rowIdx + "'></td>  " +
                                
                                
        " <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(" + rowIdx + ")'>Remove</button></td>  " +
        " </tr>");
        
        
        
      $('#containner' + rowIdx).load('job_form_loadcharge.php');
        
        
        
        
      $('.select2_single').select2({});

      rowIdx++;
      $('.select2_single').select2({});
        
        
     
    });    
    
    
    
     $("#btn_cal").click(function(event) {
         
         call_price();

         
    });
    
	
    $('.input-group.date').datepicker({
      todayBtn: "linked",
      keyboardNavigation: false,
      forceParse: false,
      calendarWeeks: true,
      autoclose: true

    });	
     
    
});
	
  function FN_Remove_Table(rowID) {
    $("#tr" + rowID).remove();
  }
    
    
  function call_price(){
  
      
      event.preventDefault();
        var form = $('#form')[0];
        var data = new FormData(form);
        $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "invoice_cal.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(result) {
              
              console.log("ERROR : ", result);
       // window.prompt("",result);
              
            var obj = jQuery.parseJSON(result);

        
               $("#total").text(obj.total);
               $("#tax").text(obj.vat7);
               $("#grand_total").text(obj.grand_total);
              $("#wh_tax1").text(obj.wh_tax1);
              $("#wh_tax3").text(obj.wh_tax3);
               $("#net_pad").text(obj.net_pad);
              
 $("#total_cost").text(obj.total_cost);
  $("#total_receive").text(obj.total_receive);             
  $("#total_Bill_of_receipt").text(obj.total_Bill_of_receipt); 
     
          },
          error: function(e) {
            console.log("ERROR : ", e);

          }



        });
      
      
      
  }  
    
    
function openInNewTab(url) {

var vardocumentID=$("#documentID").val();
    if(vardocumentID=='')return false;
//var win = window.open('print/'+url+.php?documentID?documentID='+documentID, '_blank');
var win = window.open('print/'+url+'.php?documentID='+vardocumentID, '_blank');
win.focus();
}
    
    
    
</script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-6">
    <h2>Invoice / ใบแจ้งหนี้</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Account</a></li>
      <li class="breadcrumb-item"> <a>Invoice</a> </li>
      <li class="breadcrumb-item"> <a>Invoice Form</a></li>
    </ol>
  </div>
</div>
   <form  name="form" id="form"  enctype="multipart/form-data" method="post">
<div class="wrapper wrapper-content animated fadeInRight">
<!-- Body-->

<div class="row">
  <div class="col-lg-7">
    <div class="ibox ">
      <div class="ibox-title">
        <h2>Document</h2>
        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
      </div>
      <div class="ibox-content">
        <div class="form-group row">
          <label class="col-lg-2 col-form-label"><span class="col-form-label" style="padding-top: 5px;">Document</span> No.</label>
     <div class="col-md-4">
           <input type="text" name="documentID" id="documentID" class="form-control"  value="<?php echo $documentID; ?>"  readonly>
          </div>
          <div class="col-md-2">
            <label class="col-form-label" style="padding-top: 5px;">Document Date</label>
          </div>
   <div class="col-md-4">
       <div class="input-group date">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="documentDate" class="form-control" value="<?php echo $documentDate; ?>">
                </div>
          </div>
        </div>
        <div class="form-group  row">
          <label class="col-sm-2 col-form-label">Credit Term</label>
          <div class="col-md-4">
                <select name="creditTerm" class="select2_single form-control select2" id="creditTerm">
                  <?php $db->s_credit_term($creditterm); ?>
                </select>
          </div>
          <div class="col-md-2">
            <label class="col-form-label" style="padding-top: 5px;">Your Ref.No</label>
          </div>
          <div class="col-md-4">
            <input type="text" name="your_RefNo" class="form-control" value="<?php echo $your_RefNo;?>">
          </div>
        </div>
        <div class="form-group  row">
          <label  class="col-sm-2 col-form-label">Bound</label>
          <div class="col-md-4">
            <select class="select2_single form-control select2" name="bound">
               <option value="1" <?php if($bound=='1'){echo'selected';} ?>  >IN BOUND</option>
                  <option value="2" <?php if($bound=='2'){echo'selected';} ?>  >OUT BOUND</option>>
            </select>
          </div>
          <div class="col-md-2">
            <label class="col-form-label" style="padding-top: 5px;">Commodity </label>
          </div>
          <div class="col-md-4">
            <input type="text" name="commodity" class="form-control" value="<?php echo $commodity;?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-form-label">On Board</label>
<div class="col-md-4">
       <div class="input-group date">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="on_board" class="form-control" value="<?php echo $on_board; ?>">
                </div>
          </div>
          <div class="col-md-2">
            <label class="col-form-label"  style="padding-top: 5px;">Freight</label>
          </div>
          <div class="col-md-4">
            <select name="freight" class="select2_single form-control select2" id="freight">
                  <?php $db->s_freight($freight); ?>
                </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-form-label">Qty. / Measurement</label>
          <div class="col-md-4">
            <input type="text" name="qty_measurement" class="form-control" value="<?php echo $qty_measurement; ?>">
          </div>
          <div class="col-md-2">
            <label class="col-form-label"style="padding-top: 5px;">B/L No</label>
          </div>
          <div class="col-md-4">
            <input type="text" name="bl_No" class="form-control" value="<?php echo $bl_No; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-form-label">Ref. JOB NO</label>
          <div class="col-md-4">
            <select class="select2_single form-control select2" name="ref_jobID" id="ref_jobID">
           <?php $db->s_jobref($ref_jobNo);?>
            </select>
          </div>
          <label class="col-lg-2 col-form-label">Origin / Destination</label>
          <div class="col-md-4">
            <input type="text" name="origin_desc" class="form-control" value="<?php echo $origin_desc; ?>">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="ibox ">
      <div class="ibox-title">
        <h2>Sale / Customer / Carrier</h2>
        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
      </div>
      <div class="ibox-content">
        <div class="form-group  row">
          <label class="col-sm-2 col-form-label">Sales</label>
          <div class="col-md-4">
            <select name="saleman" class="select2_single form-control select2" id="saleman">
                  <?php $db->s_saleman($_SESSION['userID']); ?>
                </select>
          </div>
        </div>
        <div class="form-group  row">
          <label class="col-sm-2 col-form-label">Customer</label>
          <div class="col-md-10">
        <select name="cusCode" class="select2_single form-control select2" id="cusCode">
                  <?php $db->s_customer("$cusCode"); ?>
                </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-form-label">Address</label>
          <div class="col-md-10">
            <textarea  class="form-control" name="cus_address" id="cus_address"><?php echo ($cus_address);?></textarea>
          </div>
        </div>
        <div class="form-group  row">
          <label class="col-sm-2 col-form-label">Carrier</label>
          <div class="col-md-10">
    <select name="carrier" class="select2_single form-control select2" id="carrier">
                  <?php $db->s_supplier($carrier); ?>
                </select>
          </div>
        </div>
        <div class="form-group row" style="margin-bottom: 29px;">
          <label class="col-lg-2 col-form-label">Note</label>
          <div class="col-md-10">
            <textarea name="note" class="form-control"><?php echo ($note);?></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
	<div class="col-lg-12">
    <div class="ibox ">
      <div class="ibox-title">
        <h2>Detail</h2>
		  
		  
        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
		  <!--
		  <div class="form-group  row">
		  <div class="col-md-6">
		<select class="select2_single form-control select2" style="width: 100%;" id="chargeCode"><?php $db->s_charge(''); ?></select>
		  </div>
		   
		  <div class="col-md-2" style="padding-left: 0px;">
			   <button class="btn btn-white " type="button" name="addCharge" id="addCharge"><i class="fa fa-plus"></i> Add</button>
		  </div>
		  </div>
		  
		  -->
		  
		  
		  
		  
		  
		  
      </div>
      <div class="ibox-content">
        <div class="form-group">
          
			          <div class="table-responsive" id="containner_charge">
                <table class="table" width="100%" id="table_charge">
                  <thead>
                    <tr>
                      <th style="width:5%">No.</th>
                      <th style="width:50%">Detail</th>
                      <th style="width:10%">Cost</th>
                      <th style="width:10%">Receive</th>
                      <th style="width:10%">Bill of receipt</th>
                     
                    </tr>
                  </thead>
                  <tbody> <?php
$sql="
SELECT
t.items,
t.comCode,
t.documentID,
t.ref_paymentCode,
t.chargeCode,
t.detail,
t.chargesCost,
t.chargesReceive,
t.chargesbillReceive
FROM
joborder_charge AS t
WHERE t.comCode='$db->comCode' AND t.documentID='$ref_jobNo' ";
$result=$db->query($sql);
$i=1;
$total_cost=0;
$total_receive=0;
$total_Bill_of_receipt=0;
$rowIdx=99;
while($r=mysqli_fetch_array($result)){
$total_cost+=$r['chargesCost'];
$total_receive+=$r['chargesReceive'];
$total_Bill_of_receipt+=$r['chargesbillReceive'];
?>                     
<tr class='gradeX' id='tr<?php echo $rowIdx;?>'> 
         <td><?php echo $i;?><input type='hidden' name='chargeitems[]'  value='<?php echo $r['chargeCode'];?>' id='chargeitems<?php echo $rowIdx;?>'></td>
         <td><?php echo $r['detail'];?></td>  
		 <td class='center'><?php echo $r['chargesCost'];?></td>
		<td class='center'><?php echo $r['chargesReceive'];?></td>
		<td class='center'><?php echo $r['chargesbillReceive'];?></td>

</tr>
                      
  <?php $i++;
} 
                      

 ?> 
                
                    </tbody>
                  <tfoot>
                         <tr>
                      <td style="width:5%"></td>
                      <td style="width:50%"></td>
                      <td style="width:10%" align="left"><span id="total_cost"><?php echo n2($total_cost);?></span></td>
                      <td style="width:5%" align="left"><span id="total_receive"><?php echo n2($total_receive);?></span></td>
                      <td style="width:5%" align="left"><span id="total_Bill_of_receipt"><?php echo n2($total_Bill_of_receipt);?></span></td>
                             
                             
                    </tr>  
                
                      
                  </tfoot>
                </table>
              </div>
			
     <div class="form-group row">
          <label class="col-lg-6 col-form-label">
		remark
			  
			  <textarea rows="8" name="remark" class="form-control"><?php echo ($remark); ?></textarea></label>
         
         
          <div class="col-lg-6">
             <table class="table invoice-total">
              <tbody>
                      <tr>
                  <td><strong>Vat 7% :</strong></td>
                           
                  <td><span id="tax"><?php echo n2($total_vat);?></span></td>
                </tr>
                <tr>
                  <td><strong>TOTAL :</strong></td>
                  <td><span id="total"><?php echo n2($total_amt);?></span></td>
                </tr>
          
                <tr>
                  <td><strong>WH TAX 3% :</strong></td>
                  <td><span id="wh_tax3"><?php echo n2($tax3);?></span></td>
                </tr>
                <tr>
                  <td><strong>WH TAX 1% :</strong></td>
                  <td><span id="wh_tax1"><?php echo n2($tax1);?></span></td>
                </tr>
                <tr>
                  <td><strong>NET PAD:</strong></td>
                  <td><span id="net_pad"><?php echo n2($total_netamt);?></span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
			
			
             
	
			  
			 
          </div>
        </div>
      </div>
    </div>
	
	
  
	
	
	<div class="col-lg-12">
    <div class="ibox ">
      <div class="ibox-title">
        <h2>Action</h2>
      </div>
      <div class="ibox-content">
     
        <div class="form-group  row">
          <label class="col-sm-2 col-form-label">Create By</label>
          <div class="col-sm-10">
            <label>admin  1/1/2021 : 03:12:20</label>
          </div>
        </div>
        <div class="form-group  row">
          <label class="col-sm-2 col-form-label">Update By</label>
          <div class="col-sm-10">
            <label>admin  1/1/2021 : 03:12:20</label>
          </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group row">
          <div class="col-sm-10 col-sm-offset-2">
		
			  
	<!--		  
    <?php
       if($documentstatus!='A'){
       ?>
                <button name="save" id="save" class="btn btn-primary" type="button" <?php echo $disabled; ?>><i class="fa fa-save"></i> Save</button>
       <?php }        
    if($_SESSION['userTypecode']==1){          
        ?>       
             <button name="approve" id="approve" class="btn btn-success " type="button"><i class="fa fa-check"></i> Approve</button>
       <?php 
    }        
                 
        ?>    
			  
			  
	-->		  
              
    <button class="btn btn-white " type="button" onclick="openInNewTab('<?php echo 'invoice_pdf';?>');"  ><i class="fa fa-print"></i> Print</button>
              
              
	  <input type="hidden" name="action" id="action" value="<?php echo $acton;?>">
		
		
		
		
		</div>
        </div>
      </div>
    </div>
  </div>
	
  </div>
  <br>
</div>
</form>
       <!--  END Body-->