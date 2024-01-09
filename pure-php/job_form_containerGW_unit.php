<script>
  $(document).ready(function() {
        $('.select2_single').select2({});
  });
</script>
<?php
require_once( 'class.php' );
$db=new cl;
$id=$_GET['id'];
?><select name="containerGW_unit[]"  class="select2_single form-control select2" style="width: 103%">
<?php $db->s_unitContainer($id); ?>
</select>
    
   


