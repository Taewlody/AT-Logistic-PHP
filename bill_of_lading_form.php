<?php
//session_start();
unset($_SESSION['chargeCode']);
require_once('class.php');
require_once('function.php');
$db = new cl;
$acton = get('action');

if($acton=="add"){
  $ref_jobID=get('jobID');
  $cusCode=get('cusCode');
}

$documentID = get('documentID');
$documentDate = date('d/m/Y');

$documentstatus='';
$shipperCode='';
$consigneeCode='';
$cusContact='';
$agentCode='';
$notify_party='';
$cargo_deliverry='';
$marks_number='';
$freight_detail='';
$prepaid='';
$collerct='';
$createID = '';
$createTime ='';
$editID = '';
$editTime = '';




if ($acton == 'view') {
  $disabled = 'disabled';
} else {
  $disabled = '';
}
/*
$sql = " SELECT * FROM $db->dbname.joborder AS c WHERE c.comCode='$db->comCode' AND c.documentID='$documentID' ";
if ($r = $db->fetch($sql)) {
  $documentID = $r['documentID'];
}

*/
if($acton=='view'){ $disabled='disabled';}else{$disabled='';}

if($documentID!=""){
$sql="SELECT
t.comCode,
t.documentID,
date_format(t.documentDate,'%d/%m/%Y') as documentDate,
t.ref_jobID,
t.cusCode,
t.shipperCode,
t.consigneeCode,
t.notify_party,
t.cargo_deliverry,
t.marks_number,
t.freight_detail,
t.prepaid,
t.collerct,
t.documentstatus,
t.createID,
date_format(t.createTime,'%d/%m/%Y') as createTime,
t.editID,
date_format(t.editTime,'%d/%m/%Y') as editTime
FROM $db->dbname.bill_of_lading AS t
WHERE t.comCode='$db->comCode' AND t.documentID='$documentID' ";
if($r=$db->fetch($sql)){
    $documentID=$r['documentID'];
    $documentDate=$r['documentDate'];
    $ref_jobID=$r['ref_jobID'];
    $cusCode=$r['cusCode'];
    $shipperCode=$r['shipperCode'];
    $consigneeCode=$r['consigneeCode'];
    $notify_party=$r['notify_party'];
    $cargo_deliverry=$r['cargo_deliverry'];
    $marks_number=$r['marks_number'];
    $freight_detail=$r['freight_detail'];
    $prepaid=$r['prepaid'];
    $collerct=$r['collerct'];
    $documentstatus=$r['documentstatus'];
    $createID=$r['createID'];
    $createTime=$r['createTime'];
    $editID=$r['editID'];
    $editTime=$r['editTime'];
}
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
	
	$('.select2_single').select2({});
  $("#form").validate({
                 rules: {
               
                  cusCode: {required: true },
                  ref_jobID: {required: true },
                  shipperCode: {required: true },
                  consigneeCode: {required: true }
                 }
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
          url: "bill_of_landing_action.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(data) {


            //window.prompt('',data);
            var obj = jQuery.parseJSON(data);
            // $("#chargeCode").val(obj.result);
            var dataresult = obj.result;
            if (dataresult == 'success') {
              $("#documentID").val(obj.documentID);
              $("#action").val('edit');
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
          url: "bill_of_landing_action.php",
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

    



	/*
$('.chosen-select').select2({
	    allowClear: true,
       placeholder: 'This is my placeholder',    
         language: {
             noResults: function() {
            return `<button style="width: 100%" type="button"
            class="btn btn-primary" 
            onClick='task()'>+ Add New Item</button>
            </li>`;
            }
         },
       
        escapeMarkup: function (markup) {
            return markup;
        },
width: "100%"
});
   		*/	
	
	
	
	
    $('.input-group.date').datepicker({
      todayBtn: "linked",
      keyboardNavigation: false,
      forceParse: false,
      calendarWeeks: true,
      autoclose: true

    });		
			
	     // $('.clockpicker').clockpicker();		
			
});
	

    
 function openInNewTab(url) {

var vardocumentID=$("#documentID").val();
    if(vardocumentID=='')return false;
var win = window.open('print/'+url+'.php?documentID='+vardocumentID, '_blank');
win.focus();
}
    
</script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-6">
    <h2>Bill of lading / ใบตราส่งสินค้า </h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Marketing</a></li>
      <li class="breadcrumb-item"> <a>Bill of lading</a> </li>
      <li class="breadcrumb-item"> <a>Bill of lading Form</a></li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<!-- Body-->
<form name="form" id="form"  method="POST" enctype="multipart/form-data">

<input type="hidden" name="jobID" id="jobID" value="<?php echo $jobID;?>">
<div class="row">
  <div class="col-lg-6">
    <div class="ibox ">
      <div class="ibox-title">
        <h2>Document</h2>
        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
      </div>
      <div class="ibox-content">
		  
		  
		  
		  
		 <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Document No.</label>
          <div class="col-md-4">
           <input type="text" name="documentID" id="documentID" class="form-control"  value="<?php echo $documentID; ?>"  readonly>
          </div>
        </div>
		  
		  
   	 <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Document Date</label>
          <div class="col-md-4">
       <div class="input-group date">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="documentDate" class="form-control" value="<?php echo $documentDate; ?>">
                </div>
          </div>
        </div>
		  

		 <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Customer</label>
          <div class="col-md-9">
         <select class="select2_single form-control select2" name="cusCode">
             <?php $db->s_customer($cusCode);?>
            </select>
          </div>
        </div>	  
	
		 <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Shipper</label>
          <div class="col-md-9">
         <select class="select2_single form-control select2" name="shipperCode"  id="shipperCode">
              <?php $db->s_supplier($shipperCode)?>
            </select>
          </div>
        </div>		  
 
		 
		 <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Consignee</label>
          <div class="col-md-9">
         <select class="select2_single form-control select2" name="consigneeCode" id="consigneeCode">
             <?php $db->s_supplier($consigneeCode);?>
            </select>
          </div>
        </div>	 
		  
 		 <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Ref. JobNo.</label>
          <div class="col-md-9">
          <select class="select2_single form-control select2" name="ref_jobID" id="ref_jobID">
           <?php $db->s_jobref($ref_jobID);?>
            </select>
          </div>
        </div>	  
		  <br>
		  
		  
		  
	
     
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="ibox ">
      <div class="ibox-title">
        <h2>Detail</h2>
        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
      </div>
      <div class="ibox-content">
 
        <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Notify Party</label>
          <div class="col-md-9">
            <input type="text" name="notify_party" class="form-control">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Cargo Delivery, Please Contact</label>
          <div class="col-md-9">
        <input type="text" name="cargo_deliverry" class="form-control">
          </div>
        </div>
		  
	     <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Marks Number</label>
          <div class="col-md-9">
            <input type="text" name="marks_number" class="form-control">
          </div>
        </div>
		  
		  
        <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Freight Detal, Charges etc.</label>
          <div class="col-md-9">
           <input type="text" name="freight_detail" class="form-control">
          </div>
        </div>
       <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Prepaid</label>
          <div class="col-md-9">
            <input type="text" name="prepaid" class="form-control">
          </div>
        </div>
		         <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Collect</label>
          <div class="col-md-9">
            <input type="text" name="collerct" class="form-control">
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
                <label><?php echo $createID;?>&nbsp;&nbsp;&nbsp;<?php echo $createTime;?></label>
              </div>
            </div>

            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Update By</label>
              <div class="col-sm-10">
                <label><?php echo $editID ;?>&nbsp;&nbsp;&nbsp;<?php echo $editTime;?></label>
              </div>
            </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group row">

       <div class="col-sm-10 col-sm-offset-2">

       <?php
       if($documentstatus!='A'){
       ?>
                <button name="save" id="save" class="btn btn-primary" type="button" <?php echo $disabled; ?>><i class="fa fa-save"></i> Save</button>
                <button name="approve" id="approve" class="btn btn-success " type="button"><i class="fa fa-check"></i> Approve</button>
        <?php } ?>

  <button class="btn btn-white " type="button" onclick="openInNewTab('<?php echo 'bill_of_lading_pdf';?>');"  ><i class="fa fa-print"></i> Print</button>
                <input type="hidden" name="action" id="action" value="<?php echo $acton; ?>">
        </div>
        </div>
      </div>
    </div>
  </div>
	
  </div>
  <br>


  </form></div>
<!--  END Body-->