<?php
// Include CForm
include('../../autoloader.php');


/**
 * Create a class for a contact-form with name, email and phonenumber.
 */
class CFormContact extends \Mos\HTMLForm\CForm {


  /** Create all form elements and validation rules in the constructor.
   *
   */
  public function __construct() {
    parent::__construct();
    
    $this->AddElement(new \Mos\HTMLForm\CFormElementText('name'))
         ->AddElement(new \Mos\HTMLForm\CFormElementText('email'))
         ->AddElement(new \Mos\HTMLForm\CFormElementText('phone'))
         ->AddElement(new \Mos\HTMLForm\CFormElementSubmit('submit', array('callback'=>array($this, 'DoSubmit'))));
  }


  /**
   * Callback for submitted forms
   */
  protected function DoSubmit() {
    echo "<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>";
    return true;
  }

}


// -----------------------------------------------------------------------
//
// Use the form and check it status.
//
session_name('cform_example');
session_start();
$form = new CFormContact();

?>


<!doctype html>
<meta charset=utf8>
<title>CForm Example: Basic example on how to use CForm (part 1)</title>
<h1>CForm Example: Basic example on how to use CForm (part 1)</h1>
<?=$form->GetHTML()?>

<?php $footer = "footer_mos.php"; if(is_file($footer)) include($footer) ?>
