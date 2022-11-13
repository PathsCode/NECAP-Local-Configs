<?php
include('../session.php');

  if (isset($_POST['mysql-start']))   
   {
     shell_exec("/var/www/html/ownpan/script_/MANAGE_mysql start");
     header("location: ../manage.php");
   } 
  elseif ( isset($_POST['mysql-stop']) )   
   {
     shell_exec("/var/www/html/ownpan/script_/MANAGE_mysql stop");
     header("location: ../manage.php");
   } 
  elseif ( isset($_POST['httpd-restart']) )
   {
     shell_exec("/var/www/html/ownpan/script_/MANAGE_httpd restart");
     header("location: ../manage.php");
   }
  elseif ( isset($_POST['evogw-stop']) )
   {
     shell_exec("/var/www/html/ownpan/script_/MANAGE_evogw stop");
     header("location: ../manage.php");
   }
  elseif ( isset($_POST['upload-stop']) )
   {
     shell_exec("/var/www/html/ownpan/script_/MANAGE_evogw upstop");
     header("location: ../manage.php");
   }
  elseif ( isset($_POST['sys-reboot']) )
   {
     shell_exec("/var/www/html/ownpan/script_/MANAGE_reboot reboot");
     header("location: ../manage.php");
   }

  /* configure.php */
  elseif ( isset($_POST['sys-name']) )
   {
     $new_name=$_POST['sys-name'];
     shell_exec("/var/www/html/ownpan/script_/MANAGE_system change '$new_name'");
     header("location: ../configure.php");
   }
  elseif ( isset($_POST['sys-proc']) )
   {
     $new_proc=$_POST['sys-proc'];
     shell_exec("/var/www/html/ownpan/script_/MANAGE_process change '$new_proc'");
     header("location: ../configure.php");
   }
  elseif ( isset($_POST['apn-name']) )
   {
     $new_apn=$_POST['apn-name'];
     shell_exec("/var/www/html/ownpan/script_/MANAGE_apn change '$new_apn'");
     header("location: ../configure.php");
   }
  elseif ( isset($_POST['usb-device']) )
   {
     $value=$_POST['usb-device'];
     shell_exec("/var/www/html/ownpan/script_/MANAGE_usb change '$value'");
     header("location: ../configure.php");
   }
  elseif ( isset($_POST['sys-addr']) )
   {
     $new_addr=$_POST['sys-addr'];
     shell_exec("/var/www/html/ownpan/script_/MANAGE_addr changeaddr '$new_addr'");
     header("location: ../configure.php");
   }
  elseif ( isset($_POST['sys-gate']) )
   {
     $new_gate=$_POST['sys-gate'];
     shell_exec("/var/www/html/ownpan/script_/MANAGE_addr changegate '$new_gate'");
     header("location: ../configure.php");
   }

  /* clients.php */

  if ( isset($_POST['blis-manage']) )
   {
     $command=$_POST['blis-manage'];
     $result=shell_exec("/var/www/html/ownpan/script_/CLIENTS_manage '$command'");
     if ( $command == 3 )
       header("location: ../clients.php");
     else
       print_r($result);
   }
  if ( isset($_POST['blis-add']) )
   {
     $value=$_POST['blis-add'];
     shell_exec("/var/www/html/ownpan/script_/CLIENTS_manage add '$value'");
     header("location: ../clients.php");
   }
  if ( isset($_POST['blis-del']) )
   {
     $value=$_POST['blis-del'];
     shell_exec("/var/www/html/ownpan/script_/CLIENTS_manage del '$value'");
     header("location: ../clients.php");
   }

  if ( isset($_POST['submit']) )
   {
     $value=$_POST['submit'];
     if ( $value == 'Reset' )
      {
       shell_exec("/var/www/html/ownpan/script_/CLIENTS_manage '$value'");
       header("location: ../clients.php");
      }
   }


  /* statistics.php */
  if (isset($_POST['mysql-query']))
   {
     $new_query=$_POST['mysql-query'];
     
     $list_opt=$_POST['cli'];

     $cid=$_POST['cli'];
     $qty=$_POST['qty'];
     $fromyear=$_POST['fromyear'];
     $frommonth=$_POST['frommonth'];
     $fromday=$_POST['fromday'];
     $fromhour=$_POST['fromhour'];
     $fromminute=$_POST['fromminute'];
     $toyear=$_POST['toyear'];
     $tomonth=$_POST['tomonth'];
     $today=$_POST['today'];
     $tohour=$_POST['tohour'];
     $tominute=$_POST['tominute'];

     
     if ( isset($_POST['qty']) )
      {
       $getres=shell_exec("/var/www/html/ownpan/script_/STATISTIC_mysql query '$new_query' '$cid' '$qty' '$fromyear' '$frommonth' '$fromday' '$fromhour' '$fromminute' '$toyear' '$tomonth' '$today' '$tohour' '$tominute'");
      }
     else
       $getres=shell_exec("/var/www/html/ownpan/script_/STATISTIC_mysql query '$new_query' '$list_opt'");

     print_r($getres);
   }
  elseif (isset($_POST['mysql-dump']))
   {
     $new_query=$_POST['mysql-dump'];
     $getres=shell_exec("/var/www/html/ownpan/script_/STATISTIC_mysql dump '$new_query'");
     print_r($getres);
   }
  elseif (isset($_POST['csv-export']))
   {
     $new_query=$_POST['csv-export'];
     $getres=shell_exec("/var/www/html/ownpan/script_/STATISTIC_mysql export '$new_query'");
     print_r($getres);
   }

  /* if no option isset */
  else   
   {
     header('location:../statistics.php') 
   }
?>
