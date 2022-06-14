<?php

require_once "Fan.php";
require_once "TempSensor.php";
require_once "PowerMeter.php";
require_once "PowerSupply.php";

class HpCommandParser
{
    private string $document;


    /**
     * @var MetricInterface[] $measurements
     */
    public array $measurements;


    public function __construct(string $document)
    {
        $this->document = $document;
    }


    /***
     * Convert raw text to MD array table
     * @param $rawText
     * @return array
     */
    private function razmesariTableo($rawText): array
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
    private function isInStr($haystack, $needle): bool
    {
        return strpos($haystack, $needle) !== false;
    }


    function parseAll()
    {
        $byEntries = explode("\n\n", $this->document);


        $rawTables = [];
        $nonTables = [];

// Parse all entries to variables
        foreach ($byEntries as $entry) {
            $entry = strtolower($entry);

            if ($this->isInStr($entry, "fan")) {
                $rawTables["fans"] = $entry;
            }

            if ($this->isInStr($entry, "sensor")) {
                $rawTables["temps"] = $entry;
            }

            if ($this->isInStr($entry, "power meter")) {
                //TODO: nontable form
                $nonTables["powermeter"] = $entry;
            }

            if ($this->isInStr($entry, "power supply")) {
                //TODO: nontable form
                $nonTables["psu"] = $entry;
            }

            if ($this->isInStr($entry, "last fetch")) {
                //TODO: nontable form
                $nonTables["lastfetch"] = $entry;
            }
        }


        $this->measurements = array_merge(
            Fan::parse($this->razmesariTableo($rawTables["fans"])),
            TempSensor::parse($this->razmesariTableo($rawTables["temps"])),
            PowerMeter::parse($nonTables["powermeter"]),
            PowerSupply::parse($nonTables["psu"]),
        );

    }


}
