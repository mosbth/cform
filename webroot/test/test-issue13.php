<?php
// Include CForm
include('../../autoloader.php');


// Start the session
session_name('cform_example');
session_start();


// Sample form
$form = new \Mos\HTMLForm\CForm([], [
    'name' => [
        'type'        => 'text',
        'label'       => 'Name of contact person:',
        'required'    => true,
        'validation'  => ['not_empty'],
    ],
    'email' => [
        'type'        => 'text',
        'required'    => true,
        'validation'  => ['not_empty', 'email_adress'],
    ],
    'phone' => [
        'type'        => 'text',
        'required'    => true,
        'validation'  => ['not_empty', 'numeric'],
    ],
    'submit' => [
        'type'      => 'submit',
    ],
    'submit-fail' => [
        'type'      => 'submit',
    ],
]);


// Check the status of the form
$status = $form->check(
    function ($form) {
        // What to do if the form was submitted?
        $form->AddOutput("<p><i>Form was submitted and the callback method returned true.</i></p>");
        header("Location: " . $_SERVER['PHP_SELF']);
    },
    function ($form) {
        // What to do when form could not be processed?
        $form->AddOutput("<p><i>Form was submitted and check() method returned false.</i></p>");
        header("Location: " . $_SERVER['PHP_SELF']);
    }
);

$title = "Test issue 13"
?>



<!doctype html>
<meta charset=utf8>
<title><?=$title?></title>
<h1><?=$title?></h1>
<?=$form->GetHTML()?>

<?php $footer = "footer_mos.php"; if(is_file($footer)) include($footer) ?>
