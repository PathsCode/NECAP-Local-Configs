
<!DOCTYPE html>
<html>
  <head>
    <title>OWNPAN - GW MODS 5</title>
    <link href='/css_/style.css' rel='stylesheet' type='text/css'>
    <link rel='stylesheet' type='text/css' href='/css_/menu.css' />
  </head>

  <body >

    <div id='profile'>
      <b id='welcome'>Hi <i><?php echo $_SESSION['login_user']; ?></i>, 
      welcome to: <i><?php $output=shell_exec("cat /srv/data/sysname"); print_r($output); ?></i>
      system time: <i><?php $output=shell_exec("date"); print_r($output); ?> - FW Rev MODS_5</i></b>
    </div>

   <div class='menu_simple'>
      <ul>
        <font size="4">
        <li><a href='profile.php'>OverView</a></li>
        <li><a href='manage.php'>Manage</a></li>
        <li><a href='configure.php'>Configure</a></li>
        <li><a href='statistics.php'>Statistics</a></li>
        <li><a href='../download'>Download</a></li>
        <!-- li >< a href='cluster.php'>Cluster</ a></li -->
        <li><a href='clients.php'>Clients</a></li>
        <li><a href='controllers.php'>Controllers</a></li>
        <li><a href='sensorc2.php'>Sensor C<sup>2</sup></a></li>
        <li><a href='logout.php'>EXIT</a></li>
        </font>
      </ul>
      <br />
    </div>
