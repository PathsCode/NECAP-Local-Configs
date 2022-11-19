<?php

    // CONSTS
    const RELE_NUM = 8;

    const RELE = 'rele';
    const SENSOR = 'sensor';
    const COMPARATOR = 'comparator';
    const VALUE = 'value'; 
    const DURATION = 'duration';
    const DELAY = 'delay';

    const RULES_DIR = '/srv/data/';

    const MINOR_THAN = 'lt';
    const MAJOR_THAN = 'gt';

    $OSIRELE = rtrim(shell_exec("cat " . RULES_DIR . "osiRele"));
    if ($OSIRELE == null) exit();

    // Basic Rules Stuff

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
                echo "rm " . RULES_DIR . $OSIRELE . "." . $i; echo "<br/>";
                echo "echo " . $config . " > " . RULES_DIR . $OSIRELE . "." . $i; echo "<br/><br/>";
                
                shell_exec("rm " . RULES_DIR . $OSIRELE . "." . $i);
                shell_exec("echo \"" . $config . "\" > " . RULES_DIR . $OSIRELE . "." . $i);   

                // Save Time (Other Check)
            
            } else {

                // Delete Config / Time

            }

        }

    }

    // SHOW TIME
    //  TIME CHECK
    //  SAVE TIME
    //  DELETE TIME if exists
    // DELETE CONF / TIME if exists
    // CONNECTION TO DB WITH NEW USER
    // SENSOR = OSINODE / PORT 
    // UNIT
    // VALUE RAW FROM TRUE 
    // REDIRECT
