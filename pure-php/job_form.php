<?php
//session_start();
unset($_SESSION['chargeCode']);
require_once('class.php');
require_once('function.php');
$db = new cl;
$acton = get('action');
$documentID = get('documentID');
$documentDate = date('d/m/Y');
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
$etdDate = date('d/m/Y');
$etaDate = date('d/m/Y');
$closingDate = date('d/m/Y');
$freetime = 0;
$freetimeEXP = date('d/m/Y');
$documentstatus = '';
$feederVOY = "";
$vesselVOY = "";

$closingTime = '';
$invNo = '';
$bill = '';
$bookingNo = '';
$deliveryType = '';
$saleman = ''; //$_SESSION['userID'];
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
$stu_date = '';
$cy_location = '';
$cy_contact = '';
$cy_mobile = '';
$cy_date = '';
$rtn_location = '';
$rtn_contact = '';
$rtn_mobile = '';
$rtn_date = '';
$createID = '';
$createTime = date('d/m/Y');
$editID = '';
$editTime = date('d/m/Y');
$billOfladingNo = '';
$trailer_bookingNO = '';
$invoiceNo = '';
$textboundType = 'Free Time Expire';
$good_total_num_package = '';
$good_commodity = '';


if ($acton == 'view') {
  $disabled = 'disabled';
} else {
  $disabled = '';
}

