<?php

namespace Mos\HTMLForm;

/**
 * Example of CFormModel implementation.
 *
 */
class CFMCheckbox extends \Mos\HTMLForm\CFormModel
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $license = "You must accept the <a href=http://opensource.org/licenses/GPL-3.0>license agreement</a>.";
        
        parent::__construct(
            [],
            [
                "accept_mail" => [
                    "type"      => "checkbox",
                    "label"     => "It´s great if you send me product information by mail.",
                    "checked"   => false,
                ],

                "accept_phone" => [
                    "type"      => "checkbox",
                    "label"     => "You may call me to try and sell stuff.",
                    "checked"   => true,
                ],

                "accept_agreement" => [
                    "type"        => "checkbox",
                    "label"       => $license,
                    "required"    => true,
                    "validation"  => ["must_accept"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Submit",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmit()
    {
        $this->AddOutput("<p>#callbackSubmit()</p>");
        $this->AddOutput("<pre>" . print_r($_POST, 1) . "</pre>");
        $this->saveInSession = true;

        return true;
    }
}
