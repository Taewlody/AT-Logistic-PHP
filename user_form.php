<?php
require_once('class.php');
require_once('function.php');
$db = new cl;
$acton = get('action');
$usercode = get('usercode');
$userpass = '';
$username = '';
$surname = '';
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
u.comCode,
u.usercode,
u.userpass,
u.username,
u.surname,
u.userTypecode,
u.isActive,
u.createID,
u.createTime,
u.img_sinal,
u.editID,
u.editTime
FROM $db->dbname.`user` AS u
WHERE u.comCode='$db->comCode' AND u.usercode='$usercode' ";

if ($r = $db->fetch($sql)) {
  $userpass = $r['userpass'];
  $username = $r['username'];
  $surname = $r['surname'];
  $userTypecode = $r['userTypecode'];
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

        userTypecode: {
          required: true
        },
        usercode: {
          required: true
        },
        userpass: {
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
          url: "user_action.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(data) {

            console.log("Result : ", data);
            var obj = jQuery.parseJSON(data);
            // $("#chargeCode").val(obj.result);
            var dataresult = obj.result;
            if (dataresult == 'success') {
              $("#usercode").val(obj.documentID);
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


  });
</script>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>User / ผู้ใช้งาน</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item">Administrator</li>
      <li class="breadcrumb-item"> <a>User</a> </li>
      <li class="breadcrumb-item"> <a>User Form</a></li>
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
                <h3><a>User</a> info</h3>
              </label>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label"><a>User</a> Code</label>
              <div class="col-md-2">
                <input type="text" name="usercode" id="usercode" value="<?php echo $usercode; ?>" <?php if ($acton != 'add') {
                                                                                                    echo 'readonly';
                                                                                                  } ?> class="form-control">
              </div>
            </div>

            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-2">
                <input type="password" name="userpass" id="userpass" value="<?php echo $userpass; ?>" class="form-control">
                  
                  <input type="hidden" name="checkPass" id="checkPass" value="<?php echo $userpass; ?>">
              </div>
            </div>

            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-2">
                <input type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>">
              </div>
            </div>


            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Surname</label>
              <div class="col-sm-2">
                <input type="text" name="surname" id="surname" class="form-control" value="<?php echo $surname; ?>">
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">User Type</label>
              <div class="col-sm-2">
                <select class="select2_single form-control select2" name="userTypecode" id="userTypecode" <?php if($_SESSION['userTypecode']!='1'){ echo 'disabled';}  ?> >
                  <?php echo $db->s_userType($userTypecode); ?>
                </select>
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
                <label>admin 1/1/2021 : 03:12:20</label>
              </div>
            </div>

            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Update By</label>
              <div class="col-sm-10">

                <label>admin 1/1/2021 : 03:12:20</label>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group row">
              <div class="col-sm-4 col-sm-offset-2">
                <button name="back" class="btn btn-white" type="button" onclick="window.location='user'"><i class="fa fa-reply"></i> Back</button>
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