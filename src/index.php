<?php
header("Content-Type: text/plain; version=0.0.4; charset=utf-8");

require_once "HpCommandParser.php";

//$hpOutputFile = getcwd() . "/hp_output.example";
$hpOutputFile = "/hpasmcli/status";

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

echo "\n";

foreach ($praser->measurements as $measurement) {
    $measurement->printPrometheus();
}