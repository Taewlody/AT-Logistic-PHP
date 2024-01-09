<?php
session_start();
unset($_SESSION['userID']);
unset($_SESSION['userTypecode']);
echo'<script  type="text/javascript">location.replace("login.php");</script>';
?>