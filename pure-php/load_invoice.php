<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();

$cusCode=post('cusCode');
$sql="SELECT
i.documentID,
i.taxivRef,
i.ref_jobNo,
i.documentDate
FROM $db->dbname.invoice AS i
LEFT JOIN $db->dbname.tax_invoice_items AS t ON i.comCode = t.comCode AND i.documentID = t.invNo
WHERE   i.cusCode='$cusCode' AND (t.documentID IS NULL  or t.documentID ='')   ";		
        $result=mysqli_query($db->connect(),$sql);
$i=1;
	   while($r=mysqli_fetch_assoc($result)){ 
           if($r['taxivRef']!=''){
                           
                           $checked = 'checked';
                       }else{
                           
                          $checked = ''; 
                       }      
                              
?>
	                 <tr class='gradeX'>
                      <td><?php echo $i;?></td>
                      <td><?php echo $r['documentID']; ?> <input type='hidden' name='documentID[]' value='<?php echo $r['documentID']; ?>'></td>
                      <td><?php echo $r['documentDate']; ?></td>
                      <td class='center'><?php echo $r['ref_jobNo']; ?></td>
                      <td align="center">
                          <div class="custom-control custom-checkbox">
                          <input type="checkbox" value="<?php echo $r['documentID']; ?>" <?php echo $checked; ?> name="chk_items[]" class="custom-control-input" id="<?php echo $r['documentID']; ?>">
                          <label class="custom-control-label" for="<?php echo $r['documentID']; ?>"></label>
                         </div>
                     </td> 
                    </tr>	

<?php $i++; } ?>

   


