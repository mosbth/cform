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

$form1 = new \Mos\HTMLForm\CFMCheckboxMultiple();
$form2 = new \Mos\HTMLForm\CFMSearchWidget();

$form1->Check();
$form2->Check();



?><!doctype html>
<meta charset=utf8>
<title><?= $title ?></title>
<h1><?= $title ?></h1>
<?=$form1->GetHTML()?>
<?=$form2->GetHTML()?>
