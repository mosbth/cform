<?php

namespace Mos\HTMLForm;

/**
 * Example of CFormModel implementation.
 *
 */
class CFMValidateVariousRules extends \Mos\HTMLForm\CFormModel
{
    /**
     * Rules to check.
     */
    public $rules = [
        "not_empty",
        "numeric",
        "email_adress",
    ];



    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct(
            [],
            [
                "enter-a-value" => [
                    "type" => "text",
                ],
                
                "tests" => [
                    "type"        => "checkbox-multiple",
                    "description" => "Choose the validation rules to use.",
                    "values"      => $this->rules,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Validate",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Get active validation rules from $_POST.
     *
     */
    public function getActiveRules()
    {
        $validation = [];
        
        if (!empty($_POST['tests'])) {
            foreach ($_POST['tests'] as $val) {
                if (in_array($val, $this->rules)) {
                    $validation[] = $val;
                }
            }
        }
        
        return $validation;
    }


    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmit()
    {
        $this->AddOutput("<p>#callbackSubmit()</p>");
        $this->AddOutput("<p>Nothing to do.</p>");
        $this->saveInSession = true;

        return true;
    }
}
