<?php

use Moltin\Currency\Currency;

class CurrencyTest extends \PHPUnit_Framework_TestCase
{

    protected $exchagnge;
    protected $tests = 100;
    protected $start = 1;       // £0.01
    protected $end   = 1000000; // £10,000.00

    public function __construct()
    {
        // Create required objects
        $store          = new \Moltin\Currency\Storage\Session();
        $currencies     = new \Moltin\Currency\Currencies\File();
        $this->exchange = new \Moltin\Currency\Exchange\OpenExchangeRates($store, $currencies, array('base' => 'GBP', 'app_id' => ''));
    }

    # Format
    public function testValue()
    {
        // Loop and test
        for ( $i = 0; $i < $this->tests; $i++ ) {

            // Build value
            $value = ( rand($this->start, $this->end) / 100 );

            // Setup
            $currency = new \Moltin\Currency\Currency($this->exchange, $value);

            // Assert it
            $this->assertEquals($value, $currency->value());
        }
    }

    public function testCurrency()
    {
        // Loop and test
        for ( $i = 0; $i < $this->tests; $i++ ) {

            // Build value
            $value = ( rand($this->start, $this->end) / 100 );

            // Setup
            $currency = new \Moltin\Currency\Currency($this->exchange, $value);

            // Assert it
            $this->assertEquals('&pound;'.number_format($value, 2), $currency->currency());
        }
    }

}
