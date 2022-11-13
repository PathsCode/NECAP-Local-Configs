<?php
include ('session.php');
include('menu.php');
?>

   <br />

    <h3 align="left" style="color:blue">CONTROLLER INHIBIT BEHAVIOR</h3>

    <div id="timeOUT">
      <form action="subphp_/script.php" method="post">
        <h4 align="center" style="color:#e65c00">STALE DATA TIMEOUT</h4>
        <b>Inhibit controller when data is older than minutes: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tSTALE showTSTALE"); print_r($output); ?></i>
        <input id="tSTALE" name="tSTALE" placeholder="Insert new timeout" type="text">
        <input name="submit" type="submit" value="Change">
      </form>
    </div>

    <div id="timeOUT">
      <form action="subphp_/script.php" method="post">
        <h4 align="center" style="color:#e65c00">FAULTY SENSOR TIMEOUT</h4>
        <b>Inhibit controller when value is constant for minutes: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tCONST showTCONST"); print_r($output); ?></i>
        <input id="tCONST" name="tCONST" placeholder="Insert new timeout" type="text">
        <input name="submit" type="submit" value="Change">
      </form>
    </div>
    <br>

    <h3 align="left" style="color:blue">TIME RANGE SETTINGS (Default 00:00 - 23:59)</h3>

    <div id="timeRange">
      <form action="subphp_/script.php" method="post">
        <h4 align="center" style="color:#e65c00">Switch no.1 (RA1)</h4>
        <b>Start time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTRON 1"); print_r($output); ?></i>
        <input id="tron1" name="tron1" placeholder="HH:MM" type="text">
        <br>
        <b>Stop time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTROFF 1"); print_r($output); ?></i>
        <input id="troff1" name="troff1" placeholder="HH:MM" type="text">
        <input name="submit" type="submit" value="Submit">
      </form>
    </div>

    <div id="timeRange">
      <form action="subphp_/script.php" method="post">
        <h4 align="center" style="color:#e65c00">Switch no.2 (RA2)</h4>
        <b>Start time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTRON 2"); print_r($output); ?></i>
        <input id="tron2" name="tron2" placeholder="HH:MM" type="text">
        <br>
        <b>Stop time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTROFF 2"); print_r($output); ?></i>
        <input id="troff2" name="troff2" placeholder="HH:MM" type="text">
        <input name="submit" type="submit" value="Submit">
      </form>
    </div>

    <div id="timeRange">
      <form action="subphp_/script.php" method="post">
        <h4 align="center" style="color:#e65c00">Switch no.3 (RB1)</h4>
        <b>Start time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTRON 3"); print_r($output); ?></i>
        <input id="tron3" name="tron3" placeholder="HH:MM" type="text">
        <br>
        <b>Stop time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTROFF 3"); print_r($output); ?></i>
        <input id="troff3" name="troff3" placeholder="HH:MM" type="text">
        <input name="submit" type="submit" value="Submit">
      </form>
    </div>

    <div id="timeRange">
      <form action="subphp_/script.php" method="post">
        <h4 align="center" style="color:#e65c00">Switch no.4 (RB2)</h4>
        <b>Start time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTRON 4"); print_r($output); ?></i>
        <input id="tron4" name="tron4" placeholder="HH:MM" type="text">
        <br>
        <b>Stop time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTROFF 4"); print_r($output); ?></i>
        <input id="troff4" name="troff4" placeholder="HH:MM" type="text">
        <input name="submit" type="submit" value="Submit">
      </form>
    </div>
    </br>

    <div id="timeRange">
      <form action="subphp_/script.php" method="post">
        <h4 align="center" style="color:#e65c00">Switch no.5 (RC1)</h4>
        <b>Start time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTRON 5"); print_r($output); ?></i>
        <input id="tron5" name="tron5" placeholder="HH:MM" type="text">
        <br>
        <b>Stop time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTROFF 5"); print_r($output); ?></i>
        <input id="troff5" name="troff5" placeholder="HH:MM" type="text">
        <input name="submit" type="submit" value="Submit">
      </form>
    </div>

    <div id="timeRange">
      <form action="subphp_/script.php" method="post">
        <h4 align="center" style="color:#e65c00">Switch no.6 (RC2)</h4>
        <b>Start time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTRON 6"); print_r($output); ?></i>
        <input id="tron6" name="tron6" placeholder="HH:MM" type="text">
        <br>
        <b>Stop time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTROFF 6"); print_r($output); ?></i>
        <input id="troff6" name="troff6" placeholder="HH:MM" type="text">
        <input name="submit" type="submit" value="Submit">
      </form>
    </div>

    <div id="timeRange">
      <form action="subphp_/script.php" method="post">
        <h4 align="center" style="color:#e65c00">Switch no.7 (RD1)</h4>
        <b>Start time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTRON 7"); print_r($output); ?></i>
        <input id="tron7" name="tron7" placeholder="HH:MM" type="text">
        <br>
        <b>Stop time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTROFF 7"); print_r($output); ?></i>
        <input id="troff7" name="troff7" placeholder="HH:MM" type="text">
        <input name="submit" type="submit" value="Submit">
      </form>
    </div>

    <div id="timeRange">
      <form action="subphp_/script.php" method="post">
        <h4 align="center" style="color:#e65c00">Switch no.8 (RD2)</h4>
        <b>Start time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTRON 8"); print_r($output); ?></i>
        <input id="tron8" name="tron8" placeholder="HH:MM" type="text">
        <br>
        <b>Stop time: <br><i><?php $output=shell_exec("/var/www/html/ownpan/script_/MANAGE_tr showTROFF 8"); print_r($output); ?></i>
        <input id="troff8" name="troff8" placeholder="HH:MM" type="text">
        <input name="submit" type="submit" value="Submit">
      </form>
    </div>
    <br/>
    <br/>

  </body>
</html>

