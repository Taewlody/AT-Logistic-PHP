<?php
session_start();
header("Cache-Control: public, max-age=60, s-maxage=60");

require_once( 'class.php' );
require_once( 'function.php' );
//unset($_SESSION['userID']);
$db=new cl;
$db->connect();
$page = get( 'page' );
$sub=get('sub');
//echo $_SESSION['userID'];

if(isset($_SESSION['userID']) ==''){
	echo'<script  type="text/javascript">location.replace("login.php");</script>';
}else{

    /*
$sql_userinfo="SELECT
u.usercode,
u.username,
u.userpass,
u.`name`,
u.userTypecode,
u.userstatus,
u.access1,
u.access2,
u.access3,
u.access4,
u.access5,
u.access6,
u.usercreate,
u.datecreate
	FROM
	user AS u
	WHERE u.usercode='$_SESSION[usercode]' ";
	$user_info=$db->fetch($sql_userinfo);
	$usercode=$user_info['usercode'];
	$user_access1=$user_info['access1'];
	$user_access2=$user_info['access2'];
	$user_access3=$user_info['access3'];
	$user_access4=$user_info['access4'];
	$user_access5=$user_info['access5'];
	$user_access6=$user_info['access6'];
    */
}



?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AT Logistic Management System</title>
<link rel="shortcut icon" href="favicon.png">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.css" rel="stylesheet">

<!--
	<link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
	-->

<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="css/animate.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">


</head>





<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/functions.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>


 <!-- Sweet Alert -->
 <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>



<!-- validate -->
<script src="js/plugins/validate/jquery.validate.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<script src="js/plugins/select2/select2.full.min.js"></script>

<!-- Chosen -->
<script src="js/plugins/chosen/chosen.jquery.js"></script>

<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script>
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
				
		
            });
        </script>

<body>
<div id="wrapper">
  <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
      <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
          <div class="dropdown profile-element"> <img alt="image" class="rounded-circle" src="img/profile_small.jpg"/> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <span class="block m-t-xs font-bold"><?php echo $_SESSION['userID'];?></span> <span class="text-muted text-xs block">User<b class="caret"></b></span> </a>
       
              
          </div>
          <div class="logo-element"> ATS</div>
        </li>
          
    <?php if($_SESSION['userTypecode']!='4'){  ?>      
          
        <li > <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li><a href="dashboard">Dashboard</a></li>
          </ul>
        </li>
          
          
          
        <?php
}
        if ( $page == 'country' || $page == 'country_form' ||
          $page == 'customer' || $page == 'customer_form' ||
          $page == 'saleman' || $page == 'saleman_form' ||
          $page == 'port' || $page == 'port_form' ||
          $page == 'charges' || $page == 'charges_form' ||
          $page == 'charges_type' || $page == 'charges_type_form' ||
          $page == 'transport_type' || $page == 'transport_type_form' ||
          $page == 'supplier' || $page == 'supplier_form' ||
          $page == 'container_size' || $page == 'container_size_form' ||
          $page == 'container_type' || $page == 'container_type_form' ||
          $page == 'unit' || $page == 'unit_form' ||
          $page == 'currency' || $page == 'currency_form' ||
          $page == 'forwarder' || $page == 'forwarder_form' ||
          $page == 'supplier' || $page == 'supplier_form'||
          $page == 'forwarder' || $page == 'forwarder_form'  ||
          $page == 'bankAccount' || $page == 'bankAccount_form'  ||  
            
          $page == 'place' || $page == 'place_form' 
        ) {
          $activeCommon = 'active';
        } else {
          $activeCommon = '';
        }
