<script>
  $(document).ready(function() {
        $('.select2_single').select2({});
  });
</script>
<?php
require_once( 'class.php' );
$db=new cl;
?><select name="containerNW_Unit[]"  class="select2_single form-control select2" style="width: 103%">
<?php $db->s_unit(''); ?>
</select>
    
   


