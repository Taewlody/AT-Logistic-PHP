<?php
//session_start();
unset($_SESSION['chargeCode']);
require_once('class.php');
require_once('function.php');
$db = new cl;
$acton = get('action');
$documentID = get('documentID');
$documentDate = date('d/m/Y');
$dueDate = date('d/m/Y');

$supCode = "";

$note = "";
$remark = "";
$createID = "";
$createTime = "";
$editID = "";
$editTime = "";
$documentstatus = "P";
$sumTotal = 0;
$tax1=0;
$tax3=0;
$tax7=0;
$grandTotal=0;

if ($acton == 'view') {
  $disabled = 'disabled';
} else {
  $disabled = '';
}


$sql = "SELECT
p.comCode,
p.documentID,
date_format(p.documentDate,'%d/%m/%Y') as documentDate,
date_format(p.dueDate,'%d/%m/%Y') as dueDate,
p.supCode,
p.refJobNo,
p.note,
p.remark,
p.sumTotal,
p.sumTax1,
p.sumTax3,
p.sumTax7,
p.grandTotal,
p.documentstatus,
p.createID,
p.createTime,
p.editID,
p.editTime
FROM $db->dbname.petty_cash AS p
WHERE p.comCode='$db->comCode' AND p.documentID='$documentID' ";

if ($r = $db->fetch($sql)) {


  $documentID = $r['documentID'];
  $documentDate = $r['documentDate'];
  $dueDate = $r['dueDate'];
  $refJobNo = $r['refJobNo'];
  $supCode = $r['supCode'];
  $note = $r['note'];
  $remark = $r['remark'];
  $documentstatus = $r['documentstatus'];
  $createID = $r['createID'];
  $createTime = $r['createTime'];
  $editID = $r['editID'];
  $editTime = $r['editTime'];
  $sumTotal = $r['sumTotal'];
$tax1=$r['sumTax1'];
$tax3=$r['sumTax3'];
$tax7=$r['sumTax7'];	
$grandTotal=$r['grandTotal'];	
	
  $readonly = 'readonly';
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
          if (result != "") {


            $("#cus_address").val(result);
          }
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
          url: "petty_cash_action.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(data) {
           // window.prompt('', data);
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
          url: "petty_cash_action.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(data) {

            // window.prompt('',data);

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
            $("#save").prop("disabled", true);
            $("#approve").prop("disabled", true);

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
        " <td><input type='text' name='invNo[]'  class='form-control' value='' id='invNo" + rowIdx + "'><input type='hidden' name='chargeitems[]'  value='" + $("#chargeCode").val() + "' id='chargeitems" + rowIdx + "'></td> " +

        " <td><input type='text' name='chargesDetail[]' class='form-control' value='" + $("#chargeCode option:selected").text() + "' id='chargesDetail" + rowIdx + "'></td>  " +
        " <td class='center'><input type='number' name='amount[]'  onkeyup='call_price()'  class='form-control' value='0' id='amount" + rowIdx + "'></td>  " +
        " <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(" + rowIdx + ")'>Remove</button></td>  " +
        " </tr>");



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
      url: "voucher_cal.php",
      data: data,
      processData: false,
      contentType: false,
      cache: false,
      timeout: 600000,
      success: function(result) {

		var var_tax1=$("#tax1").val();  
		var var_tax3=$("#tax3").val(); 
		var var_tax7=$("#tax7").val(); 

        var obj = jQuery.parseJSON(result);

        $("#sumTotal").val(obj.total);
		  
		  

		  
		  
		var grandTotal=obj.total-var_tax1-var_tax3+ parseFloat(var_tax7);
        $("#showgrandTotal").text(grandTotal.toFixed(2));
		$("#grandTotal").val(grandTotal.toFixed(2)); 
		  
      },
      error: function(e) {
        console.log("ERROR : ", e);

      }



    });



  }
    
        function openInNewTab(url) {

var vardocumentID=$("#documentID").val();
    if(vardocumentID=='')return false;
var win = window.open('print/'+url+'.php?documentID='+vardocumentID, '_blank');
win.focus();
}
</script>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-6">
    <h2>Petty Cash/ เงินสดย่อย</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Account</a></li>
      <li class="breadcrumb-item"> <a>Petty Cash</a> </li>
      <li class="breadcrumb-item"> <a>Petty Cash Form</a></li>
    </ol>
  </div>
