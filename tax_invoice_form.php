<?php
//session_start();
unset( $_SESSION[ 'chargeCode' ] );
require_once( 'class.php' );
require_once( 'function.php' );
$db = new cl;
$acton = get( 'action' );
$documentID = get( 'documentID' );
$documentDate = date( 'd/m/Y' );


$cusCode = '';
$cus_address = '';
$saleman = '';
$creditterm = '';
$note = '';
$documentstatus = 'P';

$checked="";
$createID = '';
$createTime = date( 'd/m/Y' );
$editID = '';
$editTime = date( 'd/m/Y' );

$accountCode='';
$readonly = 'readonly';
$total_amt = 0;
$total_vat = 0;
$tax3 = 0;
$tax1 = 0;
$cus_paid = 0;
$total_netamt = 0;
$remark = '';
$taxID = '';
$readonly = 'readonly';


$dueDate = date('d/m/Y');
$payType = "";
$payTypeOther = "";
$branch = "";
$chequeNo = "";
$dueTime="";

if ( $acton == 'view' ) {
  $disabled = 'disabled';
} else {
  $disabled = '';
}


$sql = "SELECT
i.comCode,
i.documentID,
date_format(i.documentDate,'%d/%m/%Y') as documentDate,
i.cusCode,
i.cus_address,
i.saleman,
i.creditterm,
i.note,
i.remark,
i.documentstatus,
i.createID,
i.createTime,
i.editID,
i.editTime,
i.total_amt,
i.total_vat,
i.tax3,
i.tax1,
i.cus_paid,
i.total_netamt,
c.custNameTH,
c.taxID,
i.accountCode,
i.payType,
i.payTypeOther,
i.branch,
i.chequeNo,
date_format(i.dueDate,'%d/%m/%Y') as dueDate,
i.dueTime

