<?php

namespace Mos\HTMLForm;

/**
 * Form element
 */
class CFormElementSelectMultiple extends CFormElementSelect
{

    /**
     * Constructor
     *
     * @param string $name       of the element.
     * @param array  $attributes to set to the element. Default is an empty array.
     *
     * @throws CFormException if missing <options>
     */
    public function __construct($name, $attributes = [])
    {
        parent::__construct($name, $attributes);
        $this['type']     = 'select-multiple';
        $this['multiple'] = true;
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
        
        $name = " name='{$this['name']}[]'";
        $options = null;
        foreach ($this['options'] as $optValue => $optText) {
            $selected = is_array($this['values']) && in_array($optValue, $this['values']) ? " selected" : null;
            $options .= "<option value='{$optValue}'{$selected}>{$optText}</option>\n";
        }

        return <<<EOD
<p>
<label for='$id'>$label</label>
<br/>
<select id='$id'{$size}{$class}{$name}{$autofocus}{$required}{$readonly}{$checked}{$title}{$multiple}>
{$options}
</select>
{$messages}
</p>
<p class='cf-desc'>{$description}</p>
EOD;
    }
}
