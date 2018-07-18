<?php
/**
 * Created by PhpStorm.
 * User: DZariusz
 * Date: 17.07.2018
 * Time: 21:28
 */

namespace CHECKOUT;


/**
 * Class TotalDiscount
 *
 * calculates total discount
 *
 * @package CHECKOUT
 */
class TotalDiscount {


    private $minSum,    //min sum of order
            $percent;   //percent of discount (integer)


    public static function make() {
        return new self;
    }

    public function __construct()
    {
        $this->minSum = 0;
        $this->percent = 0;
    }


    /**
     * @param $totalRegularSum currect sum of order
     * @return int discount amount
     */
    public function calculateMaxDiscount($totalRegularSum) {

        //do we have discount set?
        if ($this->percent <= 0) return 0;

        //do we meet sum condition?
        if ($totalRegularSum < $this->minSum) return 0;

        $discount = round($totalRegularSum * $this->percent / 100);

        DebugLog::log("total discount possible: discount $discount");

        return $discount;

    }

    public function setDiscount($minSum, $percent) {

        $this->minSum = Validate::positiveInt($minSum, 'minSum must be positive number');

        if ($percent > 100) throw new \Exception('Max value ofr percent is 100, got: '. $percent);
        $this->percent = Validate::positiveInt($percent, 'Percent sum must be positive number');


        DebugLog::log("Total discount set: $minSum => $percent");

        return true;
    }




}