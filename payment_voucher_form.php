<?php
//session_start();
unset( $_SESSION[ 'chargeCode' ] );
require_once( 'class.php' );
require_once( 'function.php' );
$db = new cl;
$acton = get( 'action' );
$documentID = get( 'documentID' );
$documentDate = date( 'd/m/Y' );
$dueDate = date( 'd/m/Y' );
$purchasevat=0;

$supCode = "";
$payType = "";
$payTypeOther = "";
$branch = "";
$chequeNo = "";
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



if ( $acton == 'view' ) {
  $disabled = 'disabled';
} else {
  $disabled = '';
}


$sql = "SELECT
p.comCode,
p.documentID,
date_format(p.documentDate,'%d/%m/%Y') as documentDate,
p.supCode,
p.refJobNo,
p.payType,
p.payTypeOther,
p.branch,
p.chequeNo,
date_format(p.dueDate,'%d/%m/%Y') as dueDate,
p.note,
p.sumTotal,
p.sumTax1,
p.sumTax3,
p.accountCode,
p.sumTax7,
p.grandTotal,
p.remark,
p.purchasevat,
p.documentstatus,
p.createID,
p.createTime,
p.editID,
p.editTime
FROM $db->dbname.payment_voucher AS p
WHERE p.comCode='$db->comCode' AND p.documentID='$documentID' ";
if ( $r = $db->fetch( $sql ) ) {


  $documentID = $r[ 'documentID' ];
  $documentDate = $r[ 'documentDate' ];
  $refJobNo = $r[ 'refJobNo' ];
  $supCode = $r[ 'supCode' ];
  $payType = $r[ 'payType' ];
  $payTypeOther = $r[ 'payTypeOther' ];
  $branch = $r[ 'branch' ];
  $purchasevat=$r['purchasevat'];
  $chequeNo = $r[ 'chequeNo' ];
  $dueDate = $r[ 'dueDate' ];
  $note = $r[ 'note' ];
  $remark = $r[ 'remark' ];
   $accountCode=$r['accountCode'];
	
  $documentstatus = $r[ 'documentstatus' ];
  $createID = $r[ 'createID' ];
  $createTime = $r[ 'createTime' ];
  $editID = $r[ 'editID' ];
  $editTime = $r[ 'editTime' ];
	
  $sumTotal = $r[ 'sumTotal' ];
	
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
          url: "payment_voucher_action.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(data) {

 			console.log(data);
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
          url: "payment_voucher_action.php",
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
    var rowIdx_atach = 1;
    var rowIdx = 1;
    $("#addCharge").click(function(event) {



      $("#table_charge tbody").append(" <tr class='gradeX' id='tr" + rowIdx + "'> " +
        " <td><input type='text' name='invNo[]'  class='form-control' value='' id='invNo" + rowIdx + "'><input type='hidden' name='chargeitems[]'  value='" + $("#chargeCode").val() + "' id='chargeitems" + rowIdx + "'></td> " +

        " <td><input type='text' name='chargesDetail[]' class='form-control' value='" + $("#chargeCode option:selected").text() + "' id='chargesDetail" + rowIdx + "'></td>  " +
        " <td class='center'><input type='number' name='amount[]'  onkeyup='call_price()'  class='form-control' value='0' id='amount" + rowIdx + "'></td>  " +
        " <td class='center'><select class='form-control' name='tax[]' id='" + rowIdx + "'><option value='0'>0%</option><option value='1'>1%</option><option value='3'>3%</option></select></td>  " +
        " <td class='center'><input type='text' name='tax_total[]'  class='form-control' value='0' id='tax_total_" + rowIdx + "' readonly></td>  " +
        " <td class='center'><select class='form-control' name='vat[]' id='" + rowIdx + "'><option value='0'>0%</option><option value='7'>7%</option></select></td>  " +
        " <td class='center'><input type='text' name='vat_total[]'  class='form-control' value='0' id='vat_total_" + rowIdx + "' readonly></td>  " +
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


    $("#btnUpload").click(function(event) {
      if ($("#supCode").val() == '') {
        swal({
          title: "Warning",
          text: "กรุณาเลือก supplier",
          confirmButtonColor: "#DD6B55",
          type: "warning"
        });
        return false;
      }

      if ($("#attach_name").val() == '') {
        swal({
          title: "Warning",
          text: "กรุณาระบุชื่อไฟล์เอกสาร",
          confirmButtonColor: "#DD6B55",
          type: "warning"
        });
        return false;
      }

      if ($("#attach_file").val() == '') {
        swal({
          title: "Warning",
          text: "กรุณาเลือกไฟล์",
          confirmButtonColor: "#DD6B55",
          type: "warning"
        });
        return false;
      }

      $("#attach_file")[0].files[0].size;

      var i_size = $("#attach_file")[0].files[0].size;
      var i_name = $("#attach_file")[0].files[0].name;
      var i_type = i_name.split('.').pop();
      if (i_size > 10000000) {
        swal({
          title: "Warning",
          text: "ไฟล์มีขนาดใหญ่เกินกว่าที่กำหนด",
          confirmButtonColor: "#DD6B55",
          type: "warning"
        });
        return false;
      }
      var ext = i_name.split('.').pop();
      if (ext != 'pdf' && ext != 'jpg' && ext != 'jpeg' && ext != 'png') {
        swal({
          title: "Warning",
          text: "อัพโหลดได้เฉพาะไฟล์ pdf,jpg,jpeg,png เท่านั้น",
          confirmButtonColor: "#DD6B55",
          type: "warning"
        });
        return false;
      }




      event.preventDefault();
      var form = $('#form')[0];
      var data = new FormData(form);
      data.append("CustomField", "This is some extra data, testing");
      // disabled the submit button
      $("#btnUpload").prop("disabled", true);
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "payment_voucher_upload.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function(result) {
          var obj = jQuery.parseJSON(result);
          // var dataresult = obj.result;
          //alert(obj.fileName);
          // alert(rowIdx_atach);
          if (obj.result == 'success') {
            //  console.log("SUCCESS : ", 'x');
            $("#btnUpload").prop("disabled", false);
            $("#table_attach").append(" <tr class='gradeX' id='tr" + rowIdx_atach + "'> " +
              " <td>" + rowIdx_atach + "<input type='hidden' name='imgKey[]'  value='" + obj.fileName + "' id='imgKey" + rowIdx_atach + "'></td> " +
              " <td><input type='text' name='fileName[]' class='form-control' value='" + $("#attach_name").val() + "' id='fileName" + rowIdx_atach + "'></td>  " +
              " <td class='center'> <a class='btn-white btn btn-xs' href='supplier_path/" + $("#supCode").val() + "/" + obj.fileName + "' target='_blank'>View</a> </button>&nbsp;<button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(" + rowIdx_atach + ")'>Remove</button></td>  " +
              " </tr>");
            rowIdx_atach++;
            // msgSuccess();
            msgUploadSuccess();
            $("#attach_file").val("");
            $("#attach_name").val("");
            $("#countImg").val(1);
            $(".close").click();



          } else {
            //  console.log("error : ", 'x');
            $("#btnUpload").prop("disabled", false);
            msgError();
          }
        },
        error: function(e) {
          msgError();
          console.log("ERROR : ", e);
          $("#btnUpload").prop("disabled", false);
        }



      });











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
        var obj = $.parseJSON(result);

        // var var_tax1 = $("#tax1").val();  
        // var var_tax3=$("#tax3").val(); 
        // var var_tax7 = $("#tax7").val(); 
        var tax_total1 = 0;
        var tax_total3 = 0;
        var vat_total = 0;

        $('select[name="tax[]"] option:selected').each(function (index, element) {
          let amount = $('input[name="amount[]"]').eq(index).val();
          $('input[name="tax_total[]"]').eq(index).val( call_vat($(element).val(), amount) ); 
        });

        $('select[name="vat[]"] option:selected').each(function (index, element) {
          let amount = $('input[name="amount[]"]').eq(index).val();
          $('input[name="vat_total[]"]').eq(index).val( call_vat($(element).val(), amount) ); 
        });

        $('input[name="tax_total[]"]').each(function (index, element) {
          if ($(element).attr('data-tax') == 1) {
            tax_total1 = tax_total1 + parseFloat($(element).val());
          }
          if ($(element).attr('data-tax') == 3) {
            tax_total3 = tax_total3 + parseFloat($(element).val());
          }
        });
        
        $('input[name="vat_total[]"]').each(function (index, element) {
          vat_total = vat_total + parseFloat($(element).val());
        });

        $("#sumTotal").val(obj.total);
		  
        var grandTotal = (obj.total - (tax_total1+tax_total3)) + vat_total;
        $("#tax1").val(num_round(tax_total1, 2));
        $("#tax3").val(num_round(tax_total3, 2));
        $("#tax7").val(num_round(vat_total, 2));
        $("#showgrandTotal").text(grandTotal.toFixed(2));
        $("#grandTotal").val(grandTotal.toFixed(2));
        console.log(
          ' tax1:'+ tax_total1 +
          ' tax3:'+ tax_total3 +
          ' vat:'+ vat_total +
          ' grandTotal:'+ grandTotal +
          ' xxx:'+ num_round(395.485)
        );
      },
      error: function(e) {
        console.log("ERROR : ", e);

      }



    });



  }

  function call_vat(vat, amount) {
    let total = (amount * vat) / 100;
    return num_round(total, 2);
  }

  function num_round(num, dec){
    if(typeof(pre) != 'undefined' && pre != null){ var decimals=dec;  } else{var decimals=2;}

    num *= Math.pow(10,decimals);
    num = (Math.round(num,decimals) + (((num - Math.round(num,decimals))>=0.4)?1:0)) / Math.pow(10,decimals);
    return num.toFixed(decimals);
  }

  $(document).on('change', 'select[name="tax[]"]', function() {
    let amount = $("#amount" + this.id).val();
    $("#tax_total_" + this.id).val( call_vat(this.value, amount) );
    $("#tax_total_" + this.id).attr('data-tax', this.value);
    call_price();
  });
  
  $(document).on('change', 'select[name="vat[]"]', function() {
    let amount = $("#amount" + this.id).val();
    $("#vat_total_" + this.id).val( call_vat(this.value, amount) );
    call_price();
  });

