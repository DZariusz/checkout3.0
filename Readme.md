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
// this will turn ON debug messages
define('CHECKOUT_DEBUG', true);

// include module
require 'classes/Checkout.php';

//create Checkout object - module uses CHECKOUT namespace.
$Checkout = new CHECKOUT\Checkout();

// add products to memory - this products will be processed, 
// you can add them at any point before finalizeCheckout() 
$Checkout->addProduct('A', 40, 3);
$Checkout->addProduct('B', 10, 1);
$Checkout->addProduct('C', 30, 1);
$Checkout->addProduct('D', 25, 1);

// call for check the current total price 
// you can call it at any moment to see what is the current sume of order 
\CHECKOUT\DebugLog::printMsg('-- current total price'. $Checkout->calculateTotalPrice());

// add buld dicounts - order doedns matter and you can add them at any time 
$Checkout->addBulkDiscount('A', 3, 70);
$Checkout->addBulkDiscount('B', 2, 15);
$Checkout->addBulkDiscount('C', 4, 60);
$Checkout->addBulkDiscount('D', 2, 40);

\CHECKOUT\DebugLog::printMsg('-- current total price'. $Checkout->calculateTotalPrice());

// add join discount - it can be done at any time 
$Checkout->addJoinDiscount(['A', 'B'], 10);
$Checkout->addJoinDiscount(['A', 'B', 'C', 'D'], 30);

\CHECKOUT\DebugLog::printMsg('-- current total price'. $Checkout->calculateTotalPrice());

// set Total discount  
// there can be only one, so whenyou call it twice, previous setting will be overriden 
$Checkout->addToalDiscount(600, 100);
$Checkout->addToalDiscount(600, 10);

// finalize order - it will print you receipt with total sum before and after dicount
// this call removes all added products from memory, but discounts stay
// also it will return data that you can save in a market
$dataToSave = $Checkout->finalizeCheckout();

```



### Debug

You can define variable  `CHECKOUT_DEBUG` to turn on debug mode eg:

`define('CHECKOUT_DEBUG', true);` 

in this mode logs/functional messages will be print out to the screen.