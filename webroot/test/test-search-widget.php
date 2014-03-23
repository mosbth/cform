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
    'search-widget' => array(
      'type'        => 'search-widget',
      'description' => 'Here you can place a description.',
      'placeholder' => 'Here is a placeholder',
      'label'       => 'Search',
      'callback'  => function($form) {
        $form->AddOutput("<p><i>DoSubmit(): Search-widget was submitted.</i></p>");
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
