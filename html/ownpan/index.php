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

<script>
    function emptyRule(id) {
        rele = document.getElementById('rele' + id);
        rele.getElementsByClassName('sensor-input')[0].value = null;
        rele.getElementsByClassName('select-comparison')[0].selectedIndex = 0;
        rele.getElementsByClassName('sensor-value')[0].value = null;
        rele.getElementsByClassName('duration-value')[0].value = null;
        rele.getElementsByClassName('delay-value')[0].value = null;
        rele.getElementsByClassName('start-time')[0].value = null;
        rele.getElementsByClassName('end-time')[0].value = null;
    }

    function onOsinodeChange(osinodeInputEl, id) {
        rele = osinodeInputEl.parentNode;
        portSelect = rele.getElementsByClassName('port-selection')[0];

        portSelect.innerHTML = '<select name="rele' + id + '"][port]" ?>" class="select-comparison port-selection">';

        osinodes[osinodeInputEl.value].forEach(possibleData => {
            portSelect.innerHTML += '<option value="' + possibleData[PORT_ID] + '">' + possibleData[PARAM] + ' (' + possibleData[PORT_ID] + ')</option>';
        });

        portSelect.innerHTML += '</select>';
    }

    osinodes = <?= json_encode($osinodes) ?>;
    osinodesNames = <?= json_encode($osinodesNames) ?>;

    PORT_ID = 'portId';
    PARAM = 'param';
</script>

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
            <div class="rele user-select <?= $allData ? '' : 'no-user-selected' ?>" id="user-select">
                <span>Utente: </span>
                <input name="ownerEmail" type="text" value="<?= $userEmail ?>" placeholder="Email NECAP">
                <button type="submit" class="enter" name="SelezionaUtente">
                    <img src="/css_/check.png">
                </button>
            </div>
            
            <?php if ($allData) : ?>
                <?php for ($releId = 1; $releId <= RELE_NUM; $releId ++) : ?>
                    <?php 
                        $releFile = RULES_DIR . $OSIRELE . "." . $releId;
                        if (file_exists($releFile)) {
                            $releContent = explode("\n", shell_exec("cat " . $releFile));
                            $releOsinode = $releContent[1];
                            $relePort = $releContent[2];
                            $releComparator = $releContent[3]; /* */
                            $releValue = $releContent[4]; /* */
                            $releDuration = $releContent[5]; 
                            $releDelay = $releContent[6]; 
                        } else {
                            $releOsinode = $relePort = $releComparator = $releValue = $releDuration = $releDelay = "";
                        }

                        $releTimeFile = RULES_DIR . TIMERANGE . "." . $releId;
                        if (file_exists($releTimeFile)) {
                            $releTimeContent = explode("\n", shell_exec("cat " . $releTimeFile));
                            $releStart = rtrim($releTimeContent[0]);
                            $releEnd = rtrim($releTimeContent[1]);
                        } else {
                            $releStart = $releEnd = "";
                        }
                    ?>

                    <div class="rele" id="<?= "rele" . $releId ?>">
                        <div class="rele-title flex">
                            <h2>RELÈ <?= $releId; ?></h2>
                            <img src="/css_/x-png-33.png" class="delete-rule cursor" onclick="emptyRule(<?= $releId ?>)"/>
                        </div>
                        <div class="rule-main rule-info">
                            <span>SE</span>
                            <select name="<?= "rele[" . $releId . "][osinode]" ?>" class="select-comparison" onchange="onOsinodeChange(this, <?= $releId ?>)">
                                <?php foreach ($osinodes as $osinodeId => $singleData) : ?>
                                    <option <?= $releOsinode == $osinodeId ? 'selected' : '' ?>><?= $osinodeId ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="osinode-port-separator">:</span>
                            <select name="<?= "rele[" . $releId . "][port]" ?>" class="select-comparison port-selection">
                                <?php if ($releOsinode && in_array($releOsinode, $osinodesNames)) : ?>
                                    <?php foreach ($osinodes[$releOsinode] as $possibleData) : ?>
                                        <option <?= $relePort == $possibleData[PORT_ID] ? 'selected' : '' ?> value="<?= $possibleData[PORT_ID]?>"><?= $possibleData[PARAM] ?> (<?= $possibleData[PORT_ID] ?>)</option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <select name="<?= "rele[" . $releId . "][comparator]" ?>" class="select-comparison">
                                <option <?= $releComparator == MINOR_THAN ? 'selected' : '' ?>><</option>
                                <option <?= $releComparator == MAJOR_THAN ? 'selected' : '' ?>>></option>
                            </select>
                            <input name="<?= "rele[" . $releId . "][value]" ?>" type="number" value="<?= $releValue ?>" placeholder="Valore" class="sensor-value">
                            <span class="unit"></span>
                        </div>
                        <div class="rule-delay rule-info">
                            <span>ACCENDI RELÈ PER</span>
                            <input name="<?= "rele[" . $releId . "][duration]" ?>" type="number" value="<?= $releDuration ?>" placeholder="0" min=0 class="duration-value">
                            <span>SECONDI E DISATTIVALO PER</span>
                            <input name="<?= "rele[" . $releId . "][delay]" ?>" type="number" value="<?= $releDelay ?>" placeholder="0" min=0 class="delay-value">
                            <span>SECONDI</span>
                        </div>
                        <div class="rule-time rule-info">
                            <span>La Regola è in funzione dalle</span>
                            <input name="<?= "rele[" . $releId . "][startTime]" ?>" type="time" value="<?= $releStart ?>" placeholder="00:00" class="start-time time-selection">
                            <span>alle</span>
                            <input name="<?= "rele[" . $releId . "][endTime]" ?>" type="time" value="<?= $releEnd ?>" placeholder="23:59" class="end-time time-selection">
                        </div>
                    </div>
                <?php endfor; ?>
                <input type="submit" name="Salva" value="Salva Modifiche" class="confirm-button update-rules cursor">
            <?php endif; ?>
        </form>
    </body>

</html>

