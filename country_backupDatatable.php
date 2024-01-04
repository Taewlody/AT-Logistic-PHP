
<?php
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
?>
<script src="js/plugins/dataTables/datatables.min.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

<link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<script >
        $(document).ready(function(){

            $('.dataTables').DataTable({
                pageLength: 100,
                responsive: true,
                "responsive": true,
                "columnDefs": [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 4 }
                ],
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
    <h2>Country / ประเทศ</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Common Data</a></li>
      <li class="breadcrumb-item"> <a>Country</a> </li>
    </ol>
  </div>
  <div class="col-lg-2"> </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight"> <!-- Body-->
  
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox ">
        <div class="ibox-title">
          <h5>Country List</h5>
          <div class="ibox-tools"> <a href="country_form?action=add" class="btn btn-primary btn-xs"><i class="fa fa-plus "> </i> Create new </a> </div>
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
            <table class="table table-hover dataTables">
              <thead>
                <tr>
                  <th style="width:5%">No.</th>
                  <th style="width:10%">Code</th>
                  <th style="width:40%">Name</th>
                  <th style="width:10%">Status</th>
                  <th style="width:10%" data-priority="1">Update By</th>
                  <th data-hide="phone,tablet"  style="width:10%">Action</th>
                </tr>
              </thead>
              <tbody>

<?php
$sql="SELECT
c.countryCode,
c.countryNameTH,
c.countryNameEN,
c.isActive,
c.editID,
c.editTime,
a.acttiveName,
u.username
FROM $db->dbname.country AS c
INNER JOIN $db->dbname.ref_active AS a ON c.comCode = a.comCode AND c.isActive = a.`code`
INNER JOIN $db->dbname.user AS u ON c.comCode = u.comCode AND c.createID = u.usercode ";
$result=$db->query($sql);
$i=1;
while($r=mysqli_fetch_array($result)){
?>
                <tr class="gradeX">
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $r['countryCode'];?></td>
                  <td><?php echo $r['countryNameTH']; ?></td>
                  <td class="center"><?php echo $r['isActive']; ?></td>
                  <td class="center"><?php echo $r['username'];?></td>
                  <td class="center">
                    <a href="customer_form"><i class="fa fa-search text-navy"></i></a>&nbsp;&nbsp;&nbsp; 
                    <a href="customer_form"><i class="fa fa-pencil-square-o text-navy"></i></a>&nbsp;&nbsp;&nbsp;
                    <a href="customer_form"><i class="fa fa-trash text-navy"></i></a></td>
                </tr>
<?php  
}
?>


                
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