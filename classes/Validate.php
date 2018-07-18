<?php


namespace CHECKOUT;

/**
 * Class Validate
 * @package CHECKOUT
 *
 * this class runs simple validations, in general all functions are static and throw on invalid data
 */
class Validate {

    /**
     * @param $value
     * @param $errMsg
     * @return int exactly the value, that was passed for validation
     * @throws \Exception
     */
    public static function positiveInt($value, $errMsg) {

        if (!is_int($value) || $value <= 0) throw new \Exception($errMsg);
        return $value;
    }


    /**
     * @param $value
     * @param $errMsg
     * @return int exactly the value, that was passed for validation
     * @throws \Exception
     */
    public static function notEmpty($value, $errMsg) {

        if (empty($value)) throw new \Exception($errMsg);
        return $value;
    }

    /**
     * @param $value
     * @param $errMsg
     * @return int exactly the value, that was passed for validation
     * @throws \Exception
     */
    public static function isTrue($value, $errMsg) {

        if (!$value) throw new \Exception($errMsg);
        return $value;
    }

    /**
     * @param $value
     * @param $class
     * @param $errMsg
     * @return int exactly the value, that was passed for validation
     * @throws \Exception
     */
    public static function isClass($value, $class, $errMsg) {

        if (!is_object($value) || get_class($value) != $class) throw new \Exception($errMsg);
        return $value;
    }
    /**
     * @param $value
     * @param $class
     * @param $errMsg
     * @return int exactly the value, that was passed for validation
     * @throws \Exception
     */
    public static function isScalar($value, $errMsg) {

        if (!is_scalar($value)) throw new \Exception($errMsg);
        return $value;
    }


}