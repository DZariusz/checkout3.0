<?php
/**
 * Created by PhpStorm.
 * User: DZariusz
 * Date: 17.07.2018
 * Time: 21:28
 */

namespace CHECKOUT;


/**
 * Class BulkDiscount
 *
 * Calculate possible discount for bulk discount
 * eg. buy N of one product, and they’ll cost you Y cents.
 *
 * @package CHECKOUT
 */
class BulkDiscount {

    // name of variable in memeory
    private $listOfDiscounts;


    public static function make() {
        return new self;
    }

    public function __construct()
    {
        $this->listOfDiscounts = [];
    }


    /**
     * @param array $productsData array of ProductData objects
     * @return int total possible bulk discount
     *
     * @throws \Exception when calculated discount is negative number
     */
    public function calculateMaxDiscount(Array $productsData) {

        //if we do not have any discounts, then 0
        if (!$this->listOfDiscounts) return 0;

        $discountSum = 0;

        //we need to go throw all product items
        foreach ($productsData as $productId => $productData) {

            //do we have discount for this product?
            if (!isset($this->listOfDiscounts[$productId])) continue;

            //we do have discount, lets get discount data
            list($units, $specialPrice) = $this->listOfDiscounts[$productId];

            //we need to know, how many groups/packages we have
            // eg. if we have 7 items and discount is for 3 units, means we have 2 groups
            $groups = floor($productData->units / $units);
            if ($groups == 0) continue;

            // our discount will be regular price for all this items in group - our special proce for this goups
            $possibleDiscount = ($groups * $units * $productData->regularPrice) - ($groups * $specialPrice);

            if ($possibleDiscount > 0) {
                $discountSum += $possibleDiscount;

                DebugLog::log("Found bulk discount option for product $productId, possible discount: $possibleDiscount");
            } elseif ($possibleDiscount < 0) {
                throw new \Exception('Bulk discount data might be invalid, we have negative discount: '. $possibleDiscount);
            }

        }

        return $discountSum;

    }

    /**
     * @param $productId
     * @param $units
     * @param $specialPrice
     * @return bool if we added successfuly
     *
     * @throws \Exception when invalid data is provided
     */
    public function setDiscount($productId, $units, $specialPrice) {

        $this->listOfDiscounts[$productId] = [
            Validate::positiveInt($units, 'Units must be a positive number'),
            Validate::positiveInt($specialPrice, 'special price must be positive number')
        ];

        DebugLog::log("Bulk discount addded: product ID $productId: $units => $specialPrice");

        return true;
    }




}