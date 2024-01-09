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

<script>
  function confirmDel(ID, URL) {
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this Data !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    }, function () {

      var jsonObj = {
        action: 'del',
        fCode: ID
      };
      $.ajax({
        type: "POST",
        url: URL,
        data: jsonObj,
        success: function (data) {
          if (data == 'success') {
            swal("Deleted!", "Your Data file has been deleted.", "success");
            setTimeout(function () {
              window.location.reload(1);
            }, 1000);
          } else {
            msgError();
            console.log("Error : ", data);
          }
        }
      });
    });

  }

  $(document).ready(function () {
    $("#form").validate({
      rules: {
        fName: {
          required: true
        },
      }
    });
    // $('.footable').footable();
  });
</script>

<!-- Start Search all columns -->
<script>
  $(document).ready(function () {
    $('#filter').keyup(function () {
      var search = $(this).val();
      $('table tbody tr').hide();
      var len = $('table tbody tr:not(.notfound) td:contains("' + search + '")').length;

      if (len > 0) {
        $('table tbody tr:not(.notfound) td:contains("' + search + '")').each(function () {
          $(this).closest('tr').show();
        });
      } else {
        $('.notfound').show();
      }
    });

    // Case-insensitive searching (Note - remove the below script for Case sensitive search )
    $.expr[":"].contains = $.expr.createPseudo(function (arg) {
      return function (elem) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
      };
    });
  });
</script>
<!-- Start Search all columns -->

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Feeder / ชื่อเรือ</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Common Data</a></li>
      <li class="breadcrumb-item">Feeder</li>
    </ol>
  </div>
  <div class="col-lg-2"> </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <!-- Body-->

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox ">
        <div class="ibox-title">
          <h5>Feeder List</h5>
          <div class="ibox-tools"> <a href="feeder_form?action=add" class="btn btn-primary btn-xs"><i
                class="fa fa-plus "> </i> Create new </a> </div>
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
            <input type="text" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Search in table">
            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="50" data-filter=#filter>
              <thead>
                <tr>
                  <th style="width:5%">No.</th>
                  <th style="width:10%">Code</th>
                  <th style="width:40%">Feeder Name</th>
                  <th style="width:10%">Status</th>
                  <th data-hide="phone" style="width:10%">Update By</th>
                  <th data-hide="phone,tablet" style="width:10%">Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
              $limit = 30;
              $page = (isset($_GET['pages']) && is_numeric($_GET['pages']) ) ? $_GET['pages'] : 1;
              $paginationStart = ($page - 1) * $limit;

              $sql="SELECT
              c.fCode,
              c.fName,
              c.isActive,
              c.editID,
              c.editTime,
              a.acttiveName,
              u.username
              FROM $db->dbname.common_feeder AS c
              INNER JOIN $db->dbname.ref_active AS a ON c.comCode = a.comCode AND c.isActive = a.`code`
              INNER JOIN $db->dbname.user AS u ON c.comCode = u.comCode AND c.createID = u.usercode order by c.fCode  LIMIT $paginationStart, $limit";
              $result=$db->query($sql);
              $i=1;
              $isActiveStype="";

              // Get total records
              $count = $db->query("SELECT count(fCode) AS id FROM $db->dbname.common_feeder")->fetch_assoc();
              $allRecrods = $count['id'];
              // Calculate total pages
              $totoalPages = ceil($allRecrods / $limit);
              // Prev + Next
              $prev = $page - 1;
              $next = $page + 1;

              while($r=mysqli_fetch_array($result)){
              if($r['isActive']=='1'){$isActiveStype='primary';}else{$isActiveStype='danger';}
              ?>
                <tr class="gradeX">
                  <td><?php echo ($paginationStart+$i); ?></td>
                  <td><?php echo $r['fCode'];?></td>
                  <td><?php echo $r['fName']; ?></td>
                  <td class="center"> <span
                      class="label label-<?php echo $isActiveStype;?>"><?php echo $r['acttiveName']; ?></span></td>
                  <td class="center"><?php echo $r['username'];?></td>
                  <td class="center">
                    <div class="btn-group">
                      <button class="btn-white btn btn-xs"
                        onClick="location.href='feeder_form?action=view&fCode=<?php echo $r['fCode'];?>' ">View</button>
                      <button class="btn-white btn btn-xs"
                        onClick="location.href='feeder_form?action=edit&fCode=<?php echo $r['fCode'];?>' ">Edit</button>
                      <button class="btn-white btn btn-xs"
                        onClick="return confirmDel('<?php echo $r['fCode']; ?>','feeder_action.php');">Delete</button>
                    </div>
                </tr>
                <?php  $i++; } ?>
              </tbody>

              <tfoot>
                <!-- <tr>
                  <td colspan="10"><ul class="pagination float-left">
                    </ul></td>
                </tr> -->
                <!-- Pagination -->
                <tr>
                  <td colspan="10">
                    <nav aria-label="Page navigation mt-5">
                      <?php 
                        include 'pagination.php';
                        if($totoalPages > 1){ pagination($page, $totoalPages, 'feeder'); }
                      ?>
                    </nav>
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