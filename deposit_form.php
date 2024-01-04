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



$cusCode = "";
$payType = "";
$payTypeOther = "";
$branch = "";
$chequeNo = "";
$note = "";
$remark = "";
$dueTime='';
$createID = "";
$createTime = "";
$editID = "";
$editTime = "";
$documentstatus = "P";
$sumTotal = 0;

if ($acton == 'view') {
  $disabled = 'disabled';
} else {
  $disabled = '';
}


$sql = "SELECT
p.comCode,
p.documentID,
date_format(p.documentDate,'%d/%m/%Y') as documentDate,
p.cusCode,
p.refJobNo,
p.payType,
p.payTypeOther,
p.branch,
p.chequeNo,
date_format(p.dueDate,'%d/%m/%Y') as dueDate,
p.dueTime,
p.note,
p.remark,
p.sumTotal,
p.documentstatus,
p.createID,
p.createTime,
p.editID,
p.editTime,
p.agentCode
FROM $db->dbname.deposit AS p
WHERE p.comCode='$db->comCode' AND p.documentID='$documentID' ";
if ($r = $db->fetch($sql)) {


  $documentID = $r['documentID'];
  $documentDate = $r['documentDate'];
  $refJobNo = $r['refJobNo'];
  $agentCode=$r['agentCode'];
  $cusCode = $r['cusCode'];
  $payType = $r['payType'];
  $payTypeOther = $r['payTypeOther'];
  $branch = $r['branch'];
  $chequeNo = $r['chequeNo'];
  $dueDate = $r['dueDate'];
  $note = $r['note'];
  $remark = $r['remark'];
  $documentstatus = $r['documentstatus'];
  $createID = $r['createID'];
  $createTime = $r['createTime'];
  $editID = $r['editID'];
  $editTime = $r['editTime'];
  $sumTotal = $r['sumTotal'];

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
        cusCode: {
          required: true
        },
        payType: {
          required: true
        }


      }
    });


      
//$('#refJobNo').append('<option value="select" selected="selected">Select From Dropdown List</option>');
      
      
  
