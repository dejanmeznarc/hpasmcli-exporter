<?php
require_once "HpCommandParser.php";

$hpOutputFile = getcwd() . "/hp_output.example";

echo "starting, reading $hpOutputFile \n";

$file = fopen($hpOutputFile, 'rb');
$content = fread($file, filesize($hpOutputFile));
fclose($file);

$praser = new HpCommandParser($content);

$praser->parseAll();

foreach ($praser->measurements as $measurement) {
    $measurement->printPrometheus();
}