if($_SESSION['userTypecode']!='4'){  
          
        ?>
        <li class="<?php echo $activeCommon;?>"> <a href="#"><i class="fa fa-bars"></i> <span class="nav-label">Common Data</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level collapse">
            <li><a href="country">Country</a></li>
            <li><a href="port">Port</a></li>
            <li><a href="customer">Customer</a></li>
            <li><a href="supplier">Supplier</a></li>
            <li><a href="saleman">Saleman</a></li>
              <li><a href="feeder">Feeder</a></li>
            <li><a href="charges">Charges</a></li>
              <li><a href="bankAccount">Bank Account</a></li>
            <li><a href="charges_type">Charges Type</a></li>
            <li><a href="transport_type">Transport Type</a></li>
            <li><a href="container_type">Container Type</a></li>
            <li><a href="container_size">Container Size</a></li>
            <li><a href="place">Place</a></li>
            <li><a href="unit">Unit</a></li>
            <li><a href="currency">Currency</a></</li>
          </ul>
        </li>
        <?php

        if ( $page == 'job' ||
          $page == 'job_form' ||
       
          $page == 'booking_tracterr' ||
          $page == 'booking_tracter_form' ||
          $page == 'contrainer_booking' ||
          $page == 'contrainer_booking_forom' ||
          $page == 'trailer_booking' ||
          $page == 'trailer_booking_form' ||
          $page == 'bill_of_lading' ||
          $page == 'bill_of_lading_form'


        ) {
          $activeSale = 'active';
        } else {
          $activeSale = '';
        }

        ?>
        <li class="<?php echo $activeSale;?>"> <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Marketing</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level collapse">
            <li class="active"><a href="job">Job Order</a></li>
       
            <li><a href="trailer_booking">Trailer Booking</a></li>
            <li><a href="bill_of_lading">Bill of Lading</a></li>

          </ul>
        </li>
		  
	 <?php
    
}
        if ( 
         $page == 'advance_payment' ||  $page == 'advance_payment_form'
      

        ) {
          $activeCustomer = 'active';
        } else {
          $activeCustomer = '';
        }

        ?>  
		  
	        <li class="<?php echo $activeCustomer;?>"> <a href="#"><i class="fa fa-user-circle-o"></i> <span class="nav-label">Customer</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level collapse">
            <li><a href="advance_payment">Advance Payment</a></li>
           
          </ul>
        </li>
		  
		  
		 
	    <?php
        if ( 
			($page == 'payment_voucher' 	|| $page == 'payment_voucher_form' ||
            $page=='deposit' 			|| $page =='deposit_form' ||
            $page=='petty_cash' 		|| $page =='petty_cash_form' )
			
			&& $sub=='shipping'
            


        ) {
          $activeshipping = 'active';
        } else {
          $activeshipping = '';
        }