</script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-6">
    <h2>Payment Voucher / ใบสำคัญจ่าย</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Account</a></li>
      <li class="breadcrumb-item"> <a>Payment Voucher</a> </li>
      <li class="breadcrumb-item"> <a>Payment Voucher Form</a></li>
    </ol>
  </div>
</div>
<form name="form" id="form" enctype="multipart/form-data" method="post">
  <div class="wrapper wrapper-content animated fadeInRight"> 
    <!-- Body-->
    
    <div class="row">
      <div class="col-lg-7" style="margin-bottom: 1px; ">
        <div class="ibox ">
          <div class="ibox-title">
            <h2>Document</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label"><span class="col-form-label" style="padding-top: 5px;">Document</span> No.</label>
              <div class="col-md-4">
                <input type="text" name="documentID" id="documentID" class="form-control" value="<?php echo $documentID; ?>" readonly>
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
              <label class="col-lg-2 col-form-label"><span class="col-form-label" style="padding-top: 5px;">จ่ายให้/Paid To</span></label>
              <div class="col-md-4">
                <select name="supCode" class="select2_single form-control select2" id="supCode">
                  <?php $db->s_supplier($supCode); ?>
                </select>
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Ref. JobNo.</label>
              </div>
              <div class="col-md-3">
                <select class="select2_single form-control select2" name="refJobNo" id="refJobNo">
                  <?php $db->s_jobref($refJobNo); ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Note</label>
              <div class="col-md-9">
                <textarea name="note" rows="4" class="form-control"><?php  echo $note;?></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="ibox ">
          <div class="ibox-title">
            <h2> Payment</h2>
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
                  <label>
                    <input type="radio" id="chsh" value="c" name="payType" <?php if ($payType == 'c') {
                                                                                    echo 'checked';
                                                                                  } ?>>
                    <i></i>เงินสด Cash </label>
                  <label>
                    <input type="radio" id="bank" value="b" name="payType" <?php if ($payType == 'b') {
                                                                                    echo 'checked';
                                                                                  } ?>>
                    <i></i>เช็คธนาคาร Bank </label>
                </div>
                <div class="i-checks">
                  <input type="radio" id="other" value="o" name="payType" <?php if ($payType == 'o') {
                                                                            echo 'checked';
                                                                          } ?>>
                  <i></i>อื่นๆ Other
                  <input type="text" name="payTypeOther" id="payTypeOther" class="form-control col-sm-6" value="<?php echo $payTypeOther; ?>">
                </div>
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-3 col-form-label">สาขา Branch</label>
              <div class="col-md-9">
                <input type="text" name="branch" id="branch" class="form-control" value="<?php echo $branch; ?>">
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-3 col-form-label">เลขที่เช็ค Cheque</label>
              <div class="col-md-3">
                <input type="text" name="chequeNo" id="chequeNo" class="form-control" value="<?php echo $chequeNo; ?>">
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Due Date</label>
              </div>
              <div class="col-md-4">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" name="dueDate" class="form-control" value="<?php echo $dueDate; ?>">
                </div>
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
                      <th style="width:5%">Tax </th>
                      <th style="width:5%">Tax รวม</th>
                      <th style="width:5%">Vat</th>
                      <th style="width:5%">Vat รวม</th>
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
t.amount,
t.tax,
t.taxamount,
t.vat,
t.vatamount
FROM $db->dbname.payment_voucher_items AS t  WHERE t.comCode='$db->comCode' AND t.documentID='$documentID' AND t.documentID<>'' ";
                    $result = $db->query( $sql );
                    $i = 1;
                    $isActiveStype = "";
                    $rowIdx = 99;
                    $sum_tax1 = 0;
                    $sum_tax3 = 0;
                    while ( $r = mysqli_fetch_array( $result ) ) {
						
						
						
                      ?>
                    <tr class='gradeX' id='tr<?php echo $rowIdx; ?>'>
                      <td>
                        <input type='text' name='invNo[]' class='form-control' value='<?php echo $r['invNo']; ?>' id='invNo<?php echo $rowIdx; ?>'>
                        <input type='hidden' name='chargeitems[]' value='<?php echo $r['chargeCode']; ?>' id='chargeitems<?php echo $rowIdx; ?>'>
                      </td>
                      <td><input type='text' name='chargesDetail[]' class='form-control' value='<?php echo $r['chartDetail']; ?>' id='chargesDetail<?php echo $rowIdx; ?>'></td>
                      <td class='center'>
                        <input type='number' name='amount[]' onkeyup='call_price()' class='form-control' value='<?php echo $r['amount']; ?>' id='amount<?php echo $rowIdx; ?>'>
                      </td>
                      <td class='center'>
                        <select class="form-control valid" name="tax[]" id="<?php echo $rowIdx; ?>">
                          <option value="0" <?php if ($r['tax'] == 0){ echo 'selected';} ?>>0%</option>
                          <option value="1" <?php if ($r['tax'] == 1){ echo 'selected';} ?>>1%</option>
                          <option value="3" <?php if ($r['tax'] == 3){ echo 'selected';} ?>>3%</option>
                        </select>
                      </td>
                      <td class='center'>
                        <input type="text" name="tax_total[]" class="form-control valid" value="<?php echo number_format($r['taxamount'], 2); ?>" id="tax_total_<?php echo $rowIdx; ?>" data-tax="<?=$r['tax'];?>" readonly="">
                      </td>
                      <td class='center'>
                        <select class="form-control valid" name="vat[]" id="<?php echo $rowIdx; ?>">
                          <option value="0" <?php if ($r['vat'] == 0){ echo 'selected';} ?>>0%</option>
                          <option value="7" <?php if ($r['vat'] == 7){ echo 'selected';} ?>>7%</option>
                        </select>
                      </td>
                      <td class='center'>
                        <input type="text" name="vat_total[]" class="form-control valid" value="<?php echo number_format($r['vatamount'], 2); ?>" id="vat_total_<?php echo $rowIdx; ?>" readonly="">
                      </td>
                      <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("<?php echo $rowIdx; ?>")'>Rempove</button></td>
                    </tr>
                    <?php
                      $rowIdx++;
                      $grandTotal   = $sumTotal-$tax1-$tax3+$tax7;
                      if ($r['tax'] == 1) {
                        $sum_tax1    += $r['taxamount'];
                      }
                      if ($r['tax'] == 3) {
                        $sum_tax3    += $r['taxamount'];
                      }
                    }
                    ?>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
              </div>
              <div class="form-group row">
                <label class="col-lg-6 col-form-label"> remark
                  <textarea rows="3" name="remark" class="form-control"><?php echo $remark;?></textarea>
                </label>
                <div class="col-lg-6">
                  <table class="table invoice-total">
                    <tbody>
                      <tr>
                        <td><strong>TOTAL :</strong></td>
                        <td style="min-width: 150px;">
                          <input type="number" name="sumTotal" id="sumTotal" class='form-control'  value="<?php echo $sumTotal; ?>" required readonly></td>
                      </tr>
                      <tr>
                        <td><strong>Tax 1% :</strong></td>
                        <td><input type="number" name="tax1" id="tax1"  onkeyup='call_price()' class='form-control'  value="<?php echo $sum_tax1; ?>" required readonly></td>
                      </tr>
                      <tr>
                        <td><strong>Tax 3% :</strong></td>
                        <td><input type="number" name="tax3" id="tax3"  onkeyup="call_price()"  class='form-control' value="<?php echo $sum_tax3; ?>" required readonly></td>
                      </tr>
                      <tr>
                        <td><strong>Vat Total : </strong></td>
                        <td><input type="number" name="tax7" id="tax7" onkeyup="call_price()"  class='form-control' value="<?php echo $tax7; ?>" required readonly></td>
                      </tr>
                     
	
						
                      <tr>
                         <td><strong>GRAND TOTAL:</strong></td>
                          <td style="text-align: left"><span id="showgrandTotal"  >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo n2($grandTotal); ?></span>
                          <input type="hidden" name="grandTotal" id="grandTotal" value="<?php echo $grandTotal; ?>"></td>
                      </tr>
						
	                 <tr>
                         <td><strong>นำไปคิดภาษีซื้อ :</strong></td>
                          <td style="text-align: left"><label class="checkbox-inline i-checks">
                  <input type="checkbox" name="purchasevat"  id="purchasevat" value="1"  <?php  if($purchasevat==1){  echo "checked";  }?>>
                 </label></td>
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
            <h2>Attach File / ไฟล์แนบ</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content collapse">
            <div class="form-group">
              <table class="table" width="100%" name="table_attach" id="table_attach">
                <thead>
                  <tr>
                    <th style="width:5%">No.</th>
                    <th style="width:50%">File Name</th>
                    <th style="width:10%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
