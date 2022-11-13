<?php
  include('session.php');
  include('menu.php');
?>

   <br />
   <form action="subphp_/script.php" method="post">
     <fieldset>
       <legend><b>Data search options</b> </legend><br>
       <input type="radio" name="mysql-query" value="11"/> Search last <b>Received</b> data <b>n.</b> [100] (All Clients)
       <br />
<!--
       < input type="radio" name="mysql-query" value="11a"/> Search < b>Received< /b>
         < ?php $output=shell_exec("/var/www/html/ownpan/script_/STATISTIC_mysql advquery 1"); print_r($output); ? >
       < br / >
-->
       <br />
       <input type="radio" name="mysql-query" value="14"/> Search last <b>Uploaded</b> data <b>n.</b> [100] (All Clients)
       <br />
<!--
       < input type="radio" name="mysql-query" value="14a"/> Search old < b>Uploaded< /b>
         < ?php $output=shell_exec("/var/www/html/ownpan/script_/STATISTIC_mysql advquery 2"); print_r($output); ? >
       < br / >
-->
       <br />
       <input type="radio" name="mysql-query" value="3"/> Search last <b>Not Uploaded</b> data <b>n.</b> [100] (All Clients)
       <br />
<!--
       < input type="radio" name="mysql-query" value="3a"/> Search old < b>Not Uploaded< /b>
         < ?php $output=shell_exec("/var/www/html/ownpan/script_/STATISTIC_mysql stdquery 11"); print_r($output); ? >
       < br / >
-->
       <br />
       <input type="radio" name="mysql-query" value="2"/> Clients with <b>Pending Uploads</b> foreach
       <br />
       <br />
       <input name="submit" type="submit" value="Query">
     </fieldset>
   </form>

   <form action="subphp_/script.php"  method="post">
     <fieldset>
       <legend><b>Operations on data</b></legend><br>
       <input type="radio" name="mysql-dump" value="5"/> Dump all data
       <input type="radio" name="mysql-dump" value="7"/> Erase all dumps from folder
       <input type="radio" name="mysql-dump" value="101"/> Flush all pending data <br>
       <br />
       <input name="submit" type="submit" value="Execute">
     </fieldset>
   </form>

  </body>
</html>

