<?php
require_once('class.php');
require_once('function.php');
$db = new cl;
$acton = get('action');
$chargeCode = get('chargeCode');
$chargeName = '';
$typeCode = '';
$isActive = '1';
$readonly = '';
$createID = '';
$purchaseVat='Y';
$createTime = '';
$editID = '';
$editTime = '';
if ($acton == 'view') {
  $disabled = 'disabled';
} else {
  $disabled = '';
}
$sql = " SELECT
c.comCode,
c.chargeCode,
c.chargeName,
c.typeCode,
c.isActive,
c.purchaseVat,
c.createID,
c.createTime,
c.editID,
c.editTime
FROM $db->dbname.common_charge AS c
WHERE c.comCode='$db->comCode' AND c.chargeCode='$chargeCode' ";
if ($r = $db->fetch($sql)) {
  $chargeName = $r['chargeName'];
  $typeCode = $r['typeCode'];
$purchaseVat=$r['purchaseVat'];
  $isActive = $r['isActive'];
  $readonly = 'readonly';
  $createID = $r['createID'];
  $createTime = $r['createTime'];
  $editID = $r['editID'];
  $editTime = $r['editTime'];
}


?>
<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<link href="css/plugins/select2/select2.min.css" rel="stylesheet">
<script>
  $(document).ready(function() {
    $('.select2_single').select2({});
    $("#form").validate({
      rules: {
        chargeName: {
          required: true
        },
        typeCode: {
          required: true
        }
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
          url: "charges_action.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(data) {


            var obj = jQuery.parseJSON(data);

            var dataresult = obj.result;
            if (dataresult == 'success') {
              $("#chargeCode").val(obj.documentID);
              $("#action").val('edit');
              msgSuccess();
              console.log("SUCCESS : ", dataresult);
            } else {
              msgError();
              console.log("Error : ", dataresult);
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


  });
</script>

<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<link href="css/plugins/select2/select2.min.css" rel="stylesheet">
<script>
  $(document).ready(function() {
    //$(".chosen-select").select2();
    $('.select2_single').select2({});
  });
</script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Charges / ค่าใช้จ่าย</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Common Data</a></li>
      <li class="breadcrumb-item"> <a>Charges</a> </li>
      <li class="breadcrumb-item"> <a>Charges Form</a></li>
    </ol>
  </div>
  <div class="col-lg-2"> </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <!-- Body-->

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox ">
        <div class="ibox-content">
          <form method="get" name="form" id="form">
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">
                <h3>Charges info</h3>
              </label>

            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Charges Code</label>
              <div class="col-md-2">
                <input type="text" name="chargeCode" id="chargeCode" class="form-control" readonly value="<?php echo $chargeCode; ?>">
              </div>
            </div>



            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Charges Name</label>

              <div class="col-sm-10"><input type="text" class="form-control" name="chargeName" id="chargeName" value="<?php echo $chargeName; ?>"></div>
            </div>

            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Charges Type</label>
              <div class="col-md-2">
                <select class="select2_single form-control select2" id="typeCode" name="typeCode">
                  <?php $db->s_charge_type($typeCode); ?>
                </select>
              </div>
            </div>



            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Input tax</label>
              <div class="col-sm-10">
                <label class="checkbox-inline i-checks">
                  <input type="radio" name="purchaseVat" value="Y" <?php if ($purchaseVat == 'Y') {
                                                                  echo 'checked';
                                                                } ?>>
                  Yes </label>
                <label class="i-checks">
                  <input type="radio" name="purchaseVat" value="N" <?php if ($purchaseVat == 'N') {
                                                                  echo 'checked';
                                                                } ?>>
                  No</label>
              </div>
            </div>
			  
			  





            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Status</label>
              <div class="col-sm-10">
                <label class="checkbox-inline i-checks">
                  <input type="radio" name="isActive" value="1" <?php if ($isActive == 1) {
                                                                  echo 'checked';
                                                                } ?>>
                  Active </label>
                <label class="i-checks">
                  <input type="radio" name="isActive" value="0" <?php if ($isActive == 0) {
                                                                  echo 'checked';
                                                                } ?>>
                  Inactive</label>
              </div>
            </div>
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
              <div class="col-sm-4 col-sm-offset-2">
                <button name="back" class="btn btn-white" type="button" onclick="window.location='charges'"><i class="fa fa-reply"></i> Back</button>
                <button name="save" id="save" class="btn btn-primary" type="button" <?php echo $disabled; ?>><i class="fa fa-save"></i> Save</button>
                <input type="hidden" name="action" id="action" value="<?php echo $acton; ?>">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  END Body-->