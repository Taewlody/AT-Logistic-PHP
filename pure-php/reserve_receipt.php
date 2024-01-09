

<!-- Data picker -->
<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script> 


<!-- FooTable --> 
<script src="js/plugins/footable/footable.all.min.js"></script> 
<!-- FooTable -->
<link href="css/plugins/footable/footable.core.css" rel="stylesheet">

<script>
        $(document).ready(function(){
			
			
			$('.select2_single').select2({});
			

			
			
$('.footable').footable();
			
			
			
     var mem = $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
     var mem = $('#data_2 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
			
				
        });

    </script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2><span class="breadcrumb-item"> <a>Reserve Receipt</a></span> / ใบสำรองรับ</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item">Shipping</li>
      <li class="breadcrumb-item"> <a> <a>Reserve Receipt</a></a></li>
    </ol>
  </div>
  <div class="col-lg-2"> </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight ecommerce">

  <div class="ibox-title">
          <h5>Search Condition</h5>
          <div class="ibox-tools"> 
			  <a href="reserve_receipt_form" class="btn btn-primary btn-xs"><i class="fa fa-plus "> </i> Create new </a> 
	  
	  
	  
	  </div>
        </div>
            <div class="ibox-content m-b-sm border-bottom">
				
               <form id="form1" name="form1" method="post">
              <div class="row m-b-sm m-t-sm">
                <div class="col-md-11">
                  <div class="input-group">
                    <div class="form-group col-margin0" id="data_1">
                      <label class="font-normal">Date Start</label>
                      <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control" value="03/04/2014">
                      </div>
                    </div>
                    <div class="form-group col-margin0" id="data_2">
                      <label class="font-normal">To Date</label>
                      <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control" value="03/04/2014">
                      </div>
                    </div>
                    <div class="form-group" >
                      <label class="font-normal">Document  No.</label>
                      <div class="input-group">
                        <input type="text" class="form-control" value="">
                      </div>
                    </div>
                    <div class="form-group col-margin0" >
                      <label class="font-normal">Customer</label>
                      <div >
                        <select class="select2_single form-control select2" style="width: 200px;">
                          <option value="1">Option 1</option>
                          <option value="2">Option 2</option>
                          <option value="3">Option 3</option>
                          <option value="4">Option 4</option>
                          <option value="5">Option 5</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-margin0" >
                      <label class="font-normal">Sale</label>
                      <div class="input-group">
                        <div class="">
                          <select class="select2_single form-control select2" style="width: 200px;">
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                            <option value="4">Option 4</option>
                            <option value="5">Option 5</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group" >
                      <label class="font-normal" style="color: wheat">.</label>
                      <div class="input-group">
                        <button type="submit" class="btn btn-primary">Search</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
						
                        <div class="ibox-content">

                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
              <thead>
                <tr>
                  <th width="5%">No.</th>
                  <th data-toggle="true" width="10%">Document  No.</th>
                  <th data-hide="phone" width="15%"> Date</th>
                  <th data-toggle="true" width="25%">Customer</th>
                
               
                  <th data-hide="phone,tablet" width="15%">Amount</th>
                  <th data-hide="phone,tablet" width="15%">Ref. Job</th>
                  <th data-hide="phone,tablet" width="15%">Status</th>
                  <th class="text-center" data-sort-ignore="true" width="15%">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>INV2106-001</td>
                  <td>16/6/2021</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
           
             
                  <td>100</td>
                  <td>&nbsp;</td>
                  <td><span class="label label-primary">Approve</span></td>
                  <td class="text-right"><div class="btn-group">
                      <button class="btn-white btn btn-xs">View</button>
                      <button class="btn-white btn btn-xs">Edit</button>
                      <button class="btn-white btn btn-xs">Delete</button>
                    </div></td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>INV2106-002</td>
                  <td>16/6/2021</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
                  
                  
               
                  <td>100</td>
                  <td>&nbsp;</td>
                  <td><span class="label label-primary">Approve</span></td>
                  <td class="text-right"><div class="btn-group">
                      <button class="btn-white btn btn-xs">View</button>
                      <button class="btn-white btn btn-xs">Edit</button>
                      <button class="btn-white btn btn-xs">Delete</button>
                    </div></td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>INV2106-003</td>
                  <td>16/6/2021</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
              
                
                
                  <td>100</td>
                  <td>&nbsp;</td>
                  <td><span class="label label-danger">Cancel</span></td>
                  <td class="text-right"><div class="btn-group">
                      <button class="btn-white btn btn-xs">View</button>
                      <button class="btn-white btn btn-xs">Edit</button>
                      <button class="btn-white btn btn-xs">Delete</button>
                    </div></td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>INV2106-004</td>
                  <td>16/6/2021</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
            
               
                  <td>100</td>
                  <td>&nbsp;</td>
                  <td><span class="label label-primary">Approve</span></td>
                  <td class="text-right"><div class="btn-group">
                      <button class="btn-white btn btn-xs">View</button>
                      <button class="btn-white btn btn-xs">Edit</button>
                      <button class="btn-white btn btn-xs">Delete</button>
                    </div></td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>INV2106-005</td>
                  <td>16/6/2021</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
      
                
                  <td>100</td>
                  <td>&nbsp;</td>
                  <td><span class="label label-warning">Inprocess</span></td>
                  <td class="text-right"><div class="btn-group">
                      <button class="btn-white btn btn-xs"  disabled >View</button>
                      <button class="btn-white btn btn-xs">Edit</button>
                      <button class="btn-white btn btn-xs">Delete</button>
                    </div></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="11"><ul class="pagination float-left">
                    </ul></td>
                </tr>
              </tfoot>
            </table>

                        </div>
                    </div>
                </div>
            </div>


        </div>

<!--  END Body-->