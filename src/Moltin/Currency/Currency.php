<?php

/**
 * This file is part of Moltin Currency, a PHP library to process, format and
 * convert values between various currencies and formats.
 *
 * Copyright (c) 2013 Moltin Ltd.
 * http://github.com/moltin/currency
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package moltin/currency
 * @author Jamie Holdroyd <jamie@molt.in>
 * @author Chris Harvey <chris@molt.in>
 * @copyright 2013 Moltin Ltd.
 * @version dev
 * @link http://github.com/moltin/currency
 *
 */

namespace Moltin\Currency;

class Currency
{
    protected $exchange;
    protected $original =  0;
    protected $value    =  0;

    public function __construct(ExchangeInterface $exchange, FormatInterface $format)
    {
        $this->exchange = $exchange;
        $this->format   = $format;
    }

    public function convert($value, $new = true)
    {
        $clone = $this;

        if ($new) $clone = clone $this;

        $clone->value = $value;

        return $clone;
    }

    public function from($code)
    {
        $this->currency = $code;

        return $this;
    }

    public function to($code)
    {
        // Assign new values
        $this->original = $this->value;
        $this->value = $this->exchange->convert($this->value, $this->currency, $code);
        $this->currency = $code;

        return $this;
    }

    public function format()
    {
        return $this->format->format($this->value, $this->currency);
    }

    public function value()
    {
        return $this->value;
    }

    public function original()
    {
        return $this->original;
    }

    public function currency()
    {
        return $this->data;
    }

    public function zeros()
    {
        return $this->format->zeros($this->value, $this->currency);
    }

    public function nines()
    {
        return $this->format->nines($this->value, $this->currency);
    }

    public function fifty()
    {
        return $this->format->fifty($this->value, $this->currency);
    }

    public function reset()
    {
        $this->value = $this->original;
        return $this;
    }

    public function setExchange(ExchangeInterface $exchange)
    {
        $this->exchange = $exchange;
    }

    public function setCurrency(array $currency)
    {
        foreach ($currency as $key => $value) {

            if (isset($this->data[$key])) $this->data[$key] = $value;

        }

        $this->reset();

        return $this;
    }
    
    public function __get($property)
    {
        return $this->data[$property];
    }

    public function __toString()
    {
        return $this->format();
    }

}
