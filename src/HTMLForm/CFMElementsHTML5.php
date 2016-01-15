<?php

namespace Mos\HTMLForm;

/**
 * Example of CFormModel implementation.
 *
 */
class CFMElementsHTML5 extends \Mos\HTMLForm\CFormModel
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct(
            [
                "legend" => "Legend"
            ],
            [
                "color" => [
                    "type"        => "color",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "date" => [
                    "type"        => "date",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "datetime" => [
                    "type"        => "datetime",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "datetime-local" => [
                    "type"        => "datetime-local",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "time" => [
                    "type"        => "time",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "week" => [
                    "type"        => "week",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "month" => [
                    "type"        => "month",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "number" => [
                    "type"        => "number",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "range" => [
                    "type"        => "range",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                    "value"       => 42,
                    "min"         => 0,
                    "max"         => 100,
                    "step"        => 2,
                ],

                "search" => [
                    "type"        => "search",
                    "label"       => "Search:",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "tel" => [
                    "type"        => "tel",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "email" => [
                    "type"        => "email",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "url" => [
                    "type"        => "url",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                ],

                "file-multiple" => [
                    "type"        => "file-multiple",
                    "description" => "Here you can place a description.",
                ],

                "reset" => [
                    "type"      => "reset",
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
