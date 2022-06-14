<?php

require_once "MetricInterface.php";

class Fan implements MetricInterface
{
    /**
     * @var int
     */
    private $number;
    /**
     * @var string
     */
    private $location;
    /**
     * @var bool
     */
    private $present;
    /**
     * @var string
     */
    private $speed;
    /**
     * @var float
     */
    private $speed_percent;
    /**
     * @var bool
     */
    private $redundant;
    /**
     * @var int|null
     *
     */
    private $partner;
    /**
     * @var bool|null
     */
    private $hotplug;


    public function printPrometheus()
    {
        echo "hpe_fan_present{number=\"$this->number\",location=\"$this->location\"} " . (int)($this->present) . "\n";
        echo "hpe_fan_redundant{number=\"$this->number\",location=\"$this->location\"} " . (int)($this->redundant) . "\n";
        echo "hpe_fan_hotplug{number=\"$this->number\",location=\"$this->location\"} " . (int)($this->hotplug) . "\n";
        echo "hpe_fan_speed{number=\"$this->number\",location=\"$this->location\"} \"$this->speed\"" . "\n";
        echo "hpe_fan_speed_percent{number=\"$this->number\",location=\"$this->location\"} $this->speed_percent" . "\n";
        echo "hpe_fan_partner{number=\"$this->number\",location=\"$this->location\"} " . (int)($this->partner??-1) . "\n";
    }

    public static function parse(array $tableArray): array
    {
        $return = [];

        // start at third line, cuz first line is header; second line are ----
        for ($i = 2, $iMax = count($tableArray); $i < $iMax; $i++) {

            $fan = new self();
            $fan->number =  (int)preg_replace('/\D+/', '', $tableArray[$i][0]);
            $fan->location = $tableArray[$i][1];
            $fan->present = (strtolower($tableArray[$i][2]) === "yes");
            $fan->speed = (string)$tableArray[$i][3];
            $fan->speed_percent = (float)((int)$tableArray[$i][4] / 100);
            $fan->redundant = (strtolower($tableArray[$i][5]) === "n/a" ? null : (strtolower($tableArray[$i][5]) === "yes"));
            $fan->partner = (strtolower($tableArray[$i][6]) === "n/a" ? null : ((int)$tableArray[$i][6]));
            $fan->hotplug = (strtolower($tableArray[$i][7]) === "n/a" ? null : (strtolower($tableArray[$i][7]) === "yes"));

            $return[] = $fan;
        }
        return $return;
    }


}
