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
$(document).ready(function () {
	
	$('.select2_single').select2({
		/*
       allowClear: true,
       placeholder: 'Select',    
         language: {
             noResults: function() {
            return `<button style="width: 100%" type="button" class="btn btn-primary"  onClick='task()'>+ Add New Item</button> </li>`;
            }
         },
       
        escapeMarkup: function (markup) {
            return markup;
        }
		*/
    });
	
        
	/*
$('.chosen-select').select2({
	    allowClear: true,
       placeholder: 'This is my placeholder',    
         language: {
             noResults: function() {
            return `<button style="width: 100%" type="button"
            class="btn btn-primary" 
            onClick='task()'>+ Add New Item</button>
            </li>`;
            }
         },
       
        escapeMarkup: function (markup) {
            return markup;
        },
width: "100%"
});
   		*/	
	
	
	
	
	
    var mem = $('.date .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });			
			
	      $('.clockpicker').clockpicker();		
			
});
	


</script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-6">
    <h2>Reserve Payment / ใบสำรองจ่าย</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Account</a></li>
      <li class="breadcrumb-item"> <a>Tax Invoice</a> </li>
      <li class="breadcrumb-item"> <a>Tax Invoice Form</a></li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<!-- Body-->

<div class="row">
  <div class="col-lg-6">
    <div class="ibox ">
      <div class="ibox-title">
        <h2>Document</h2>
        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
      </div>
      <div class="ibox-content">
		  
		  
		  
		  
		 <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Document No.</label>
          <div class="col-md-9">
           <input type="text" name="cusCode" class="form-control">
          </div>
        </div>
		  
		  
   	 <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Document Date</label>
          <div class="col-md-9">
       <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input  type="text" class="form-control input-group date" value="03/04/2014"  >
            </div>
          </div>
        </div>
		  

		 <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Customer</label>
          <div class="col-md-9">
         <select class="select2_single form-control select2">
              <option value="1">Customer1</option>
              <option value="2">Customer2</option>
            </select>
          </div>
        </div>	  
		  

   		 <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Address</label>
          <div class="col-md-9">
         <input type="text" name="cusCode" class="form-control">
          </div>
        </div>	 
		  
		 		 <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Ref. JobNo.</label>
          <div class="col-md-9">
         <select class="select2_single form-control select2">
              <option value="1">JO2106-0001</option>
            </select>
          </div>
        </div>	  
		   
		  
 	 
		  
		  
		  
		  
	
     
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="ibox ">
      <div class="ibox-title">
        <h2>Payment</h2>
        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
      </div>
      <div class="ibox-content">
 
        <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Cash</label>
          <div class="col-md-9">
            <input type="number" name="cusCode" class="form-control">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Bank Name</label>
          <div class="col-md-9">
            <select class="select2_single form-control select2">
              <option value="1">kasikorn bank</option>
              
            </select>
          </div>
        </div>
		  
	     <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Cheque No.</label>
          <div class="col-md-9">
            <input type="number" name="cusCode" class="form-control">
          </div>
        </div>
		  
		  
        <div class="form-group  row">
          <label class="col-sm-3 col-form-label">cheque Date</label>
          <div class="col-md-9">
               <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input  type="text" class="form-control input-group date" value="03/04/2014"  >
            </div>
          </div>
        </div>
       <div class="form-group  row">
          <label class="col-sm-3 col-form-label">Amount</label>
          <div class="col-md-9">
            <input type="number" name="cusCode" class="form-control">
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
		  <select class="select2_single form-control select2">
                    <option value="1">Select</option>
          </select>
		  </div>
		   
		  <div class="col-md-2" style="padding-left: 0px;">
			  <button class="btn btn-white "  type="button"><i class="fa fa-plus"></i> Add</button>
		  </div>
		  </div>
		  
		  
		  
		  
		  
		  
		  
		  
      </div>
      <div class="ibox-content">
        <div class="form-group">
          <div class="table-responsive">
            <table class="table" width="100%">
              <thead>
                <tr>
                  <th style="width:5%">No.</th>
                  <th style="width:50%">Detail</th>
                  <th style="width:10%"><span style="width:25%">Amount</span></th>
                  <th style="width:5%">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr class="gradeX">
                  <td>1</td>
                  <td><span class="center">
                    <input type="text" name="cusCode2" class="form-control">
                  </span></td>
                  <td class="center"><input type="number" name="cusCode3" class="form-control" value="0"></td>
                  <td class="center"><a href="#"><i class="fa fa-trash text-navy"></i></a></td>
                </tr>
                <tr class="gradeX">
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="center">&nbsp;</td>
                  <td class="center"></td>
                </tr>
              </tbody>
              <tfoot>
              </tfoot>
            </table>
          </div>
			
			
     <div class="form-group row">
          <label class="col-lg-6 col-form-label">
		remark
			  
			  <textarea rows="8"  class="form-control"></textarea></label>
         
         
          <div class="col-lg-6">
             <table class="table invoice-total">
              <tbody>
                <tr>
                  <td><strong>TOTAL :</strong></td>
                  <td> 10,000.00</td>
                </tr>
                <tr>
                  <td><strong>VAT 7% :</strong></td>
                  <td>700.00</td>
                </tr>
                <tr>
                  <td><strong>GRAND TOTAL :</strong></td>
                  <td>10,700.00</td>
                </tr>
                <tr>
                  <td><strong>WH TAX 3% :</strong></td>
                  <td>321.00</td>
                </tr>
                <tr>
                  <td><strong>WH TAX 1% :</strong></td>
                  <td>107.00</td>
                </tr>
                <tr>
                  <td><strong>NET PAD:</strong></td>
                  <td>10,272.00</td>
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
            <label>admin  1/1/2021 : 03:12:20</label>
          </div>
        </div>
        <div class="form-group  row">
          <label class="col-sm-2 col-form-label">Update By</label>
          <div class="col-sm-10">
            <label>admin  1/1/2021 : 03:12:20</label>
          </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group row">
          <div class="col-sm-10 col-sm-offset-2">
			  
			  
            <button class="btn btn-primary " type="submit"><i class="fa fa-save"></i> Save</button>
			  <button class="btn btn-success " type="submit"><i class="fa fa-check"></i> Approve</button> 
			<button class="btn btn-white " type="submit"><i class="fa fa-print"></i> Print</button>
	
		
		
		
		
		</div>
        </div>
      </div>
    </div>
  </div>
	
  </div>
  <br>
</div>
<!--  END Body-->