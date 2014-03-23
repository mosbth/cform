<?php
// Include CForm
include('../../autoloader.php');


// -----------------------------------------------------------------------
//
// Use the form and check it status.
//
session_name('cform_example');
session_start();
$form = new \Mos\HTMLForm\CForm(array('legend' => 'Legend'), array(
    'text' => array(
      'type'        => 'text',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),        
    'password' => array(
      'type'        => 'password',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),        
    'hidden' => array(
      'type'        => 'hidden',
      'value'       => 'secret value',
    ),        
    'file' => array(
      'type'        => 'file',
      'description' => 'Here you can place a description.',
    ),
    'textarea' => array(
      'type'        => 'textarea',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),        
    'radio' => array(
      'type'        => 'radio',
      'label'       => 'What is your preferred choice of fruite?',
      'description' => 'Here you can place a description.',
      'values'      => array('tomato', 'potato', 'apple', 'pear', 'banana'),
      'checked'     => 'potato',
    ),
    'checkbox' => array(
      'type'        => 'checkbox',
      'description' => 'Here you can place a description.',
    ),        
    'select' => array(
      'type'        => 'select',
      'label'       => 'Select your fruite:',
      'description' => 'Here you can place a description.',
      'options'     => array(
        'tomato' => 'tomato', 
        'potato' => 'potato', 
        'apple'  => 'apple', 
        'pear'   => 'pear', 
        'banana' => 'banana',
      ),
      'value'    => 'potato',
    ),        
    'selectm' => array(
      'type'        => 'select-multiple',
      'label'       => 'Select your fruite:',
      'description' => 'Here you can place a description.',
      'size'        => 6,
      'options'     => array(
        'tomato' => 'tomato', 
        'potato' => 'potato', 
        'apple'  => 'apple', 
        'pear'   => 'pear', 
        'banana' => 'banana',
      ),
      'values'   => array('potato', 'pear'),
    ),        
    'reset' => array(
      'type'      => 'reset',
    ),
    'button' => array(
      'type'      => 'button',
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
    'submit-fail' => array(
      'type'      => 'submit',
      'callback'  => function($form) {
        $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
        return false;
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
<title>CForm Example: Form elements as of HTML 4.01</title>
<h1>CForm Example: Form elements as of HTML 4.01</h1>
<?=$form->GetHTML()?>

<?php $footer = "footer_mos.php"; if(is_file($footer)) include($footer) ?>
