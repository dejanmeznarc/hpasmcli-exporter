<?php
header("Content-Type: text/plain");

require_once "HpCommandParser.php";

$hpOutputFile = getcwd() . "/hp_output.example";

if(isset($_GET["debug"])) {
echo "starting, reading $hpOutputFile \n";
}

$file = fopen($hpOutputFile, 'rb');
$content = fread($file, filesize($hpOutputFile));
fclose($file);

$praser = new HpCommandParser($content);

$praser->parseAll();

if(isset($_GET["debug"])){
    print_r($praser);
}


include "promhelp.php";

foreach ($praser->measurements as $measurement) {
    $measurement->printPrometheus();
}