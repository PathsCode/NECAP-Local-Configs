<?php
include ('session.php');
include('menu.php');
?>
   <br />
   <form action="subphp_/cluster.php" method="post">
     <fieldset>
       <legend><b>Cluster enabled: <?php $output=shell_exec("/var/www/html/ownpan/script_/CLUSTER_manage show enabled"); print_r($output); ?></b></legend><br>
       <input type="radio" name="clus-enabled" value="yes"/> YES
       <input type="radio" name="clus-enabled" value="no"/> NO
       &nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <input name="submit" type="submit" value="Apply">
     </fieldset>
   </form>

   <form action="subphp_/cluster.php" method="post">
     <fieldset>
       <legend><b>My Cluster role: <?php $output=shell_exec("/var/www/html/ownpan/script_/CLUSTER_manage show role"); print_r($output); ?></b></legend><br>
       <input type="radio" name="clus-role" value="master"/> Master
       <input type="radio" name="clus-role" value="slave"/> Slave
       &nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <input name="submit" type="submit" value="Apply">
     </fieldset>
   </form>

   <form action="subphp_/cluster.php" method="post">
     <fieldset>
       <legend><b>Operational Mode: <?php $output=shell_exec("/var/www/html/ownpan/script_/CLUSTER_manage show mode"); print_r($output); ?></b></legend><br>
       <input type="radio" name="clus-mode" value="proactive"/> Proactive
       <input type="radio" name="clus-mode" value="passive"/> Passive
       &nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <input name="submit" type="submit" value="Apply">
     </fieldset>
   </form>

   <form action="subphp_/cluster.php" method="post">
     <fieldset>
       <legend><b>Deadline Timeout: <?php $output=shell_exec("/var/www/html/ownpan/script_/CLUSTER_manage show deadline"); print_r($output); ?></b></legend><br>
       <input type="radio" name="clus-deadline" value="60"/> 60 sec
       <input type="radio" name="clus-deadline" value="120"/> 120 sec
       <input type="radio" name="clus-deadline" value="300"/> 300 sec
       &nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <input name="submit" type="submit" value="Apply">
     </fieldset>
   </form>
   
    <br />
    <div id="login">
      <form action="subphp_/cluster.php" method="post">
      <b>Companion IPv4: <i><?php $output=shell_exec("/var/www/html/ownpan/script_/CLUSTER_manage show companion"); print_r($output); ?></i></b>
        <input id="clus-companion" name="clus-companion" placeholder="Insert Companion LAN Address" type="text">
        <input name="submit" type="submit" value="Change">
      </form>
    </div>


  </body>
</html>

