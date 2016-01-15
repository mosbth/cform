<?php

namespace Mos\HTMLForm;

/**
 * Form element
 */
class CFormElementCheckboxMultiple extends CFormElement
{

    /**
     * Constructor
     *
     * @param string $name       of the element.
     * @param array  $attributes to set to the element. Default is an empty array.
     */
    public function __construct($name, $attributes = [])
    {
        parent::__construct($name, $attributes);
        $this['type'] = 'checkbox-multiple';
        
        if (!isset($this['values'])) {
            throw new CFormException("Missing values for the checkbox.");
        }
    }



    /**
     * Get the value of the form element.
     *
     * @return array the checked values of the form element.
     */
    public function value()
    {
        return $this['checked'];
    }



    /**
     * Get HTML code for a element.
     *
     * @return string HTML code for the element.
     */
    public function getHTML()
    {
        $details = $this->getHTMLDetails();
        extract($details);

        $type = "type='checkbox'";
        $name = " name='{$this['name']}[]'";
        $ret = null;
        $checkedValues = is_array($this['checked']) ? $this['checked'] : [];

        foreach ($this['values'] as $val) {
            $id .= $val;
            $item = $onlyValue  = htmlentities($val, ENT_QUOTES, $this->characterEncoding);
            $value = " value='{$onlyValue}'";
            $checked = in_array($val, $checkedValues)
                ? " checked='checked'"
                : null;

            $ret .= <<<EOD
<p>
<input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$readonly}{$checked}{$title} />
<label for='$id'>$item</label>
{$messages}
</p>
EOD;
        }
        return <<<EOD
<div>
<p>{$label}</p>
{$ret}
<p class='cf-desc'>{$description}</p>
</div>
EOD;
    }
}
