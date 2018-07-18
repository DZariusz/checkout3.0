<?php

namespace CHECKOUT;

/**
 * Class ProductData
 *
 * this is object for single product in a list of products we added for processing
 *
 * @package CHECKOUT
 */
class ProductData {

    public $regularPrice, // price in cents - positive integer
           $units;

    public function __construct($regularPrice, $units)
    {
        Validate::positiveInt($regularPrice, "Regular Price must be positive integer, found $regularPrice");
        Validate::positiveInt($units, "Units must be positive integer, found $units");

        $this->regularPrice = $regularPrice;
        $this->units = $units;
    }
}

/**
 * Class Checkout
 *
 * This is class for al products that we need to process during checkout
 *
 * @version 3.0
 */
class Products {

    // Array of Product objects
    private $products;


    public static function make() {
        return new self;
    }

    public function __construct()
    {
        $this->products = [];
    }


    /**
     * Add product for processing
     *
     * you can add product at any time untill you print final receipt
     *
     *
     * @param $productId mixed any scalar unique value that identifies the product
     * @param $regularPrice
     * @param $units
     * @return bool
     */
    public function addProduct($productId, $regularPrice, $units) {

        $this->products[Validate::isScalar($productId, "Product ID must be scalar value")] = new ProductData($regularPrice, $units);

        DebugLog::log("Added product $productId | price $regularPrice | units $units");

        return true;
    }


    public function getProducts() {
        return $this->products;
    }

    /**
     * remove all added products
     */
    public function clearProducts() {
        $this->products = [];
    }


    /**
     * Calculates current regular sum base on added products
     *
     * @return int total regular sum
     */
    public function getTotalRegularSum() {
        $total = 0;

        foreach ($this->products as $productData) {

            $total += $productData->regularPrice * $productData->units;
        }

        return $total;
    }

    /**
     * Returns well formated string with product information.
     * Might be used as position in receipt
     *
     * @param $productId
     * @return null|string
     */
    protected function getFormatedProduct($productId) {
        if (!isset($this->products[$productId])) return null;

        $data = $this->products[$productId];
        return "$productId: price $data->regularPrice x $data->units usits = ". ($data->regularPrice * $data->units);
    }

}