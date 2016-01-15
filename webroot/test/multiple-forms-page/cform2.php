<?php
// Include CForm
include("../../../autoloader.php");



error_reporting(-1);              // Report all type of errors
ini_set("display_errors", 1);     // Display all errors



// Need session
session_name("cform_example");
session_start();



// Create the form
$title = "CForm Example: Multiple forms in one page";

$form = new \Mos\HTMLForm\CFMSearchWidget();
$form->Check();

var_dump($_SESSION);


?><!doctype html>
<meta charset=utf8>
<title><?= $title ?></title>
<h1><?= $title ?></h1>
<?=$form->GetHTML()?>
