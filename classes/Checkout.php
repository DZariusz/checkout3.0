<?php
/**
 * Created by PhpStorm.
 * User: DZariusz
 * Date: 17.07.2018
 * Time: 21:28
 */

namespace CHECKOUT;

require 'Validate.php';
require 'DebugLog.php';

require 'Products.php';
require 'BulkDiscount.php';
require 'JoinDiscount.php';
require 'TotalDiscount.php';


/**
 * Class Checkout
 *
 * It allows to callculate sum of order + it chooses maximal possible discount for the client
 *
 * @package CHECKOUT
 * @verion 3.0
 */
class Checkout extends Products {

    //this are dicount objects - each type has its own variable
    private $bulkDiscounts,
            $joinDiscounts,
            $totalDiscounts;

    public function __construct()
    {
        parent::__construct();

        $this->bulkDiscounts = BulkDiscount::make();
        $this->joinDiscounts = JoinDiscount::make();
        $this->totalDiscounts = TotalDiscount::make();
    }

    /**
     * @param $productId int|string
     * @param $units int
     * @param $specialPrice int
     * @return bool true if added successfuly
     * @throws \Exception on invalid input data
     */
    public function addBulkDiscount($productId, $units, $specialPrice) {
        return $this->bulkDiscounts->setDiscount($productId, $units, $specialPrice);
    }

    /**
     * @param array $productIds array of products ids
     * @param $discount int
     * @return bool true if added successfuly
     * @throws \Exception on invalid input data
     */
    public function addJoinDiscount(Array $productIds, $discount) {
        return $this->joinDiscounts->setDiscount($productIds, $discount);
    }

    /**
     * @param $minSum int
     * @param $percent int
     * @return bool true if added successfuly
     * @throws \Exception on invalid input data
     */
    public function addToalDiscount($minSum, $percent) {
        return $this->totalDiscounts->setDiscount($minSum, $percent);
    }


        /**
         * calculates the best possing discount - one of all that are available
         * @return int max discount value
         * @throws \Exception
         */
        private function getBestDiscount() {

            $maxDiscount = max(
                $this->bulkDiscounts->calculateMaxDiscount($this->getProducts()),
                $this->joinDiscounts->calculateMaxDiscount($this->getProducts()),
                $this->totalDiscounts->calculateMaxDiscount($this->getTotalRegularSum())
            );

            if ($maxDiscount > 0) {
                DebugLog::log("Best discount for client: $maxDiscount");
                return $maxDiscount;
            }

            return 0;
        }

    /**
     * caclculate final price in real time
     *
     * @return int
     * @throws \Exception
     */
    public function calculateTotalPrice() {

        $maxDiscount = $this->getBestDiscount();
        return $this->getTotalRegularSum() - $maxDiscount;
    }



        /**
         *
         * generate the receipt
         * @return int price on receipt
         * @throws \Exception
         */
        private function printReceipt() {

            DebugLog::printMsg();
            DebugLog::printMsg();

            DebugLog::printMsg('.. RECEIPT ..');

            foreach ($this->getProducts() as $productId => $productData) {
                DebugLog::printMsg($this->getFormatedProduct($productId));
            }

            $receiptPrice = $this->calculateTotalPrice();

            DebugLog::printMsg("Total price: ". $this->getTotalRegularSum());
            DebugLog::printMsg("Total price (including discount): $receiptPrice");

            DebugLog::printMsg();
            DebugLog::printMsg();

            return $receiptPrice;
        }


    /**
     * this will close all calculations - print receipt and rmove all added products
     * discounts will stay.
     *
     * @return object data for save in the market
     * @throws \Exception
     */
    public function finalizeCheckout() {

        $receiptPrice = $this->printReceipt();

        $saveData = (object)[
            'soldProducts' => array_keys($this->getProducts()),
            'receiptPrice' => $receiptPrice,
            'discount' => $this->getBestDiscount()
        ];

        $this->clearProducts();

        return $saveData;
    }

}