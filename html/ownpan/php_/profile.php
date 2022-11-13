<?php
  include('session.php');
  include('menu.php');
?>

    <div id="overview">
      <b id="VIEW_sysname">System Name: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/VIEW_sysname"); print_r($output); ?></i></b>
      <b id="VIEW_serialn">System Serial: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/VIEW_serialn"); print_r($output); ?></i></b>
      <b id="VIEW_address">All Addresses: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/VIEW_address"); print_r($output); ?></i></b>
      <b id="VIEW_uptime">Load Average: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/VIEW_uptime"); print_r($output); ?></i></b>
      <b id="VIEW_space">Disk Usage: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/VIEW_space"); print_r($output); ?></i></b>
      <b id="VIEW_lsusb">Attached USB: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/VIEW_lsusb"); print_r($output); ?></i></b>
      <b id="VIEW_lsusb">Devices USB: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/VIEW_lsusb dev"); print_r($output); ?></i></b>
      <b id="VIEW_process">Processes: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/VIEW_process"); print_r($output); ?></i></b>
    </div>

  </body>
</html>