if($_SESSION['userTypecode']!='4'){  
        ?>	  
		  
        <li class="<?php echo $activeshipping;?>"> <a href="#"><i class="fa fa-truck"></i> <span class="nav-label">Shipping</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level collapse">
            <li><a href="job"><li><a href="payment_voucher&sub=shipping">Payment voucher</li></a></a></li>
          
           <li><a href="job"><li><a href="petty_cash&sub=shipping">Petty Cash</li></a></a></li>
      
           <li><a href="deposit&sub=shipping">Deposit</a></li> 
          </ul>
        </li>
		  
		  
		    <?php
        if ( $page == 'messenger_booking' || $page == 'messenger_booking_form'
			|| $page == 'calendar_booking'

        ) {
          $activemessenger = 'active';
        } else {
          $activemessenger = '';
        }

        ?>	
		  
		  
        <li class="<?php echo $activemessenger;?>"> <a href="#"><i class="fa fa-taxi"></i> <span class="nav-label">Messenger</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level collapse">
            <li><a href="messenger_booking">messenger booking</a></li>
			<li><a href="calendar_booking">Calendar booking</a></li>
          </ul>
        </li>
        <?php
        if ( ($page == 'invoice' || $page == 'invoice_form' ||
            $page == 'tax_invoice' || $page == 'tax_invoice_form' ||
            $page == 'receipt_voucher' || $page == 'receipt_voucher_form' ||
            $page == 'payment_voucher' || $page == 'payment_voucher_form' ||
            $page == 'withholding_tax' || $page == 'withholding_tax_form' ||
			$page == 'billing_receipt' || $page == 'billing_receipt_form' ||
            $page == 'reserve_payment' || $page == 'reserve_payment_form' ||
            $page == 'petty_cash' || $page == 'petty_cash_form' ) && $sub=='account'
			

        ) {
          $activeAccount = 'active';
        } else {
          $activeAccount = '';
        }

        ?>
        <li class="<?php echo $activeAccount;?>"> <a href="#"><i class="fa fa-folder-open"></i> <span class="nav-label">Account</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level collapse">
            <li><a href="invoice">Invoice</a></li>
            <li><a href="tax_invoice">Tax Invoice</a></li>
            <li><a href="payment_voucher&sub=account">Payment Voucher</a></li>
            <li><a href="receipt_voucher">Receipt Voucher</a></li>
            
			 <li><a href="billing_receipt">billing receipt</a></li>
           <li><a href="petty_cash&sub=account">Petty cash</a></li>
            <li><a href="withholding_tax">Withholding Tax</a></li>
          </ul>
        </li>
      
        <?php
        if ( $page == 'report1' 
             || $page == 'report2' 
             || $page == 'report3' 
             || $page == 'report4' 
             || $page == 'report5' 
             || $page == 'report6' 
             || $page == 'report7' 
             || $page == 'report8' 
             || $page == 'report9' 
             || $page == 'report10' 
             || $page == 'report11' 
             || $page == 'report12' 
             || $page == 'report13' 

        ) {
          $activeReport = 'active';
        } else {
          $activeReport = '';
        }

        ?>
      
        <li class="<?php echo $activeReport;?>"> <a href="#"><i class="fa fa-line-chart"></i> <span class="nav-label">Report</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level collapse">
			<li><a href="report1">งานระหว่างทำ</a></li>
			<li><a href="report2">กำไร-ขาดทุนตาม Job</a></li>
			<li><a href="report3">ยอดขายตามใบแจ้งหนี้</a></li>
			<li><a href="report4">ยอดขายตามใบกำกับภาษี</a></li>
			<li><a href="report5">ใบแจ้งหนี้ค้างชำระ</a></li>
			<li><a href="report6">ใบสำคัญจ่าย</a></li> 
			<li><a href="report7">ใบสำคัญรับ</a></li>
            <li><a href="report8">ภาษีขาย</a></li>
		    <li><a href="report9">ภาษีซื้อ</a></li>
			<li><a href="#">ภาษีหัก ณ ที่จ่าย</a></li>
          </ul>
        </li>
        <?php
        if ( $page == 'usertype' || $page == 'usertypee_form' ||
          $page == 'user' || $page == 'user_form'

        ) {
          $activeUser = 'active';
        } else {
          $activeUser = '';
        }

        ?>
        <li class="<?php echo $activeUser;?>"> <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Administrator</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level collapse">
          <?php               
if($_SESSION['userTypecode']=='1'){                  
?>  
              
            <li><a href="usertype">UserType</a></li>
       
              
            <li><a href="user">User</a></li>
<?php } } ?>     
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
      <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header"> <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a> </div>
        <ul class="nav navbar-top-links navbar-right">
          <!--  email 
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a class="dropdown-item float-left" href="profile.html">
                                    <img alt="image" class="rounded-circle" src="img/a7.jpg">
                                </a>
                                <div class="media-body">
                                    <small class="float-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a class="dropdown-item float-left" href="profile.html">
                                    <img alt="image" class="rounded-circle" src="img/a4.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="float-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a class="dropdown-item float-left" href="profile.html">
                                    <img alt="image" class="rounded-circle" src="img/profile.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="float-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html" class="dropdown-item">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
				

          
          <li class="dropdown"> <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#"> <i class="fa fa-bell"></i> <span class="label label-primary">8</span> </a>
            <ul class="dropdown-menu dropdown-alerts">
              <li> <a href="mailbox.html" class="dropdown-item">
                <div> <i class="fa fa-envelope fa-fw"></i> You have 16 messages <span class="float-right text-muted small">4 minutes ago</span> </div>
                </a> </li>
              <li class="dropdown-divider"></li>
              <li> <a href="profile.html" class="dropdown-item">
                <div> <i class="fa fa-twitter fa-fw"></i> 3 New Followers <span class="float-right text-muted small">12 minutes ago</span> </div>
                </a> </li>
              <li class="dropdown-divider"></li>
              <li> <a href="grid_options.html" class="dropdown-item">
                <div> <i class="fa fa-upload fa-fw"></i> Server Rebooted <span class="float-right text-muted small">4 minutes ago</span> </div>
                </a> </li>
              <li class="dropdown-divider"></li>
              <li>
                <div class="text-center link-block"> <a href="notifications.html" class="dropdown-item"> <strong>See All Alerts</strong> <i class="fa fa-angle-right"></i> </a> </div>
              </li>
            </ul>
          </li>
	  -->

          <li> <a href="logout.php"> <i class="fa fa-sign-out"></i> Log out </a> </li>
        </ul>
      </nav>
    </div>
    <?php


      
    if ( $page == "" ) {

        
      $page = 'dashboard';
   
        
    }
      
      
      
      
    if ( file_exists( $page . '.php' ) ) {
      require_once( $page . '.php' );
    } else {
      require_once( '404.php' );
    }


    ?>
    <div class="footer">
      <div class="float-right"> 
        <!-- same text --> 
      </div>
      <div> <strong>Copyright</strong> AT Logistic Company Limited &copy; </div>
    </div>
  </div>
</div>
</body>
</html>
