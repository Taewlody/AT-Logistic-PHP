<?php
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$acton=get('action');
$comCode='';
$isActive='1';
$empCode=get('empCode');
$empName='';
$empSurname='';
$usercode='';
$mobile='';
$phone='';
$email='';
$createID='';
$createTime='';
$editID='';
$editTime='';
$readonly='';

if($acton=='view'){ $disabled='disabled';}else{$disabled='';}
 $sql=" SELECT * FROM $db->dbname.common_saleman AS c WHERE c.comCode='$db->comCode' AND c.empCode='$empCode' ";
if($r=$db->fetch($sql)){

  $empCode=$r['empCode'];
  $empName=$r['empName'];
  $empSurname=$r['empSurname'];
  $usercode=$r['usercode'];
  $mobile=$r['mobile'];
  $phone=$r['phone'];
  $readonly='readonly';	
  $email=$r['email'];
  $createID=$r['createID'];
  $createTime=$r['createTime'];
  $editID=$r['editID'];
  $editTime=$r['editTime'];
}


?>
<script>
  $(document).ready(function(){  
$('.select2_single').select2({});
    $("#form").validate({
                rules: {
                  empCode: {required: true },
                  empName: {required: true },
                  empSurname: {required: true }
                 }
     });
	  
$("#save").click(function (event) {
        event.preventDefault();
		if($('#form').valid()){
        var form = $('#form')[0];
        var data = new FormData(form);
        data.append("CustomField", "This is some extra data, testing");
		// disabled the submit button
        $("#save").prop("disabled", true);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "saleman_action.php",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
      
              var obj = jQuery.parseJSON(data);
             // $("#chargeCode").val(obj.result);
              var dataresult=obj.result;
              if(dataresult=='success'){
                $("#empCode").val(obj.documentID);
                $("#action").val('edit');
                msgSuccess();
              }else{
                 msgError();
              }
                console.log("SUCCESS : ", dataresult);
                $("#save").prop("disabled", false);
				
            },
            error: function (e) {
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
    <h2>Saleman / พนักงานขาย</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Common Data</a></li>
      <li class="breadcrumb-item"> <a>Saleman</a> </li>
      <li class="breadcrumb-item"> <a>Saleman Form</a></li>
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
          <form method="get" id="form" name="form">
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">
                <h3>Saleman info</h3>
              </label>

            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Employee Code</label>
              <div class="col-md-2">
                <input type="text" name="empCode" id="empCode"  autocomplete="empty" class="form-control" value="<?php echo $empCode;?>"  <?php echo $readonly;?>>
              </div>
            </div>



            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Name</label>
              <div class="col-md-3">
                <input type="text" class="form-control" name="empName" id="empName"  autocomplete="empty" value="<?php echo $empName;?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Surname</label>
              <div class="col-md-3">
                <input type="text" class="form-control" name="empSurname" id="empSurname"  autocomplete="empty" value="<?php echo $empSurname;?>">
              </div>
            </div>



            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Mobile</label>
              <div class="col-md-3">
                <input type="text" class="form-control" name="mobile" id="mobile" autocomplete="empty" value="<?php echo $mobile;?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">E-Mail</label>
              <div class="col-md-3">
                <input type="text" class="form-control" name="email" id="email"  autocomplete="empty" value="<?php echo $email;?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Phone</label>
              <div class="col-md-3">
                <input type="text" class="form-control" name="phone" id="phone"  autocomplete="off" value="<?php echo $phone;?>">
              </div>
            </div>
 
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Refer User ID</label>
              <div class="col-md-3">
                <select class="select2_single form-control select2" name="usercode" id="usercode">
                   <?php $db->s_user($usercode);?>
                </select>
              </div>
            </div>






 
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Status</label>
              <div class="col-sm-10">
                <label class="checkbox-inline i-checks">
                  <input type="radio" name="isActive" value="1" <?php if($isActive==1){ echo 'checked';}?> >
                  Active </label>
                <label class="i-checks">
                  <input type="radio" name="isActive" value="0" <?php if($isActive==0){ echo 'checked';}?> >
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
                 <button name="back" class="btn btn-white" type="button" onclick="window.location='saleman'"><i class="fa fa-reply"></i> Back</button>
                <button name="save" id="save" class="btn btn-primary" type="button"<?php echo $disabled;?>  ><i class="fa fa-save"></i> Save</button>
                <input type="hidden" name="action" id="action" value="<?php echo $acton;?>">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  END Body-->