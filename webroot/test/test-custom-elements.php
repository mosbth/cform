<?php
// Include CForm
include('../CForm.php');


// -----------------------------------------------------------------------
//
// Use the form and check it status.
//
session_name('cform_example');
session_start();
$form = new CForm(array('legend' => 'Legend'), array(
    'search-widget' => array(
      'type'        => 'search-widget',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
      'callback'  => function($form) {
        $form->AddOutput("<p><i>DoSubmit(): Search-widget was submitted.</i></p>");
        $form->AddOutput("<p><pre>" . print_r($_POST, 1) . "</pre></p>");
        $form->saveInSession = true;
        return true;
      }
    ),
    'checkbox-multiple' => array(
      'type'        => 'checkbox-multiple',
      'label'       => 'checkbox-multiple:',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
      'values'      => array('tomato', 'potato', 'apple', 'pear', 'banana'),
      'checked'     => array('potato', 'pear'),
   ),
    'reset' => array(
      'type'      => 'reset',
    ),
    'submit' => array(
      'type'      => 'submit',
      'callback'  => function($form) {
        $form->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
        $form->AddOutput("<p><pre>" . print_r($_POST, 1) . "</pre></p>");
        $form->saveInSession = true;
        return true;
      }
    ),
  )
);


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
<title>CForm Example: New form elements in HTML 5</title>
<h1>CForm Example: New form elements in HTML 5</h1>
<?=$form->GetHTML()?>

<?php $footer = "../../template/footer_mos.php"; if(is_file($footer)) include($footer) ?>
