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
    <h2>Supplier / ผู้จำหน่าย</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Common Data</a></li>
      <li class="breadcrumb-item">Supplier</li>
    </ol>
  </div>
  <div class="col-lg-2"> </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight"> <!-- Body-->
  
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox ">
        <div class="ibox-title">
          <h5>Supplier List</h5>
          <div class="ibox-tools"> <a href="supplier_form" class="btn btn-primary btn-xs"><i class="fa fa-plus "> </i> Create new </a> </div>
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
            <table class="table table-hover dataTables">
              <thead>
                <tr>
                  <th style="width:5%">No.</th>
                  <th style="width:10%">Code</th>
                  <th style="width:60%">Name</th>
                  <th style="width:10%">Status</th>
                  <th style="width:10%">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr class="gradeX">
                  <td>1</td>
                  <td>C-0001</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
                  <td class="center">Active</td>
                  <td class="center"><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                </tr>
                <tr class="gradeC">
                  <td>2</td>
                  <td>C-0002</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
                  <td class="center">Active</td>
                  <td class="center"><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                </tr>
                <tr class="gradeA">
                  <td>3</td>
                  <td>C-0003</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
                  <td class="center">Active</td>
                  <td class="center"><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                </tr>
                <tr class="gradeA">
                  <td>4</td>
                  <td>C-0004</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
                  <td class="center">Active</td>
                  <td class="center"><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                </tr>
                <tr class="gradeA">
                  <td>5</td>
                  <td>C-0005</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
                  <td class="center">Active</td>
                  <td class="center"><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                </tr>
                <tr class="gradeA">
                  <td>6</td>
                  <td>C-0006</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
                  <td class="center">Active</td>
                  <td class="center"><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                </tr>
                <tr class="gradeA">
                  <td>7</td>
                  <td>C-0007</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
                  <td class="center">Active</td>
                  <td class="center"><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                </tr>
                <tr class="gradeA">
                  <td>8</td>
                  <td>C-0008</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
                  <td class="center">Active</td>
                  <td class="center"><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                </tr>
                <tr class="gradeA">
                  <td>9</td>
                  <td>C-0009</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
                  <td class="center">Active</td>
                  <td class="center"><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                </tr>
                <tr class="gradeA">
                  <td>10</td>
                  <td>C-0010</td>
                  <td>แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด</td>
                  <td class="center">Active</td>
                  <td class="center"><a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp; <a href="customer_form"><i class="fa fa-trash  text-navy"></i></a></td>
                </tr>
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