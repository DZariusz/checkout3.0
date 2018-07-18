<?php

//define('CHECKOUT_DEBUG', 1);

require 'classes/Checkout.php';

$Checkout = new CHECKOUT\Checkout();

$Checkout->addProduct('A', 40, 3);
$Checkout->addProduct('B', 10, 1);
$Checkout->addProduct('C', 30, 1);
$Checkout->addProduct('D', 25, 1);

\CHECKOUT\DebugLog::printMsg('-- current total price'. $Checkout->calculateTotalPrice());

$Checkout->addBulkDiscount('A', 3, 70);
$Checkout->addBulkDiscount('B', 2, 15);
$Checkout->addBulkDiscount('C', 4, 60);
$Checkout->addBulkDiscount('D', 2, 40);

\CHECKOUT\DebugLog::printMsg('-- current total price'. $Checkout->calculateTotalPrice());

$Checkout->addJoinDiscount(['A', 'B'], 10);
$Checkout->addJoinDiscount(['A', 'B', 'C', 'D'], 130);

\CHECKOUT\DebugLog::printMsg('-- current total price'. $Checkout->calculateTotalPrice());

$Checkout->addToalDiscount(600, 100);

$Checkout->finalizeCheckout();

