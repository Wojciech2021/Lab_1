<?php

namespace App\Service;

use PhpParser\Node\Scalar\String_;

class Item
{

    private $segment;
    private $country;
    private $product;
    private $unitSold;

    public function __construct()
    {
        $this->segment = '';
        $this->country = '';
        $this->product = '';
        $this->unitSold = 0;

    }

    /**
     * @return mixed
     */
    public function getSegment()
    {
        return $this->segment;
    }

    /**
     * @param mixed $segment
     */
    public function setSegment($segment)
    {
        $this->segment = $segment;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getUnitSold()
    {
        return $this->unitSold;
    }

    /**
     * @param mixed $unitSold
     */
    public function setUnitSold($unitSold)
    {
        $this->unitSold = $unitSold;
    }
}