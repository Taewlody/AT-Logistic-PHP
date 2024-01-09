<?php
//session_start();
unset( $_SESSION[ 'chargeCode' ] );
require_once( 'class.php' );
require_once( 'function.php' );
$db = new cl;
$acton = get( 'action' );
$documentID = get( 'documentID' );
$documentDate = date( 'd/m/Y' );
$bound = '';
$freight = '';
$port_of_landing = '';
$port_of_discharge = '';
$mbl = '';
$hbl = '';
$co = '';
$paperless = '';
$bill_of_landing = '';
$import_entry = '';
$etdDate = date( 'd/m/Y' );
$etaDate = date( 'd/m/Y' );
$closingDate = date( 'd/m/Y' );
$closingTime = '';
$invNo = '';
$bill = '';
$bookingNo = '';
$deliveryType = '';
$saleman = '';
$cusCode = '';
$cusContact = '';
$agentCode = '';
$agentContact = '';
$feeder = '';
$vessel = '';
$note = '';
$stu_location = '';
$stu_contact = '';
$stu_mobile = '';
$stu_date = date( 'd/m/Y' );
$cy_location = '';
$cy_contact = '';
$cy_mobile = '';
$cy_date = date( 'd/m/Y' );
$rtn_location = '';
$rtn_contact = '';
$rtn_mobile = '';
$rtn_date = date( 'd/m/Y' );
$createID = '';
$createTime = date( 'd/m/Y' );
$editID = '';
$editTime = date( 'd/m/Y' );
$billOfladingNo = '';
$trailer_bookingNO = '';

if ( $acton == 'view' ) {
  $disabled = 'disabled';
} else {
  $disabled = '';
}