$("#refJobNo").change(function() {
    $('#containner_agent').load('load_agent.php?jobNo='+$(this).val());
});
     
      
$("#cusCode").change(function() {
//$('#containner_job').load('load_job.php?cusCode='+$("#cusCode").val());
   /* data: {id:id_amphures,function:'amphures'},
    $('#refJobNo').data();
    $('#refJobNo').html(data); 
    */
        var cusCode = $(this).val();
      $.ajax({
      type: "POST",
      url: "load_job.php",
      data: {id:cusCode},
      success: function(data){
          console.log(data)
          $('#refJobNo').html(data);  
      }
    });
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
          url: "deposit_action.php",
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
          url: "deposit_action.php",
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


    $("#btnUpload").click(function(event) {
      if ($("#cusCode").val() == '') {
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
      if (i_size > 2000000) {
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
        url: "deposit_upload.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function(result) {
          var obj = jQuery.parseJSON(result);
            console.log("Result : ", result);
          // var dataresult = obj.result;
          //alert(obj.fileName);
          // alert(rowIdx_atach);
          if (obj.result == 'success') {
            //  console.log("SUCCESS : ", 'x');
            $("#btnUpload").prop("disabled", false);
            $("#table_attach").append(" <tr class='gradeX' id='tr" + rowIdx_atach + "'> " +
              " <td>" + rowIdx_atach + "<input type='hidden' name='imgKey[]'  value='" + obj.fileName + "' id='imgKey" + rowIdx_atach + "'></td> " +
              " <td><input type='text' name='fileName[]' class='form-control' value='" + $("#attach_name").val() + "' id='fileName" + rowIdx_atach + "'></td>  " +
              " <td class='center'> <a class='btn-white btn btn-xs' href='customer_path/" + $("#cusCode").val() + "/" + obj.fileName + "' target='_blank'>View</a> </button>&nbsp;<button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(" + rowIdx_atach + ")'>Remove</button></td>  " +
              " </tr>");
            rowIdx_atach++;
            // msgSuccess();
            msgUploadSuccess();
            $("#attach_file").val("");
            $("#attach_name").val("");
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
        // window.prompt("",result);

        var obj = jQuery.parseJSON(result);

        $("#sumTotal").val(obj.total);
        $("#total").text(obj.total);
      },
      error: function(e) {
        console.log("ERROR : ", e);

      }



    });



  }
</script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-6">
    <h2>Deposit / เงินมัดจำ</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Account</a></li>
      <li class="breadcrumb-item">deposit</li>
      <li class="breadcrumb-item"> <a>depositt  Form</a></li>
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
              <label class="col-lg-2 col-form-label"><span class="col-form-label" style="padding-top: 5px;">Customer</span></label>
              <div class="col-md-4">
                <select name="cusCode" class="select2_single form-control select2" id="cusCode">
                  <?php 
                    if($_SESSION['userTypecode']=='4'){ $cusCode=$_SESSION['userID'];}
                    $db->s_customer_advance($cusCode, $_SESSION['userTypecode']); ?>
                </select>

              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Ref. JobNo.</label>
              </div>
              <div class="col-md-4" id="containner_job">
                <select class="select2_single form-control select2" name="refJobNo" id="refJobNo">
                  <?php $db->s_jobref_advance($refJobNo,$cusCode); ?>
                </select>
              </div>

            </div>
             
   <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Agent</label>
              <div class="col-md-4" id="containner_agent">
                <select name="agentCode" class="select2_single form-control select2" id="agentCode">
                  <?php $db->s_supplier("$agentCode"); ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Note</label>
              <div class="col-md-9">
                <textarea name="note" rows="4" class="form-control"></textarea>
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
                  <?php $db->s_account(''); ?>
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
                                                                                  } ?>> <i></i>เช็คธนาคาร Bank </label>

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
              <label class="col-sm-3 col-form-label">สาขา Branch</label>
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
                <label class="col-form-label" style="padding-top: 5px;"> Time</label>
              </div>
              <div class="col-md-1">
                  <input type="text" name="dueTime" class="form-control" value="<?php echo $dueTime; ?>">
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
                  <?php //$db->s_charge('C-032'); ?>
                    <option value="C-033">เงินมัดจำ</option>
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
FROM $db->dbname.deposit_items AS t  WHERE t.comCode='$db->comCode' AND t.documentID='$documentID' ";
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
                  <textarea rows="3" name="remark" class="form-control"></textarea>
                </label>
                <div class="col-lg-6">
                  <table class="table invoice-total">
                    <tbody>
                      <tr>
                        <td><strong>TOTAL :</strong></td>
                        <td><span id="total"><?php echo $sumTotal; ?></span><input type="hidden" name="sumTotal" id="sumTotal" value="<?php echo $sumTotal; ?>"> </td>
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
t.cusCode,
t.fileDetail,
t.fileName
FROM deposit_attach AS t
WHERE t.comCode='$db->comCode' AND t.documentID='$documentID' AND t.cusCode='$cusCode' ";
                  $result = $db->query($sql);
                  $i_container = 1;
                  $i = 1;
                  while ($r = mysqli_fetch_array($result)) {
                  ?>


                    <tr class='gradeX' id='tr<?php echo $i; ?>'>
                      <td><?php echo $i; ?><input type='hidden' name='imgKey[]' value='"+obj.fileName+"' id='imgKey<?php echo $i; ?>'></td>
                      <td><input type='text' name='fileName[]' class='form-control' value='<?php echo $r['fileDetail']; ?>' id='fileName<?php echo $i; ?>'></td>
                      <td class='center'> <a class='btn-white btn btn-xs' href='customer_path/<?php echo $r['cusCode'] . '/' . $r['fileName']; ?>' target='_blank'>View</a> </button>&nbsp;<button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("<?php echo $i; ?>")'>Remove</button></td>
                    </tr>


                  <?php $i++;
                  } ?>


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
                <button name="back" class="btn btn-white" type="button" onclick="window.location='deposit'"><i class="fa fa-reply"></i> Back</button>
                <?php
                if ($documentstatus != 'A') {
                ?>
                  <button name="save" id="save" class="btn btn-primary" type="button" <?php echo $disabled; ?>><i class="fa fa-save"></i> Save</button>
                <?php
                if($_SESSION['userTypecode']!='4'){
                ?>
                  <button name="approve" id="approve" class="btn btn-success " type="button" <?php echo $disabled; ?>><i class="fa fa-check"></i> Approve</button>
                <?php  }} ?>
                <button class="btn btn-white " type="button" onclick="window.open('print/deposit_pdf.php?documentID=<?php echo $documentID; ?>','_blank')"><i class="fa fa-print"></i> Print</button>
                <input type="hidden" name="action" id="action" value="<?php echo $acton; ?>">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
 
</form>
<!--  END Body-->