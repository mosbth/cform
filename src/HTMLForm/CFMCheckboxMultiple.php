<?php

namespace Mos\HTMLForm;

/**
 * Example of CFormModel implementation.
 *
 */
class CFMCheckboxMultiple extends \Mos\HTMLForm\CFormModel
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct(
            [
                "id" => __CLASS__,
            ],
            [
                "items" => [
                    "type"        => "checkbox-multiple",
                    "values"      => ["tomato", "potato", "apple", "pear", "banana"],
                    "checked"     => ["potato", "pear"],
                ],
                "submit" => [
                    "type"      => "submit",
                    "callback"  => [$this, "callbackSubmit"],
                ],
                "submit-fail" => [
                    "type"      => "submit",
                    "callback"  => [$this, "callbackSubmitFail"],
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
        
        // Get the selected items as an array
        $items = $this->value("items");
        $itemsAsString = implode(", ", $items);
        $this->AddOutput("<p>Selected items are: '$itemsAsString'.");

        $this->AddOutput("<pre>" . print_r($_POST, 1) . "</pre>");
        $this->AddOutput("<pre>" . print_r($this["items"], 1) . "</pre>");
        $this->saveInSession = true;
        
        return true;
    }



    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFail()
    {
        $this->AddOutput("<p>#callbackSubmitFail()</p>");
        $this->AddOutput("<p>Form was submitted but I failed to process/save/validate it</p>");
        return false;
    }
}
