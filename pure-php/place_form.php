<?php
require_once('class.php');
require_once('function.php');
$db = new cl;
$acton = get('action');
$pCode = get('pCode');
$pName = '';
$isActive = '1';
$readonly = '';
$createID = '';
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
c.pCode,
c.pName,
c.isActive,
c.createID,
c.createTime,
c.editID,
c.editTime
FROM $db->dbname.common_place AS c
WHERE c.comCode='$db->comCode' AND c.pCode='$pCode' ";
if ($r = $db->fetch($sql)) {
  $pName = $r['pName'];;
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
        pName: {
          required: true
        },
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
          url: "place_action.php",
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
              $("#pCode").val(obj.documentID);
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


  });
</script>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Place / สถานที่</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Common Data</a></li>
      <li class="breadcrumb-item">Place</li>
      <li class="breadcrumb-item"> <a>Place Form</a></li>
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
          <form name="form" id="form" action="" enctype="multipart/form-data" method="post">
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">
                <h3>Flace info</h3>
              </label>

            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label"> Code</label>
              <div class="col-md-2">
                <input name="pCode" type="text" class="form-control " id="pCode" readonly autocomplete="off" value="<?php echo $pCode; ?>" <?php echo $readonly; ?>>
              </div>
            </div>

            <div class="form-group  row">
              <label class="col-sm-2 col-form-label"> Name</label>
              <div class="col-sm-8"><input name="pName" type="text" class="form-control " id="pName" autocomplete="empty" value="<?php echo $pName; ?>"></div>
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
                <button name="back" class="btn btn-white" type="button" onclick="window.location='place'"><i class="fa fa-reply"></i> Back</button>
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
<script type="text/javascript">
  function closeCurrentTab() {
    window.close();
  }
</script>
<!--  END Body-->