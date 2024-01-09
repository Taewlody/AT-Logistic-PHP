
<?php
require_once( 'class.php' );
require_once( 'function.php' );

$db=new cl;
$db->connect();
?>

<!-- FooTable --> 
<script src="js/plugins/footable/footable.all.min.js"></script> 
<!-- FooTable -->
<link href="css/plugins/footable/footable.core.css" rel="stylesheet">

<script >
function confirmDel(ID,URL){
  swal({
        title: "Are you sure?",
        text: "You will not be able to recover this Data !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function () {
	  
	  
  					var jsonObj={
						action:'del',
						unitCode:ID
					}; 
					$.ajax({
					   	type: "POST",
					   	url: URL,
					   	data: jsonObj,
					   	success: function(data) {
						if(data=='success'){
						 swal("Deleted!", "Your Data file has been deleted.", "success");
							setTimeout(function(){ 
							 window.location.reload(1);	
							}, 1000);
						  }else{
							 msgError();
							 console.log("Error : ", data);
						  }	 
					   }
					 });
    });

}

        $(document).ready(function(){

          $("#form").validate({
                rules: {
                
               
                    unitName: {required: true },
                
                   
                 }
     });


          $('.footable').footable();

        });

    </script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Unit / หน่วยนับ</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Common Data</a></li>
      <li class="breadcrumb-item"> <a>Unit</a> </li>
    </ol>
  </div>
  <div class="col-lg-2"> </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight"> <!-- Body-->
  
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox ">
        <div class="ibox-title">
          <h5>Unit List</h5>
          <div class="ibox-tools"> <a href="unit_form?action=add" class="btn btn-primary btn-xs"><i class="fa fa-plus "> </i> Create new </a> </div>
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
			   <input type="text" class="form-control form-control-sm m-b-xs" id="filter"placeholder="Search in table">
			  
			   
          <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="50" data-filter=#filter>
              <thead>
                <tr>
                  <th style="width:5%">No.</th>
                  <th style="width:10%">Code</th>
                  <th style="width:40%">Unit Name</th>
                  <th  style="width:10%">Status</th>
                  <th data-hide="phone"  style="width:10%">Update By</th>
                  <th data-hide="phone,tablet"  style="width:10%">Action</th>
                </tr>
              </thead>
              <tbody>

<?php
$sql="SELECT
c.unitCode,
c.unitName,
c.isActive,
c.editID,
c.editTime,
a.acttiveName,
u.username
FROM $db->dbname.common_unit AS c
INNER JOIN $db->dbname.ref_active AS a ON c.comCode = a.comCode AND c.isActive = a.`code`
INNER JOIN $db->dbname.user AS u ON c.comCode = u.comCode AND c.createID = u.usercode order by c.unitCode  ";
$result=$db->query($sql);
$i=1;
$isActiveStype="";
while($r=mysqli_fetch_array($result)){
if($r['isActive']=='1'){$isActiveStype='primary';}else{$isActiveStype='danger';}
?>
                <tr class="gradeX">
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $r['unitCode'];?></td>
                  <td><?php echo $r['unitName']; ?></td>
                  <td class="center"> <span class="label label-<?php echo $isActiveStype;?>"><?php echo $r['acttiveName']; ?></span></td>
                  <td class="center"><?php echo $r['username'];?></td>
                  <td class="center">
                    <div class="btn-group">
                      <button class="btn-white btn btn-xs" onClick="location.href='unit_form?action=view&unitCode=<?php echo $r['unitCode'];?>' ">View</button>
                      <button class="btn-white btn btn-xs" onClick="location.href='unit_form?action=edit&unitCode=<?php echo $r['unitCode'];?>' ">Edit</button>
                      <button class="btn-white btn btn-xs" onClick="return confirmDel('<?php echo $r['unitCode']; ?>','unit_action.php');">Delete</button>
                    </div>
                </tr>
<?php  
}
?>


                
              </tbody>
              <tfoot>
              <tr>
                  <td colspan="10"><ul class="pagination float-left">
                    </ul></td>
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