<?php

namespace Rubix\ML\Kernels\Distance;

use Rubix\ML\DataType;

/**
 * Haversine
 *
 * Distance between two points on a sphere using latitude and longitude.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 * @author      JS Quetier, with inspiration from Akanksha Rai(Abby_akku)
 */
class Haversine implements Distance
{
    /**
     * Return the data types that this kernel is compatible with.
     *
     * @internal
     *
     * @return list<\Rubix\ML\DataType>
     */
    public function compatibility() : array
    {
        return [
            DataType::continuous(),
        ];
    }

    /**
     * Compute the distance between two vectors.
     * @todo : throw Exception if the function receive 1D datas (only latitudes) ?
     *
     * @internal
     *
     * @param list<int|float> $a [latitude, longitude]
     * @param list<int|float> $b [latitude, longitude]
     * @return float
     */
    public function compute(array $a, array $b) : float
    {
        // checks if we got the longitudes
        if (!isset($a[1]) || !isset($b[1])) return 0;

        $lat1     = $a[0];
        $long1    = $a[1];
        $lat2     = $b[0];
        $long2    = $b[1];
        $radCoeff = M_PI / 180.0;

        // distance between latitudes and longitudes
        $dLat = ($lat2 - $lat1) * $radCoeff;
        $dLon = ($long2 - $long1) * $radCoeff;

        // convert latitudes to radians
        $lat1 = $lat1 * $radCoeff;
        $lat2 = $lat2 * $radCoeff;

        // apply haversine formula
        $a = pow(sin($dLat / 2), 2) + pow(sin($dLon / 2), 2) * cos($lat1) * cos($lat2);
        return asin(sqrt($a)) * 12742;
    }

    /**
     * Return the string representation of the object.
     *
     * @internal
     *
     * @return string
     */
    public function __toString() : string
    {
        return 'Haversine';
    }
}
