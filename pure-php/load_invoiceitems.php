<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();

$chk_items=post('chk_items');

foreach ($chk_items as $documentID){
  
    
 $sql="SELECT
i.items,
i.comCode,
i.documentID,
i.chargeCode,
i.detail,
i.chargesCost,
i.chargesReceive,
i.chargesbillReceive 
FROM
invoice_items AS i
WHERE   i.documentID='$documentID'    ";
$i=1;
$result=mysqli_query($db->connect(),$sql);
 while($r=mysqli_fetch_assoc($result)){
$key_row=rand().$i; 
 ?>    
 <tr class='gradeX' id='tr<?php echo $key_row;?>'> 
         <td><input type='text'  readonly name='invNo[]' class='form-control' value='<?php echo $r['documentID'];?>' id='invNo<?php echo $key_row;?>'><input type='hidden' name='chargeitems[]'  value='<?php echo $r['chargeCode'];?>' id='chargeitems<?php echo $key_row;?>'></td>
 
    <td><input type='text' name='chargesDetail[]' class='form-control' value='<?php echo $r['detail'];?>' id='chargesDetail<?php echo $key_row;?>'></td>  

<td class='center'><input type='number' name='paid[]'  onkeyup='call_price()'  class='form-control' value='<?php echo $r['chargesCost'];?>' id='paid<?php echo $key_row;?>'></td>
<td class='center'><input type='number' name='receive[]'  onkeyup='call_price()'  class='form-control' value='<?php echo $r['chargesReceive'];?>' id='receive<?php echo $key_row;?>'></td>
<td class='center'><input type='number' name='chargesPrice[]'  onkeyup='call_price()'  class='form-control' value='<?php echo $r['chargesbillReceive'];?>' id='chargesPrice<?php echo $key_row;?>'></td>
<td class='center'><button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table(<?php echo $key_row;?>)'>Remove</button></td>
</tr>


<?php  
 }}
?>

   


