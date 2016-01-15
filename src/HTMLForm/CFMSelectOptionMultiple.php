<?php

namespace Mos\HTMLForm;

/**
 * Example of CFormModel implementation.
 *
 */
class CFMSelectOptionMultiple extends \Mos\HTMLForm\CFormModel
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

        $items = $this->value("selectm");
        $itemsAsString = implode(", ", $items);
        $this->AddOutput("<p>Selected items are: '$itemsAsString'.");

        $this->AddOutput("<pre>" . print_r($_POST, 1) . "</pre>");
        $this->AddOutput("<pre>" . print_r($this["selectm"], 1) . "</pre>");
        $this->saveInSession = true;

        return true;
    }
}