$sql = "SELECT
c.comCode,
c.documentID,
c.documentDate,
c.bound,
c.freight,
c.port_of_landing,
c.port_of_discharge,
c.mbl,
c.hbl,
c.co,
c.paperless,
c.bill_of_landing,
c.import_entry,
c.etdDate,
c.etaDate,
c.closingDate,
TIME_FORMAT(c.closingTime,'%H:%i') AS closingTime,
c.invNo,
c.bill,
c.bookingNo,
c.deliveryType,
c.saleman,
c.cusCode,
c.cusContact,
c.agentCode,
c.agentContact,
c.feeder,
c.vessel,
c.note,
c.stu_location,
c.stu_contact,
c.stu_mobile,
c.stu_date,
c.cy_location,
c.cy_contact,
c.cy_mobile,
c.freetime,
c.freetimeEXP,
c.cy_date,
c.rtn_location,
c.rtn_contact,
c.rtn_mobile,
c.rtn_date,
c.good_total_num_package,
c.good_commodity,
c.billOfladingNo,
c.trailer_bookingNO,
c.invoiceNo,
c.fob,
c.feederVOY,
c.vesselVOY,
c.place_receive,
c.documentstatus,
c.createID,
c.createTime,
c.editID,
c.editTime
FROM $db->dbname.joborder AS c WHERE c.comCode='$db->comCode' AND c.documentID='$documentID' ";
if ($r = $db->fetch($sql)) {
  $documentID = $r['documentID'];
  $documentDate = date_slash($r['documentDate']);


  if ($acton == 'copy') {
    $documentID = '';
    $documentDate = date('d/m/Y');

  }


  $bound = $r['bound'];

  if ($bound == 1) {
    $textboundType = 'Free Time Expire';
  } else {
    $textboundType = 'First return';
  }


  $freight = $r['freight'];
  $port_of_landing = $r['port_of_landing'];
  $port_of_discharge = $r['port_of_discharge'];
  $mbl = $r['mbl'];
  $hbl = $r['hbl'];
  $co = $r['co'];
  $paperless = $r['paperless'];
  $bill_of_landing = $r['bill_of_landing'];
  $import_entry = $r['import_entry'];
  $etdDate = date_slash($r['etdDate']);
  $etaDate = date_slash($r['etaDate']);
  $closingDate = date_slash($r['closingDate']);
  $closingTime = $r['closingTime'];
  $invNo = $r['invNo'];
  $bill = $r['bill'];
  $feederVOY = $r['feederVOY'];
  $vesselVOY = $r['vesselVOY'];
  $bookingNo = $r['bookingNo'];

  if ($acton == 'copy') {
    $bookingNo = '';
    $invNo = '';

  }


  $deliveryType = $r['deliveryType'];
  $saleman = $r['saleman'];
  $cusCode = $r['cusCode'];
  $cusContact = $r['cusContact'];
  $agentCode = $r['agentCode'];
  $agentContact = $r['agentContact'];
  $feeder = $r['feeder'];
  $vessel = $r['vessel'];
  $note = $r['note'];
  $stu_location = $r['stu_location'];
  $stu_contact = $r['stu_contact'];
  $stu_mobile = $r['stu_mobile'];
  $stu_date = date_slash($r['stu_date']);
  $cy_location = $r['cy_location'];
  $cy_contact = $r['cy_contact'];
  $cy_mobile = $r['cy_mobile'];
  $cy_date = date_slash($r['cy_date']);
  $rtn_location = $r['rtn_location'];
  $rtn_contact = $r['rtn_contact'];
  $rtn_mobile = $r['rtn_mobile'];
  $rtn_date = date_slash($r['rtn_date']);
  $documentstatus = $r['documentstatus'];
  $freetime = $r['freetime'];
  $freetimeEXP = date_slash($r['freetimeEXP']);


  if ($documentstatus == 'A') {

    $disabled = 'disabled';
  }

  $createID = $r['createID'];
  $createTime = $r['createTime'];
  $editID = $r['editID'];
  $editTime = $r['editTime'];
  $good_total_num_package = $r['good_total_num_package'];
  $good_commodity = $r['good_commodity'];
  $fob = $r['fob'];
  $place_receive = $r['place_receive'];
  $billOfladingNo = $r['billOfladingNo'];
  $trailer_bookingNO = $r['trailer_bookingNO'];
  $invoiceNo = $r['invoiceNo'];
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
      
      
$('#form').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});

                         
                         
                         
       $("#bound").change(function() {
         
      
            var boundType= $("#bound").val();
            var nday=parseInt($( "#freetime" ).val());
            var var_etaDate = $('#etaDate').datepicker('getDate');
            var var_etdDate =$('#etdDate').datepicker('getDate');

           
            if(boundType==1){
                var_etaDate.setDate(var_etaDate.getDate()+ nday);
                $("#textboundType").text('Free Time Expire');  
            }else if(boundType==2){
        
                var_etaDate.setDate(var_etdDate.getDate()- nday);  
               $("#textboundType").text('First return');   
            }
           
            $( "#freetimeEXP" ).datepicker("setDate", var_etaDate);

          
           
        });
      
      
      $( "#freetime" ).keyup(function() {
       var boundType= $("#bound").val();
            var nday=parseInt($( "#freetime" ).val());
            var date2 = $('#etaDate').datepicker('getDate');
            var var_etdDate =$('#etdDate').datepicker('getDate');
           
            if(boundType==1){
                date2.setDate(date2.getDate()+ nday);
                
              $("#textboundType").text('Free Time Expire');  
                
                
            }else{
                date2.setDate(var_etdDate.getDate()- nday);  
                
               $("#textboundType").text('First return');   
                
            }
            $( "#freetimeEXP" ).datepicker("setDate", date2);
           
        });
      
      
      
      

      if($("#action").val()=='add'){
             $("#Approve").prop("disabled", true); 
      }
      
      
    var rowIdx_atach = 1;


      $("#x").click(function() {
          
      call_price();    
          
      }); 
      
      
 
    var rowIdx_ctQty = $("#rowIdx_ctQty").val();
      
      
    $("#btnAddQT").click(function() {
        
        if($("#containQty").val()==""){
               swal({
          title: "Warning",
          text: "กรุณาระบุจำนวนตู้",
          confirmButtonColor: "#DD6B55",
          type: "warning"
        });
            
        return false;
        }
        
        
         if($("#containerSizeHeader").val()==""){
               swal({
          title: "Warning",
          text: "กรุณาระบุขนาด้",
          confirmButtonColor: "#DD6B55",
          type: "warning"
        });
            
        return false;
        }       
        
         if($("#containerTypeHeader").val()==""){
               swal({
          title: "Warning",
          text: "กรุณาระบุประเภทตู้",
          confirmButtonColor: "#DD6B55",
          type: "warning"
        });
            
        return false;
        }
        
        
        
    let i = 0;    
    while (i < $("#containQty").val()) {
        
        
        
        var cType=$("#containerTypeHeader").val();
        var cSize=$("#containerSizeHeader").val();
        
        
        
        
       $("#table_container").append(" "+
              " <tr class='gradeX' id='tr" + rowIdx_ctQty + "'> " +
              " <td>"+rowIdx_ctQty+"</td> "+                               
              " <td><div id='ctType"+rowIdx_ctQty+"'></div></td> "+ 
               " <td><div id='ctSize"+rowIdx_ctQty+"'></div></td> "+                                            
               " <td><input type='text' name='containerNo[]' class='form-control' value='' id='containerNo" + rowIdx_ctQty + "'></td>  " +
                " <td><input type='text' name='containerSealNo[]' class='form-control' value='' id='containerSealNo" + rowIdx_ctQty + "'></td>  " +
               " <td><input type='text' name='containerGW[]' class='form-control' value='' id='containerGW" + rowIdx_ctQty + "'></td>  " +
                " <td><div id='ctGW_unit"+rowIdx_ctQty+"'></div></td> "+                                
                " <td><input type='text' name='containerNW[]' class='form-control' value='' id='containerNW" + rowIdx_ctQty + "'></td>  " +
                " <td><div id='ctNW_Unit_unit"+rowIdx_ctQty+"'></div></td> "+
                " <td><input type='text' name='containerTareweight[]' class='form-control' value='' id='containerTareweight" + rowIdx_ctQty + "'></td>  " +
              " <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(" + rowIdx_ctQty + ")'>Remove</button></td> "+
              " </tr>");
                $('#ctType' + rowIdx_ctQty).load('job_form_loadContainnerType.php?id='+cType);
                $('#ctSize' + rowIdx_ctQty).load('job_form_containerSize.php?id='+cSize);
                $('#ctGW_unit' + rowIdx_ctQty).load('job_form_containerGW_unit.php?id=U-02');
                $('#ctNW_Unit_unit' + rowIdx_ctQty).load('job_form_containerNW_Unit.php?id=U-02');
            rowIdx_ctQty++;
         
        i++;
}
        
        
    });  
      
      
      
      
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

 $("#cusCode").change(function() {
       
            var jsonObj={
            cusCode: $("#cusCode").val()
          }; 
          $.ajax({
               type: "POST",
               url: "loadcustomerContact.php",
               data: jsonObj,
               success: function(result) {
                            console.log(result);
                 var obj = jQuery.parseJSON(result);
                             $("#cusContact").val(obj.cusContact);
               $("#saleman").val(obj.salemanID);
              
              
             } 
           }); 
    });     
    
    
    
    
      
      
 $("#agentCode").change(function() {
       
            var jsonObj={
            supCode: $("#agentCode").val()
          }; 
          $.ajax({
               type: "POST",
               url: "loadSupContact.php",
               data: jsonObj,
               success: function(result) {
                            console.log(result);
                 var obj = jQuery.parseJSON(result);
                             $("#agentContact").val(obj.contactName);   
             } 
           }); 
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
        url: "job_action_upload.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function(result) {
          var obj = jQuery.parseJSON(result);
             console.log("Result Upload : ", result);
          // var dataresult = obj.result;
          //alert(obj.fileName);
         // alert(rowIdx_atach);
          if (obj.result == 'success') {
            //  console.log("SUCCESS : ", 'x');
            $("#btnUpload").prop("disabled", false);
            $("#table_attach").append(" <tr class='gradeX' id='tr" + rowIdx_atach + "'> " +
        
              " <td><input type='hidden' name='imgKey[]'  value='"+obj.fileName+"' id='imgKey" + rowIdx_atach + "'><input type='text' name='fileName[]' class='form-control' value='" + $("#attach_name").val() + "' id='fileName" + rowIdx_atach + "'></td>  " +
              " <td class='center'> <a class='btn-white btn btn-xs' href='customer_path/"+obj.cusCode+"/"+obj.fileName+"' target='_blank'>View</a> </button>&nbsp;<button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(" + rowIdx_atach + ")'>Remove</button></td>  " +
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

      
      
      
      
      
      
      
      
      
      
    var rowIdxpacked = $("#rowIdxpacked").val();
    $("#addpacked").click(function(event) {


      $("#table_packed").append(" <tr class='gradeX' id='tr" + rowIdxpacked + "'> " +
" <td class='center'>"+ rowIdxpacked +"</td>  " +                          
" <td class='center'><input type='number' name='packaed_width[]' class='form-control' value='' id='packaed_width" + rowIdxpacked + "' onchange='return FN_CalPacked("+rowIdxpacked+");'></td>  " +
" <td class='center'><input type='number' name='packaed_length[]' class='form-control' value='' id='packaed_length" + rowIdxpacked + "' onchange='return FN_CalPacked("+rowIdxpacked+");'></td>  " +  
" <td class='center'><input type='number' name='packaed_height[]' class='form-control' value='' id='packaed_height" + rowIdxpacked + "' onchange='return FN_CalPacked("+rowIdxpacked+");'></td>  " +                   " <td class='center'><input type='number' name='packaed_qty[]' class='form-control' value='' id='packaed_qty" + rowIdxpacked + "'></td>  " +                       
" <td class='center'><input type='number' name='packaed_weight[]' class='form-control' value='' id='packaed_weight" + rowIdxpacked + "' onchange='return FN_CalPacked("+rowIdxpacked+");'></td>  " +
 " <td class='center'><div id='UnitWeight"+rowIdxpacked+"'></div></td>  " +                                    
 " <td class='center'><input type='number'   name='packaed_totalCBM[]' class='form-control' value='' id='packaed_totalCBM" + rowIdxpacked + "' ></td>  " +
  " <td class='center'><input type='number'  name='packaed_totalWeight[]' class='form-control' value='' id='packaed_totalWeight" + rowIdxpacked + "'></td>  " +                               
                                
                                
" <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(" + rowIdxpacked + ")'>Remove</button></td>  " +
        " </tr>");

     $('#UnitWeight' + rowIdxpacked).load('job_form_containerNW_Unit.php?id=U-02');
      //$('.select2_single').select2({});

      rowIdxpacked++;
      //$('.select2_single').select2({});
    });
      
      
      
  var rowIdxproduct = $("#rowIdxproduct").val();
    $("#addproduct").click(function(event) {

      $("#table_product").append(" <tr class='gradeX' id='tr" + rowIdxproduct + "'> " +
" <td class='center'>"+ rowIdxproduct +"</td>  " +                          
" <td class='center'><input type='text' name='goodNo[]' class='form-control' value='' id='goodNo" + rowIdxproduct + "''></td>  " +
 " <td class='center'><input type='text' name='goodDec[]' class='form-control' value='' id='goodDec" + rowIdxproduct + "''></td>  " +
  " <td class='center'><input type='text' name='goodWeight[]' class='form-control' value='' id='goodWeight" + rowIdxproduct + "''></td>  " +                           " <td class='center'><div id='Unitproduct"+rowIdxproduct+"'></div></td>  " +      
    " <td class='center'><input type='text' name='goodSize[]' class='form-control' value='' id='goodSize" + rowIdxproduct + "''></td>  " +                           " <td class='center'><input type='text' name='goodKind[]' class='form-control' value='' id='goodKind" + rowIdxproduct + "''></td>  " +        
                                 
" <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(" + rowIdxproduct + ")'>Remove</button></td>  " +
        " </tr>");

    $('#Unitproduct' + rowIdxproduct).load('job_form_Unit.php');
      //$('.select2_single').select2({});

      rowIdxproduct++;
      //$('.select2_single').select2({});
    });
      
      
      
      
      
      
      
    var rowIdx = $("#rowIdx").val();
    $("#addCharge").click(function(event) {


      $("#table_charge").append(" <tr class='gradeX' id='trCharge" + rowIdx + "'> " +
        " <td>" + rowIdx + "<input type='hidden' name='chargeitems[]'   value='" + $("#chargeCode").val() + "' id='chargeitems" + rowIdx + "'>                      <input type='hidden' name='ref_paymentCode[]'   value='' id='ref_paymentCode" + rowIdx + "'></td> " +
" <td><input type='text' name='chargesDetail[]' class='form-control' value='" + $("#chargeCode option:selected" ).text() + "' id='chargesDetail" + rowIdx + "'></td> " +
                        
"<td class='center'><input type='number' name='price[]'  onchange='call_price(),call_exchange(" + rowIdx +")' class='form-control full' value='1' id='price" + rowIdx +"'></td>  " +
" <td class='center'><input type='number' name='volum[]'  onchange='call_price(),call_exchange(" + rowIdx +")' class='form-control full' value='1' id='volum" + rowIdx + "'></td>  " +
" <td class='center'><input type='number' name='exchange[]'  onchange='call_price(),call_exchange(" + rowIdx +")' class='form-control full' value='1' id='exchange" + rowIdx + "'></td>  " +                      
" <td class='center'><input type='number' name='chargesCost[]'  onchange='call_price()' class='form-control full' value='0' id='chargesCost" + rowIdx + "'></td>  " +
                                
" <td class='center'><input type='number' name='chargesReceive[]'  onchange='call_price()' class='form-control full' value='0' id='chargesReceive" + rowIdx + "'></td>  " +
" <td class='center'><input type='number' name='chargesbillReceive[]' onchange='call_price()' class='form-control full' value='0' id='chargesbillReceive" + rowIdx + "'></td>  " +
" <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(Charge" + rowIdx + ")'>Remove</button></td>  " +
        " </tr>");
    //  $('#containner' + rowIdx).load('job_form_loadcharge.php');
      //$('.select2_single').select2({});

      rowIdx++;
      //$('.select2_single').select2({});
      $("#chargeCode").select2("val", "");
    });


    

    $('.select2_single').select2({});
    $("#form").validate({
      rules: {
        
             cusCode: {required: true }
           
          

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
        var invNo = $('#invNo').val();
        if(invNo == ''){
          swal({
              title: "Error",
              text: "กรุณาระบุ INV No. ",
              confirmButtonColor: "#DD6B55",
              type: "warning",
              
            });;
            $('#invNo').focus();
         return false;   
        }

        var bookingNo = $('#bookingNo').val();
        if(bookingNo == ''){ 
          swal({
              title: "Error",
              text: "กรุณาระบุ Booking No. ",
              confirmButtonColor: "#DD6B55",
              type: "warning",
              
            });;
            $('#bookingNo').focus();
            return false
        }
        
        var freight = $('#freight').val();
        if(freight == ''){ 
          swal({
              title: "Error",
              text: "กรุณาเลือก freight. ",
              confirmButtonColor: "#DD6B55",
              type: "warning",
              
            });;
            $('#bookingNo').focus();
            return false
        }

        var bound = $('#bound').val();
        if(bound == ''){ 
          swal({
              title: "Error",
              text: "กรุณาเลือก bound. ",
              confirmButtonColor: "#DD6B55",
              type: "warning",
              
            });;
            return false
        }
        
        
        var agentCode = $('#agentCode').val();
        if(agentCode == ''){ 
          swal({
              title: "Error",
              text: "กรุณาเลือก Agent. ",
              confirmButtonColor: "#DD6B55",
              type: "warning",
              
            });;
            return false
        }

        
        var feeder = $('#feeder').val();
        if(feeder == ''){ 
          swal({
              title: "Error",
              text: "กรุณาเลือก Feeder. ",
              confirmButtonColor: "#DD6B55",
              type: "warning",
              
            });;
            return false
        }




        //return false;
        call_price(); 
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
          
            //window.prompt('',data);
              console.log("SUCCESS : ", data);  
            var obj = jQuery.parseJSON(data);
            // $("#chargeCode").val(obj.result);
            var dataresult = obj.result;
            if (dataresult == 'success') {
              $("#documentID").val(obj.documentID);
              $("#action").val('edit');
                 $("#Approve").prop("disabled", false); 
              msgSuccess();
            } else if(dataresult == 'error_duplicateIV') {
         //msgDuplicate();
          //msgError();
      }else{
        
        
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

    $("#Approve").click(function(event) {
         $("#action").val('approve');
        call_price(); 
      event.preventDefault();
      if ($('#form').valid()) {
        var form = $('#form')[0];
        var data = new FormData(form);
        data.append("CustomField", "This is some extra data, testing");
        // disabled the submit button
        $("#save").prop("disabled", true);
    $("#Approve").prop("disabled", true);  
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
           
            //window.prompt('',data);
              console.log("SUCCESS : ", data);  
            var obj = jQuery.parseJSON(data);
            // $("#chargeCode").val(obj.result);
            var dataresult = obj.result;
            if (dataresult == 'success') {
              $("#documentID").val(obj.documentID);
        $("#invoiceNo").val(obj.invoiceNo);
              $("#action").val('approve');
              msgSuccess();
              $("#save").prop("disabled", false);
            $("#Approve").prop("disabled", false);    
            } else {
              msgError();
                
            }
            console.log("SUCCESS : ", dataresult);
          

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

    $("#invoice").click(function(event) {
         //alert('print inv');
      //if($("#documentID").val()=="")return false;

        var documentID=$("#documentID").val();
        var invoiceNo=$("#invoiceNo").val();
        //alert("inv No = "+invoiceNo);
        var cusCode=$("#cusCode").val();
        if(invoiceNo=="") { return false; }
              window.open('invoice_form?action=edit&documentID='+invoiceNo,'_blank');
        
    });    
      
      
      
      

 call_price(); 

  });

  function FN_attach_view(filename){
    var filename;
   // alert(filename);
  }

    
function openInNewTab(url) {
var vardocumentID=$("#documentID").val();
    if(vardocumentID=='')return false;
//var win = window.open('print/'+url+.php?documentID?documentID='+documentID, '_blank');
var win = window.open('print/'+url+'.php?documentID='+vardocumentID, '_blank');
win.focus();
}
    

    
  function FN_Remove_Table(rowID) {
      
 alert("XXX");
    $("#tr" + rowID).remove();
      //call_price();
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
      $("#packaed_totalWeight" + rowID).val(total*var_qty);
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
    
    
function call_exchange(indexRow){

     if(indexRow!=""){
      var price=$("#price"+indexRow).val();
      var volum=$("#volum"+indexRow).val();
      var exchange=$("#exchange"+indexRow).val();  
         
      var total=price*volum*exchange;
      $("#chargesReceive"+indexRow).val(parseFloat(total).toFixed(2));
      }   
    call_price();
    
}  
    
    
    
    
 function call_price(){

      //event.preventDefault();
        var form = $('#form')[0];
        var data = new FormData(form);
        $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "job_charge_cal.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(result) {
        //window.prompt("",result);
              
            //var obj = jQuery.parseJSON(result);
            var obj = $.parseJSON(result);

              
             console.log("Result : ", result);
              
              $("#total_chargesCost").val(obj.total_chargesCost);
              $("#total_chargesReceive").val(obj.total_chargesReceive);
              $("#total_chargesReceive_beforevat").val(obj.total_chargesReceive_beforevat);
              $("#total_chargesbillReceive").val(obj.total_chargesbillReceive);
            
              
              
              $("#vat_total_chargesCost").val(obj.vat_total_chargesCost);
              $("#vat_total_chargesReceive").val(obj.vat_total_chargesReceive);
              $("#vat_total_chargesbillReceive").val(obj.vat_total_chargesbillReceive);
              
              
                $("#h_total").val(obj.total);
               $("#total").text(obj.total); 
               
              
               $("#tax3").text(obj.total_tax3); $("#h_tax3").val(obj.total_tax3);
               $("#tax1").text(obj.total_tax1); $("#h_tax1").val(obj.total_tax1);

               $("#grand_total").text(obj.grand_total);
               $("#net_pad").text(obj.net_pad); $("#h_net_pad").val(obj.net_pad); 
            
            console.log("Result Call : ", result);

          },
          error: function(e) {
            console.log("ERROR : ", e);

          }



        });
      
      
      
  }      
    
</script>
<style type="text/css">
.full {
    width: 130px;
}
</style>
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
      <div class="file"> <a id="invoice">
        <div class="icon"> <i class="fa fa-file-text <?php if ($invoiceNo != '') {
          echo "text-navy";
        } ?> "></i> </div>
        <div class="file-name text-navy"> Invoice <small><?php echo $invoiceNo; ?></small> </div>
        </a> </div>
    </div>
    <div class="file-box">
      <div class="file"> <a id="btnbill_of_lading">
        <div class="icon"> <i class="fa fa-file-text  <?php if ($billOfladingNo != '') {
          echo "text-navy";
        } ?> "></i> </div>
        <div class="file-name text-navy"> Bill of landing <small><?php echo $billOfladingNo; ?></small> </div>
        <input type="hidden" name="billOfladingNo" id="billOfladingNo" value="<?php echo $billOfladingNo; ?>">
        </a> </div>
    </div>
    <div class="file-box">
      <div class="file"> <a id="trailer_booking">
        <div class="icon"> <i class="fa fa-file-text <?php if ($trailer_bookingNO != '') {
          echo "text-navy";
        } ?> "></i> </div>
        <div class="file-name text-navy"> Trailer Booking <small><?php echo $trailer_bookingNO; ?></small> </div>
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
              <input name="documentID" type="text" class="form-control" id="documentID" value="<?php echo $documentID; ?>" readonly="readonly">
            </div>
            <input type="hidden" name="invoiceNo" id="invoiceNo" value="<?php echo $invoiceNo; ?>">
    
        
        
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
                <option value="1" <?php if ($bound == '1') {
                  echo 'selected';
                } ?>  >IN BOUND</option>
                <option value="2" <?php if ($bound == '2') {
                  echo 'selected';
                } ?>  >OUT BOUND</option>
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
              <input type="text" name="mbl" class="form-control" id="mbl" value="<?php echo $mbl; ?>">
            </div>
            <div class="col-md-2">
              <label class="col-form-label" style="padding-top: 5px;">H B/L</label>
            </div>
            <div class="col-md-4">
              <input type="text" name="hbl" class="form-control" id="hbl" value="<?php echo $hbl; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">C/O</label>
            <div class="col-md-4">
              <input type="text" name="co" class="form-control" id="co"  value="<?php echo $co; ?>">
            </div>
            <div class="col-md-2">
              <label class="col-form-label" style="padding-top: 5px;">Paper Less Code</label>
            </div>
            <div class="col-md-4">
              <input type="text" name="paperless" class="form-control" id="paperless" value="<?php echo $paperless; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">Bill of lading</label>
            <div class="col-md-4">
              <input type="text" name="bill_of_landing" class="form-control" id="bill_of_landing" value="<?php echo $bill_of_landing; ?>">
            </div>
            <label class="col-lg-2 col-form-label">Import Entry</label>
            <div class="col-md-4">
              <input type="text" name="import_entry" class="form-control" id="import_entry" value="<?php echo $import_entry; ?>">
            </div>
          </div>
          <div class="form-group row date">
            <label class="col-lg-2 col-form-label">ETD</label>
            <div class="col-lg-4">
              <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" name="etdDate" id="etdDate" class="form-control" value="<?php echo $etdDate; ?>" >
              </div>
            </div>
            <div class="col-md-2">
              <label class="col-form-label" style="padding-top: 5px;">ETA</label>
            </div>
            <div class="col-lg-4">
              <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input name="etaDate" id="etaDate" type="text" class="form-control" value="<?php echo $etaDate; ?>">
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
                <input name="closingTime" type="text" class="form-control" id="closingTime" value="<?php echo $closingTime; ?>">
                <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span> </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">INV No.</label>
            <div class="col-md-4">
              <input type="text" name="invNo" class="form-control" id="invNo" value="<?php echo $invNo; ?>">
            </div>
            <div class="col-md-2">
              <label class="col-form-label" style="padding-top: 5px;">Bill</label>
            </div>
            <div class="col-md-4">
              <input type="text" name="bill" class="form-control" id="bill" value="<?php echo $bill; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">Booking No.</label>
            <div class="col-md-4">
              <input type="text" name="bookingNo" class="form-control" id="bookingNo" value="<?php echo $bookingNo; ?>">
            </div>
            <div class="col-md-2">
              <label class="col-form-label" style="padding-top: 5px;">Delivery Type</label>
            </div>
            <div class="col-md-4">
              <select name="deliveryType" class="select2_single form-control select2" id="deliveryType">
                <option value="FCL"  <?php if ($deliveryType == 'FCL') {
                  echo 'selected';
                } ?> >FCL</option>
                <option value="LCL" <?php if ($deliveryType == 'LCL') {
                  echo 'selected';
                } ?>>LCL</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">FOB AT</label>
            <div class="col-md-4">
              <select name="fob" class="select2_single form-control select2" id="fob">
                <?php $db->s_place($fob); ?>
              </select>
            </div>
            <div class="col-md-2">
              <label class="col-form-label" style="padding-top: 5px;">Place of receive </label>
            </div>
            <div class="col-md-4">
              <select name="place_receive" class="select2_single form-control select2" id="place_receive"  >
                <?php $db->s_place($place_receive); ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">Free Time</label>
            <div class="col-md-4">
              <input type="number" name="freetime" class="form-control" id="freetime" value="<?php echo $freetime; ?>">
            </div>
            <div class="col-md-2">
              <label class="col-form-label" style="padding-top: 5px;"><span id="textboundType"><?php echo $textboundType; ?></span></label>
            </div>
            <div class="col-md-4">
              <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input name="freetimeEXP" id="freetimeEXP" type="text" class="form-control" value="<?php echo $freetimeEXP; ?>">
              </div>
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
            <label class="col-sm-2 col-form-label">Customer</label>
            <div class="col-md-10">
              <select name="cusCode" class="select2_single form-control select2" id="cusCode">
                <?php $db->s_customer("$cusCode"); ?>
              </select>
            </div>
          </div>
          <div class="form-group  row">
            <label class="col-sm-2 col-form-label">Sales</label>
            <div class="col-md-10">
             <!--
        <select name="saleman" class="select2_single form-control select2" id="saleman" required>
                <?php $db->s_saleman($saleman); ?>
              </select>
        
        -->
        <input name="saleman" type="text" required class="form-control" id="saleman" placeholder="" value="<?php echo $saleman; ?>" readonly="readonly">

        
        
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">Contact</label>
            <div class="col-md-10">
              <input type="text" name="cusContact" class="form-control" id="cusContact" value="<?php echo $cusContact; ?>">
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
              <input type="text" name="agentContact" class="form-control" id="agentContact" value="<?php echo $agentContact; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">Feeder</label>
            <div class="col-md-5">
              <select name="feeder" class="select2_single form-control select2" id="feeder">
                <?php $db->s_feeder("$feeder"); ?>
              </select>
            </div>
            <div class="col-md-1">
              <label class="col-form-label" style="padding-top: 5px;">VOY</label>
            </div>
            <div class="col-md-4">
              <input type="text" name="feederVOY" class="form-control" id="feederVOY" value="<?php echo $feederVOY; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">Vessel</label>
            <div class="col-md-5">
              <select name="vessel" class="select2_single form-control select2" id="vessel">
                <?php $db->s_feeder("$vessel"); ?>
              </select>
            </div>
            <div class="col-md-1">
              <label class="col-form-label" style="padding-top: 5px;">VOY</label>
            </div>
            <div class="col-md-4">
              <input type="text" name="vesselVOY" class="form-control" id="vesselVOY" value="<?php echo $vesselVOY; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">Note</label>
            <div class="col-md-10">
              <textarea name="note" rows="4" class="form-control" id="note"><?php echo $note; ?></textarea>
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
              <input type="text" name="stu_location" class="form-control" placeholder="location" id="stu_location" value="<?php echo $stu_location; ?>">
            </div>
            <div class="col-md-3">
              <input name="stu_contact" type="text" class="form-control" id="stu_contact" placeholder="Contact Person" autocomplete="empty" value="<?php echo $stu_contact; ?>">
            </div>
            <div class="col-md-2">
              <input type="text" name="stu_mobile" class="form-control" placeholder="Mobile" id="stu_mobile" value="<?php echo $stu_mobile; ?>">
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
              <input type="text" name="cy_location" class="form-control" placeholder="location" id="cy_location" value="<?php echo $cy_location; ?>">
            </div>
            <div class="col-md-3">
              <input type="text" name="cy_contact" class="form-control" placeholder="Contact Person" id="cy_contact" autocomplete="empty" value="<?php echo $cy_contact; ?>">
            </div>
            <div class="col-md-2">
              <input type="text" name="cy_mobile" class="form-control" placeholder="Mobile" id="cy_mobile" value="<?php echo $cy_mobile; ?>">
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
              <input type="text" name="rtn_location" class="form-control" placeholder="location" id="rtn_location" value="<?php echo $rtn_location; ?>">
            </div>
            <div class="col-md-3">
              <input type="text" name="rtn_contact" class="form-control" placeholder="Contact Person" id="rtn_contact" autocomplete="empty" value="<?php echo $rtn_contact; ?>">
            </div>
            <div class="col-md-2">
              <input type="text" name="rtn_mobile" class="form-control" placeholder="Mobile" id="rtn_mobile" value="<?php echo $rtn_mobile; ?>">
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
          <div class="form-group row">
            <div class="col-md-2">
              <select name="containerTypeHeader" class="select2_single form-control select2" id="containerTypeHeader" style="width: 100%">
                <?php $db->s_containerType($r['containerType']); ?>
              </select>
            </div>
            <div class="col-md-2">
              <select name="containerSizeHeader" id="containerSizeHeader" class="select2_single form-control select2" style="width: 100%">
                <?php $db->s_containerSize($r['containerSize']); ?>
              </select>
            </div>
            <div class="col-md-1">
              <input name="containQty" type="number" class="form-control" id="containQty" value="">
            </div>
            <div class="col-md-1">
              <button name="btnAddQT" id="btnAddQT" class="btn btn-white" type="button"><i class="fa fa-plus"></i>Add</button>
            </div>
          </div>
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
                  $sql = "SELECT
                  c.items,
                  c.comCode,
                  c.documentID,
                  c.containerType,
                  c.containerSize,
                  c.containerNo,
                  c.containerSealNo,
                  c.containerGW,
                  c.containerGW_unit,
                  c.containerNW,
                  c.containerNW_Unit,
                  c.containerTareweight
                  FROM
                  joborder_container AS c
                  WHERE c.comCode='$db->comCode' AND c.documentID='$documentID' AND  c.documentID<>'' ";
                  $result = $db->query($sql);
                  $i_container = 1;
                  $i = 1;
                  while ($r = mysqli_fetch_array($result)) {
                    ?>
                    <tr id="tr<?php echo $i; ?>">
                      <td>&nbsp;&nbsp;<?php echo $i; ?></td>
                      <td><select name="containerType[]" class="select2_single form-control select2" id="containerType<?php echo $i_container; ?>" style="width: 100%">
                          <?php $db->s_containerType($r['containerType']); ?>
                        </select></td>
                      <td><select name="containerSize[]" id="containerSize<?php echo $i_container; ?>" class="select2_single form-control select2" style="width: 100%">
                          <?php $db->s_containerSize($r['containerSize']); ?>
                        </select></td>
                      <td><input type="text" name="containerNo[]" id="containerNo<?php echo $i_container; ?>" class="form-control" value="<?php echo $r['containerNo']; ?>"></td>
                      <td class="center"><input type="text" name="containerSealNo[]" id="containerSealNo<?php echo $i_container; ?>" class="form-control" value="<?php echo $r['containerSealNo']; ?>"></td>
                      <td class="center"><input type="number" name="containerGW[]" id="containerGW<?php echo $i_container; ?>" class="form-control" value="<?php echo $r['containerGW']; ?>"></td>
                      <td class="center"><select name="containerGW_unit[]" id="containerGW_unit<?php echo $i_container; ?>" class="select2_single form-control select2" style="width: 100%">
                          <?php $db->s_unitContainer($r['containerGW_unit']); ?>
                        </select></td>
                      <td class="center"><input type="text" name="containerNW[]" id="containerNW<?php echo $i_container; ?>" class="form-control" value="<?php echo $r['containerNW']; ?>"></td>
                      <td class="center"><select name="containerNW_Unit[]" id="containerNW_Unit<?php echo $i_container; ?>" class="select2_single form-control select2" style="width: 100%">
                          <?php $db->s_unitContainer($r['containerNW_Unit']); ?>
                        </select></td>
                      <td class="center"><input type="text" name="containerTareweight[]" id="containerTareweight<?php echo $i_container; ?>" class="form-control" value="<?php echo $r['containerTareweight']; ?>"></td>
                      <td class="center"><button type="button" class="btn-white btn btn-xs" onClick="return FN_Remove_Table('<?php echo $i; ?>');">Remove</button></td>
                    </tr>
                    <?php $i++;
                    $i_container++;
                  } ?>
                <input type="hidden" name="rowIdx_ctQty" id="rowIdx_ctQty" value="<?php echo $i; ?>">
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
              <table class="table dataTables" width="100%" id="table_packed">
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
                  $sql = "SELECT
                  t.items,
                  t.comCode,
                  t.documentID,
                  t.packaed_width,
                  t.packaed_length,
                  t.packaed_height,
                  t.packaed_qty,
                  t.packaed_weight,
                  t.packaed_unit,
                  round(t.packaed_totalCBM,2) as packaed_totalCBM,
                  round(t.packaed_totalWeight,2) as  packaed_totalWeight
                  FROM
                  joborder_packed AS t
                  WHERE t.comCode='$db->comCode' AND t.documentID='$documentID' ";
                  $result = $db->query($sql);
                  $i_container = 1;
                  $i = 1;
                  while ($r = mysqli_fetch_array($result)) {
                    ?>
                    <tr class="gradeX" id="tr<?php echo $i; ?>">
                      <td><?php echo $i; ?></td>
                      <td><span class="center">
                        <input type="number" name="packaed_width[]" class="form-control" value="<?php echo $r['packaed_width']; ?>" id="packaed_width<?php echo $i; ?>" onchange="return FN_CalPacked('<?php echo $i; ?>');">
                        </span></td>
                      <td><span class="center">
                        <input type="number" name="packaed_length[]" class="form-control" value="<?php echo $r['packaed_length']; ?>" id="packaed_length<?php echo $i; ?>" onchange="return FN_CalPacked('<?php echo $i; ?>');">
                        </span></td>
                      <td><input type="number" name="packaed_height[]" class="form-control" value="<?php echo $r['packaed_height']; ?>" id="packaed_height<?php echo $i; ?>" onchange="return FN_CalPacked('<?php echo $i; ?>');"></td>
                      <td class="center"><input type="number" name="packaed_qty[]" class="form-control" value="<?php echo $r['packaed_qty']; ?>" id="packaed_qty<?php echo $i; ?>" onchange="return FN_CalPacked('<?php echo $i; ?>');"></td>
                      <td class="center"><input type="number" name="packaed_weight[]" class="form-control" value="<?php echo $r['packaed_weight']; ?>" id="packaed_weight<?php echo $i; ?>" onchange="return FN_CalPacked('<?php echo $i; ?>');"></td>
                      <td class="center"><select name="packaed_unit[]" class="select2_single form-control select2" style="width: 100%" id="packaed_unit<?php echo $i; ?>" onchange="return FN_CalPacked('<?php echo $i; ?>');">
                          <?php $db->s_unitContainer($r['packaed_unit']); ?>
                        </select></td>
                      <td class="center"><input type="number"  name="packaed_totalCBM[]" class="form-control" value="<?php echo n2(0); ?>" id="packaed_totalCBM<?php echo $i; ?>"></td>
                      <td class="center"><input type="number"  name="packaed_totalWeight[]" class="form-control" value="<?php echo n2($r['packaed_totalWeight']); ?>" id="packaed_totalWeight<?php echo $i; ?>"></td>
                      <td class="center"><button type="button" class="btn-white btn btn-xs" onClick="return FN_Remove_Table('<?php echo $i; ?>');">Remove</button></td>
                    </tr>
                    <?php $i++;
                  } ?>
                  <?php
                  //$i = 1;
                  while ($i <= 1) {
                    ?>
                    <tr class="gradeX" id="tr<?php echo $i; ?>">
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
                          <?php $db->s_unitContainer(); ?>
                        </select></td>
                      <td class="center"><input type="number"  name="packaed_totalCBM[]" class="form-control" value="" id="packaed_totalCBM<?php echo $i; ?>"></td>
                      <td class="center"><input type="number"  name="packaed_totalWeight[]" class="form-control" value="" id="packaed_totalWeight<?php echo $i; ?>"></td>
                      <td class="center"><button type="button" class="btn-white btn btn-xs" onClick="return FN_Remove_Table('<?php echo $i; ?>');">Remove</button></td>
                    </tr>
                    <?php
                    $i++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <a  class="btn btn-white btn-xs"  id="addpacked"><i class="fa fa-plus "> </i> Add New Row </a>
            <input type="hidden" name="rowIdxpacked" id="rowIdxpacked" value="<?php echo $i; ?>">
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
              <table class="table" width="100%" id="table_product">
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
                  $sql = "SELECT
                  t.items,
                  t.comCode,
                  t.documentID,
                  t.goodNo,
                  t.goodDec,
                  t.goodWeight,
                  t.good_unit,
                  t.goodSize,
                  t.goodKind
                  FROM
                  joborder_goods AS t
                  WHERE t.comCode='$db->comCode' AND t.documentID='$documentID' ";
                  $result = $db->query($sql);
                  $i_container = 1;
                  $i = 1;
                  while ($r = mysqli_fetch_array($result)) {
                    ?>
                    <tr class="gradeX" id="tr<?php echo $i; ?>">
                      <td><?php echo $i; ?></td>
                      <td><input type="text" name="goodNo[]" class="form-control" value="<?php echo $r['goodNo']; ?>" id="goodNo<?php echo $i; ?>"></td>
                      <td><input type="text" name="goodDec[]" class="form-control" value="<?php echo $r['goodDec']; ?>" id="goodDec<?php echo $i; ?>"></td>
                      <td><input type="number" name="goodWeight[]" class="form-control" value="<?php echo $r['goodWeight']; ?>" id="goodWeight<?php echo $i; ?>"></td>
                      <td><select name="good_unit[]" class="select2_single form-control select2" style="width: 100%" id="good_unit<?php echo $i; ?>">
                          <?php $db->s_unit($r['good_unit']); ?>
                        </select></td>
                      <td class="center"><input type="text" name="goodSize[]" class="form-control" value="<?php echo $r['goodSize']; ?>" id="goodSize<?php echo $i; ?>"></td>
                      <td class="center"><input type="text" name="goodKind[]" class="form-control" value="<?php echo $r['goodKind']; ?>" id="goodKind<?php echo $i; ?>"></td>
                      <td class="center"><button type="button" class="btn-white btn btn-xs" onClick="return FN_Remove_Table('<?php echo $i; ?>');">Remove</button></td>
                    </tr>
                    <?php $i++;
                  } ?>
                  <?php

                  while ($i <= 1) {
                    ?>
                    <tr class="gradeX" id="tr<?php echo $i; ?>">
                      <td><?php echo $i; ?></td>
                      <td><input type="text" name="goodNo[]" class="form-control" value="" id="goodNo<?php echo $i; ?>"></td>
                      <td><input type="text" name="goodDec[]" class="form-control" value="" id="goodDec<?php echo $i; ?>"></td>
                      <td><input type="number" name="goodWeight[]" class="form-control" value="" id="goodWeight<?php echo $i; ?>"></td>
                      <td><select name="good_unit[]" class="select2_single form-control select2" style="width: 100%" id="good_unit<?php echo $i; ?>">
                          <?php $db->s_unit(); ?>
                        </select></td>
                      <td class="center"><input type="text" name="goodSize[]" class="form-control" value="" id="goodSize<?php echo $i; ?>"></td>
                      <td class="center"><input type="text" name="goodKind[]" class="form-control" value="" id="goodKind<?php echo $i; ?>"></td>
                      <td class="center"><button type="button" class="btn-white btn btn-xs" onClick="return FN_Remove_Table('<?php echo $i; ?>');">Remove</button></td>
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
            <a  class="btn btn-white btn-xs"  id="addproduct"><i class="fa fa-plus "> </i> Add New Row </a>
            <input type="hidden" name="rowIdxproduct" id="rowIdxproduct" value="<?php echo $i; ?>">
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">Total Number of Package (in words)</label>
            <div class="col-md-4">
              <input type="text" name="good_total_num_package" class="form-control" id="good_total_num_package" value="<?php echo $good_total_num_package; ?>">
            </div>
            <div class="col-md-1">
              <label style="padding-top: 5px;">Commodity</label>
            </div>
            <div class="col-md-4">
              <input type="text" name="good_commodity" class="form-control" id="good_commodity" value="<?php echo $good_commodity; ?>">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="ibox ">
        <div class="ibox-title">
          <h2>Charges / ค่าใช้จ่าย</h2>
          <div class="ibox-tools"><a class="collapse-link" id="x"><i class="fa fa-chevron-up"></i></a></div>
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
                    <th style="width:10%">Detail</th>
                    <th style="width:10%">Price</th>
                    <th style="width:10%">Volum</th>
                    <th style="width:10%">Exchange</th>
                    <th style="width:10%">Cost</th>
                    <th style="width:10%">Receive</th>
                    <th style="width:10%">Bill of receipt</th>
                    <th style="width:5%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $rowIdx = 1;
                  if ($acton != 'add' && $acton != 'copy') {
                    $sql = "
                      SELECT * from 
                      (SELECT
                      j.comCode,
                      j.ref_paymentCode,
                      j.chargeCode,
                      j.detail as chartDetail,
                      j.chargesCost,
                      j.chargesReceive,
                      j.chargesbillReceive
                      FROM
                      joborder_charge AS j
                      WHERE j.comCode='$db->comCode' AND j.documentID='$documentID' 
                      UNION ALL
                      SELECT
                      i.comCode,
                      i.documentID as ref_paymentCode,
                      i.chargeCode,
                      i.chartDetail,
                      i.amount as chargesCost,
                      0 as chargesReceive,
                      0 as chargesbillReceive
                      FROM  $db->dbname.payment_voucher AS m
                      INNER JOIN $db->dbname.payment_voucher_items AS i ON m.comCode = i.comCode AND m.documentID = i.documentID
                      WHERE m.comCode='$db->comCode' AND m.refJobNo='$documentID' AND m.documentstatus='A'
                      UNION ALL
                      SELECT
                      pm.comCode,
                      pm.documentID AS ref_paymentCode,
                      pd.chargeCode,
                      pd.chartDetail,
                      pd.amount as chargesCost,
                      0 as chargesReceive,
                      0 as chargesbillReceive
                      FROM $db->dbname.petty_cash AS pm
                      INNER JOIN $db->dbname.petty_cash_items AS pd ON pm.comCode = pd.comCode AND pm.documentID = pd.documentID
                      WHERE pm.comCode='$db->comCode' AND pm.refJobNo='$documentID' AND pm.documentstatus='A'
                      UNION ALL
                      SELECT
                      pm.comCode,
                      pm.documentID AS ref_paymentCode,
                      pd.chargeCode,
                      pd.chartDetail,
                      pd.amount as chargesCost,
                      0 as chargesReceive,
                      0 as chargesbillReceive
                      FROM $db->dbname.petty_cashshiping AS pm
                      INNER JOIN $db->dbname.petty_cashshiping_items AS pd ON pm.comCode = pd.comCode AND pm.documentID = pd.documentID
                      WHERE pm.comCode='$db->comCode' AND pm.refJobNo='$documentID' AND pm.documentstatus='A'
                      UNION ALL
                      SELECT
                      pm.comCode,
                      pm.documentID AS ref_paymentCode,
                      pd.chargeCode,
                      pd.chartDetail,
                      pd.amount as chargesCost,
                      0 as chargesReceive,
                      0 as chargesbillReceive
                      FROM $db->dbname.shiping_payment_voucher AS pm
                      INNER JOIN $db->dbname.shiping_payment_voucher_items AS pd ON pm.comCode = pd.comCode AND pm.documentID = pd.documentID
                      WHERE pm.comCode='$db->comCode' AND pm.refJobNo='$documentID' AND pm.documentstatus='A'

                      ) as t
                      GROUP BY  t.comCode,t.chargeCode,t.ref_paymentCode,t.chartDetail    ";


                    $result = $db->query($sql);
                    $i = 1;

                    while ($r = mysqli_fetch_array($result)) {
                      ?>
                      <tr class='gradeX' id='trCharge<?php echo $rowIdx; ?>'>
                        <td><?php echo $rowIdx; ?>
                          <input type="hidden" name="chargeitems[]"   value="<?php echo $r["chargeCode"]; ?>" id="chargeitems<?php echo $rowIdx; ?>">
                          <input type="hidden" name="ref_paymentCode[]"   value="<?php echo $r["ref_paymentCode"]; ?>" id="ref_paymentCode<?php echo $rowIdx; ?>"></td>
                        <td><input type="text" name="chargesDetail[]" class="form-control" value="<?php echo $r["chartDetail"]; ?>" id="chargesDetail<?php echo $rowIdx; ?>"></td>
                        <td class="center"><input type="number" name="price<?php echo $rowIdx; ?>"  onkeyup="call_price(),call_exchange(<?php echo $rowIdx; ?>)" class="form-control full" value="1" id="price<?php echo $rowIdx; ?>"></td>
                        <td class="center"><input type="number" name="volum<?php echo $rowIdx; ?>"   onkeyup="call_price(),call_exchange(<?php echo $rowIdx; ?>)" class="form-control full" value="1" id="volum<?php echo $rowIdx; ?>"></td>
                        <td class="center"><input type="number" name="exchange<?php echo $rowIdx; ?>"  onkeyup="call_price(),call_exchange(<?php echo $rowIdx; ?>)" class="form-control full" value="1" id="exchange<?php echo $rowIdx; ?>"></td>
                        <td class="center"><input type="number" name="chargesCost[]" <?php if ($r["ref_paymentCode"] != '') {
                          echo "readonly";
                        }
                        ; ?>  onkeyup="call_price()" class="form-control full" value="<?php echo $r["chargesCost"]; ?>" id="chargesCost<?php echo $rowIdx; ?>"></td>
                        <td class="center"><input type="number" name="chargesReceive[]" onkeyup="call_price()"  class="form-control full" value="<?php echo $r["chargesReceive"]; ?>" id="chargesReceive<?php echo $rowIdx; ?>"></td>
                        <td class="center"><input type="number" name="chargesbillReceive[]" onkeyup="call_price()"  class="form-control full" value="<?php echo $r["chargesbillReceive"]; ?>" id="chargesbillReceive<?php echo $rowIdx; ?>"></td>
                        <td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("Charge<?php echo $rowIdx; ?>")'>Remove</button></td>
                      </tr>
                      <?php
                      $rowIdx++;
                    }

                  }


                  $sqlContrainner = " SELECT 
                  GROUP_CONCAT(t.qty) as ct
                  from(
                  SELECT
                  concat(count(s.containersizeName),'x',(s.containersizeName))as qty
                  FROM
                  joborder_container AS j
                  INNER JOIN common_containertype AS c ON j.comCode = c.comCode AND j.containerType = c.containertypeCode
                  INNER JOIN common_containersize AS s ON j.comCode = s.comCode AND j.containerSize = s.containersizeCode
                  WHERE j.documentID='$documentID'  and j.documentID<>'' 
                  GROUP BY containersizeCode) as t ";
                                    $rcon = $db->fetch($sqlContrainner);

                                    $sqlpacked = " 
                  SELECT
                  concat(round(sum(j.packaed_totalCBM),2),' CBM') as qtyCBM
                  FROM
                  joborder_packed AS j
                  WHERE j.documentID='$documentID' and j.documentID<>'' ";
                  $rpacked = $db->fetch($sqlpacked);

                  if ($rcon['ct'] != "") {
                    $showCBM = $rcon['ct'];
                  } else {

                    $showCBM = $rpacked['qtyCBM'];
                  }


                  ?>
                <input    type="hidden" name="rowIdx" id="rowIdx" value="<?php echo $rowIdx; ?>">
                </tbody>
                
                <tfoot>
                  <tr>
                    <td style="width:5%"></td>
                    <td style="width:50%;"><strong>Volum : <?php echo $showCBM; ?></strong></td>
                    <td style="width:10%">&nbsp;</td>
                    <td style="width:10%">&nbsp;</td>
                    <td style="width:10%"><span style="width:50%; text-align: right;">Vat 7%</span></td>
                    <td style="width:10%"><input  type="hidden" name="vat_total_chargesCost" readonly class="form-control" value="" id="vat_total_chargesCost"></td>
                    <td style="width:10%"><input type="text" name="vat_total_chargesReceive" readonly class="form-control" value="" id="vat_total_chargesReceive"></td>
                    <td style="width:10%"><input type="hidden" name="vat_total_chargesbillReceive" readonly class="form-control" value="" id="vat_total_chargesbillReceive"></td>
                    <td style="width:5%"></td>
                  </tr>
                  <tr>
                    <td style="width:5%"></td>
                    <td style="width:50%; text-align: right;">&nbsp;</td>
                    <td style="width:10%">&nbsp;</td>
                    <td style="width:10%">&nbsp;</td>
                    <td style="width:10%"><span style="width:50%; text-align: right;">Toal 7%</span></td>
                    <td style="width:10%"><input type="text" name="total_chargesCost"  readonly class="form-control" value="" id="total_chargesCost"></td>
                    <td style="width:10%"><input type="text" name="total_chargesReceive" readonly class="form-control" value="" id="total_chargesReceive">
                      <input type="hidden" name="total_chargesReceive_beforevat" readonly class="form-control" value="" id="total_chargesReceive_beforevat"></td>
                    <td style="width:10%"><input type="text" name="total_chargesbillReceive" readonly class="form-control" value="" id="total_chargesbillReceive"></td>
                    <td style="width:5%"></td>
                  </tr>
                </tfoot>
              </table>
              <table class="table invoice-total">
                <tbody>
                  <tr>
                    <td><strong>รวม  :</strong></td>
                    <td><span id="total">0</span>
                      <input type="hidden" id="h_total" name="h_total" value=""></td>
                  </tr>
                  <tr>
                    <td><strong>ค่าบริการ Tax (3%) :</strong></td>
                    <td><span id="tax3">0</span>
                      <input type="hidden" id="h_tax3" name="h_tax3" value=""></td>
                  </tr>
                  <tr>
                    <td><strong>ค่าขนส่ง Tax (1%) :</strong></td>
                    <td><span id="tax1">0</span>
                      <input type="hidden" id="h_tax1"  name="h_tax1" value=""></td>
                  </tr>
                  <tr>
                    <td><strong>รวม :</strong></td>
                    <td><span id="grand_total">0</span>
                      <input type="hidden" id="h_grand_total" name="h_grand_total" value=""></td>
                  </tr>
                  <tr>
                    <td><strong>ลูกค้าสำรองจ่าย</strong></td>
                    <?php
                    $sql = "SELECT
                    sum(av.sumTotal) as sumTotal
                    FROM
                    advance_payment AS av
                    WHERE av.refJobNo='$documentID' and av.documentstatus='A' ";
                    $result = $db->fetch($sql);
                    $h_cus_paid = $result['sumTotal'];
                    ?>
                    <td><span id="cus_paid"><?php echo n2($h_cus_paid) ?></span>
                      <input type="hidden" id="h_cus_paid" name="h_cus_paid" value="<?php echo n2($h_cus_paid) ?>"></td>
                  </tr>
                  <tr>
                    <td><strong>คงเหลือจ่ายจริง</strong></td>
                    <td><span id="net_pad">0</span>
                      <input type="hidden" id="h_net_pad" name="h_net_pad" value=""></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="ibox ">
        <div class="ibox-title">
          <h2>ลูกค้าสำรองจ่าย</h2>
          <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
        </div>
        <div class="ibox-content collapse">
          <div class="form-group">
            <table class="table" width="100%" name="table_cash" id="table_cash">
              <thead>
                <tr>
                  <th style="width:5%">No.</th>
                  <th style="width:10%">documentID</th>
                  <th style="width:30%">detail</th>
                  <th style="width:20%">Amount</th>
                  <th style="width:10%">View</th>
                  <th style="width:10%">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT
                m.documentID,
                m.documentDate,
                m.refJobNo,
                i.chartDetail,
                i.amount,
                a.fileDetail,
                a.fileName,
                m.cusCode,
                rf.status_name,
                m.documentstatus
                FROM
                advance_payment AS m
                INNER JOIN $db->dbname.ref_documentstatus AS rf ON m.comCode = rf.comCode AND m.documentstatus = rf.status_code
                INNER JOIN advance_payment_items AS i ON m.comCode = i.comCode AND m.documentID = i.documentID
                LEFT JOIN advance_payment_attach AS a ON m.comCode = a.comCode AND m.documentID = a.documentID
                WHERE m.refJobNo='$documentID'  ";
                $result = $db->query($sql);
                $i_container = 1;
                $i = 1;
                $isActiveStype = "";
                while ($r = mysqli_fetch_array($result)) {
                  switch ($r['documentstatus']) {
                    case 'A':
                      $isActiveStype = 'primary';
                      break;
                    case 'P':
                      $isActiveStype = 'warning';
                      break;
                    case 'P':
                      $isActiveStype = 'danger';
                      break;
                    default:
                      $isActiveStype = 'primary';
                      break;
                  }
                  ?>
                <td><?php echo $i; ?></td>
                  <td><a href="advance_payment_form?action=edit&documentID=<?php echo $r['documentID']; ?>" target="_blank"><?php echo $r['documentID']; ?></a></td>
                  <td><?php echo $r['chartDetail']; ?></td>
                  <td><?php echo $r['amount']; ?></td>
                  <td><?php if ($r['fileName'] != '') { ?>
                      <a href="customer_path/<?php echo $r['cusCode']; ?>/<?php echo $r['fileName']; ?>" target="_blank">View</a>
                    <?php } else { ?>
                      No File
                    <?php } ?></td>
                  <td><span class="label label-<?php echo $isActiveStype; ?>"><?php echo $r['status_name']; ?></span></td>
                  <?php $i++;
                } ?>
                </tbody>
              <tfoot>
              </tfoot>
            </table>
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
                  <th style="width:10%">document</th>
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
                FROM
                joborder_attach AS t
                WHERE t.comCode='$db->comCode' AND t.documentID='$documentID' ";
                $result = $db->query($sql);
                $i_container = 1;
                $i = 99;

                if ($acton != 'add' && $acton != 'copy') {
                  while ($r = mysqli_fetch_array($result)) {

                    ?>
                    <tr class='gradeX' id='tr<?php echo $i; ?>'>
                      <td><?php echo $r['documentID']; ?></td>
                      <td><input type='hidden' name='imgKey[]'  value='"+obj.fileName+"' id='imgKey<?php echo $i; ?>'>
                        <input type='text' name='fileName[]' class='form-control' value='<?php echo $r['fileDetail']; ?>' id='fileName<?php echo $i; ?>'></td>
                      <td class='center'><a class='btn-white btn btn-xs' href='customer_path/<?php echo $r['cusCode'] . '/' . $r['fileName']; ?>' target='_blank'>View</a>
                        </button>
                        &nbsp;
                        <button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("<?php echo $i; ?>")'>Remove</button></td>
                    </tr>
                    <?php $i++;
                  }
                } ?>
                <?php

                $sql = "SELECT
                t.documentID,
                f.supCode,
                t.refJobNo,
                f.fileDetail,
                f.fileName
                FROM
                payment_voucher AS t
                INNER JOIN payment_voucher_attach AS f ON t.comCode = f.comCode AND t.documentID = f.documentID
                WHERE t.comCode='$db->comCode' AND t.refJobNo='$documentID' AND t.documentstatus='A' ";
                $result = $db->query($sql);
                if ($acton != 'add' && $acton != 'copy') {
                  while ($r = mysqli_fetch_array($result)) {

                    ?>
                    <tr class='gradeX' id='tr<?php echo $i; ?>'>
                      <td><?php echo $r['documentID']; ?></td>
                      <td><input type='hidden' name='imgKey[]'  value='"+obj.fileName+"' id='imgKey<?php echo $i; ?>'>
                        <input type='text' name='fileName[]' class='form-control' value='<?php echo $r['fileDetail']; ?>' id='fileName<?php echo $i; ?>'></td>
                      <td class='center'><a class='btn-white btn btn-xs' href='supplier_path/<?php echo $r['supCode'] . '/' . $r['fileName']; ?>' target='_blank'>View</a>
                        </button>
                        &nbsp;
                        <button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("<?php echo $i; ?>")'>Remove</button></td>
                    </tr>
                    <?php $i++;
                  }
                } ?>
                <?php
                $sql = "SELECT
                t.documentID,
                f.cusCode,
                t.refJobNo,
                f.fileDetail,
                f.fileName
                FROM
                advance_payment AS t
                INNER JOIN advance_payment_attach AS f ON t.comCode = f.comCode AND t.documentID = f.documentID
                WHERE t.comCode='$db->comCode' AND t.refJobNo='$documentID' AND t.documentstatus='A'  ";
                $result = $db->query($sql);
                if ($acton != 'add' && $acton != 'copy') {
                  while ($r = mysqli_fetch_array($result)) {

                    ?>
                    <tr class='gradeX' id='tr<?php echo $i; ?>'>
                      <td><?php echo $r['documentID']; ?></td>
                      <td><input type='hidden' name='imgKey[]'  value='"+obj.fileName+"' id='imgKey<?php echo $i; ?>'>
                        <input type='text' name='fileName[]' class='form-control' value='<?php echo $r['fileDetail']; ?>' id='fileName<?php echo $i; ?>'></td>
                      <td class='center'><a class='btn-white btn btn-xs' href='customer_path/<?php echo $r['cusCode'] . '/' . $r['fileName']; ?>' target='_blank'>View</a>
                        </button>
                        &nbsp;
                        <button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("<?php echo $i; ?>")'>Remove</button></td>
                    </tr>
                    <?php $i++;
                  }
                } ?>
                <?php
                $sql = "SELECT
                t.documentID,
                f.cusCode,
                t.refJobNo,
                f.fileDetail,
                f.fileName
                FROM
                deposit AS t
                INNER JOIN deposit_attach AS f ON t.comCode = f.comCode AND t.documentID = f.documentID
                WHERE t.comCode='$db->comCode' AND t.refJobNo='$documentID' AND t.documentstatus='A'  ";
                $result = $db->query($sql);
                if ($acton != 'add' && $acton != 'copy') {
                  while ($r = mysqli_fetch_array($result)) {

                    ?>
                    <tr class='gradeX' id='tr<?php echo $i; ?>'>
                      <td><?php echo $r['documentID']; ?></td>
                      <td><input type='hidden' name='imgKey[]'  value='"+obj.fileName+"' id='imgKey<?php echo $i; ?>'>
                        <input type='text' name='fileName[]' class='form-control' value='<?php echo $r['fileDetail']; ?>' id='fileName<?php echo $i; ?>'></td>
                      <td class='center'><a class='btn-white btn btn-xs' href='customer_path/<?php echo $r['cusCode'] . '/' . $r['fileName']; ?>' target='_blank'>View</a>
                        </button>
                        &nbsp;
                        <button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("<?php echo $i; ?>")'>Remove</button></td>
                    </tr>
                    <?php $i++;
                  }
                } ?>
              </tbody>
              <tfoot>
              </tfoot>
            </table>
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
                <button name="back" class="btn btn-white" type="button" onclick="window.location='job'"><i class="fa fa-reply"></i> Back</button>
                <?php
                if ($_SESSION['userTypecode'] == '1') {
                  $disabled = '';
                }

                if ($acton != 'view') {
                  if ($documentstatus != 'A') {
                    ?>
                    <button name="save" id="save" class="btn btn-primary" type="button" <?php echo $disabled; ?>><i class="fa fa-save"></i> Save</button>
                    <?php
                  }
                  if ($_SESSION['userTypecode'] == '1') {
                    ?>
                    <button name="Approve" id="Approve" class="btn btn-primary" type="button" <?php echo $disabled; ?>><i class="fa fa-save"></i> Approve</button>
                  <?php }
                } ?>
                <button class="btn btn-white " type="button" onclick="openInNewTab('<?php echo 'job_pdf'; ?>');" ><i class="fa fa-print"></i> Job</button>
                <button class="btn btn-white " type="button" onclick="openInNewTab('<?php echo 'booking_confirm_pdf'; ?>');" ><i class="fa fa-print"></i> Booking confirm</button>
                <button class="btn btn-white " type="button" onclick="openInNewTab('<?php echo 'trailerbooking_pdf'; ?>');" ><i class="fa fa-print"></i> Trailer booking</button>
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