$sql = " SELECT * FROM $db->dbname.joborder AS c WHERE c.comCode='$db->comCode' AND c.documentID='$documentID' ";
if ( $r = $db->fetch( $sql ) ) {
  $documentID = $r[ 'documentID' ];
  $documentDate = $r[ 'documentDate' ];
  $bound = $r[ 'bound' ];
  $freight = $r[ 'freight' ];
  $port_of_landing = $r[ 'port_of_landing' ];
  $port_of_discharge = $r[ 'port_of_discharge' ];
  $mbl = $r[ 'mbl' ];
  $hbl = $r[ 'hbl' ];
  $co = $r[ 'co' ];
  $paperless = $r[ 'paperless' ];
  $bill_of_landing = $r[ 'bill_of_landing' ];
  $import_entry = $r[ 'import_entry' ];
  $etdDate = $r[ 'etdDate' ];
  $etaDate = $r[ 'etaDate' ];
  $closingDate = $r[ 'closingDate' ];
  $closingTime = $r[ 'closingTime' ];
  $invNo = $r[ 'invNo' ];
  $bill = $r[ 'bill' ];
  $bookingNo = $r[ 'bookingNo' ];
  $deliveryType = $r[ 'deliveryType' ];
  $saleman = $r[ 'saleman' ];
  $cusCode = $r[ 'cusCode' ];
  $cusContact = $r[ 'cusContact' ];
  $agentCode = $r[ 'agentCode' ];
  $agentContact = $r[ 'agentContact' ];
  $feeder = $r[ 'feeder' ];
  $vessel = $r[ 'vessel' ];
  $note = $r[ 'note' ];
  $stu_location = $r[ 'stu_location' ];
  $stu_contact = $r[ 'stu_contact' ];
  $stu_mobile = $r[ 'stu_mobile' ];
  $stu_date = $r[ 'stu_date' ];
  $cy_location = $r[ 'cy_location' ];
  $cy_contact = $r[ 'cy_contact' ];
  $cy_mobile = $r[ 'cy_mobile' ];
  $cy_date = $r[ 'cy_date' ];
  $rtn_location = $r[ 'rtn_location' ];
  $rtn_contact = $r[ 'rtn_contact' ];
  $rtn_mobile = $r[ 'rtn_mobile' ];
  $rtn_date = $r[ 'rtn_date' ];
  $documentstatus = $r[ 'documentstatus' ];
  $createID = $r[ 'createID' ];
  $createTime = $r[ 'createTime' ];
  $editID = $r[ 'editID' ];
  $editTime = $r[ 'editTime' ];
  $good_total_num_package = $r[ 'good_total_num_package' ];
  $good_commodity = $r[ 'good_commodity' ];


  $billOfladingNo = $r[ 'billOfladingNo' ];
  $trailer_bookingNO = $r[ 'trailer_bookingNO' ];

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

    var rowIdx_atach = 1;

    
    $("#deliveryType").change(function() {
  
        if($(this).val()=='fcl'){
          
          $('#cy_location,#cy_contact,#cy_mobile,#cy_date').prop('readonly', false);
          $('#rtn_location,#rtn_contact,#rtn_mobile,#rtn_date').prop('readonly', false);
        }else if($(this).val()=='lcl'){
           $('#cy_location,#cy_contact,#cy_mobile,#cy_date').prop('readonly', true);
           $('#rtn_location,#rtn_contact,#rtn_mobile,#rtn_date').prop('readonly', true);

           $('#cy_location,#cy_contact,#cy_mobile').val('');
           $('#rtn_location,#rtn_contact,#rtn_mobile').val('');
        }
        
    });

$( "#stu_location" ).keyup(function() {
      if($( "#stu_location" ).val()!=''){
          $('#cy_location,#cy_contact,#cy_mobile,#cy_date').prop('readonly', true);
           $('#rtn_location,#rtn_contact,#rtn_mobile,#rtn_date').prop('readonly', true);
      }else{

         $('#cy_location,#cy_contact,#cy_mobile,#cy_date').prop('readonly', false);
          $('#rtn_location,#rtn_contact,#rtn_mobile,#rtn_date').prop('readonly', false);
      }
});








    $("#btnUpload").click(function(event) {
      if ($("#cusCode").val() == '') {
        swal({
          title: "Warning",
          text: "กรุณาเลือกลูกค้า",
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
          text: "อัพโหลดได้เฉพาะไฟล์ jpg เท่านั้น",
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
        url: "job_action_upload.php",
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
              " <td>" + rowIdx_atach + "<input type='hidden' name='imgKey[]'  value='"+obj.fileName+"' id='imgKey" + rowIdx_atach + "'></td> " +
              " <td><input type='text' name='fileName[]' class='form-control' value='" + $("#attach_name").val() + "' id='fileName" + rowIdx_atach + "'></td>  " +
              " <td class='center'> <a class='btn-white btn btn-xs' href='customer_path/C-0001/"+obj.fileName+"' target='_blank'>View</a> </button>&nbsp;<button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(" + rowIdx_atach + ")'>Remove</button></td>  " +
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




    var rowIdx = 1;
    $("#addCharge").click(function(event) {


      $("#table_charge").append(" <tr class='gradeX' id='tr" + rowIdx + "'> " +
        " <td>" + rowIdx + "<input type='hidden' name='chargeitems[]'  value='" + $("#chargeCode").val() + "' id='chargeitems" + rowIdx + "'></td> " +
        " <td><input type='text' name='chargesDetail[]' class='form-control' value='" + $("#chargeCode option:selected" ).text() + "' id='chargesDetail" + rowIdx + "'></td>  " +
        " <td class='center'><div id='containner" + rowIdx + "'></div></td>" +
        " <td class='center'><input type='number' name='chargesCost[]'  class='form-control' value='0' id='chargesCost" + rowIdx + "'></td>  " +
        " <td class='center'><input type='number' name='chargesPrice[]'  class='form-control' value='0' id='chargesPrice" + rowIdx + "'></td>  " +
        " <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(" + rowIdx + ")'>Remove</button></td>  " +
        " </tr>");
      $('#containner' + rowIdx).load('job_form_loadcharge.php');
      $('.select2_single').select2({});

      rowIdx++;
      $('.select2_single').select2({});
    });


    

    $('.select2_single').select2({});
    $("#form").validate({
      rules: {
        /*
             countryCode: {required: true },
             freight: {required: true }
           */

      }
    });
    $('.input-group.date').datepicker({
      todayBtn: "linked",
      keyboardNavigation: false,
      forceParse: false,
      calendarWeeks: true,
      autoclose: true

    });

    $('.clockpicker').clockpicker();

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
          url: "job_action.php",
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


    $("#btnbill_of_lading").click(function(event) {
      if($("#documentID").val()=="")return false;

        var documentID=$("#documentID").val();
        var billOfladingNo=$("#billOfladingNo").val();
        var cusCode=$("#cusCode").val();
          if(billOfladingNo==""){
              window.open('bill_of_lading_form?action=add&jobID='+documentID+'&cusCode='+cusCode,'_blank');
          }else{
              window.open('bill_of_lading_form?action=edit&documentID='+billOfladingNo,'_blank');
          }
    });

    $("#trailer_booking").click(function(event) {
      if($("#documentID").val()=="")return false;

        var documentID=$("#documentID").val();
        var trailer_booking=$("#trailer_bookingNO").val();
        var cusCode=$("#cusCode").val();
          if(trailer_booking==""){
              window.open('trailer_booking_form?action=add&jobID='+documentID+'&cusCode='+cusCode,'_blank');
          }else{
              window.open('trailer_booking_form?action=edit&documentID='+trailer_booking,'_blank');
          }
    });  




  });

  function FN_attach_view(filename){
    var filename;
    alert(filename);
  }


  function FN_Remove_Table(rowID) {
    $("#tr" + rowID).remove();
  }

  function FN_ClearLocation(rowID) {
    $("#containerType" + rowID).val('').trigger('change');
    $("#containerSize" + rowID).val("").trigger('change');
    $("#containerNo" + rowID).val("");
    $("#containerSealNo" + rowID).val("");
    $("#containerGW" + rowID).val("");
    $("#containerGW_unit" + rowID).val("").trigger('change');
    $("#containerNW" + rowID).val("");
    $("#containerNW_Unit" + rowID).val("").trigger('change');
    $("#containerTareweight" + rowID).val("");
  }

  function FN_ClearPacked(rowID) {
    $("#packaed_width" + rowID).val("");
    $("#packaed_length" + rowID).val("");
    $("#packaed_height" + rowID).val("");
    $("#packaed_qty" + rowID).val("");
    $("#packaed_weight" + rowID).val("");
    $("#packaed_unit" + rowID).val("").trigger('change');
    $("#packaed_totalCBM" + rowID).val("");
    $("#packaed_totalWeight" + rowID).val("");

  }

  function FN_CalPacked(rowID) {
    var var_width = $("#packaed_width" + rowID).val();
    var var_length = $("#packaed_length" + rowID).val();
    var var_height = $("#packaed_height" + rowID).val();
    var var_weight = $("#packaed_weight" + rowID).val();
    var var_qty = $("#packaed_qty" + rowID).val();

    if (var_width > 0 && var_length > 0 && var_height > 0 && var_weight > 0) {
      var cbm = parseFloat((parseFloat(var_width) * parseFloat(var_length) * parseFloat(var_height)) / 1000000);
      var total = parseFloat(parseFloat(var_weight) * parseFloat(var_length));
      $("#packaed_totalCBM" + rowID).val(cbm);
      $("#packaed_totalWeight" + rowID).val(total);
      return true;
    } else {
      return false;
    }
  }



  function FN_ClearGoods(rowID) {

    $("#goodNo" + rowID).val("");
    $("#goodDec" + rowID).val("");
    $("#goodWeight" + rowID).val("");
    $("#good_unit" + rowID).val("").trigger('change');
    $("#goodSize" + rowID).val("");
    $("#goodKind" + rowID).val("");

  }
</script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-6">
    <h2>Job Order / ใบสั่งงาน</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Sale</a></li>
      <li class="breadcrumb-item"> <a>Job Order</a> </li>
      <li class="breadcrumb-item"> <a>Job Order Form</a></li>
    </ol>
  </div>
  <div class="col-lg-6">
    <div class="file-box">
      <div class="file"> <a href="#">
        <div class="icon"> <i class="fa fa-file-text "></i> </div>
        <div class="file-name text-navy"> Invoice <small>IV2106-0001</small> </div>
        <input type="hidden" name="invNo" id="invNo" value="<?php echo $billOfladingNo; ?>">
        </a> </div>
    </div>
    <div class="file-box">
      <div class="file"> <a id="btnbill_of_lading">
        <div class="icon"> <i class="fa fa-file-text  <?php if($billOfladingNo!=''){ echo "text-navy";}?> "></i> </div>
        <div class="file-name text-navy"> Bill of landing <small><?php echo $billOfladingNo;?></small> </div>
        <input type="hidden" name="billOfladingNo" id="billOfladingNo" value="<?php echo $billOfladingNo; ?>">
        </a> </div>
    </div>
    <div class="file-box">
      <div class="file"> <a id="trailer_booking">
        <div class="icon"> <i class="fa fa-file-text <?php if($trailer_bookingNO!=''){ echo "text-navy";}?> "></i> </div>
        <div class="file-name text-navy"> Trailer Booking <small><?php echo $trailer_bookingNO;?></small> </div>
        <input type="hidden" name="trailer_bookingNO" id="trailer_bookingNO" value="<?php echo $trailer_bookingNO; ?>">
        </a> </div>
    </div>
  </div>
</div>
<form name="form" id="form" action="" enctype="multipart/form-data" method="post">
  <div class="wrapper wrapper-content animated fadeInRight"> 
    <!-- Body-->
    
    <div class="row">
      <div class="col-lg-7">
        <div class="ibox ">
          <div class="ibox-title">
            <h2>Document</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Document No.</label>
              <div class="col-md-4">
                <input name="documentID" type="text" class="form-control" id="documentID" value="<?php echo $documentID;?>" readonly="readonly">
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Document Date</label>
              </div>
              <div class="col-lg-4">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" name="documentDate" class="form-control" value="<?php echo $documentDate; ?>">
                </div>
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Bound</label>
              <div class="col-md-4">
                <select name="bound" class="select2_single form-control select2" id="bound">
                  <option value="1">IN BOUND</option>
                  <option value="2">OUT BOUND</option>
                </select>
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Freight</label>
              </div>
              <div class="col-md-4">
                <select name="freight" class="select2_single form-control select2" id="freight">
                  <?php $db->s_freight($freight); ?>
                </select>
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Port of Loading</label>
              <div class="col-md-4">
                <select name="port_of_landing" class="select2_single form-control select2" id="port_of_landing">
                  <?php $db->s_port($port_of_landing); ?>
                </select>
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Port of Discharge </label>
              </div>
              <div class="col-md-4">
                <select name="port_of_discharge" class="select2_single form-control select2" id="port_of_discharge">
                  <?php $db->s_port($port_of_discharge); ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">M B/L</label>
              <div class="col-md-4">
                <input type="text" name="mbl" class="form-control" id="mbl">
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">H B/L</label>
              </div>
              <div class="col-md-4">
                <input type="text" name="hbl" class="form-control" id="hbl">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">C/O</label>
              <div class="col-md-4">
                <input type="text" name="co" class="form-control" id="co">
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Paper Less Code</label>
              </div>
              <div class="col-md-4">
                <input type="text" name="paperless" class="form-control" id="paperless">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Bill of landing</label>
              <div class="col-md-4">
                <input type="text" name="bill_of_landing" class="form-control" id="bill_of_landing">
              </div>
              <label class="col-lg-2 col-form-label">Import Entry</label>
              <div class="col-md-4">
                <input type="text" name="import_entry" class="form-control" id="import_entry">
              </div>
            </div>
            <div class="form-group row date">
              <label class="col-lg-2 col-form-label">ETD</label>
              <div class="col-lg-4">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" name="etaDate" class="form-control" value="<?php echo $etaDate; ?>">
                </div>
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">ETA</label>
              </div>
              <div class="col-lg-4">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input name="etaDate" type="text" class="form-control" value="<?php echo $etaDate; ?>">
                </div>
              </div>
            </div>
            <div class="form-group row date">
              <label class="col-lg-2 col-form-label">Closing Date</label>
              <div class="col-lg-4">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input name="closingDate" type="text" class="form-control" id="closingDate" value="<?php echo $closingDate; ?>">
                </div>
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Time</label>
              </div>
              <div class="col-lg-4">
                <div class="input-group clockpicker" data-autoclose="true">
                  <input name="closingTime" type="text" class="form-control" id="closingTime" value="09:30">
                  <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span> </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">INV No.</label>
              <div class="col-md-4">
                <input type="text" name="invNo" class="form-control" id="invNo">
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Bill</label>
              </div>
              <div class="col-md-4">
                <input type="text" name="bill" class="form-control" id="bill">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Booking No.</label>
              <div class="col-md-4">
                <input type="text" name="bookingNo" class="form-control" id="bookingNo">
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Delivery Type</label>
              </div>
              <div class="col-md-4">
                <select name="deliveryType" class="select2_single form-control select2" id="deliveryType">
                  <option value="fcl">FCL</option>
                  <option value="lcl">LCL</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">FOB AT</label>
              <div class="col-md-4">
                <select name="fob" class="select2_single form-control select2" id="fob">
                  <?php $db->s_place('');?>
                </select>
              </div>
              <div class="col-md-2">
                <label class="col-form-label" style="padding-top: 5px;">Place of receive </label>
              </div>
              <div class="col-md-4">
                <select name="place_receive" class="select2_single form-control select2" id="place_receive">
                  <?php $db->s_place('');?>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="ibox ">
          <div class="ibox-title">
            <h2>Sale / Customer / Agent / Feeder</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content">
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Sales</label>
              <div class="col-md-10">
                <select name="saleman" class="select2_single form-control select2" id="saleman">
                  <?php $db->s_saleman($_SESSION['userID']); ?>
                </select>
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Customer</label>
              <div class="col-md-10">
                <select name="cusCode" class="select2_single form-control select2" id="cusCode">
                  <?php $db->s_customer("$cusCode"); ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Contact</label>
              <div class="col-md-10">
                <input type="text" name="cusContact" class="form-control" id="cusContact">
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Agent</label>
              <div class="col-md-10">
                <select name="agentCode" class="select2_single form-control select2" id="agentCode">
                  <?php $db->s_supplier("$agentCode"); ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Contact</label>
              <div class="col-md-10">
                <input type="text" name="agentContact" class="form-control" id="agentContact">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Feeder</label>
              <div class="col-md-10">
                <select name="feeder" class="select2_single form-control select2" id="feeder">
                  <?php $db->s_supplier("$feeder"); ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Vessel</label>
              <div class="col-md-10">
                <input type="text" name="vessel" class="form-control" id="vessel">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Note</label>
              <div class="col-md-10">
                <textarea name="note" rows="4" class="form-control" id="note"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label"></label>
              <div class="col-md-10"> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="ibox ">
          <div class="ibox-title">
            <h2>Location</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content collapse">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Stuffing</label>
              <div class="col-md-3">
                <input type="text" name="stu_location" class="form-control" placeholder="location" id="stu_location">
              </div>
              <div class="col-md-3">
                <input name="stu_contact" type="text" class="form-control" id="stu_contact" placeholder="Contact Person" autocomplete="empty">
              </div>
              <div class="col-md-2">
                <input type="text" name="stu_mobile" class="form-control" placeholder="Mobile" id="stu_mobile">
              </div>
              <div class="col-md-2">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" name="stu_date" class="form-control" value="<?php echo $stu_date; ?>">
                </div>
              </div>
            </div>
            <div class="form-group row" >
              <label class="col-lg-2 col-form-label">CY</label>
              <div class="col-md-3">
                <input type="text" name="cy_location" class="form-control" placeholder="location" id="cy_location">
              </div>
              <div class="col-md-3">
                <input type="text" name="cy_contact" class="form-control" placeholder="Contact Person" id="cy_contact" autocomplete="empty">
              </div>
              <div class="col-md-2">
                <input type="text" name="cy_mobile" class="form-control" placeholder="Mobile" id="cy_mobile">
              </div>
              <div class="col-md-2">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar "></i></span>
                  <input type="text" name="cy_date" id="cy_date" class="form-control" value="<?php echo $cy_date; ?>">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">RTN</label>
              <div class="col-md-3">
                <input type="text" name="rtn_location" class="form-control" placeholder="location" id="rtn_location">
              </div>
              <div class="col-md-3">
                <input type="text" name="rtn_contact" class="form-control" placeholder="Contact Person" id="rtn_contact" autocomplete="empty">
              </div>
              <div class="col-md-2">
                <input type="text" name="rtn_mobile" class="form-control" placeholder="Mobile" id="rtn_mobile">
              </div>
              <div class="col-md-2">
                <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="text" name="rtn_date" id="rtn_date" class="form-control" value="<?php echo $rtn_date; ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="ibox ">
          <div class="ibox-title">
            <h2>Containers</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content collapse">
            <div class="form-group">
              <div class="table-responsive">
                <table id="table_container" class="table" width="100%">
                  <thead>
                    <tr>
                      <th style="width:5%">No.</th>
                      <th style="width:10%">Container&nbsp;Type</th>
                      <th style="width:10%">Size</th>
                      <th style="width:10%">Container&nbsp;No.</th>
                      <th style="width:10%">Seal&nbsp;No.</th>
                      <th style="width:10%">Gross Weight</th>
                      <th style="width:10%">GW.Unit</th>
                      <th style="width:10%"> Net Weight</th>
                      <th style="width:10%">NW.Unit</th>
                      <th style="width:10%">Tare Weight</th>
                      <th style="width:10%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 1;
                    while ( $i <= 5 ) {
                      ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><div class="col-md-12">
                          <select name="containerType[]" class="select2_single form-control select2" id="containerType<?php echo $i; ?>" style="width: 100%">
                            <?php $db->s_containerType(); ?>
                          </select>
                        </div></td>
                      <td><select name="containerSize[]" id="containerSize<?php echo $i; ?>" class="select2_single form-control select2" style="width: 100%">
                          <?php $db->s_containerSize(); ?>
                        </select></td>
                      <td><input type="text" name="containerNo[]" id="containerNo<?php echo $i; ?>" class="form-control" value=""></td>
                      <td class="center"><input type="text" name="containerSealNo[]" id="containerSealNo<?php echo $i; ?>" class="form-control" value=""></td>
                      <td class="center"><input type="number" name="containerGW[]" id="containerGW<?php echo $i; ?>" class="form-control" value=""></td>
                      <td class="center"><select name="containerGW_unit[]" id="containerGW_unit<?php echo $i; ?>" class="select2_single form-control select2" style="width: 100%">
                          <?php $db->s_unit(); ?>
                        </select></td>
                      <td class="center"><input type="text" name="containerNW[]" id="containerNW<?php echo $i; ?>" class="form-control" value=""></td>
                      <td class="center"><select name="containerNW_Unit[]" id="containerNW_Unit<?php echo $i; ?>" class="select2_single form-control select2" style="width: 100%">
                          <?php $db->s_unit(); ?>
                        </select></td>
                      <td class="center"><input type="text" name="containerTareweight[]" id="containerTareweight<?php echo $i; ?>" class="form-control" value=""></td>
                      <td class="center"><button type="button" class="btn-white btn btn-xs" onClick="return FN_ClearLocation('<?php echo $i; ?>');">Clear</button></td>
                    </tr>
                    <?php
                    $i++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- <a id="addContainer"  class="btn btn-white btn-xs"><i class="fa fa-plus "> </i> Add New Row </a>--> 
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="ibox ">
          <div class="ibox-title">
            <h2>Packaed Size</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content collapse">
            <div class="form-group">
              <div class="table-responsive">
                <table class="table dataTables" width="100%">
                  <thead>
                    <tr>
                      <th style="width:5%">No.</th>
                      <th style="width:10%">Width (cm)</th>
                      <th style="width:10%">Length (cm)</th>
                      <th style="width:10%">Height (cm)</th>
                      <th style="width:10%">Quantity Package</th>
                      <th style="width:10%">Weight/Package</th>
                      <th style="width:10%">Unit Weight</th>
                      <th style="width:10%">Total (CBM)</th>
                      <th style="width:10%">Total Weight</th>
                      <th style="width:10%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 1;
                    while ( $i <= 5 ) {
                      ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><span class="center">
                        <input type="number" name="packaed_width[]" class="form-control" value="" id="packaed_width<?php echo $i; ?>" onchange="return FN_CalPacked('<?php echo $i; ?>');">
                        </span></td>
                      <td><span class="center">
                        <input type="number" name="packaed_length[]" class="form-control" value="" id="packaed_length<?php echo $i; ?>" onchange="return FN_CalPacked('<?php echo $i; ?>');">
                        </span></td>
                      <td><input type="number" name="packaed_height[]" class="form-control" value="" id="packaed_height<?php echo $i; ?>" onchange="return FN_CalPacked('<?php echo $i; ?>');"></td>
                      <td class="center"><input type="number" name="packaed_qty[]" class="form-control" value="" id="packaed_qty<?php echo $i; ?>" onchange="return FN_CalPacked('<?php echo $i; ?>');"></td>
                      <td class="center"><input type="number" name="packaed_weight[]" class="form-control" value="" id="packaed_weight<?php echo $i; ?>" onchange="return FN_CalPacked('<?php echo $i; ?>');"></td>
                      <td class="center"><select name="packaed_unit[]" class="select2_single form-control select2" style="width: 100%" id="packaed_unit<?php echo $i; ?>" onchange="return FN_CalPacked('<?php echo $i; ?>');">
                          <?php $db->s_unit(); ?>
                        </select></td>
                      <td class="center"><input type="number" readonly name="packaed_totalCBM[]" class="form-control" value="" id="packaed_totalCBM<?php echo $i; ?>"></td>
                      <td class="center"><input type="number" readonly name="packaed_totalWeight[]" class="form-control" value="" id="packaed_totalWeight<?php echo $i; ?>"></td>
                      <td class="center"><button type="button" class="btn-white btn btn-xs" onClick="return FN_ClearPacked('<?php echo $i; ?>');">Clear</button></td>
                    </tr>
                    <?php
                    $i++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- <a href="job_form" class="btn btn-white btn-xs"><i class="fa fa-plus "> </i> Add New Row </a>--> 
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="ibox ">
          <div class="ibox-title">
            <h2>Goods / สินค้า</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content collapse">
            <div class="form-group">
              <div class="table-responsive">
                <table class="table" width="100%">
                  <thead>
                    <tr>
                      <th style="width:5%">No.</th>
                      <th style="width:10%">No of Package</th>
                      <th style="width:10%">Description</th>
                      <th style="width:10%">Weight</th>
                      <th style="width:10%">Unit</th>
                      <th style="width:10%">Size</th>
                      <th style="width:10%">Kind of package</th>
                      <th style="width:10%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 1;
                    while ( $i <= 5 ) {
                      ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><input type="text" name="goodNo[]" class="form-control" value="" id="goodNo<?php echo $i; ?>"></td>
                      <td><input type="text" name="goodDec[]" class="form-control" value="" id="goodDec<?php echo $i; ?>"></td>
                      <td><input type="number" name="goodWeight[]" class="form-control" value="" id="goodWeight<?php echo $i; ?>"></td>
                      <td><select name="good_unit[]" class="select2_single form-control select2" style="width: 100%" id="good_unit<?php echo $i; ?>">
                          <?php $db->s_unit(); ?>
                        </select></td>
                      <td class="center"><input type="text" name="goodSize[]" class="form-control" value="" id="goodSize<?php echo $i; ?>"></td>
                      <td class="center"><input type="text" name="goodKind[]" class="form-control" value="" id="goodKind<?php echo $i; ?>"></td>
                      <td class="center"><button type="button" class="btn-white btn btn-xs" onClick="return FN_ClearGoods('<?php echo $i; ?>');">Clear</button></td>
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
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label">Total Number of Package (in words)</label>
              <div class="col-md-4">
                <input type="text" name="good_total_num_package" class="form-control" id="good_total_num_package">
              </div>
              <div class="col-md-1">
                <label style="padding-top: 5px;">Commodity</label>
              </div>
              <div class="col-md-4">
                <input type="text" name="good_commodity" class="form-control" id="good_commodity">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="ibox ">
          <div class="ibox-title">
            <h2>Charges / ค่าใช้จ่าย</h2>
            <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
          </div>
          <div class="ibox-content  collapse">
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
            <div class="form-group">
              <div class="table-responsive" id="containner_charge">
                <table class="table" width="100%" id="table_charge">
                  <thead>
                    <tr>
                      <th style="width:5%">No.</th>
                      <th style="width:50%">Detail</th>
                      <th style="width:10%">Cost</th>
                      <th style="width:10%">Receive</th>
                      <th style="width:10%">Bill of receipt</th>
                      <th style="width:5%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td style="width:5%"></td>
                      <td style="width:50%"></td>
                      <td style="width:10%"><input type="text" name="goodSize" readonly class="form-control" value="" id="goodSize"></td>
                      <td style="width:10%"><input type="text" name="goodSize" readonly class="form-control" value="" id="goodSize"></td>
                      <td style="width:10%"><input type="text" name="goodSize" readonly class="form-control" value="" id="goodSize"></td>
                      <td style="width:5%"></td>
                    </tr>
                    <tr>
                      <td style="
      width:5%"></td>
                      <td style="width:50%; text-align: right;">Vat 7%</td>
                      <td style="width:10%"><input type="text" name="goodSize" readonly class="form-control" value="" id="goodSize"></td>
                      <td style="width:10%"><input type="text" name="goodSize" readonly class="form-control" value="" id="goodSize"></td>
                      <td style="width:10%"><input type="text" name="goodSize" readonly class="form-control" value="" id="goodSize"></td>
                      <td style="width:5%"></td>
                    </tr>
                  </tfoot>
                </table>
                <table class="table invoice-total">
                  <tbody>
                    <tr>
                      <td><strong>Total :</strong></td>
                      <td>$1026.00</td>
                    </tr>
                    <tr>
                      <td><strong>ค่าบริการ Tax (3%) :</strong></td>
                      <td>$235.98</td>
                    </tr>
                    <tr>
                      <td><strong>ค่าขนส่ง Tax (1%) :</strong></td>
                      <td>$235.98</td>
                    </tr>
                    <tr>
                      <td><strong>TOTAL :</strong></td>
                      <td>$1261.98</td>
                    </tr>
                    <tr>
                      <td><strong>ลูกค้าสำรองจ่าย</strong></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><strong>คงเหลือจ่ายจริง</strong></td>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
              </div>
             
                
                <div class="col-lg-12">
                <div class="ibox ">
                 
                    <div class="form-group row">
                      <label class="col-lg-2 col-form-label">Note</label>
                      <div class="col-md-3">
                        <textarea name="note" rows="4" class="form-control" id="note"></textarea>
                      </div>
                    </div>
              

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
                </span> <span class="fileinput-filename"></span> <a  href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a> </div>
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
              <div class="col-sm-10 col-sm-offset-2">
                <button name="back" class="btn btn-white" type="button" onclick="window.history.back();"><i class="fa fa-reply"></i> Back</button>
                <button name="save" id="save" class="btn btn-primary" type="button" <?php echo $disabled; ?>><i class="fa fa-save"></i> Save</button>
                <button class="btn btn-success " type="submit"><i class="fa fa-check"></i> Approve</button>
                <button class="btn btn-white " type="submit"><i class="fa fa-print"></i> Job</button>
                <button class="btn btn-white " type="submit"><i class="fa fa-print"></i> Booking confirm</button>
                <button class="btn btn-white " type="button" id="btn_trailerbooking"><i class="fa fa-print"></i> Trailer booking</button>
                <input type="hidden" name="action" id="action" value="<?php echo $acton; ?>">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<br>
<!--  END Body-->