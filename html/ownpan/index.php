<?php

include('php_/login.php');

include('php_/rules.php');

if (isset($_SESSION['login_user'])) {
    header("location: php_/profile.php");
}

if (file_exists("/srv/data/sysname")) {
    $myfile = fopen("/srv/data/sysname", "r");
    $sysname = fread($myfile,filesize("/srv/data/sysname"));
    fclose($myfile);
} else {
    $sysname = 'SCONOSCIUTO';
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Gestione OsiGATE <?= $sysname ?></title>
        <link href="css_/rules.css" rel="stylesheet" type="text/css">
    </head>

    <body class="flex-vertical">
        <h1>OsiGATE: <i><?php echo $sysname ?></i></h1>
        <div class="flex-vertical" id="login">
            <b>Login - Admin</b>
            <form action="" method="post" class="flex-vertical" id="login-form" autocomplete="off">
                <input autocomplete="off" name="username" type="text" class="none">
                <input autocomplete="off" name="password" type="password" class="none">
                <div class="flex">
                    <div class="flex">
                        <label>Username </label>
                        <input id="name" name="username" placeholder="Username" type="text" autocomplete="off">
                    </div>
                    <div class="flex">
                        <label>Password </label>
                        <input id="password" name="password" placeholder="********" type="password" autocomplete="off">
                    </div>
                </div>
                <span id="<?= $error ? 'error-login' : ''?>"><?= $error ? 'Username o Password errata' : '' ?></span>
                <input name="submit" type="submit" value="Login" class="confirm-button">
            </form>
        </div>
        <h1 class="rules-title">Regole</h1>
        <form action="php_/rules.php" method="post" class="reles">
            <?php for ($releId = 1; $releId <= RELE_NUM; $releId ++) : ?>
                <div class="rele">
                    <div class="rele-title flex">
                        <h2>RELÈ <?= $releId; ?></h2>
                        <img src="/css_/x-png-33.png" class="delete-rule cursor"/>
                    </div>
                    <div class="rule-main rule-info">
                        <span>SE</span>
                        <input name="<?= "rele[" . $releId . "][sensor]" ?>" type="text" placeholder="Sensore" class="sensor-input">
                        <select name="<?= "rele[" . $releId . "][comparator]" ?>" class="select-comparison">
                            <option><</option>
                            <option>></option>
                        </select>
                        <input name="<?= "rele[" . $releId . "][value]" ?>" type="number" placeholder="Valore" class="sensor-value">
                        <span class="unit"></span>
                    </div>
                    <div class="rule-delay rule-info">
                        <span>ACCENDI RELÈ PER</span>
                        <input name="<?= "rele[" . $releId . "][duration]" ?>" type="number" placeholder="0" min=0 class="duration-value">
                        <span>SECONDI E DISATTIVALO PER</span>
                        <input name="<?= "rele[" . $releId . "][delay]" ?>" type="number" placeholder="0" min=0 class="delay-value">
                        <span>SECONDI</span>
                    </div>
                    <div class="rule-time rule-info">
                        <span>La Regola è in funzione dalle</span>
                        <input placeholder="00:00" class="start-time time-selection">
                        <span>alle</span>
                        <input placeholder="23:59" class="end-time time-selection">
                    </div>
                </div>
            <?php endfor; ?>
            <input type="submit" name="Salva" value="Salva Modifiche" class="confirm-button update-rules cursor">
        </form>
    </body>

</html>

