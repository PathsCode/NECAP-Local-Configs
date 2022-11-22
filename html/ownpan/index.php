<?php

include('php_/login.php');

if (isset($_SESSION['login_user'])) {
    header("location: php_/profile.php");
}

include('php_/rules.php');

if (file_exists("/srv/data/sysname")) {
    $myfile = fopen("/srv/data/sysname", "r");
    $sysname = fread($myfile,filesize("/srv/data/sysname"));
    fclose($myfile);
} else {
    $sysname = 'SCONOSCIUTO';
}

?>

<script src="https://cdn.jsdelivr.net/npm/nerdamer@latest/nerdamer.core.js"></script>
<script src="https://cdn.jsdelivr.net/npm/nerdamer@latest/Algebra.js"></script>
<script src="https://cdn.jsdelivr.net/npm/nerdamer@latest/Calculus.js"></script>
<script src="https://cdn.jsdelivr.net/npm/nerdamer@latest/Solve.js"></script>

<script>
    function emptyRule(emptyButton) {
        rele = emptyButton.parentNode.parentNode;
        rele.getElementsByClassName('osinode-selection')[0].selectedIndex = 0;
        rele.getElementsByClassName('port-selection')[0].innerHTML = '';
        rele.getElementsByClassName('select-comparison')[0].selectedIndex = 0;
        rele.getElementsByClassName('sensor-value')[0].value = null;
        rele.getElementsByClassName('formula')[0].value = null;
        rele.getElementsByClassName('unit')[0].innerText = '';
        rele.getElementsByClassName('duration-value')[0].value = null;
        rele.getElementsByClassName('delay-value')[0].value = null;
        rele.getElementsByClassName('start-time')[0].value = null;
        rele.getElementsByClassName('end-time')[0].value = null;
    }

    function onOsinodeChange(osinodeInputEl, id) {
        rele = osinodeInputEl.parentNode;
        portSelect = rele.getElementsByClassName('port-selection')[0];
        unitInfo = rele.getElementsByClassName('unit')[0];

        portSelect.innerHTML = '<select>';
        portSelect.innerHTML += '<option disabled selected value class="none"> --- </option>';
        osinodes[osinodeInputEl.value].forEach(possibleData => {
            portSelect.innerHTML += '<option value="' + possibleData[PORT_ID] + '">' + possibleData[PARAM] + ' (' + possibleData[PORT_ID] + ')</option>';
        });
        portSelect.innerHTML += '</select>';

        portSelect.attributes.onchange.nodeValue = "onPortChange(this, '" + osinodeInputEl.value + "')";
        unitInfo.innerText = osinodes[osinodeInputEl.value][0][UNIT];
    }

    function onPortChange(portInputEl, osinodeName) {
        rele = portInputEl.parentNode;
        unitInfo = rele.getElementsByClassName('unit')[0];
        formulaInfo = rele.getElementsByClassName('formula')[0];

        osinodes[osinodeName].forEach(possibleData => {
            if (possibleData[PORT_ID] == portInputEl.value) {
                unitInfo.innerText = possibleData[UNIT];
                formulaInfo.value = possibleData[FORMULA];
            }
        });
    }

    function onTimeChange(changedElement, className) {
        similarInputs = document.getElementsByClassName(className);
        for (indexxx = 0; indexxx < similarInputs.length; indexxx++) {
            similarInputs[indexxx].value = changedElement.value;
        }
    }

    function onValueChange(valueElement) {
        releValuesData = valueElement.parentNode;

        value = valueElement.value;
        rawInput = releValuesData.getElementsByClassName('sensor-raw-value')[0];
        formula = releValuesData.getElementsByClassName('formula')[0].value; 

        if (value && formula) {

            if (formula == 'x') {
                
                x = [value];

            } else {
            
                equation = value + " = " + formula;
                x = nerdamer(equation).solveFor('x');
                
                console.log(equation + " => [" + x + "]");
                console.log(x.length)
            
            }

            rawInput.value = x[0].toString();

        } else {
            rawInput.value = '';
        }
    }

    function preventDot(event) {
        if (event.key == '.') {
            event.preventDefault();
        }
    }

    osinodes = <?= json_encode($osinodes) ?>;
    osinodesNames = <?= json_encode($osinodesNames) ?>;

    PORT_ID = 'portId';
    PARAM = 'param';
    FORMULA = 'formula';
    UNIT = 'unit';
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
            <b>Login ADMIN</b>
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
                <input name="submit" type="submit" value="Login" class="confirm-button cursor">
            </form>
        </div>
        <h1 class="rules-title">Regole</h1>
        <form action="php_/rules.php" method="post" class="reles <?= $allData ? '' : 'no-user-selected' ?>">
            <div class="rele user-select <?= $allData ? '' : 'no-user-selected' ?>" id="user-select">
                <span>Utente </span>
                <div class="flex">
                    <input name="ownerEmail" type="text" value="<?= $userEmail ?>" placeholder="Email NECAP">
                    <button type="submit" class="enter" name="SelezionaUtente">
                        <img src="/css_/check.png">
                    </button>
                </div>
            </div>
            
            <?php if ($connError) : ?>
                <div class="main-error rele">
                    <span>Errore di Connessione al database NECAP.TECH</span>
                </div>
            <?php elseif (!$allData) : ?>
                <div class="main-error rele">
                    <span>Non ci sono OsiNODE / Sensori per l'utente selezionato</span>
                </div>
            <?php else : ?>
                <?php foreach ($OSIRELES_NAMES as $ReleName) : ?>
                    <div class="osirele">
                        <div class="osirele-title-div">
                            <span class="osirele-title">OsiRELE <?= $ReleName ?></span>
                        </div>
                        <?php for ($releId = 1; $releId <= RELE_NUM; $releId ++) : ?>
                            <?php 
                                $releFile = RULES_DIR . $ReleName . "." . $releId;
                                if (file_exists($releFile)) {
                                    $releContent = explode("\n", shell_exec("cat " . $releFile));
                                    $releOsinode = $releContent[1];
                                    $relePort = $releContent[2];
                                    $releComparator = $releContent[3]; /* */
                                    $releRawValue = $releContent[4]; /* */
                                    $releDuration = $releContent[5]; 
                                    $releDelay = $releContent[6]; 
                                } else {
                                    $releOsinode = $relePort = $releComparator = $releRawValue = $releValue = $releDuration = $releDelay = "";
                                }

                                $releTimeFile = RULES_DIR . TIMERANGE . "." . $releId;
                                if (file_exists($releTimeFile)) {
                                    $releTimeContent = explode("\n", shell_exec("cat " . $releTimeFile));
                                    $releStart = rtrim($releTimeContent[0]);
                                    $releEnd = rtrim($releTimeContent[1]);
                                } else {
                                    $releStart = $releEnd = "";
                                }

                                $releUnit = null;
                                $releFormula = null;
                                if ($releOsinode && in_array($releOsinode, $osinodesNames)) {
                                    foreach ($osinodes[$releOsinode] as $possibleData) {
                                        if ($relePort == $possibleData[PORT_ID]) {
                                            $releFormula = $possibleData[FORMULA];
                                            $releUnit = $possibleData[UNIT];
                                            $releValue = eval('return ' . str_replace('x', $releRawValue, $releFormula) . ';');
                                        }
                                    }
                                }
                            ?>

                            <div class="rele" id="<?= "rele" . $releId ?>">
                                <div class="rele-title flex">
                                    <h2>RELÈ <?= $releId; ?></h2>
                                    <img src="/css_/x-png-33.png" class="delete-rule cursor" onclick="emptyRule(this)"/>
                                </div>
                                <div class="inline-rule-info">
                                    <div class="rule-main rule-info">
                                        <span>SE</span>
                                        <select name="<?= "rele[" . $ReleName . "][" . $releId . "][osinode]" ?>" class="select-comparison osinode-selection" onchange="onOsinodeChange(this, <?= $releId ?>)">
                                            <option disabled selected value class="none"> --- </option>
                                            <?php foreach ($osinodes as $osinodeId => $singleData) : ?>
                                                <option <?= $releOsinode == $osinodeId ? 'selected' : '' ?>><?= $osinodeId ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="osinode-port-separator">:</span>
                                        <select name="<?= "rele[" . $ReleName . "][" . $releId . "][port]" ?>" class="select-comparison port-selection" onchange="onPortChange(this, '<?= ($releOsinode && in_array($releOsinode, $osinodesNames)) ? $releOsinode : '' ?>')">
                                            <option disabled selected value class="none"> --- </option>
                                            <?php if ($releOsinode && in_array($releOsinode, $osinodesNames)) : ?>
                                                <?php foreach ($osinodes[$releOsinode] as $possibleData) : ?>
                                                    <option <?= $relePort == $possibleData[PORT_ID] ? 'selected' : '' ?> value="<?= $possibleData[PORT_ID]?>"><?= $possibleData[PARAM] ?> (<?= $possibleData[PORT_ID] ?>)</option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <select name="<?= "rele[" . $ReleName . "][" . $releId . "][comparator]" ?>" class="select-comparison">
                                            <option <?= $releComparator == MINOR_THAN ? 'selected' : '' ?>><</option>
                                            <option <?= $releComparator == MAJOR_THAN ? 'selected' : '' ?>>></option>
                                        </select>
                                        <input type="number" value="<?= $releValue ?>" placeholder="123,4" step="0.1" class="sensor-value" onkeydown="preventDot(event)" onkeyup="onValueChange(this)">
                                        <input name="<?= "rele[" . $ReleName . "][" . $releId . "][value]" ?>" type="hidden" value="<?= $releRawValue ?>" class="sensor-raw-value none">
                                        <input name="<?= "rele[" . $ReleName . "][" . $releId . "][formula]" ?>" type=hidden value="<?= $releFormula ? $releFormula : '' ?>" class="formula">
                                        <span class="unit"><?= $releUnit ? $releUnit : '' ?></span>
                                    </div>
                                    <div class="rule-delay rule-info">
                                        <span>ACCENDI RELÈ PER</span>
                                        <input name="<?= "rele[" . $ReleName . "][" . $releId . "][duration]" ?>" type="number" value="<?= $releDuration ?>" placeholder="0" min=0 class="duration-value">
                                        <span>MINUTI E DISATTIVALO PER</span>
                                        <input name="<?= "rele[" . $ReleName . "][" . $releId . "][delay]" ?>" type="number" value="<?= $releDelay ?>" placeholder="0" min=0 class="delay-value">
                                        <span>MINUTI</span>
                                    </div>
                                </div>
                                <div class="inline-rule-info">
                                    <div class="rule-time rule-info">
                                        <span>La Regola è in funzione dalle</span>
                                        <input name="<?= "timesettings[" . $releId . "][startTime][]" ?>" type="time" value="<?= $releStart ?>" placeholder="00:00" class="start<?= $releId ?> start-time time-selection" onchange="onTimeChange(this, 'start<?= $releId ?>')">
                                        <span>alle</span>
                                        <input name="<?= "timesettings[" . $releId . "][endTime][]" ?>" type="time" value="<?= $releEnd ?>" placeholder="23:59" class="end<?= $releId ?> end-time time-selection" onchange="onTimeChange(this, 'end<?= $releId ?>')">
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endforeach; ?>
                <div class="add-osirele-div rele flex">
                    <span>Aggiungi OsiRELE</span>
                    <button name="Aggiungi" class="cursor">
                        <img src="/css_/add.png" />
                    </button>
                </div>
                <input type="submit" name="Salva" value="Salva Modifiche" class="confirm-button update-rules cursor">
            <?php endif; ?>
        </form>
    </body>

</html>

