<?php
// Include CForm
include('../../autoloader.php');


/**
 * Create a class for a contact-form with name, email and phonenumber.
 */
//class CFormContact extends CForm {


  /** Create all form elements and validation rules in the constructor.
   *
   */
/*  public function __construct() {
    parent::__construct();
    
    $this->AddElement(new CFormElementText('name', array('label'=>'Name of contact person:', 'required'=>true)))
         ->AddElement(new CFormElementText('email', array('required'=>true)))
         ->AddElement(new CFormElementText('phone', array('required'=>true)))
         ->AddElement(new CFormElementSubmit('submit', array('callback'=>array($this, 'DoSubmit'))))
         ->AddElement(new CFormElementSubmit('submit-fail', array('callback'=>array($this, 'DoSubmitFail'))));
         
    $this->SetValidation('name', array('not_empty'))
         ->SetValidation('email', array('not_empty', 'email_adress'))
         ->SetValidation('phone', array('not_empty', 'numeric'));
  }
*/

  /**
   * Callback for submitted forms, will always fail
   */
/*  protected function DoSubmitFail() {
    $this->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
    return false;
  }
*/

  /**
   * Callback for submitted forms
   */
/*  protected function DoSubmit() {
    $this->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
    $this->AddOutput("<p><b>Name: " . $this->Value('name') . "</b></p>");
    $this->AddOutput("<p><b>Email: " . $this->Value('email') . "</b></p>");
    $this->AddOutput("<p><b>Phone: " . $this->Value('phone') . "</b></p>");
    return true;
  }

}
*/


// -----------------------------------------------------------------------
//
// Use the form and check it status.
//
session_name('cform_example');
session_start();
$form = new \Mos\HTMLForm\CForm(array(), array(
    'name' => array(
      'type'        => 'text',
      'label'       => 'Name of contact person:',
      'required'    => true,
      'validation'  => array('not_empty'),
    ),        
    'email' => array(
      'type'        => 'text',
      'required'    => true,
      'validation'  => array('not_empty', 'email_adress'),
    ),        
    'phone' => array(
      'type'        => 'text',
      'required'    => true,
      'validation'  => array('not_empty', 'numeric'),
    ),        
    'submit' => array(
      'type'      => 'submit',
      'callback'  => function($form) {
        $form->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
        $form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
        $form->AddOutput("<p><b>Email: " . $form->Value('email') . "</b></p>");
        $form->AddOutput("<p><b>Phone: " . $form->Value('phone') . "</b></p>");
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
<title>CForm Example: How to create CForm using array</title>
<h1>CForm Example: How to create CForm using array</h1>
<?=$form->GetHTML()?>

<?php $footer = "footer_mos.php"; if(is_file($footer)) include($footer) ?>
