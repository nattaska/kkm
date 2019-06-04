<?php 
require 'libs/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

try {
    // Enter the share name for your USB printer here
    // $connector = null;
    $connector = new WindowsPrintConnector("Cashier");

    /* Print a "Hello world" receipt" */
    $printer = new Printer($connector);
    $printer -> setFont(Printer::FONT_A);
    $printer -> text("Hello World!\n");
    $printer -> text("สวัสดี!\n");
    $printer -> text("คอหมู!\n");
    $printer -> text("ผักกาดขาว!\n");
    $printer -> cut();
    
    /* Close printer */
    $printer -> close();
    
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}
?> 