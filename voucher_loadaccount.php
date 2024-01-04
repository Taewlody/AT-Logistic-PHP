<script>
  $(document).ready(function() {
        $('.select2_single').select2({});
  });
</script>
<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
//$attach_file=post('attach_file');
$cusCode=post('cusCode');
?>
 <select name="account[]" class="select2_single form-control select2" style="width: 100%" >
<?php $db->s_account('');?> 
</select>
   


