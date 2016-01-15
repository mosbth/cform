<?php

namespace Mos\HTMLForm;

/**
 * Example of CFormModel implementation.
 *
 */
class CFMElementsHTML401 extends \Mos\HTMLForm\CFormModel
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct(
            [
                "legend" => "Legend",
            ],
            [
                "text" => [
                    "type"        => "text",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],
                        
                "password" => [
                    "type"        => "password",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "hidden" => [
                    "type"        => "hidden",
                    "value"       => "secret value",
                ],

                "file" => [
                    "type"        => "file",
                    "description" => "Here you can place a description.",
                ],

                "textarea" => [
                    "type"        => "textarea",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "radio" => [
                    "type"        => "radio",
                    "label"       => "What is your preferred choice of fruite?",
                    "description" => "Here you can place a description.",
                    "values"      => [
                        "tomato",
                        "potato",
                        "apple",
                        "pear",
                        "banana"
                    ],
                    "checked"     => "potato",
                ],

                "checkbox" => [
                    "type"        => "checkbox",
                    "description" => "Here you can place a description.",
                ],

                "select" => [
                    "type"        => "select",
                    "label"       => "Select your fruite:",
                    "description" => "Here you can place a description.",
                    "options"     => [
                        "tomato" => "tomato",
                        "potato" => "potato",
                        "apple"  => "apple",
                        "pear"   => "pear",
                        "banana" => "banana",
                    ],
                    "value"    => "potato",
                ],

                "selectm" => [
                    "type"        => "select-multiple",
                    "label"       => "Select one or more fruite:",
                    "description" => "Here you can place a description.",
                    "size"        => 6,
                    "options"     => [
                        "tomato" => "tomato",
                        "potato" => "potato",
                        "apple"  => "apple",
                        "pear"   => "pear",
                        "banana" => "banana",
                    ],
                    "checked"   => ["potato", "pear"],
                ],

                "reset" => [
                    "type"      => "reset",
                ],

                "button" => [
                    "type"      => "button",
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
