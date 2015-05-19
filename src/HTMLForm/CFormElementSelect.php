<?php

namespace Mos\HTMLForm;

/**
 * Form element
 */
class CFormElementSelect extends CFormElement
{

    /**
     * Constructor
     *
     * @param string $name       of the element.
     * @param array  $attributes to set to the element. Default is an empty array.
     *
     * @throws CFormException if missing <options>
     *
     * @return void
     */
    public function __construct($name, $attributes = [])
    {
        parent::__construct($name, $attributes);
        $this['type'] = 'select';
        $this->UseNameAsDefaultLabel();
        
        if (!is_array($this['options'])) {
            throw new CFormException("Select needs options, did you forget to specify them when creating the element?");
        }
    }
}
