<?php

namespace Mos\HTMLForm;

/**
 * Example of CFormModel implementation.
 *
 */
class CFMSearchWidget extends \Mos\HTMLForm\CFormModel
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
                "search" => [
                    "type"        => "search-widget",
                    "description" => "Here you can place a description.",
                    "placeholder" => "Here is a placeholder",
                    "label"       => "Search",
                    "callback"    => [$this, "callbackSubmit"],
                ]
            ]
        );
    }



    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmit()
    {
        $this->AddOutput("<p>You searched for '" . $this->value("search") . "'.</p>");
        $this->saveInSession = true;
        return true;
    }
}