$sql = "SELECT
t.items,
t.comCode,
t.documentID,
t.supCode,
t.fileDetail,
t.fileName
FROM payment_voucher_attach AS t
WHERE t.comCode='$db->comCode' AND t.documentID='$documentID' AND t.documentID<>'' ";
                  $result = $db->query( $sql );
                  $i_container = 1;
                  $i = 1;
                  $countImg = 0;
                  while ( $r = mysqli_fetch_array( $result ) ) {

                    $countImg = 1;
                    ?>
                  <tr class='gradeX' id='tr<?php echo $i; ?>'>
                    <td><?php echo $i; ?>
                      <input type='hidden' name='imgKey[]' value='"+obj.fileName+"' id='imgKey<?php echo $i; ?>'></td>
                    <td><input type='text' name='fileName[]' class='form-control' value='<?php echo $r['fileDetail']; ?>' id='fileName<?php echo $i; ?>'></td>
                    <td class='center'><a class='btn-white btn btn-xs' href='supplier_path/<?php echo $r['supCode'] . '/' . $r['fileName']; ?>' target='_blank'>View</a>
                      </button>
                      &nbsp;
                      <button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("<?php echo $i; ?>")'>Remove</button></td>
                  </tr>
                  <?php
                  $i++;
                  }
                  ?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">File Name</label>
              <div class="col-md-4">
                <input type="text" name="attach_name" class="form-control" id="attach_name">
              </div>
              <div id="container_attach" class="fileinput fileinput-new" data-provides="fileinput"> <span class="btn btn-primary btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                <input type="file" name="attach_file" id="attach_file">
                </span> <span class="fileinput-filename"></span> <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a> </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Action</label>
              <div class="col-md-4">
                <button class="btn btn-primary " type="button" name="btnUpload" id="btnUpload"><i class="fa fa-save"></i> Upload File</button>
                <input type="hidden" name="countImg" id="countImg" value="<?php echo $countImg; ?>">
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
                <button name="back" class="btn btn-white" type="button" onclick="window.location='payment_voucher&sub=<?php echo $sub;?>'"><i class="fa fa-reply"></i> Back</button>
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
				  
				  
				  
                <button class="btn btn-white " type="button" onclick="window.open('print/payment_voucher_pdf.php?documentID=<?php echo $documentID; ?>','_blank')"><i class="fa fa-print"></i> Print</button>
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