<?php
// Include CForm
include("../../autoloader.php");



error_reporting(-1);              // Report all type of errors
ini_set("display_errors", 1);     // Display all errors



// Need session
session_name("cform_example");
session_start();



// Create the form
$title = "CForm Example: Select option list";

$form = new \Mos\HTMLForm\CFMSelectOption();
$form->Check();



?><!doctype html>
<meta charset=utf8>
<title><?= $title ?></title>
<h1><?= $title ?></h1>
<?=$form->GetHTML()?>
