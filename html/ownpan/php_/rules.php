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

    // Select User Email
    if (isset($_POST['SelezionaUtente'])) {
        $ownerEmail = $_POST['ownerEmail'];
        shell_exec("echo \"$ownerEmail\" > " . RULES_DIR . "ownerEmail");

        header('Location: /');
        exit();
    }

    // Get OsiRELE Name
    $OSIRELE = rtrim(shell_exec("cat " . RULES_DIR . "osiRele"));
    if ($OSIRELE == null) {
        shell_exec("echo \"RE0000\" > " . RULES_DIR . "osiRele");
        $OSIRELE = rtrim(shell_exec("cat " . RULES_DIR . "osiRele"));
    }

    // Edit Rules (Add / Edit / Delete)
    if (isset($_POST['Salva'])) {

        $reles = $_POST[RELE];

        for ($i = 1; $i <= RELE_NUM; $i++) {
            
            $releData = $reles[$i];

            // preg_match("/[A-Za-z0-9]+:[A-Za-z0-9]+/", $releData[SENSOR])
            if (!empty($releData[OSINODE]) && !empty($releData[PORT]) && !empty($releData[VALUE]) && is_numeric($releData[VALUE])) {
            
                // Get Data
                // echo $i . " "; print_r($releData); echo "<br/>";
                $osinode = $releData[OSINODE];
                $port = $releData[PORT];
                $comparator = isset($releData[COMPARATOR]) ? $releData[COMPARATOR] : '';
                $value = $releData[VALUE];
                $duration = !empty($releData[DURATION]) ? $releData[DURATION] : '0';
                $delay = !empty($releData[DELAY]) ? $releData[DELAY] : '0';

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
                
                if (file_exists(RULES_DIR . $OSIRELE . "." . $i)) {
                    shell_exec("rm " . RULES_DIR . $OSIRELE . "." . $i);   // echo "rm " . RULES_DIR . $OSIRELE . "." . $i; echo "<br/>";
                }
                shell_exec("echo \"" . $config . "\" > " . RULES_DIR . $OSIRELE . "." . $i);   // echo "echo " . $config . " > " . RULES_DIR . $OSIRELE . "." . $i; echo "<br/><br/>";

                // Get Time Data && Save Time Config
                if ((!empty($releData[START_TIME]) && preg_match("/[0-2][0-9]\:[0-5][0-9]/", $releData[START_TIME])) && (!empty($releData[END_TIME]) && preg_match("/[0-2][0-9]\:[0-5][0-9]/", $releData[END_TIME]))) {
                    
                    $startTime = $releData[START_TIME];
                    $endTime = $releData[END_TIME];

                    $timeConfig = "$startTime\n$endTime";

                    if (file_exists(RULES_DIR . TIMERANGE . "." . $i)) {
                        shell_exec("rm " . RULES_DIR . TIMERANGE . "." . $i);   // echo "rm " . RULES_DIR . TIMERANGE . "." . $i; echo "<br/>";                      
                    }
                    shell_exec("echo \"" . $timeConfig . "\" > " . RULES_DIR . TIMERANGE . "." . $i);   // echo "echo " . $timeConfig . " > " . RULES_DIR . TIMERANGE . "." . $i; echo "<br/><br/>";

                }
            
            } else {

                // Delete Config 
                if (file_exists(RULES_DIR . $OSIRELE . "." . $i)) {
                    shell_exec("rm " . RULES_DIR . $OSIRELE . "." . $i);
                }

                // Delete Time Config
                if (file_exists(RULES_DIR . TIMERANGE . "." . $i)) {
                    shell_exec("rm " . RULES_DIR . TIMERANGE . "." . $i);                     
                }

            }

            // Redirect
            header("Location: /"); 
            exit();

        }

    }

    // Get User Data
    $userEmail = rtrim(shell_exec("cat " . RULES_DIR . "ownerEmail"));
    if ($userEmail) {
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
    }
