# Checkout component

version 3.0

## How To Run It

Use any server where you have PHP installed and just run the `index.php` in your browser 
eg: `http://localhost/checkout/index.php`.
 
You can also run this from CLI eg: `php index.php`; 


## How to Include It

Copy all files to your project and include main `Checkout.php` class eg:

`<?php require 'Checkout.php'; ?>`


Examples of usage: 

```
define('CHECKOUT_DEBUG', true);

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
$Checkout->addJoinDiscount(['A', 'B', 'C', 'D'], 30);

\CHECKOUT\DebugLog::printMsg('-- current total price'. $Checkout->calculateTotalPrice());

$Checkout->addToalDiscount(600, 100);

$Checkout->finalizeCheckout();

```



### Debug

You can define variable  `CHECKOUT_DEBUG` to turn on debug mode eg:

`define('CHECKOUT_DEBUG', true);` 

in this mode logs/functional messages will be print out to the screen.