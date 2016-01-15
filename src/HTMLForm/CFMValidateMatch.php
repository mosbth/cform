<?php

namespace Mos\HTMLForm;

/**
 * Example of CFormModel implementation.
 *
 */
class CFMValidateMatch extends \Mos\HTMLForm\CFormModel
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct(
            [],
            [
                "pwd" => [
                    "type" =>"text",
                    "label" => "Password",
                ],

                "pwdAgain" => [
                    "type" => "text",
                    "label" => "Password again",
                    "validation" => [
                        "match" => "pwd"
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create user",
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
        $matches = $this->value("pwd") === $this->value("pwdAgain")
            ? "YES"
            : "NO";

        $this->AddOutput("<p>#callbackSubmit()</p>");
        $this->AddOutput("<p>Passwords matches: $matches</p>");
        $this->saveInSession = true;

        return true;
    }
}