FROM
tax_invoice AS i
INNER JOIN common_customer AS c ON i.comCode = c.comCode AND i.cusCode = c.cusCode
WHERE i.comCode='$db->comCode' AND i.documentID='$documentID' ";
if ( $r = $db->fetch( $sql ) ) {

$accountCode=$r['accountCode'];
  $documentID = $r[ 'documentID' ];
  $documentDate = $r[ 'documentDate' ];
  $cusCode = $r[ 'cusCode' ];
  $cus_address = $r[ 'cus_address' ];
  $saleman = $r[ 'saleman' ];
  $creditterm = $r[ 'creditterm' ];
  $note = $r[ 'note' ];
  $documentstatus = $r[ 'documentstatus' ];
  $createID = $r[ 'createID' ];
  $createTime = $r[ 'createTime' ];
  $editID = $r[ 'editID' ];
  $editTime = $r[ 'editTime' ];
  $readonly = 'readonly';
  $total_amt = $r[ 'total_amt' ];
  $total_vat = $r[ 'total_vat' ];
  $tax3 = $r[ 'tax3' ];
  $tax1 = $r[ 'tax1' ];
  $cus_paid = $r[ 'cus_paid' ];
  $total_netamt = $r[ 'total_netamt' ];
  $remark = $r[ 'remark' ];
  $taxID = $r[ 'taxID' ];
  $readonly = 'readonly';
	
	$payType=$r['payType'];
	$payTypeOther=$r['payTypeOther'];
	$branch=$r['branch'];
	$chequeNo=$r['chequeNo'];
	$dueDate=$r['dueDate'];
	$dueTime=$r['dueTime'];

	
	
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
   $(document).ready(function() {

     $('.select2_single').select2({});

     $("#form").validate({
       rules: {
         supCode: {
           required: true
         },
         payType: {
           required: true
         }


       }
     });



     $("#cusCode").change(function() {



       var jsonObj = {
         cusCode: $("#cusCode").val()
       };

       $.ajax({
         type: "POST",
         url: "load_address_customer.php",
         data: jsonObj,
         success: function(result) {
           var obj = jQuery.parseJSON(result);
           $("#cus_address").val(obj.address);
           $("#taxID").val(obj.taxID);
           //$("#refIV").load(obj.documentID);    
         }
       });


         
  /*       
       $.ajax({
         type: "POST",
         url: "load_invoice.php",
         data: jsonObj,
         success: function(result) {
           // window.prompt('',result);
           /// $("#refIV").
           $('#refIV').find('option').remove().end();
           $("#refIV").append(result);
         }
       });



*/
        $.ajax({
         type: "POST",
         url: "load_invoice.php",
         data: jsonObj,
         success: function(result) {
           // window.prompt('',result);
           /// $("#refIV").
           // $('#refIV').find('option').remove().end();
           $("#table_invoice").append(result);
         
          // call_price();
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
           url: "tax_invoice_action.php",
           data: data,
           processData: false,
           contentType: false,
           cache: false,
           timeout: 600000,
           success: function(data) {

             console.log("Result : ", data);
             //window.prompt('',data);
             var obj = jQuery.parseJSON(data);
             // $("#chargeCode").val(obj.result);
             var dataresult = obj.result;
             if (dataresult == 'success') {
               $("#documentIDx").val(obj.documentID);
               $("#action").val('edit');
               msgSuccess();
             } else {
               msgError();
             }
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

     if($("#documentIDx")==''){
         
      return;   
     }     
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
           url: "tax_invoice_action.php",
           data: data,
           processData: false,
           contentType: false,
           cache: false,
           timeout: 600000,
           success: function(data) {

             console.log("Result : ", data);
             //window.prompt('',data);
             var obj = jQuery.parseJSON(data);
             // $("#chargeCode").val(obj.result);
             var dataresult = obj.result;
             if (dataresult == 'success') {
               $("#documentIDx").val(obj.documentID);
               $("#action").val('edit');
               msgSuccess();
             } else {
               msgError();
             }
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

     var rowIdx = 1;
     $("#addCharge").click(function(event) {


         
          if ($('#form').valid()) {
             //$("#action").val('approve');
         var form = $('#form')[0];
         var data = new FormData(form);
         data.append("CustomField", "This is some extra data, testing");
         // disabled the submit button
        // $("#save").prop("disabled", true);
         $.ajax({
           type: "POST",
           enctype: 'multipart/form-data',
           url: "load_invoiceitems.php",
           data: data,
           processData: false,
           contentType: false,
           cache: false,
           timeout: 600000,
           success: function(data) {

             console.log("Result : ", data);
               $("#table_charge").empty();
             //window.prompt('',data);
            // var obj = jQuery.parseJSON(data);
             // $("#chargeCode").val(obj.result);
           //  var dataresult = obj.result;
              $("#table_charge").append(data);

                call_price();
        
           },
           error: function(e) {
             console.log("ERROR : ", e);
           }
         });


       }
         
/*
       var jsonObj = {
         documentID: $("chk_items").val()
       };
*/
/*
       $.ajax({
         type: "POST",
         url: "load_invoiceitems.php",
         data: data,
         success: function(result) {
             console.log(result);
           // window.prompt('',result);
           /// $("#refIV").
           // $('#refIV').find('option').remove().end();
           $("#table_charge").append(result);

           call_price();
         }
       });

*/


       /*       
      
      $("#table_charge").append(" <tr class='gradeX' id='tr" + rowIdx + "'> " +
" <td><input type='text' name='invNo[]'  class='form-control' value='' id='invNo" + rowIdx + "'><input type='hidden' name='chargeitems[]'  value='" + $("#chargeCode").val() + "' id='chargeitems" + rowIdx + "'></td> " +

" <td><input type='text' name='chargesDetail[]' class='form-control' value='" + $("#chargeCode option:selected" ).text()+ "' id='chargesDetail" + rowIdx + "'></td>  " +                           
" <td class='center'><input type='number' name='amount[]'  onkeyup='call_price()'  class='form-control' value='0' id='amount" + rowIdx + "'></td>  " +
" <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(" + rowIdx + ")'>Remove</button></td>  " +
" </tr>");
        
        */

       //   $('#containner' + rowIdx).load('voucher_loadaccount.php');




       // $('.select2_single').select2({});

       rowIdx++;
       //$('.select2_single').select2({});



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
     call_price();
   }


   function call_price() {

     event.preventDefault();
     var form = $('#form')[0];
     var data = new FormData(form);
     $.ajax({
       type: "POST",
       enctype: 'multipart/form-data',
       url: "tax_invoice_cal.php",
       data: data,
       processData: false,
       contentType: false,
       cache: false,
       timeout: 600000,
       success: function(result) {
         console.log("Resut : ", result);
         // window.prompt("",result);

         var obj = jQuery.parseJSON(result);


         $("#total").text(obj.grand_total);
         $("#tax").text(obj.vat7);
         $("#grand_total").text(obj.grand_total);
         $("#wh_tax1").text(obj.wh_tax1);
         $("#wh_tax3").text(obj.wh_tax3);
         $("#net_pad").text(obj.net_pad);
		  
         $("#cus_paid").text(obj.total_cus_paid);
		     $("#cus_paid2").val(obj.total_cus_paid);  
		   
		   
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

     var vardocumentID = $("#documentIDx").val();
     if (vardocumentID == '') return false;
     var win = window.open('print/' + url + '.php?documentID=' + vardocumentID, '_blank');
     win.focus();
   }
 </script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-6">
    <h2>Tax Invoice / ใบกำกับภาษี</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Account</a></li>
      <li class="breadcrumb-item">Tax Invoice</li>
      <li class="breadcrumb-item"> <a>Tax Invoice Form</a></li>
    </ol>
  </div>
</div>
<form name="form" id="form" enctype="multipart/form-data" method="post">
  <div class="wrapper wrapper-content animated fadeInRight"> 
    <!-- Body-->
    
    <div class="row">
      <div class="col-lg-6" style="margin-bottom: 1px; ">
        <div class="ibox ">
          <div class="ibox-title">
            <h2>Document</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label"><span class="col-form-label" style="padding-top: 5px;">Document</span> No.</label>
              <div class="col-md-4">
                <input type="text" name="documentIDx" id="documentIDx" class="form-control" value="<?php echo $documentID; ?>" >
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Document Date</label>
              </div>
              <div class="col-md-3">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" name="documentDate" class="form-control" value="<?php echo $documentDate; ?>">
                </div>
              </div>
            </div>
			  
		     <div class="form-group row">
              <label class="col-lg-2 col-form-label"><span class="col-form-label" style="padding-top: 5px;">Customer</span></label>
              <div class="col-md-9">
                <select name="cusCode" class="select2_single form-control select2" id="cusCode">
                  <?php $db->s_customer("$cusCode"); ?>
                </select>
              </div>
            </div>
			  
			  
	   <div class="form-group row">
              <label class="col-lg-2 col-form-label"><span class="col-form-label" style="padding-top: 5px;">Tax</span></label>
              <div class="col-md-9">
                <input type="text" name="taxID" class="form-control"  id="taxID" value="<?php echo $taxID; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label"><span class="col-form-label" style="padding-top: 5px;">Address</span></label>
              <div class="col-md-9">
                <textarea rows="2" id="cus_address" name="cus_address" class="form-control"><?php echo $cus_address; ?></textarea>
              </div>
            </div>		  
			  
			  
			  
			  
            <div class="form-group row">
              <label class="col-lg-2 col-form-label"><span class="col-form-label" style="padding-top: 5px;">Note</span></label>
              <div class="col-md-9">
                <textarea rows="2" id="note" name="note" class="form-control"><?php //echo $cus_address; 
                ?>
</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="ibox ">
          <div class="ibox-title">
            <h2>Payment</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content">
       
         
			
            <div class="form-group row">
              <label class="col-lg-3 col-form-label"><span class="col-form-label" style="padding-top: 5px;">ชื่อบัญชี</span></label>
              <div class="col-md-9">
                <select name="accountCode" id="accountCode" class="select2_single form-control select2" style="width: 100%">
                  <?php $db->s_account($accountCode); ?>
                </select>

              </div>


            </div>



            <div class="form-group  row">
              <label class="col-sm-3 col-form-label">โดย By</label>
              <div class="col-md-9">
                <div class="i-checks">
                  <label> <input type="radio" id="chsh" value="c" name="payType" <?php if ($payType == 'c') {
                                                                                    echo 'checked';
                                                                                  } ?>> <i></i>เงินสด Cash </label>
                  <label> <input type="radio" id="bank" value="b" name="payType" <?php if ($payType == 'b') {
                                                                                    echo 'checked';
                                                                                  } ?>> <i></i>เช็คธนาคาร สาขา</label>

                </div>
                <div class="i-checks">
                  <input type="radio" id="other" value="o" name="payType" <?php if ($payType == 'o') {
                                                                            echo 'checked';
                                                                          } ?>> <i></i>อื่นๆ Other
                  <input type="text" name="payTypeOther" id="payTypeOther" class="form-control col-sm-6" value="<?php echo $payTypeOther; ?>">

                </div>

              </div>
            </div>


            <div class="form-group  row">
              <label class="col-sm-3 col-form-label">ธนาคาร สาขา</label>
              <div class="col-md-3">
                <input type="text" name="branch" id="branch" class="form-control" value="<?php echo $branch; ?>">
              </div>    
              <label class="col-sm-2 col-form-label">เลขที่เช็ค</label>
              <div class="col-md-3">
                <input type="text" name="chequeNo" id="chequeNo" class="form-control" value="<?php echo $chequeNo; ?>">
              </div>    
            </div>
              
              
              
              
            <div class="form-group  row">
           

              <div class="col-md-3">
                <label class="col-form-label" style="padding-top: 5px;"> Date</label>
              </div>
              <div class="col-md-3">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" name="dueDate" class="form-control" value="<?php echo $dueDate; ?>">
                </div>
              </div>
                
                         <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;"> ยอดรวม</label>
              </div>
              <div class="col-md-3">
                  <input type="text" name="dueTime" class="form-control" value="<?php echo $dueTime; ?>">
                </div>
              </div>    
			  
			  
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="ibox ">
          <div class="ibox-title">
            <h2> Invoice Ref.</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content">
            <div class="form-group">
              <div class="table-responsive" id="containner_invoice">
                <table class="table" width="100%" id="table_invoice">
                  <thead>
                    <tr>
                      <th style="width:10%">No.</th>
                      <th style="width:10%">invNo.</th>
                      <th style="width:10%">documentDate</th>
                      <th style="width:10%">Job Ref</th>
                      <th style="width:10%">Select</th>
                      <!-- <th style="width:5%">Action</th> --> 
                    </tr>
                  </thead>
                  <tbody>
					  
                    <?php
					  /*
                    $sql = "
SELECT
t.items,
t.comCode,
t.invNo,
t.documentID,
t.chargeCode,
t.detail,
t.chargesCost,
t.chargesReceive,
t.chargesbillReceive
FROM
invoice AS t
WHERE t.comCode='$db->comCode' AND t.documentID='$documentID' ";
                    $result = $db->query( $sql );
                    $i = 1;
                    $total_cost = 0;
                    $total_receive = 0;
                    $total_Bill_of_receipt = 0;
                    $rowIdx = 99;
                    while ( $r = mysqli_fetch_array( $result ) ) {
                      $total_cost += $r[ 'chargesCost' ];
                      $total_receive += $r[ 'chargesReceive' ];
                      $total_Bill_of_receipt += $r[ 'chargesbillReceive' ];
                      ?>
                    <tr class='gradeX' id='tr<?php echo $rowIdx; ?>'>
                      <td>&nbsp;</td>
                      <td><input type='hidden' name='chargeitems[]' value='<?php echo $r['chargeCode']; ?>' id='chargeitems<?php echo $rowIdx; ?>'></td>
                      <td>&nbsp;</td>
                      <td class='center'>&nbsp;</td>
                      <td align="center"><div class="custom-control custom-checkbox">
                          <input type="checkbox" value="<?php echo $r['items']; ?>" <?php echo $checked; ?> name="chk_items[]" class="custom-control-input" id="<?php echo $r['items']; ?>">
                          <label class="custom-control-label" for="<?php echo $r['items']; ?>"></label>
                        </div></td>
                      <!--
                           <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(<?php echo $rowIdx; ?>)'>Remove</button></td> --> 
                      
                    </tr>
                    <?php
                    $i++;
						
                    }

*/
                    ?>
                  </tbody>
               
                </table>
              </div>
 
            </div><div class="form-group  row">
                  <div class="col-md-2" style="padding-left: 0px;">
                    <button class="btn btn-white " type="button" name="addCharge" id="addCharge"><i class="fa fa-plus"></i> Add</button>
                  </div>
                </div>
          </div> 
                
            
        </div>
      </div>
      <div class="col-lg-12">
        <div class="ibox ">
          <div class="ibox-content">
            <div class="form-group">
              <div class="table-responsive" id="containner_charge">
                <table class="table" width="100%" id="table_charge">
                  <thead>
                    <tr>
                      <th style="width:10%">invNo.</th>
                      <th style="width:50%">Detail</th>
                      <th style="width:10%">Cost</th>
                      <th style="width:10%">Receive</th>
                      <th style="width:10%">Bill of receipt</th>
                      <!-- <th style="width:5%">Action</th> --> 
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "
SELECT
t.items,
t.comCode,
t.invNo,
t.documentID,
t.chargeCode,
t.detail,
t.chargesCost,
t.chargesReceive,
t.chargesbillReceive
FROM
tax_invoice_items AS t
WHERE t.comCode='$db->comCode' AND t.documentID='$documentID' ";
                    $result = $db->query( $sql );
                    $i = 1;
                    $total_cost = 0;
                    $total_receive = 0;
                    $total_Bill_of_receipt = 0;
                    $rowIdx = 99;
                    while ( $r = mysqli_fetch_array( $result ) ) {
                      $total_cost += $r[ 'chargesCost' ];
                      $total_receive += $r[ 'chargesReceive' ];
                      $total_Bill_of_receipt += $r[ 'chargesbillReceive' ];
                      ?>
                    <tr class='gradeX' id='tr<?php echo $rowIdx; ?>'>
                      <td><input type='text' readonly name='invNo[]' class='form-control' value='<?php echo $r['invNo']; ?>' id='invNo<?php echo $key_row; ?>'>
                        <input type='hidden' name='chargeitems[]' value='<?php echo $r['chargeCode']; ?>' id='chargeitems<?php echo $rowIdx; ?>'></td>
                      <td><input type='text' name='chargesDetail[]' class='form-control' value='<?php echo $r['detail']; ?>' id='chargesDetail<?php echo $rowIdx; ?>'></td>
                      <td class='center'><input type='number' name='paid[]' onkeyup='call_price()' class='form-control' value='<?php echo $r['chargesCost']; ?>' id='paid<?php echo $rowIdx; ?>'></td>
                      <td class='center'><input type='number' name='receive[]' onkeyup='call_price()' class='form-control' value='<?php echo $r['chargesReceive']; ?>' id='receive<?php echo $rowIdx; ?>'></td>
                      <td class='center'><input type='number' name='chargesPrice[]' onkeyup='call_price()' class='form-control' value='<?php echo $r['chargesbillReceive']; ?>' id='chargesPrice<?php echo $rowIdx; ?>'></td>
                      <!--
                           <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(<?php echo $rowIdx; ?>)'>Remove</button></td> --> 
                      
                    </tr>
                    <?php
                    $i++;
                    }


                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td style="width:5%"></td>
                      <td style="width:50%"></td>
                      <td style="width:10%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;<span id="total_cost"><?php echo $total_cost; ?></span></td>
                      <td style="width:5%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;<span id="total_receive"><?php echo $total_receive; ?></span></td>
                      <td style="width:5%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;<span id="total_Bill_of_receipt"><?php echo $total_Bill_of_receipt; ?></span></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="form-group row">
                <label class="col-lg-6 col-form-label"> remark
                  <textarea rows="8" name="remark" class="form-control"><?php echo nl2br($remark); ?></textarea>
                </label>
                <div class="col-lg-6">
                  <table class="table invoice-total">
                    <tbody>
                      <tr>
                        <td><strong>Vat 7% :</strong></td>
                        <td><span id="tax"><?php echo $total_vat; ?></span></td>
                      </tr>
                      <tr>
                        <td><strong>TOTAL :</strong></td>
                        <td><span id="total"><?php echo $total_amt; ?></span></td>
                      </tr>
                      <tr>
                        <td><strong>WH TAX 3% :</strong></td>
                        <td><span id="wh_tax3"><?php echo n2($tax3); ?></span></td>
                      </tr>
                      <tr>
                        <td><strong>WH TAX 1% :</strong></td>
                        <td><span id="wh_tax1"><?php echo n2($tax1); ?></span></td>
                      </tr>
                      <tr>
                        <td><strong>ลูกค้าสำรองจ่าย :</strong></td>
                        <td><span id="cus_paid"><?php echo n2($cus_paid); ?></span><input  name="cus_paid2" id="cus_paid2"   type="hidden" value="<?php echo ($cus_paid); ?>"> </td>
                      </tr>
                      <tr>
                        <td><strong>NET PAD:</strong></td>
                        <td><span id="net_pad"><?php echo n2($total_netamt); ?></span></td>
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
                <label><?php echo $createID; ?>&nbsp;&nbsp;&nbsp;<?php echo $createTime; ?></label>
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Update By</label>
              <div class="col-sm-10">
                <label><?php echo $editID; ?>&nbsp;&nbsp;&nbsp;<?php echo $editTime; ?></label>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group row">
              <div class="col-sm-10 col-sm-offset-2">
                <button name="back" class="btn btn-white" type="button" onclick="window.location='tax_invoice'"><i class="fa fa-reply"></i> Back</button>
                <?php
                if ( $documentstatus != 'A'  || $_SESSION['userTypecode']=='1' ) {
				    if ( $documentstatus != 'A' ){
				  ?>
                <button name="save" id="save" class="btn btn-primary" type="button" <?php echo $disabled; ?>><i class="fa fa-save"></i> Save</button>
                <?php } if($acton!='add'){
				  if($_SESSION['userTypecode']=='1'){
				  ?>
                <button name="approve" id="approve" class="btn btn-success " type="button" <?php echo $disabled; ?>><i class="fa fa-check"></i> Approve</button>
                <?php }}} ?>
 
                <button class="btn btn-white " type="button" onclick="openInNewTab('<?php echo 'tax_invoice_pdf'; ?>');"><i class="fa fa-print"></i> Print</button>
                <input type="hidden" name="action" id="action" value="<?php echo $acton; ?>">
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
