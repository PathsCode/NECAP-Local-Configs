<?php

    /* TEMP */ ini_set('display_errors', 1);

    // CONSTS
    const RELE_NUM = 8;

    const RELE = 'rele';
    const SENSOR = 'sensor';
    const OSINODE = 'osinode';
    const PORT = 'port';
    const COMPARATOR = 'comparator';
    const VALUE = 'value'; 
    const DURATION = 'duration';
    const DELAY = 'delay';

    const TIME_CONFIG = 'timesettings';
    const START_TIME = 'startTime';
    const END_TIME = 'endTime';

    const RULES_DIR = '/srv/data/';
    const TIMERANGE = 'timeRange';

    const MINOR_THAN = 'lt';
    const MAJOR_THAN = 'gt';

    const ID = 'id';
    const OSINODE_ID = 'osinodeId';
    const PORT_ID = 'portId';
    const PARAM = 'param';
    const FORMULA = 'formula';
    const UNIT = 'unit';

    const DEFAULT_OSIRELE = 'RE0001';

    // Select User Email
    if (isset($_POST['SelezionaUtente'])) {
        $ownerEmail = $_POST['ownerEmail'];
        shell_exec("echo \"$ownerEmail\" > " . RULES_DIR . "ownerEmail");

        header('Location: /');
        exit();
    }

    // Add OsiRELE
    else if (isset($_POST['Aggiungi'])) {

        // Get OsiRELE Names
        $OSIRELES_NAMES = [];
        foreach (explode("\n", shell_exec("cat " . RULES_DIR . "osiRele")) as $OsiRELE_Name) {
            $OsiRELE_Name = rtrim($OsiRELE_Name);
            if ($OsiRELE_Name) $OSIRELES_NAMES[] = rtrim($OsiRELE_Name);
        }
        print_r($OSIRELES_NAMES);

        // Select New OsiRELE Name
        if (empty($OSIRELES_NAMES)) {
            $newName = DEFAULT_OSIRELE;
        } else {
            $lastName = end($OSIRELES_NAMES);
            $lastNum = intval(substr($lastName, 2));
            $newNum = $lastNum + 1;
            $newName = "RE" . str_pad($newNum, 4, '0', STR_PAD_LEFT);
        }

        // Build New OsiRELE Names List
        $namesList = "";
        foreach ($OSIRELES_NAMES as $OsiRELE_Name) {
            if ($namesList) $namesList .= "\n";
            $namesList .= $OsiRELE_Name;
        }

        if ($namesList) $namesList .= "\n";
        $namesList .= $newName;

        // Apply Changes
        shell_exec("echo \"" . $namesList . "\" > " . RULES_DIR . "osiRele");

        header('Location: /');
        exit();        
    }

    // Edit Rules (Add / Edit / Delete)
    else if (isset($_POST['Salva'])) {

        // Get OsiRELE Names
        $OSIRELES_NAMES = [];
        foreach (explode("\n", shell_exec("cat " . RULES_DIR . "osiRele")) as $OsiRELE_Name) {
            $OsiRELE_Name = rtrim($OsiRELE_Name);
            if ($OsiRELE_Name) {
                $OSIRELES_NAMES[] = rtrim($OsiRELE_Name);
            }
        }
        
        // Empty OsiRELE List
        shell_exec("echo \"\" > " . RULES_DIR . "osiRele");
        $activeOsiRELES = [];
        
        // Delete OsiRELE Files
        foreach ($OSIRELES_NAMES as $OsiRELE_Name) {
            for ($i = 1; $i <= RELE_NUM; $i++) {
                if (file_exists(RULES_DIR . $OsiRELE_Name . "." . $i)) {
                    shell_exec("rm " . RULES_DIR . $OsiRELE_Name . "." . $i);
                }
            }
        }

        // Delete TIME Files
        for ($i = 1; $i <= RELE_NUM; $i++) {
            
            if (file_exists(RULES_DIR . TIMERANGE . "." . $i)) {
                shell_exec("rm " . RULES_DIR . TIMERANGE . "." . $i);                     
            }

        }

        // RULES CONFIG
        $rules = $_POST[RELE];

        foreach ($rules as $OsiRELE_Name => $OsiRELE_Rules) {

            for ($i = 1; $i <= RELE_NUM; $i++) {
                
                $releData = $OsiRELE_Rules[$i];

                // preg_match("/[A-Za-z0-9]+:[A-Za-z0-9]+/", $releData[SENSOR])
                if (!empty($releData[OSINODE]) && !empty($releData[PORT]) && !empty($releData[VALUE]) && is_numeric($releData[VALUE])) {
                
                    // Get Data
                    // echo $i . " "; print_r($releData); echo "<br/>";
                    $osinode = $releData[OSINODE];
                    $port = $releData[PORT];
                    $comparator = isset($releData[COMPARATOR]) ? $releData[COMPARATOR] : '';
                    $value = $releData[VALUE];
                    $formula = $releData[FORMULA] ? $releData[FORMULA] : '';
                    $duration = !empty($releData[DURATION]) ? $releData[DURATION] : '0';
                    $delay = !empty($releData[DELAY]) ? $releData[DELAY] : '0';

                    // Get Comparator
                    switch ($comparator) {
                        case "<":
                            $comparator = MINOR_THAN; break;
                        case ">":
                            $comparator = MAJOR_THAN; break;
                        default:
                            $comparator = null; break;
                    }

                    if (!$comparator) continue;

                    // Save Config
                    $config = "threshold\n$osinode\n$port\n$comparator\n$value\n$duration\n$delay";
                    
                    if (file_exists(RULES_DIR . $OsiRELE_Name . "." . $i)) {
                        shell_exec("rm " . RULES_DIR . $OsiRELE_Name . "." . $i);   // echo "rm " . RULES_DIR . $OsiRELE_Name . "." . $i; echo "<br/>";
                    }
                    shell_exec("echo \"" . $config . "\" > " . RULES_DIR . $OsiRELE_Name . "." . $i);   // echo "echo " . $config . " > " . RULES_DIR . $OsiRELE_Name . "." . $i; echo "<br/><br/>";
                
                    // Save Rele Name
                    if (!in_array($OsiRELE_Name, $activeOsiRELES)) {
                        $activeOsiRELES[] = $OsiRELE_Name;
                    }

                }
                
            }
        
        }

        // TIME CONFIG
        $timeconfigs = $_POST[TIME_CONFIG];

        foreach ($timeconfigs as $timeidentifier => $timeconfig) {

            // Get Time Start Data
            $timeStart = null;
            foreach ($timeconfig[START_TIME] as $timeStartCandidate) {
                if ($timeStartCandidate) $timeStart = $timeStartCandidate;
            }

            // Get Time End Data
            $timeEnd = null;
            foreach ($timeconfig[END_TIME] as $timeEndCandidate) {
                if ($timeEndCandidate) $timeEnd = $timeEndCandidate;
            }

            // echo $timeidentifier . ' '; print_r($timeconfig);
            // echo 'Time Start: ' . $timeStart . "   Time End: ". $timeEnd . '<br>';

            // Save Time Config
            if ((!empty($timeStart) && preg_match("/[0-2][0-9]\:[0-5][0-9]/", $timeStart)) && (!empty($timeEnd) && preg_match("/[0-2][0-9]\:[0-5][0-9]/", $timeEnd))) {
    
                $timeConfig = "$timeStart\n$timeEnd";
    
                if (file_exists(RULES_DIR . TIMERANGE . "." . $timeidentifier)) {
                    shell_exec("rm " . RULES_DIR . TIMERANGE . "." . $timeidentifier);   // echo "rm " . RULES_DIR . TIMERANGE . "." . $timeidentifier; echo "<br/>";                      
                }
                shell_exec("echo \"" . $timeConfig . "\" > " . RULES_DIR . TIMERANGE . "." . $timeidentifier);   // echo "echo " . $timeConfig . " > " . RULES_DIR . TIMERANGE . "." . $timeidentifier; echo "<br/><br/>";
    
            } 
        
        }

        // Save OsiRELES
        $activeOsiRELEStxt = "";
        foreach ($activeOsiRELES as $activeOsiRELE) {
            if ($activeOsiRELEStxt) $activeOsiRELEStxt .= "\n";
            $activeOsiRELEStxt .= $activeOsiRELE;
        }
        shell_exec("echo \"" . $activeOsiRELEStxt . "\" > " . RULES_DIR . "osiRele");

        // Redirect
        header("Location: /"); 
        exit();

    // View Rules for index.php
    } else {

        // Get OsiRELE Names
        $OSIRELES_NAMES = [];
        foreach (explode("\n", shell_exec("cat " . RULES_DIR . "osiRele")) as $OsiRELE_Name) {
            $OsiRELE_Name = rtrim($OsiRELE_Name);
            if ($OsiRELE_Name) {
                $OSIRELES_NAMES[] = rtrim($OsiRELE_Name);
            }
        }

        // Create OsiRELE if NULL
        if ($OSIRELES_NAMES == null) {
            shell_exec("echo \"RE0001\" > " . RULES_DIR . "osiRele");
            $OSIRELES_NAMES = [DEFAULT_OSIRELE];
        }

        // Get User Data
        $userEmail = rtrim(shell_exec("cat " . RULES_DIR . "ownerEmail"));
        if ($userEmail) {
            try {
                $PDO = new PDO('mysql:host=65.109.11.231; dbname=necap;
                charset=utf8', 'localconfiguser', 'local');
                $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                $sql = 'SELECT `osinode`.`osinodeId`, `portId`, `param`, `formula`, `unit` FROM `sensor-types` INNER JOIN `sensor` ON `sensor-types`.`id` = `sensor`.`sensorTypeId` INNER JOIN `osinode-sensors` ON `sensor`.`id` = `osinode-sensors`.`sensorId` INNER JOIN `osinode` ON `osinode-sensors`.`osinodeId` = `osinode`.`id` INNER JOIN `user-osinodes` ON `osinode`.`id` = `user-osinodes`.`osinodeId` INNER JOIN `user` ON `userId` = `user`.`id` WHERE `email` = :userEmail';
                $pars = ['userEmail' => $userEmail];
    
                $query = $PDO->prepare($sql);
                $query->execute($pars);
    
                $allData = $query->fetchAll();
    
                $osinodes = [];
                $osinodesNames = [];
                foreach ($allData as $singleData) {
                    $osinodes[$singleData[OSINODE_ID]][] = $singleData;
                    if (!in_array($singleData[OSINODE_ID], $osinodesNames)) {
                        $osinodesNames[] = $singleData[OSINODE_ID];
                    }
                }

                $connError = false;
            } catch (PDOException $e) {
                $connError = true;
            }

        }

    }
