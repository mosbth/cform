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
    'color' => array(
      'type'        => 'color',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),
    'date' => array(
      'type'        => 'date',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),
    'datetime' => array(
      'type'        => 'datetime',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),
    'datetime-local' => array(
      'type'        => 'datetime-local',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),
    'time' => array(
      'type'        => 'time',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),
    'week' => array(
      'type'        => 'week',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),
    'month' => array(
      'type'        => 'month',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),
    'number' => array(
      'type'        => 'number',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),
    'range' => array(
      'type'        => 'range',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
      'value'       => 42,
      'min'         => 0,
      'max'         => 100,
      'step'        => 2,
    ),
    'search' => array(
      'type'        => 'search',
      'label'       => 'Search:',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),
    'tel' => array(
      'type'        => 'tel',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),
    'email' => array(
      'type'        => 'email',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),
    'url' => array(
      'type'        => 'url',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
    ),
    'file-multiple' => array(
      'type'        => 'file-multiple',
      'description' => 'Here you can place a description.',
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

<?php $footer = "footer_mos.php"; if(is_file($footer)) include($footer) ?>
