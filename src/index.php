<?php
require_once "Fan.php";
require_once "TempSensor.php";
require_once "PowerMeter.php";

$hpOutputFile = getcwd() . "/hp_output.example";

echo "starting, reading $hpOutputFile \n";

$file = fopen($hpOutputFile, 'rb');
$content = fread($file, filesize($hpOutputFile));
fclose($file);

$byEntries = explode("\n\n", $content);

print_r($byEntries);


/***
 * Convert raw text to MD array table
 * @param $rawText
 * @return array
 */
function razmesariTableo($rawText): array
{
    $textLines = explode("\n", $rawText);

    $return = [];
    foreach ($textLines as $key => $line) {
        $return[$key] = preg_split('/\h{2,}/', $line);
    }

    return $return;
}

/***
 * Check if $needle is in $haysstack
 * @param $haystack
 * @param $needle
 * @return bool
 */
function isInStr($haystack, $needle): bool
{
    return strpos($haystack, $needle) !== false;
}

$rawTables = [];
$nonTables = [];

// Parse all entries to variables
foreach ($byEntries as $entry) {
    $entry = strtolower($entry);

    if (isInStr($entry, "fan")) {
        $rawTables["fans"] = $entry;
    }

    if (isInStr($entry, "sensor")) {
        $rawTables["temps"] = $entry;
    }

    if (isInStr($entry, "power meter")) {
        //TODO: nontable form
        $nonTables["powermeter"] = $entry;
    }

    if (isInStr($entry, "power supply")) {
        //TODO: nontable form
        $nonTables["psu"] = $entry;
    }

    if (isInStr($entry, "last fetch")) {
        //TODO: nontable form
        $nonTables["lastfetch"] = $entry;
    }
}



//print_r(razmesariTableo($rawTables["fans"]));
//print_r(razmesariTableo($rawTables["temps"]));

$fans = Fan::parse(razmesariTableo($rawTables["fans"]));
$temps = TempSensor::parse(razmesariTableo($rawTables["temps"]));

$pm = PowerMeter::parse($nonTables["powermeter"]);


//print_r($fans);
//print_r($temps);
print_r($pm);

