<?php
  include('session.php');
  include('menu.php');
?>
    <br/>
    <div id="login">
      <form action="subphp_/script.php" method="post">
      <b>System Name: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_system"); print_r($output); ?></i></b>
        <input id="sys-name" name="sys-name" placeholder="Insert new system name" type="text">
        <input name="submit" type="submit" value="Change">
      </form>
    </div>

    <!-- div id="login">
      < form action="subphp_/script.php" method="post">
        <b>Process List: <br><i>< ?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_process"); print_r($output); ?></i></b>
        < input id="sys-proc" name="sys-proc" placeholder="Insert processes to be monitored" type="text">
        < input name="submit" type="submit" value="Change">
      < /form>
    < /div>

    < br/ -->

    <div id="login">
      <form action="subphp_/script.php" method="post">
        <b>Apn Address: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_apn"); print_r($output); ?></i></b>
        <input id="apn-name" name="apn-name" placeholder="Insert the provider APN" type="text">
        <input name="submit" type="submit" value="Change">
      </form>
    </div>

    <!-- div id="login">
      < form action="subphp_/script.php" method="post">
        <b>USB Device: <br><i>< ? php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_usb"); print_r($output); ?></i></b>
        < input id="usb-device" name="usb-device" placeholder="Insert the MODEM device (via LAN only!!!)" type="text">
        < input name="submit" type="submit" value="Change">
      < /form>
    < /div -->

    <br/>

    <div id="login">
      <form action="subphp_/script.php" method="post">
        <b>Webhost URL: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_webhost"); print_r($output); ?></i></b>
        <input id="web-host" name="web-host" placeholder="Insert webhost url" type="text">
        <input name="submit" type="submit" value="Change">
      </form>
    </div>

<!-- VT - Modifica marzo 2017 per acquisire numero porta del socket -->

    <div id="login">
      <form action="subphp_/script.php" method="post">
        <b>Webhost port number: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_webhostPort"); print_r($output); ?></i></b>
        <input id="web-host-port" name="web-host-port" placeholder="Insert webhost port number" type="text">
        <input name="submit" type="submit" value="Change">
      </form>
    </div>

    <br/>

<!-- VT - Modifica gennaio 2018 per acquisire secondo URL di upload -->

    <div id="login">
      <form action="subphp_/script.php" method="post">
        <b>Additional Webhost URL: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_additwebhost"); print_r($output); ?></i></b>
        <input id="additweb-host" name="additweb-host" placeholder="Insert webhost url" type="text">
        <input name="submit" type="submit" value="Change">
      </form>
    </div>

    <div id="login">
      <form action="subphp_/script.php" method="post">
        <b>Additional Webhost port number: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_additwebhostPort"); print_r($output); ?></i></b>
        <input id="additweb-host-port" name="additweb-host-port" placeholder="Insert webhost port number" type="text">
        <input name="submit" type="submit" value="Change">
      </form>
    </div>

    <br/>

<!-- VT - giugno 2017 modifica per configurare WiFi  -->

    <div id="login">
      <form action="subphp_/script.php" method="post">
        <b>Wifi SSID: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_wifi showSSID"); print_r($output); ?></i></b>
        <input id="sys-ssid" name="sys-ssid" placeholder="Insert wifi SSID" type="text">
        <br>
        <br>
        <b>Wifi password: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_wifi showPSK"); print_r($output); ?></i></b>
        <input id="sys-psk" name="sys-psk" placeholder="Insert wifi password" type="text">
        <input name="submit" type="submit" value="Change">
      </form>
    </div>


    <div id="login">
      <form action="subphp_/script.php" method="post">
        <b>Application: </b><br><br>
        <input id="application" name="application" value="A" type="radio" 
               <?php $output=trim(shell_exec("/var/www/html/ownpan/script_/MANAGE_application show")); if ($output=="A") echo "checked";?> >Agriculture<br><br>
        <input id="application" name="application" value="I" type="radio" 
               <?php $output=trim(shell_exec("/var/www/html/ownpan/script_/MANAGE_application show")); if ($output=="I") echo "checked";?> >Industry<br><br>
        <input name="submit" type="submit" value="Set">
      </form>
    </div>

    <br/>



  </body>
</html>
