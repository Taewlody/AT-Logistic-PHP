<script>
  $(document).ready(function() {
        $('.select2_single').select2({});
  });
</script>
<?php
require_once( 'class.php' );
require_once('function.php');
$db=new cl;
$jobNo=get('jobNo');

$sql_job="SELECT j.agentCode FROM joborder AS j WHERE j.documentID='$jobNo'  ";
$info=$db->fetch($sql_job);
$agentCode=$info['agentCode'];
?>

<select name="agentCode" class="select2_single form-control select2" id="agentCode">
<?php $db->s_supplier("$agentCode"); ?>
</select> 


