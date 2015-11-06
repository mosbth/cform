<?php
// Include CForm
include('../../autoloader.php');



// Need session
session_name('cform_example');
session_start();



// Create the form
$form = new \Mos\HTMLForm\CForm();
$form->create(
    [
        "enctype" => "multipart/form-data"
    ],
    [
        "file" => [
            "type" =>"file",
            "label" => "Choose file...",
        ],
        'submit' => [
            'type' => 'submit',
            'value' => 'Upload file',
            'callback' => function($form) {

                $form->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
                $form->AddOutput("<p><b>The file is now available in the \$_FILE array</b></p><pre>" . print_r($_FILES, true) . "</pre>");
                
                $form->saveInSession = true;
                return true;
            }
        ]
    ]
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
<h1>CForm Example: File upload</h1>
<?=$form->GetHTML()?>

<?php $footer = "footer_mos.php"; if(is_file($footer)) include($footer) ?>
