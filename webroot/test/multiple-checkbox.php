<?php
// Include CForm
include('../../autoloader.php');

error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors



// Need session
session_name('cform_example');
session_start();



// Create the form
$form = new \Mos\HTMLForm\CForm();
$form->create(
    [],
    [
        "items" => [
            "type"        => "checkbox-multiple",
            "values"      => ["tomato", "potato", "apple", "pear", "banana"],
            "checked"     => ["potato", "pear"],
        ],

        "submit" => [
            "type"      => "submit",
            "callback"  => function($form) {
                $form->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
                
                // Get the selected items as an array
                $items = $form->value("items");
                $itemsAsString = implode(", ", $items);
                $form->AddOutput("<p>Selected items are: '$itemsAsString'.");

                $form->AddOutput("<pre>" . print_r($_POST, 1) . "</pre>");
                $form->AddOutput("<pre>" . print_r($form["items"], 1) . "</pre>");
                $form->saveInSession = true;
                
                return true;
            }
        ],

        "submit-fail" => [
            "type"      => "submit",
            "callback"  => function($form) {
                $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
                
                return false;
            }
        ],
    ]
);



// Check the status of the form
$status = $form->Check();



// What to do if the form was submitted?
if ($status === true) {
    $form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
    header("Location: " . $_SERVER['PHP_SELF']);

} elseif ($status === false) {
    // What to do when form could not be processed?
    $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
    header("Location: " . $_SERVER['PHP_SELF']);
}



?><!doctype html>
<meta charset=utf8>
<title>CForm Example: Multiple checkbox</title>
<h1>CForm Example: Multiple checkbox</h1>
<?=$form->GetHTML()?>

<?php $footer = "footer_mos.php"; if(is_file($footer)) include($footer) ?>
