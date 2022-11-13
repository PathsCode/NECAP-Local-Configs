<?php
include('../session.php');

  if (isset($_POST['clus-enabled']))   
   { 
     $new_value=$_POST['clus-enabled'];
     shell_exec("/var/www/html/ownpan/script_/CLUSTER_manage change enabled '$new_value'");
     header("location: ../cluster.php");
   } 
  elseif ( isset($_POST['clus-role']) )   
   {
     $new_value=$_POST['clus-role'];
     shell_exec("/var/www/html/ownpan/script_/CLUSTER_manage change role '$new_value'");
     header("location: ../cluster.php");
   } 
  elseif ( isset($_POST['clus-mode']) )
   {
     $new_value=$_POST['clus-mode'];
     shell_exec("/var/www/html/ownpan/script_/CLUSTER_manage change mode '$new_value'");
     header("location: ../cluster.php");
   }
  elseif ( isset($_POST['clus-deadline']) )
   {
     $new_value=$_POST['clus-deadline'];
     shell_exec("/var/www/html/ownpan/script_/CLUSTER_manage change deadline '$new_value'");
     header("location: ../cluster.php");
   }
  elseif ( isset($_POST['clus-companion']) )
   {
     $new_value=$_POST['clus-companion'];
     shell_exec("/var/www/html/ownpan/script_/CLUSTER_manage change companion '$new_value'");
     header("location: ../cluster.php");
   }

  else   
   {
     echo "nothing to do here, just nice to have a comment letting you know";
   }
?>
