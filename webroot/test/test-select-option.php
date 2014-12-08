<?php
// Include CForm
include('../../autoloader.php');

error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly



// -----------------------------------------------------------------------
//
// Use the form and check it status.
//
session_name('cform_example');
session_start();

$elements = array(
  'expmonth' => array(
    'type' => 'select',
    'label' => 'Expiration month:',
    'options' => array(
      'default' => 'Select credit card expiration month...',
      '01' => 'January',
      '02' => 'February',
      '03' => 'March',
      '04' => 'April',
      '05' => 'May',
      '06' => 'June',
      '07' => 'July',
      '08' => 'August',
      '09' => 'September',
      '10' => 'October',
      '11' => 'November',
      '12' => 'December',
    ),
  ),
  'doPay' => array(
    'type' => 'submit',
    'value' => 'Perform payment',
    'callback' => function($form) {
      $form->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
      $form->AddOutput("<p><b>Selected month is: " . $form->value('expmonth') . "</b></p>");
      $form->saveInSession = true;
      return true;
    }
  ),
);

$form = new \Mos\HTMLForm\CForm(array(), $elements);

// Check the status of the form
$status = $form->Check();

// What to do if the form was submitted?
if($status === true) {
  $form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
  header("Location: " . $_SERVER['PHP_SELF']);
}

// What to do when form could not be processed?
else if($status === false){
  $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
  header("Location: " . $_SERVER['PHP_SELF']);
}

?>


<!doctype html>
<meta charset=utf8>
<title>CForm Example: Creditcard checkout with two column layout</title>
<h1>CForm Example: Useage of select option list</h1>
<?=$form->GetHTML()?>

<?php $footer = "footer_mos.php"; if(is_file($footer)) include($footer) ?>
