<?php
/**
 * Created by PhpStorm.
 * User: DZariusz
 * Date: 17.07.2018
 * Time: 21:28
 */

namespace CHECKOUT;


/**
 * Class DebugLog
 *
 * simple class for helping with debugging process
 *
 * if user set `CHECKOUT_DEBUG` variable to true (or any other value), component will be printing log messages
 * that might help with debugging
 *
 * eg: define('CHECKOUT_DEBUG', true);
 *
 * @package CHECKOUT
 */
class DebugLog {

    /**
     * @return string brake char, depends on environment CLI/web
     */
    private static function interfaceBr()
    {
        return (php_sapi_name() === 'cli') ? "\n" : '<br>';
    }

    /**
     * print message only when debug in ON
     *
     * @param $msg
     * @param bool $nl do we need to include line brake?
     */
    public static function log($msg, $nl = true) {

        if (!defined('CHECKOUT_DEBUG')) return;

        echo $msg . ($nl ? self::interfaceBr() : '');
    }

    public static function printMsg($msg = '', $nl = true) {

        echo $msg . ($nl ? self::interfaceBr() : '');
    }
}