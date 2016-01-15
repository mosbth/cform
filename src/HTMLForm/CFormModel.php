<?php

namespace Mos\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
abstract class CFormModel extends \Mos\HTMLForm\CForm
{
    /**
     * Customise the check() method to use own methods.
     *
     * @param callable $callIfSuccess handler to call if function returns true.
     * @param callable $callIfFail    handler to call if function returns true.
     */
    public function check($callIfSuccess = null, $callIfFail = null)
    {
        return parent::check([$this, "callbackSuccess"], [$this, "callbackFail"]);
    }



    /**
     * Callback for submitting the form.
     *
     */
    abstract public function callbackSubmit();



    /**
     * Callback What to do if the form was submitted successfully?
     *
     */
    public function callbackSuccess()
    {
        $this->AddOUtput("<p>#callbackSuccess()</p>");
        $this->AddOUtput("<p>Form was submitted and the callback method returned true.</p>");
        header("Location: " . $_SERVER['PHP_SELF']);
    }



    /**
     * Callback What to do when submitted form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput("<p>#callbackFailed()</p>");
        $this->AddOutput("<p>Form was submitted and the Check() method returned false.</p>");
        header("Location: " . $_SERVER['PHP_SELF']);
    }
}
