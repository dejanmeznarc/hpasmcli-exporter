<?php
require_once "MetricInterface.php";

class PowerMeter implements MetricInterface
{

    public int $number;
    public float $power;

    public function printPrometheus()
    {
        echo "hpe_power_meter{number=\"$this->number\"} $this->power" . "\n";
    }

    public static function parse(string $fulltext)
    {
        $powerMeters = [];
        $powerMeterValues = [];

        preg_match_all('/power meter #(\d+)/mi', $fulltext, $powerMeters, PREG_UNMATCHED_AS_NULL);
        preg_match_all('/power reading {2}: (\d+)/mi', $fulltext, $powerMeterValues, PREG_UNMATCHED_AS_NULL);

        $ret = [];

//        echo "pm: \n";
//        print_r($powerMeters);
//        echo "----: \n";

        foreach ($powerMeters[1] as $key => $powerMeter) {

            $pm = new self();
            $pm->number = (int)$powerMeter;
            $pm->power = (float)$powerMeterValues[1][$key];
            $ret[] = $pm;
        }

        return $ret;
    }


    private static function getFirstRegexMatch(string $regex, string $text): int|null
    {
        $matches = [];
        preg_match($regex, $text, $matches, PREG_UNMATCHED_AS_NULL);

        if (count($matches) > 0) {
            return ((int)$matches[0]);
        }

        return null;
    }


}