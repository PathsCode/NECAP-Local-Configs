<?php
include('../session.php');


  if (isset($_POST['mysql-query']))
   {
     $new_query=$_POST['mysql-query'];
     $getres=shell_exec("/var/www/html/ownpan/script_/STATISTIC_mysql query '$new_query'");
     //header("location: ../manage.php");
     //print "ASKED for query..\n";
     //print $new_query;
     print_r($getres);
     
   }


?>
