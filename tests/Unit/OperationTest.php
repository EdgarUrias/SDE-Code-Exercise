<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\OperationController;

class OperationTest extends TestCase
{

    public function testCalculateSSEvenLengthstreet()
    {
        // Test when street length is even.
        $assignment = new OperationController();
        $ss = $assignment->calculateSS('215 Osinski Manors', 'Sellis Wisozk');

        // Expected SS: vowels(4) * 1.5 = 6.0
        $this->assertEquals(6.0, $ss);
    }

    public function testCalculateSSOddLengthstreet()
    {

        // Test when street length is odd.
        $assignment = new OperationController();
        $ss = $assignment->calculateSS('4567 Elm Aves', 'Jane Smith');

        // Expected SS: consonants(6) * 1 = 6.0
        $this->assertEquals(6.0, $ss);
    }

    public function testCalculateSSWithCommonFactors()
    {
        // Test when street and driver lengths have common factors.
        $assignment = new OperationController();
        $ss = $assignment->calculateSS('1234 Elm Stree', 'Robert Johnson');

        // Expected SS: vowels(4) * 1.5 + 50% = 6.0 + 3.0 = 9.0
        $this->assertEquals(9.0, $ss);
    }

    public function testCalculateSSNoCommonFactors()
    {
        // Test when street and driver lengths have no common factors.
        $assignment = new OperationController();
        $ss = $assignment->calculateSS('7890 Willow Lane', 'Michael Jackson');

        // Expected SS: vowels(5) * 1.5 = 7.5
        $this->assertEquals(7.5, $ss);
    }
}
