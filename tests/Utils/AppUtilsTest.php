<?php
namespace Test\Utils;

use App\Utils\AppUtils;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class AppUtilsTest extends TestCase
{
    private $options = array('min_range' => 10,
            'max_range' => 20);

    public function testNumberInRangeFilter_integer_variable()
    {
        $result = AppUtils::filter_integer_variable(10, $this->options);
        $this->assertEquals(10, $result);
    }

    public function testNumberNotInRangeFilter_integer_variable()
    {
        $result = AppUtils::filter_integer_variable(21, $this->options);
        $this->assertEmpty($result);
    }
}
