<?php
include ('session.php');
include('menu.php');
?>

   <br />
   <form action="subphp_/script.php" method="post">
     <fieldset>
       <legend><b>Data Statistics: </b></legend><br>
       <table border=1>
       <tr>
         <td><b>EMPTYEND</td><td>(Short or older)</td><td><b><?php $output=shell_exec("/var/www/html/ownpan/script_/CLIENTS_manage 4 E"); print_r($output); ?></b></td>
       </tr>
       <tr>
         <td><b>MALFORMED</td><td>(Not valid end)</td><td><b><?php $output=shell_exec("/var/www/html/ownpan/script_/CLIENTS_manage 4 M"); print_r($output); ?></b></td>
       </tr>
       <tr>
         <td><b>ACCEPTED</td><td>(Valid data)</td><td><b><?php $output=shell_exec("/var/www/html/ownpan/script_/CLIENTS_manage 4 V"); print_r($output); ?></b></td>
       </tr>
       <tr>
         <td><b>TOTAL</td><td>(Total rec data)</td><td><b><?php $output=shell_exec("/var/www/html/ownpan/script_/CLIENTS_manage 4 T"); print_r($output); ?></b></td>
       </tr>
       </table>
       <br>
       <input name="submit" type="submit" value="Reset">

     </fieldset>
   </form>

   <br />
   <form action="subphp_/script.php" method="post">
     <fieldset>
       <legend><b>Manage Blacklist: <?php $output=shell_exec("/var/www/html/ownpan/script_/CLIENTS_manage cnt"); print_r($output); ?></b></legend><br>
       <input type="radio" name="blis-manage" value="1"/> Show all blacklisted Clients
       <input type="radio" name="blis-manage" value="2"/> Show all registered Clients
       <input type="radio" name="blis-manage" value="3"/> Blacklist reset (<b>not reversible</b>)
       &nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <input name="submit" type="submit" value="Apply">
     </fieldset>
   </form>


    <div id="login">
      <form action="subphp_/script.php" method="post">
      <b>Add to Blacklist: </b>
        <input id="blis-add" name="blis-add" placeholder="Insert Client NAME (Es: aBc123)" type="text">
        <input name="submit" type="submit" value=" Add ">
      </form>
    </div>

    <div id="login">
      <form action="subphp_/script.php" method="post">
      <b>Remove from Blacklist: </b>
        <input id="blis-del" name="blis-del" placeholder="Insert Client NAME (Es: aBc123)" type="text">
        <input name="submit" type="submit" value="Remove">
      </form>
    </div>

  </body>
</html>

