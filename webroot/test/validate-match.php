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
        "pwd" => [
            "type" =>"text",
            "label" => "Password",
        ],

        "pwdAgain" => [
            "type" => "text",
            "label" => "Password again",
            "validation" => [
                "match" => "pwd"
            ],
        ],

        "submit" => [
            "type" => "submit",
            "value" => "Create user",
            "callback" => function ($form) {
                $matches = $form->value("pwd") === $form->value("pwdAgain")
                    ? "YES"
                    : "NO";

                $form->AddOutput("<p><i>DoSubmit(): Passwords were submitted.</i></p>");
                $form->AddOutput("<p>Callback tests passwords matches: $matches</p>");
                $form->saveInSession = true;

                return true;
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
<title>CForm Example: Password matches</title>
<h1>CForm Example: Password matches</h1>
<?=$form->GetHTML()?>

<?php $footer = "footer_mos.php"; if(is_file($footer)) include($footer) ?>
