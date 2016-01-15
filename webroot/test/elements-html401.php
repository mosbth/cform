<?php
// Include CForm
include("../../autoloader.php");



error_reporting(-1);              // Report all type of errors
ini_set("display_errors", 1);     // Display all errors



// Need session
session_name("cform_example");
session_start();



// Create the form
$title = "CForm Example: Form elements as of HTML 4.01";

$form = new \Mos\HTMLForm\CFMElementsHTML401();
$form->Check();



?><!doctype html>
<meta charset=utf8>
<title><?= $title ?></title>
<h1><?= $title ?></h1>
<?=$form->GetHTML()?>
