<script src="js/plugins/dataTables/datatables.min.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

<link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<script>
        $(document).ready(function(){
            $('.dataTables').DataTable({
                pageLength: 100,
                responsive: true,
                dom: '<"pull-left"f><"html5buttons"B>lTgitp',
		
				
				bInfo : false,
				
				lengthChange: false,
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Customer List'},
                    {extend: 'pdf', title: 'Customer List'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Booking Request / ใบจองตู้ </h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item">Customer </li>
      <li class="breadcrumb-item"> <a>Booking Request </a> </li>
    </ol>
  </div>
  <div class="col-lg-2"> </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight"> <!-- Body-->
  
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox ">
        <div class="ibox-title">
          <h5>Charges List</h5>
          <div class="ibox-tools"> <a href="booking_request_form" class="btn btn-primary btn-xs"><i class="fa fa-plus "> </i> Create new </a> </div>
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
            <table class="table table-hover dataTables">
              <thead>
                <tr>
                  <th style="width:5%">No.</th>
                  <th style="width:10%">Document No.</th>
                  <th style="width:25%">Customer</th>
                  <th style="width:10%">Type</th>
                  <th style="width:10%">Size</th>
                  <th style="width:10%">ETD</th>
                  <th style="width:10%">ETA</th>
                  <th style="width:10%">Status</th>
                  <th style="width:10%">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  END Body-->