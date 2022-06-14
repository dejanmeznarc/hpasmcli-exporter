<?php

class Fan
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
