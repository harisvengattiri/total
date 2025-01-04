<?php
// Debugging
ini_set('error_reporting', E_ALL);

// DATABASE INFORMATION
define('DATABASE_HOST', 'localhost');
define('DATABASE_NAME', 'commissioning_erp');
define('DATABASE_USER', 'gulfit');
define('DATABASE_PASS', 'Gulfit2018!');

// OTHER SETTINFS
define('INVOICE_PREFIX', 'MD'); // Prefix at start of invoice - leave empty '' for no prefix
define('INVOICE_INITIAL_VALUE', '1'); // Initial invoice order number (start of increment)
define('INVOICE_THEME', '#222222'); // Theme colour, this sets a colour theme for the PDF generate invoice
define('TIMEZONE', 'Asia/Kolkata'); // Timezone - See for list of Timezone's http://php.net/manual/en/function.date-default-timezone-set.php
define('DATE_FORMAT', 'DD/MM/YYYY'); // DD/MM/YYYY or MM/DD/YYYY
define('CURRENCY', 'Rs.'); // Currency symbol
define('ENABLE_VAT', true); // Enable TAX/VAT
define('VAT_INCLUDED', false); // Is VAT included or excluded?
define('VAT_RATE', '10'); // This is the percentage value

// CONNECT TO THE DATABASE
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
?>