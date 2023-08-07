<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OperationController extends Controller
{
    /**
     * process the operation
     *
     *@param $addresses array
     *@param $drivers array
     *
     * return collection
     */
    public function processSS($addresses, $drivers){

        //declare empty array and sum = 0
        $shipmentAssignments = [];
        $SumSS = 0;

        foreach ($addresses as $address) {
            //index
            $maxSS = 0;
            foreach ($drivers as $driver) {
                //extract only the street from the address
                $street = strstr($address, ',', true);
                $street = trim($street);

                //calculate the SS
                $ss = $this->calculateSS($street, $driver);

                //validate if the SS is bigger than the maxSS and the street is not assigned to another driver or the driver is not assigned to another street
                if ($ss > $maxSS && !in_array($street, $shipmentAssignments) && !in_array($driver, $shipmentAssignments)) {
                    $maxSS = $ss;
                    $shipmentAssignments[$street] = $driver;
                }

            }
            //sum the SS of all the addresses
            $SumSS += $maxSS;
        }

        $collection = collect();

        $collection->put('shipmentAssignments', $shipmentAssignments);
        $collection->put('totalSS', $SumSS);

        return $collection;

    }

    /**
     * calculate the SS
     *
     *@param $street
     *@param $driver
     *
     * @return float
     */
    public function calculateSS($street, $driver)
    {
        //get the length of the street and driver
        $streetLen = strlen($street);
        $driverLen = strlen(str_replace(' ', '', $driver));

        //get the number of vowels and consonants
        $vowels = preg_match_all('/[aeiouAEIOU]/', $driver);
        $consonants = $driverLen - $vowels;

        //calculate the base SS
        $baseSS = ($streetLen % 2 === 0) ? ($vowels * 1.5) : ($consonants * 1);

        // Increase SS by 50% if they share common factors
        if ($streetLen > 1 && $driverLen > 1 && $this->hasCommonFactors($streetLen, strlen($driver))) {
            $baseSS *= 1.5;
        }

        return $baseSS;
    }

    /**
     *check if the two numbers have common factors
     *
     * @param $streetLen
     * @param $driverLen
     *
     * return bool
     */
    private function hasCommonFactors($streetLen, $driverLen)
    {
        //get the minimum of the two numbers
        $min = min($streetLen, $driverLen);
        for ($i = 2; $i <= $min; $i++) {
            if ($streetLen % $i === 0 && $driverLen % $i === 0) {
                return true;
            }
        }
        return false;
    }

}