</div>
<form name="form" id="form" enctype="multipart/form-data" method="post">
  <div class="wrapper wrapper-content animated fadeInRight">
    <!-- Body-->

    <div class="row">


      <div class="col-lg-12">
        <div class="ibox ">
          <div class="ibox-title">
            <h2>Document</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content">




            <div class="form-group  row">
              <label class="col-sm-1 col-form-label">Document No.</label>
              <div class="col-md-4">
                <input type="text" name="documentID" id="documentID" class="form-control" value="<?php echo $documentID; ?>" readonly>
              </div>
              <label class="col-sm-1 col-form-label">Document Date</label>
              <div class="col-md-2">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" name="documentDate" class="form-control" value="<?php echo $documentDate; ?>">
                </div>
              </div>
            </div>

            <div class="form-group  row">
              <label class="col-sm-1 col-form-label">จ่ายให้/Paid To</label>
              <div class="col-md-4">
                <select name="supCode" class="select2_single form-control select2" id="supCode">
                  <?php $db->s_supplier($supCode); ?>
                </select>
              </div>
              <label class="col-sm-1 col-form-label">Ref. JobNo.</label>
              <div class="col-md-2">
                <select class="select2_single form-control select2" name="refJobNo" id="refJobNo">
                  <?php $db->s_jobref($refJobNo); ?>
                </select>
              </div>
            </div>


            <div class="form-group  row">
              <label class="col-sm-1 col-form-label">Address</label>
              <div class="col-md-4">
                <input type="text" name="cusCode" class="form-control" >
              </div>

              <label class="col-sm-1 col-form-label">วันชำระ</label>
              <div class="col-md-2">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" name="dueDate" class="form-control" value="<?php echo $dueDate; ?>">
                </div>
              </div>
              <!--<div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Due Date</label>
              </div>
              <div class="col-md-4">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" name="dueDate" class="form-control" value="<?php echo $dueDate; ?>">
                </div>
              </div> -->

            </div>











          </div>
        </div>
      </div>




      <div class="col-lg-12">
        <div class="ibox ">
          <div class="ibox-title">
            <h2>Detail</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
            <div class="form-group  row">
              <div class="col-md-6">
                <select class="select2_single form-control select2" style="width: 100%;" id="chargeCode">
                  <?php $db->s_charge(''); ?>
                </select>
              </div>
              <div class="col-md-2" style="padding-left: 0px;">
                <button class="btn btn-white " type="button" name="addCharge" id="addCharge"><i class="fa fa-plus"></i> Add</button>
              </div>
            </div>
          </div>
          <div class="ibox-content">
            <div class="form-group">
              <div class="table-responsive" id="containner_charge">
                <table class="table" width="100%" id="table_charge">
                  <thead>
                    <tr>
                      <th style="width:10%">เลขที่บิล No.</th>
                      <th style="width:35%">รายการ Particulars</th>
                      <th style="width:10%">จำนวนเงิน Amount</th>
                      <th style="width:5%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT
t.comCode,
t.documentID,
t.invNo,
t.chargeCode,
t.chartDetail,
t.amount
FROM $db->dbname.petty_cash_items AS t  WHERE t.comCode='$db->comCode' AND t.documentID='$documentID' ";
                    $result = $db->query($sql);
                    $i = 1;
                    $isActiveStype = "";
                    $rowIdx = 99;
                    while ($r = mysqli_fetch_array($result)) {
                    ?>
                      <tr class='gradeX' id='tr<?php echo $rowIdx; ?>'>
                        <td><input type='text' name='invNo[]' class='form-control' value='<?php echo $r['invNo']; ?>' id='invNo<?php echo $rowIdx; ?>'>
                          <input type='hidden' name='chargeitems[]' value='<?php echo $r['chargeCode']; ?>' id='chargeitems<?php echo $rowIdx; ?>'>
                        </td>
                        <td><input type='text' name='chargesDetail[]' class='form-control' value='<?php echo $r['chartDetail']; ?>' id='chargesDetail<?php echo $rowIdx; ?>'></td>
                        <td class='center'><input type='number' name='amount[]' onkeyup='call_price()' class='form-control' value='<?php echo $r['amount']; ?>' id='amount<?php echo $rowIdx; ?>'></td>
                        <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("<?php echo $rowIdx; ?>")'>Rempove</button></td>
                      </tr>
                    <?php $rowIdx++;
                    } ?>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
              </div>
              <div class="form-group row">
                <label class="col-lg-6 col-form-label"> remark
                  <textarea rows="3" name="remark" class="form-control"><?php echo $remark; ?></textarea>
                </label>
                <div class="col-lg-6">
                  <table class="table invoice-total">
                    <tbody>
                      <tr>
                        <td><strong>TOTAL :</strong></td>
                        <td>
                          <input type="number" name="sumTotal" id="sumTotal" class='form-control'  value="<?php echo $sumTotal; ?>" required></td>
                      </tr>
                      <tr>
                        <td><strong>Tax 1% :</strong></td>
                        <td><input type="number" name="tax1" id="tax1"  onkeyup='call_price()' class='form-control'  value="<?php echo $tax1; ?>" required></td>
                      </tr>
                      <tr>
                        <td><strong>Tax 3% :</strong></td>
                        <td><input type="number" name="tax3" id="tax3"  onkeyup="call_price()"  class='form-control' value="<?php echo $tax3; ?>" required></td>
                      </tr>
                      <tr>
                        <td><strong>Vat7% :</strong></td>
                        <td><input type="number" name="tax7" id="tax7" onkeyup="call_price()"  class='form-control' value="<?php echo $tax7; ?>" required></td>
                      </tr>
                      <tr>
                         <td><strong>GRAND TOTAL:</strong></td>
                          <td style="text-align: left"><span id="showgrandTotal"  >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo n2($grandTotal); ?></span>
                          <input type="hidden" name="grandTotal" id="grandTotal" value="<?php echo $grandTotal; ?>"></td>
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
                <button name="back" class="btn btn-white" type="button" onclick="window.location='petty_cash&sub=<?php echo $sub;?>'"><i class="fa fa-reply"></i> Back</button>
                <?php
                if ( $documentstatus != 'A' || $_SESSION['userTypecode']=='1') {
					 if ( $documentstatus != 'A'){
                ?>
                  <button name="save" id="save" class="btn btn-primary" type="button" <?php echo $disabled; ?>><i class="fa fa-save"></i> Save</button>
                 <?php }
			if($_SESSION['userTypecode']=='1'){ 
				  
				  ?>
				  <button name="approve" id="approve" class="btn btn-success " type="button" <?php echo $disabled; ?>><i class="fa fa-check"></i> Approve</button>
                <?php } } ?>
        
                  
                <button class="btn btn-white " type="button" onclick="openInNewTab('<?php echo 'petty_cash_pdf';?>');" ><i class="fa fa-print"></i> Print</button>  
                  
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
