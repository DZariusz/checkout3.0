<?php
/**
 * Created by PhpStorm.
 * User: DZariusz
 * Date: 17.07.2018
 * Time: 21:28
 */

namespace CHECKOUT;


/**
 * Class JoinDiscount
 *
 * Join discount is when eg you buy A and B => wyou will get 10cents discounts
 *
 * @package CHECKOUT
 */
class JoinDiscount  {

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
         * @param array $productsInCart - array of ProductData objects
         * @param $joinDiscountItem - one item/discount that we need to chek, if we can apply it to list of our products
         *
         * @return bool if we can apply this discount
         */
        private function isJoinDiscountPossible(Array $productsInCart, $joinDiscountItem) {

            //lets get data from out discount item
            list($productIds, $discount) = $joinDiscountItem;

            //just in case
            if (!$productIds) return false;

            //we need to have all product specified by discount
            $hasAll = true;
            foreach ($productIds as $id) {
                //if we found at least one that is not present in our "cart", we cant apply this discount
                if (!isset($productsInCart[$id])) $hasAll = false;
            }

            return $hasAll;
        }


    /**
     * Calculates maximum possible discount for join discount type
     *
     * @param array $productsData array of ProductData objects
     * @return int
     */
    public function calculateMaxDiscount(Array $productsData) {

        //if we do not have any discounts, then 0
        if (!$this->listOfDiscounts) return 0;

        $discountSum = 0;

        //lets review all discount options
        foreach ($this->listOfDiscounts as $discountItem) {

            //can we apply this discount item?
            if (!$this->isJoinDiscountPossible($productsData, $discountItem)) continue;

            //we can apply discount, so lets geg detailed information
            list($productIds, $discount) = $discountItem;

            $discountSum += $discount;

            DebugLog::log("Found join discount option for products ". implode(',', $productIds) .": $discount");

        }

        return $discountSum;

    }

    /**
     * @param array $productIds - array of products Ids that we need to have together for this discount
     * @param int $discount amount in cents
     * @return bool
     *
     * @throws \Exception
     */
    public function setDiscount(Array $productIds, $discount) {

        $this->listOfDiscounts[] = [Validate::notEmpty($productIds, 'Please specify product IDs'), Validate::positiveInt($discount, "Discount must be positive number")];

        DebugLog::log("Join discount added: product IDs ". implode(',', $productIds) ." => $discount");

        return true;
    }




}