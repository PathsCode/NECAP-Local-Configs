<?php

    // CONSTS
    const RELE_NUM = 8;

    const RELE = 'rele';
    const SENSOR = 'sensor';
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

    // Get User Email
    $userEmail = rtrim(shell_exec("cat " . RULES_DIR . "ownerEmail"));
    $user = $userEmail;

    // Edit Rules (Add / Edit / Delete)
    if (isset($_POST['Salva'])) {

        $reles = $_POST[RELE];

        for ($i = 1; $i <= RELE_NUM; $i++) {
            
            $releData = $reles[$i];

            if (!empty($releData[SENSOR]) && preg_match("/[A-Za-z0-9]+:[A-Za-z0-9]+/", $releData[SENSOR]) && !empty($releData[VALUE]) && is_numeric($releData[VALUE])) {
            
                // Get Data
                // echo $i . " "; print_r($releData); echo "<br/>";
                list($osinode, $port) = explode(":", $releData[SENSOR]);
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

        }

    }

    // CONNECTION TO DB WITH NEW USER
    // INSERT YOUR NECAP EMAIL
    // GET OSINODES && SENSORS LIST (With No Power && No Personal Data)
    // DROPDOWN CHOICE OF OSINODE
    // DROPDOWN CHOICE OF PORT WITH TYPE INFO
    // SENSOR = OSINODE : PORT 
    // UNIT
    // VALUE RAW FROM TRUE 
    // REDIRECT
