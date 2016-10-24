<?php
include ("config.inc.php");

$fp = fsockopen($host, $port, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    stream_set_timeout($fp, 2);
    $buffer = ""; 

    // Get and ignore the telnet options for now
    // consists of 12 bytes on my Cisco 2651XM
    $buffer = fgets($fp, 13); 

    // Answer with telnet options grabbed from command line 
    // telnet client 
    // FFFD01FFFD03FFFB18FFFB1FFFFA1F00CC0043FFF0
    $data = hex2bin("FFFE01FFFD03");
    fwrite($fp, $data); 

    // read and ignore 6 byte answer
    $buffer = fgets($fp, 7); 

    // Another answer grabbed from a console telnet session
    // FFFA1800787465726D2D323536636F6C6F72FFF0
    // contains the clients name, modified to display "Quantar-Dashboard".
    $data = hex2bin("FFFA18005175616E7461722D44617368626F617264FFF0");
    fwrite($fp, $data); 

    // Now the console seems to be open and ready to receive commands
    // Send one carriage return
    $data = hex2bin("0D");
    fwrite($fp, $data);

    // Read echo and discard
    $buffer = fgets($fp, 5); 

    // Read command prompt (i.e. "]-O ") and check if it came back
    $buffer = fgets($fp, 6); 
    if ($buffer != "]-O ") {
        printf ("Error. Prompt \"]-O \" not found\n");
    }

    // Send command "dorap"
    $data = "dorap\r";
    fwrite($fp, $data);

    // Read and discard echo of "dorap" command
    $buffer = fgets($fp, 7);
    if ($buffer != "dorap\r") {
        printf ("Error. Command \"dorap\" not accepted\n");
    }

    // Read and discard line feed
    $buffer = fgets($fp, 5); 

    // Read and discard prompt "RAP: "
    $buffer = fgets($fp, 6);
    if ($buffer != "RAP: ") {
        printf ("Error. RAP prompt not found\n");
    }

    // Send command "MTR TX_PA_P1"
    $data = "MTR TX_PA_P1\r";
    fwrite($fp, $data);

    // Read and discard echo of "MTR TX_PA_P1" command
    $buffer = fgets($fp, 13);
    if ($buffer != "MTR TX_PA_P1") {
        printf ("Error. MTR TX_PA_P1 not found\n");
    }

    // Read and discard line feed
    $buffer = fgets($fp, 5); 

    // Read output of MTR TX_PA_P1 command
    $values = array();

    $i = 1;
    for ($i=1; $i < 50; $i++) {
        $buffer = fgets($fp, 1024);
        $buffer = trim(preg_replace('/RAP: /', '', $buffer));
        if ($buffer != '') {
            $temp = explode(" = ", $buffer);
            $values["$temp[0]"] = $temp[1];
        }
    }

    // Now we should have all the values in an indexed array

    // Send command "exit"
    $data = "exit\r";
    fwrite($fp, $data);

    // close connection
    fclose($fp);
}
?>
