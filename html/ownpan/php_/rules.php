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

    $OSIRELE = rtrim(shell_exec("cat " . RULES_DIR . "osiRele"));
    if ($OSIRELE == null) exit();

    // Basic Rules Stuff

    // Edit Rules (Add / Edit / Delete)
    if (isset($_POST['Salva'])) {

        $reles = $_POST[RELE];

        for ($i = 1; $i <= RELE_NUM; $i++) {
            
            $releData = $reles[$i];

            if (!empty($releData[SENSOR]) && preg_match("/[A-Za-z0-9]+:[A-Za-z0-9]+/", $releData[SENSOR]) && !empty($releData[VALUE]) && is_numeric($releData[VALUE])) {
            
                /* TEMP */ echo $i . " "; print_r($releData); echo "<br/>";

                // Get Data
                list($osinode, $port) = explode(":", $releData[SENSOR]);
                $comparator = isset($releData[COMPARATOR]) ? $releData[COMPARATOR] : '';
                $value = $releData[VALUE];
                $duration = !empty($releData[DURATION]) ? $releData[DURATION] : '0';
                $delay = !empty($releData[DELAY]) ? $releData[DELAY] : '0';

                switch ($comparator) {
                    case "<":
                        $comparator = "lt"; break;
                    case ">":
                        $comparator = "gt"; break;
                    default:
                        $comparator = null; break;
                }

                if (!$comparator) continue;

                // Save Config
                $config = "threshold\n$osinode\n$port\n$comparator\n$value\n$duration\n$delay";
                echo "echo " . $config . " > " . RULES_DIR . $OSIRELE . "halo";

                exit();
                shell_exec("echo \"" . $config . "\" > " . RULES_DIR . $OSIRELE . "halo");

                // Save Time (Other Check)
            
            } else {

                // Delete Config / Time

            }

        }

    }

    // SAVE CONF
    //  TIME CHECK
    //  SAVE TIME
    //  DELETE TIME if exists
    // DELETE CONF / TIME if exists
    // CONNECTION TO DB WITH NEW USER
    // SENSOR = OSINODE / PORT 
    // UNIT
    // VALUE RAW FROM TRUE 
    // OsiRELE