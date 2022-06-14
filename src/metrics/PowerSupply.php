<?php
require_once "MetricInterface.php";

class PowerSupply implements MetricInterface
{

    public int $number;
    public bool $present;
    public ?bool $redundant;
    public ?string $condition;
    public ?bool $hotplug;
    public ?float $power;


    public function printPrometheus()
    {
        echo "hpe_psu_present{number=\"$this->number\"} " . (int)($this->present) . "\n";
        echo "hpe_psu_redundant{number=\"$this->number\"} " . (int)($this->redundant ?? -1) . "\n";
        echo "hpe_psu_condition{number=\"$this->number\", value=\"" . ($this->condition ?? "unknown")
            . "\"} \"" . (int)(($this->condition ?? "NaN") === "ok") . "\"\n";
        echo "hpe_psu_hotplug{number=\"$this->number\"} " . (int)($this->hotplug ?? -1) . "\n";
        echo "hpe_psu_power{number=\"$this->number\"} " . ($this->power ?? -1.0) . "\n";
    }


    public static function parse(string $fulltext)
    {

        /* this returns that:
         Array
         (
             [0] =>

             [1] =>
                 present  : yes
                 redundant: no
                 condition: ok
                 hotplug  : supported
                 power    : 50 watts

             [2] =>
                 power supply not present
         )*/
        $psuTexts = preg_split('/(Power supply #\d+)/mi', $fulltext);

        $ret = [];

        // start at one
        for ($i = 1, $iMax = count($psuTexts); $i < $iMax; $i++) {
            $psu = new self();

            $psu->number = $i;
            self::parseOne($psu, $psuTexts[$i]);

            $ret[] = $psu;

        }


        return $ret;
    }

    private static function parseOne(self $psu, string $text)
    {

        $psu->present = (preg_match('/(present\s+:\s+Yes)/mi', $text) === 1);

        if ($psu->present) {
            $psu->redundant = strtolower(self::getFirstRegexMatch('/redundant:\s+(Yes|No)$/mi', $text)) === "yes";
            $psu->condition = self::getFirstRegexMatch('/condition: (\w+)/mi', $text);
            $psu->hotplug = preg_match('/hotplug\s+:\s(supported)/mi', $text) === 1;
            $psu->power = (float)self::getFirstRegexMatch('/power\s+:\s+(\d+)\s+watts/mi', $text);
        }
    }


    private static function getFirstRegexMatch(string $regex, string $text)
    {
        $matches = [];
        preg_match($regex, $text, $matches, PREG_UNMATCHED_AS_NULL);

        if (count($matches) > 0) {
            return $matches[1];
        }

        return null;
    }


}