<script>
  $(document).ready(function() {
        $('.select2_single').select2({});
  });
</script>
<?php
require_once( 'class.php' );
require_once('function.php');
$db=new cl;
$id=post('id');

$sql_job="SELECT j.documentID,concat(j.documentID,' -INV NO. [',j.invNo,']') as documentName FROM joborder AS j WHERE j.cusCode='$id'  ";
$result=$db->query($sql_job);
$i=1;
    echo "<option value=''>--select--</option>';"; 
while($r=mysqli_fetch_array($result)){
   // echo "<option value='".$r['documentID']."'>".$r['documentName']."</option>';";   
  	if($ref_jobID==$row['documentID']){
				echo "<option value='$row[documentID]' selected='selected'>$row[documentName]</option>";
			}else{
				echo "<option value='$row[documentID]'>$row[documentName]</option>";
			}	
}



/*
$sql_job="SELECT j.agentCode FROM joborder AS j WHERE j.documentID='$cusCode'  ";
$info=$db->fetch($sql_job);
$agentCode=$info['agentCode'];
*/
?>
<!--
<select class="select2_single form-control select2" name="refJobNo" id="refJobNo">
<?php// $db->s_jobref_advance($refJobNo,$cusCode); ?>
</select>
-->




