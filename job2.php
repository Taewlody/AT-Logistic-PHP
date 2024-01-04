

<!-- FooTable -->
<link href="css/plugins/footable/footable.core.css" rel="stylesheet">


<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<!-- Data picker --> 
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script> 

    <!-- FooTable -->
<script src="js/plugins/footable/footable.all.min.js"></script>
<link href="css/plugins/footable/footable.core.css" rel="stylesheet">


<script>
        $(document).ready(function(){
			
			
			$('.select2_single').select2({});
			
    /*
       $('.dataTables').DataTable({
                pageLength: 100,
                responsive: true,
                dom: '<"pull-left"><"html5buttons">lTgitp',
				bInfo : false,
				lengthChange: false
   

            });
			*/
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
    <h2>Job Orders</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Sale</a></li>
      <li class="breadcrumb-item"> <a>Job Orders</a></li>
    </ol>
  </div>
  <div class="col-lg-2"> </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight"> <!-- Body-->
  <div class="row">
	  
    <div class="col-lg-12">
		
		  <div class="ibox ">
        <div class="ibox-title">
          <h5>Search Condition</h5>
          <div class="ibox-tools"> <a href="job_form" class="btn btn-primary btn-xs"><i class="fa fa-plus "> </i> Create new </a> </div>
        </div>
		<div class="ibox-content m-b-sm border-bottom">
			
                <div class="row">
					
					   <div class="col-sm-2 col-margin0">
					<div class="form-group" id="data_1">
                      <label class="col-form-label">Date Start</label>
                      <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control" value="03/04/2014">
                      </div>
                    </div>
					</div> <div class="col-sm-2 col-margin0" >
					    <div class="form-group" id="data_2">
                      <label class="col-form-label">To Date</label>
                      <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control" value="03/04/2014">
                      </div>
                    </div>
					</div>
					
					
                    <div class="col-sm-1 col-margin0">
                        <div class="form-group">
                            <label class="col-form-label" for="product_name">JOb No.</label>
                            <input type="text" id="product_name" name="product_name" value=""  class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2 col-margin0">
                        <div class="form-group">
                            <label class="col-form-label" for="price">Customer</label>
                                <select class="select2_single form-control select2">
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                        <option value="4">Option 4</option>
                                        <option value="5">Option 5</option>
                                    </select>
                        </div>
                    </div>
                    <div class="col-sm-1 col-margin0">
                        <div class="form-group">
                            <label class="col-form-label" for="quantity">Sale</label>
                             <select class="select2_single form-control select2">
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                        <option value="4">Option 4</option>
                                        <option value="5">Option 5</option>
                                    </select>
                        </div>
					
						
                    </div>
					
					
                         <div class="col-sm-1 col-margin0">
                        <div class="form-group" style="margin-top: 33px;">
                         <button type="submit" class="btn btn-primary">Search</button>
							
                        </div>
                    </div>      
					
					
				
					
					
					
					
					
					
                </div>

            </div>
		</div>
		
		
		
      <div class="ibox ">
        
        <div class="ibox-content">
          <div class="table-responsive">
          
            <table class="footable table table-stripped toggle-arrow-tiny" width="100%">
                                <thead>
                                <tr>
                                  <th width="5%" >No.</th>
                                    <th data-toggle="true" width="15%">Job No.</th>
                                    <th width="10%">Job Date</th>
                                    <th width="30%">Customer</th>
                                    <th width="15%">Sale</th>
                                    <th width="10%">Status</th>
                                    <th data-hide="all">Invoice</th>
                                    <th data-hide="all">Booking Tractor</th>
                                    <th data-hide="all">Bill of Laning</th>
                                    <th data-hide="all">Cargo ship</th>
                                    <th width="10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                  <td>1</td>
                                    <td>JO2105-0001</td>
                                    <td>4/6/2021</td>
                                    <td>TORRANCE CALIFORNIA </td>
                                    <td>Sales1</td>
                                    <td>Inprocess</td>
                                    <td><a href="" class="text-info">IV2106-0001</a></td>
                                    <td>BT2106-0001</td>
                                    <td>BOL2106-0001</td>
                                    <td>CS2106-0001</td>
                                    <td><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                    <td>JO2105-0002</td>
                                    <td>4/6/2021</td>
                                    <td>TORRANCE CALIFORNIA</td>
                                    <td>Sales1</td>
                                  <td>Inprocess</td>
                                    <td>IV2106-0001</td>
                                    <td>BT2106-0001</td>
                                    <td>BOL2106-0001</td>
                                    <td>CS2106-0001</td>
                                    <td><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                                </tr>
                                <tr>
                                  <td>3</td>
                                    <td>JO2105-0003</td>
                                    <td>4/6/2021</td>
                                    <td>TORRANCE CALIFORNIA</td>
                                    <td>Sales1</td>
                                  <td>Inprocess</td>
                                  <td>IV2106-0001</td>
                                  <td>BT2106-0001</td>
                                  <td>BOL2106-0001</td>
                                  <td>CS2106-0001</td>
                                    <td><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                                </tr>
                                <tr>
                                  <td>4</td>
                                    <td>JO2105-0004</td>
                                    <td>4/6/2021</td>
                                    <td>TORRANCE CALIFORNIA </td>
                                    <td>Sales1</td>
                                  <td>Inprocess</td>
                                  <td>IV2106-0001</td>
                                  <td>BT2106-0001</td>
                                  <td>BOL2106-0001</td>
                                  <td>CS2106-0001</td>
                                    <td><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                                </tr>
                                <tr>
                                  <td>5</td>
                                    <td>JO2105-0005</td>
                                    <td>4/6/2021</td>
                                    <td>TORRANCE CALIFORNIA</td>
                                    <td>Sales1</td>
                                  <td>Inprocess</td>
                                  <td>IV2106-0001</td>
                                  <td>BT2106-0001</td>
                                  <td>BOL2106-0001</td>
                                  <td>CS2106-0001</td>
                                    <td><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                                </tr>
                                <tr>
                                  <td>6</td>
                                    <td>JO2105-0006</td>
                                    <td>4/6/2021</td>
                                    <td>TORRANCE CALIFORNIA</td>
                                    <td>Sales1</td>
                                  <td>Inprocess</td>
                                  <td>IV2106-0001</td>
                                  <td>BT2106-0001</td>
                                  <td>BOL2106-0001</td>
                                  <td>CS2106-0001</td>
                                    <td><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                                </tr>
                                <tr>
                                  <td>7</td>
                                    <td>JO2105-0007</td>
                                    <td>4/6/2021</td>
                                    <td>TORRANCE CALIFORNIA </td>
                                    <td>Sales1</td>
                                  <td>Inprocess</td>
                                  <td>IV2106-0001</td>
                                  <td>BT2106-0001</td>
                                  <td>BOL2106-0001</td>
                                  <td>CS2106-0001</td>
                                    <td><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                                </tr>
                                <tr>
                                  <td>8</td>
                                    <td>JO2105-0008</td>
                                    <td>4/6/2021</td>
                                    <td>TORRANCE CALIFORNIA</td>
                                    <td>Sales1</td>
                                  <td>Inprocess</td>
                                  <td>IV2106-0001</td>
                                  <td>BT2106-0001</td>
                                  <td>BOL2106-0001</td>
                                  <td>CS2106-0001</td>
                                    <td><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                                </tr>
                                <tr>
                                  <td>9</td>
                                    <td>JO2105-0009</td>
                                    <td>4/6/2021</td>
                                    <td>TORRANCE CALIFORNIA</td>
                                    <td>Sales1</td>
                                  <td>Inprocess</td>
                                  <td>IV2106-0001</td>
                                  <td>BT2106-0001</td>
                                  <td>BOL2106-0001</td>
                                  <td>CS2106-0001</td>
                                    <td><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                                </tr>
                                <tr>
                                  <td>10</td>
                                    <td>JO2105-0010</td>
                                    <td>4/6/2021</td>
                                    <td>TORRANCE CALIFORNIA</td>
                                    <td>Sales1</td>
                                  <td>Inprocess</td>
                                  <td>IV2106-0001</td>
                                  <td>BT2106-0001</td>
                                  <td>BOL2106-0001</td>
                                  <td>CS2106-0001</td>
                                    <td><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <ul class="pagination float-left"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  END Body-->