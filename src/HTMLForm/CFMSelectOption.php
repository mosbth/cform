<?php

namespace Mos\HTMLForm;

/**
 * Example of CFormModel implementation.
 *
 */
class CFMSelectOption extends \Mos\HTMLForm\CFormModel
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
                "expmonth" => [
                    "type" => "select",
                    "label" => "Expiration month:",
                    
                    "options" => [
                        "default" => "Select credit card expiration month...",
                        "01" => "January",
                        "02" => "February",
                        "03" => "March",
                        "04" => "April",
                        "05" => "May",
                        "06" => "June",
                        "07" => "July",
                        "08" => "August",
                        "09" => "September",
                        "10" => "October",
                        "11" => "November",
                        "12" => "December",
                    ],
                ],
                
                "doPay" => [
                    "type" => "submit",
                    "value" => "Perform payment",
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
        $this->AddOutput("<p>Selected month is: " . $this->value("expmonth") . "</p>");
        $this->saveInSession = true;

        return true;
    }
}
