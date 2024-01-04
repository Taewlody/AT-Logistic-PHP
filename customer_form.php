<?php
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$acton=get('action');

$cusCode=get('cusCode');
$businessType='';
$custNameTH='';
$custNameEN='';
$branchCode='';
$branchTH='';
$branchEN='';
$creditDay='';
$taxID='';
$salemanID='';
$addressTH='';
$addressEN='';
$zipCode='';
$countryCode='';
$tel='';
$fax='';
$mobile='';
$isActive='1';
$contactName='';
$contactMobile='';
$contactEmail='';
$createID='';
$createTime='';
$editID='';
$editTime='';

if($acton=='view'){ $disabled='disabled';}else{$disabled='';}
 $sql=" SELECT * FROM $db->dbname.common_customer AS c WHERE c.comCode='$db->comCode' AND c.cusCode='$cusCode' ";
if($r=$db->fetch($sql)){
$cusCode=$r['cusCode'];
$businessType=$r['businessType'];
$custNameTH=$r['custNameTH'];
$custNameEN=$r['custNameEN'];
$branchCode=$r['branchCode'];
$branchTH=$r['branchTH'];
$branchEN=$r['branchEN'];
$creditDay=$r['creditDay'];
$taxID=$r['taxID'];
$salemanID=$r['salemanID'];
$addressTH=$r['addressTH'];
$addressEN=$r['addressEN'];
$zipCode=$r['zipCode'];
$countryCode=$r['countryCode'];
$tel=$r['tel'];
$fax=$r['fax'];
$mobile=$r['mobile'];
$isActive=$r['isActive'];
$contactName=$r['contactName'];
$contactMobile=$r['contactMobile'];
$contactEmail=$r['contactEmail'];
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
              
                  custNameTH: {required: true },
                  salemanID: {required: true },
                countryCode: {required: true },
                 
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
            url: "customer_action.php",
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
                $("#cusCode").val(obj.documentID);
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
    <h2>Customer / ลูกค้า</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Common Data</a></li>
      <li class="breadcrumb-item"> <a>Customer</a> </li>
      <li class="breadcrumb-item"> <a>Customer Form</a></li>
    </ol>
  </div>
  <div class="col-lg-2"> </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight"> <!-- Body-->
  
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox ">
        <div class="ibox-content">
          <form  name="form" id="form" action="" enctype="multipart/form-data" method="post">
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">
              <h3>Customer info</h3>
              </label>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Customer Code</label>
              <div class="col-md-2">
                <input type="text" name="cusCode" id="cusCode" class="form-control" value="<?php echo $cusCode;?>" readonly>
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Business Type</label>
              <div class="col-md-2">
                 <select class="select2_single form-control select2" name="businessType" id="businessType" >
                  <option value="1">Corporation</option>
                  <option value="2">individual</option>
                </select>
				  
				
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Customer Name</label>
              <div class="col-md-4">
                <input type="text"  name="custNameTH" id="custNameTH" value="<?php echo $custNameTH;?>" autocomplete="empty"  placeholder="Name (TH)" class="form-control">
              </div>
          
                <div class="col-md-4">
                <input type="text"  name="custNameEN" id="custNameEN"  value="<?php echo $custNameEN;?>" placeholder="Name (EN)" class="form-control">
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Branch Code</label>
              <div class="col-md-2">
                <input type="text"  name="branchCode" id="branchCode"  value="<?php echo $branchCode;?>" autocomplete="empty"   class="form-control">
              </div>
   
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Branch Name</label>
           
                
                
               <div class="col-md-4">
              <input type="text"  name="branchTH"  id="branchTH" autocomplete="empty"  value="<?php echo $branchTH;?>" placeholder="Branch (TH)" class="form-control">
              </div>
                
                
              <div class="col-md-4">
                <input type="text"  name="branchEN"  id="branchEN" autocomplete="empty"  value="<?php echo $branchEN;?>"placeholder="Branch (EN)" class="form-control">
              </div>
            </div>
       
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Address</label>
              <div class="col-sm-10">
                <input name="addressTH" type="text" class="form-control" id="addressTH"  value="<?php echo $addressTH;?>" autocomplete="empty" placeholder="Address (TH)">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"></label>
              <div class="col-sm-10">
                <input name="addressEN" type="text" class="form-control" id="addressEN"  value="<?php echo $addressEN;?>"autocomplete="empty" placeholder="Address (EN)">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Zip Code</label>
              <div class="col-md-2">
                <input type="number" class="form-control" name="zipCode" autocomplete="empty"   value="<?php echo $zipCode;?>" id="zipCode">
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Country</label>
              <div class="col-md-2">
               <select class="select2_single form-control select2" name="countryCode" id="countryCode" >
                <?php echo $db->s_country($countryCode);?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Tax ID</label>
              <div class="col-md-2">
                <input type="number" class="form-control" name="taxID" autocomplete="empty"  value="<?php echo $taxID;?>"id="taxID">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Fax</label>
              <div class="col-md-2">
                <input type="text" class="form-control" name="fax" autocomplete="empty" value="<?php echo $fax;?>"id="fax">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Phone</label>
              <div class="col-md-2">
                <input type="text" class="form-control" name="tel" autocomplete="empty"  value="<?php echo $tel;?>"id="tel">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Mobile</label>
              <div class="col-md-2">
                <input type="text" class="form-control" name="mobile" autocomplete="empty"  value="<?php echo $mobile;?>"id="mobile">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Credit (Day)</label>
              <div class="col-md-2">
                <select name="creditDay" class="select2_single form-control select2" id="creditDay">
                  <?php $db->s_credit_term($creditDay); ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Sale</label>
              <div class="col-md-2">
              <select name="salemanID" class="select2_single form-control select2" id="salemanID">
              <?php echo $db->s_saleman($salemanID); ?>
       
            </select>
                  
              
                  
              </div>
            </div>
			  <div class="form-group  row">
              <label class="col-sm-2 col-form-label">
              <h3>Contact Person info</h3>
              </label>
              <div class="col-md-2"> </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Contact Name</label>
              <div class="col-md-2">
                <input type="text" class="form-control" name="contactName" autocomplete="empty" value="<?php echo $contactName;?>" id="contactName">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Mobile</label>
              <div class="col-md-2">
                <input type="text" class="form-control" name="contactMobile" autocomplete="empty"  value="<?php echo $contactMobile;?>"id="contactMobile">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">E-Mail</label>
              <div class="col-md-2">
                <input type="email" class="form-control" name="contactEmail" autocomplete="empty" value="<?php echo $contactEmail;?>" id="contactEmail">
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
            </div>        <div class="form-group  row">
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
              <div class="col-sm-4 col-sm-offset-2">
                  <button name="back" class="btn btn-white" type="button" onclick="window.location='customer'"><i class="fa fa-reply"></i> Back</button>
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