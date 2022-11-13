<?php
  include('session.php');
  include('menu.php');
?>

    <div id="overview">

      <b id="MANAGE_mysql">MySQL Status: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_mysql"); print_r($output); ?></i></b>
      <form action="subphp_/script.php" method="post">
        <input type="submit" name="mysql-start" value="Start">
        <input type="submit" name="mysql-stop" value="Stop">
      </form>

      <b id="MANAGE_httpd">Apache Status: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_httpd"); print_r($output); ?></i></b>
      <br>
      <!-- form action="subphp_/script.php" method="post" >
        < input type="submit" name="httpd-reload" value="Reload" >
      < /form -->

      <b id="MANAGE_evogw">Gateway Status: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_evogw gwshow"); print_r($output); ?></i></b>
      <form action="subphp_/script.php" method="post">
        <input type="submit" name="evogw-stop" value="Stop">
      </form>

      <b id="MANAGE_evogw">Upload Status: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_evogw upshow"); print_r($output); ?></i></b>
      <form action="subphp_/script.php" method="post">
        <input type="submit" name="upload-stop" value="Stop">
      </form>

      <b id="MANAGE_reboot">System Status: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_reboot"); print_r($output); ?></i></b>
      <form action="subphp_/script.php" method="post">
        <input type="submit" name="sys-reboot" value="System Reboot">
      </form>
    </div>
