<?php

class TempSensor
{


    /**
     * @var int
     */
    public int $number;
    public string $location;
    public ?int $temp;
    public ?int $threshold;


    public static function parse(array $tableArray): array
    {

        $return = [];

        // start at third line, cuz first line is header; second line are ----
        for ($i = 2, $iMax = count($tableArray); $i < $iMax; $i++) {
            $tempsensor = new self();

            $tempsensor->number = (int)preg_replace('/\D+/', '', $tableArray[$i][0]);
            $tempsensor->location = $tableArray[$i][1];

            $tempsensor->temp = self::convertTempToCelsius($tableArray[$i][2]);
            $tempsensor->threshold = self::convertTempToCelsius($tableArray[$i][3]);

            $return[] = $tempsensor;
        }

        return $return;

    }


    private static function convertTempToCelsius(string $tempstring): int|null
    {
        $matches = [];
        preg_match('/(\d+[Cc])/', $tempstring, $matches, PREG_UNMATCHED_AS_NULL);

        if (count($matches) > 0) {
            return ((int)$matches[0]);
        }

        return null;
    }
}