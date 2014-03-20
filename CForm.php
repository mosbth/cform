<?php
/**
 * A utility class to easy creating and handling of forms
 * 
 * ToDo:
 * t()
 * many forms on one page (session & naming)
 * fieldset label
 * description on each element
 * basic style
 *
 * @package CForm
 */
class CFormElement implements ArrayAccess {

  /**
   * Properties
   */
  public $attributes;
  public $characterEncoding;
  

  /**
   * Constructor creating a form element.
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    $this->attributes = $attributes;    
    $this['name'] = $name;
    //$this['key'] = $name;
    //$this['name'] = isset($this['name']) ? $this['name'] : $name;

    // Use character encoding from lydia if available, else use UTF-8
    if(is_callable('CLydia::Instance()')) {
      $this->characterEncoding = CLydia::Instance()->config['character_encoding'];
    } else {
      $this->characterEncoding = 'UTF-8';
    }
  }
  
  
  /**
   * Implementing ArrayAccess for this->attributes
   */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->attributes[] = $value; } else { $this->attributes[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->attributes[$offset]); }
  public function offsetUnset($offset) { unset($this->attributes[$offset]); }
  public function offsetGet($offset) { return isset($this->attributes[$offset]) ? $this->attributes[$offset] : null; }


  /**
   * Create a formelement from an array, factory returns the correct instance. 
   *
   * @param string name of the element.
   * @param array attributes to use when creating the element.
   * @return the instance of the form element.
   */
  public static function Create($name, $attributes) {
    
    // Not supported is type=image, <button>, list, output, select-optgroup
    $types = array(

      // Standard HTML 4.01
      'text'              => 'CFormElementText',
      'file'              => 'CFormElementFile',
      'password'          => 'CFormElementPassword',
      'hidden'            => 'CFormElementHidden',
      'textarea'          => 'CFormElementTextArea',
      'radio'             => 'CFormElementRadio',
      'checkbox'          => 'CFormElementCheckbox',
      'select'            => 'CFormElementSelect',
      'select-multiple'   => 'CFormElementSelectMultiple',
      'submit'            => 'CFormElementSubmit',
      'reset'             => 'CFormElementReset',
      'button'            => 'CFormElementButton',

      // HTML5
      'color'             => 'CFormElementColor',
      'date'              => 'CFormElementDate',
      'number'            => 'CFormElementNumber',
      //'progress'          => 'CFormElementProgress',
      //'meter'             => 'CFormElementMeter',
      'range'             => 'CFormElementRange',
      'tel'               => 'CFormElementTel',
      'email'             => 'CFormElementEmail',
      'url'               => 'CFormElementUrl',
      'search'            => 'CFormElementSearch',
      'file-multiple'     => 'CFormElementFileMultiple',
      'datetime'          => 'CFormElementDatetime',
      'datetime-local'    => 'CFormElementDatetimeLocal',
      'month'             => 'CFormElementMonth',
      'time'              => 'CFormElementTime',
      'week'              => 'CFormElementWeek',

      // Custom
      'search-widget'     => 'CFormElementSearchWidget',
      'checkbox-multiple' => 'CFormElementCheckboxMultiple',
      // Address
    );

    // $attributes['type'] must contain a valid type creating an object to succeed.
    $type = isset($attributes['type']) ? $attributes['type'] : null;
    if($type && isset($types[$type])) {
      return new $types[$type]($name, $attributes);
    } else {
      throw new Exception("Form element does not exists and can not be created: $name - $type");
    }
  }



  /**
   * Get HTML code for a element. 
   *
   * @return HTML code for the element.
   */
  public function GetElementId() {
    return ($this['id'] = isset($this['id']) ? $this['id'] : 'form-element-' . $this['name']);
  }



  /**
   * Get HTML code for a element. 
   *
   * @return HTML code for the element.
   */
  public function GetHTML() {
    // Add disabled to be able to disable a form element
    // Add maxlength
    $id           =  $this->GetElementId();
    $class        = isset($this['class']) ? "{$this['class']}" : null;
    $validates    = (isset($this['validation-pass']) && $this['validation-pass'] === false) ? ' validation-failed' : null;
    $class        = (isset($class) || isset($validates)) ? " class='{$class}{$validates}'" : null;
    $name         = " name='{$this['name']}'";
    $label        = isset($this['label']) ? ($this['label'] . (isset($this['required']) && $this['required'] ? "<span class='form-element-required'>*</span>" : null)) : null;
    $autofocus    = isset($this['autofocus']) && $this['autofocus'] ? " autofocus='autofocus'" : null;    
    $required     = isset($this['required']) && $this['required'] ? " required='required'" : null;    
    $readonly     = isset($this['readonly']) && $this['readonly'] ? " readonly='readonly'" : null;    
    $placeholder  = isset($this['placeholder']) && $this['placeholder'] ? " placeholder='{$this['placeholder']}'" : null;    
    $multiple     = isset($this['multiple']) && $this['multiple'] ? " multiple" : null;    
    $max          = isset($this['max']) ? " max='{$this['max']}'" : null;    
    $min          = isset($this['min']) ? " min='{$this['min']}'" : null;    
    $low          = isset($this['low']) ? " low='{$this['low']}'" : null;    
    $high         = isset($this['high']) ? " high='{$this['high']}'" : null;    
    $optimum      = isset($this['optimum']) ? " optimum='{$this['optimum']}'" : null;    
    $step         = isset($this['step']) ? " step='{$this['step']}'" : null;    
    $size         = isset($this['size']) ? " size='{$this['size']}'" : null;    
    $text         = isset($this['text']) ? htmlentities($this['text'], ENT_QUOTES, $this->characterEncoding) : null;    
    $checked      = isset($this['checked']) && $this['checked'] ? " checked='checked'" : null;    
    $type         = isset($this['type']) ? " type='{$this['type']}'" : null;
    $title        = isset($this['title']) ? " title='{$this['title']}'" : null;
    $pattern      = isset($this['pattern']) ? " pattern='{$this['pattern']}'" : null;
    $description  = isset($this['description']) ? $this['description'] : null;
    $onlyValue    = isset($this['value']) ? htmlentities($this['value'], ENT_QUOTES, $this->characterEncoding) : null;
    $value        = isset($this['value']) ? " value='{$onlyValue}'" : null;

    // Gather all validation messages
    $messages = null;
    if(isset($this['validation-messages'])) {
      $message = null;
      foreach($this['validation-messages'] as $val) {
        $message .= "<li>{$val}</li>\n";
      }
      $messages = "<ul class='validation-message'>\n{$message}</ul>\n";
    }
    
    // type=submit || reset || button
    if(in_array($this['type'], array('submit', 'reset', 'button'))) {
      return "<span><input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$readonly}{$title} /></span>\n";
    } 

    // custom search-widget with type=search and type=submit
    else if($this['type'] == 'search-widget') {
      $label = isset($this['label']) ? " value='{$this['label']}'" : null;
      $classSubmit = isset($this['class-submit']) ? " class='{$this['class-submit']}'" : null;
      return "<p><input id='$id' type='search'{$class}{$name}{$value}{$autofocus}{$required}{$readonly}{$placeholder}/><input id='do-{$id}' type='submit'{$classSubmit}{$label}{$readonly}{$title}/></p><p class='cf-desc'>{$description}</p>\n";        
    } 

    /* // meter
    else if($this['type'] == 'meter') {
      return "<p><label for='$id'>$label</label><br/>\n<meter id='$id'{$class}{$name}{$value}{$autofocus}{$required}{$readonly}{$placeholder}{$title}{$min}{$max}{$low}{$high}{$optimum}>{$onlyValue}</meter></p><p class='cf-desc'>{$description}</p>\n"; 
    } 

    // progress
    else if($this['type'] == 'progress') {
      return "<p><label for='$id'>$label</label><br/>\n<progress id='$id'{$class}{$name}{$value}{$autofocus}{$required}{$readonly}{$placeholder}{$title}{$max}>{$onlyValue}</progress></p><p class='cf-desc'>{$description}</p>\n"; 
    } */

    // textarea
    else if($this['type'] == 'textarea') {
      return "<p><label for='$id'>$label</label><br/>\n<textarea id='$id'{$type}{$class}{$name}{$autofocus}{$required}{$readonly}{$placeholder}{$title}>{$onlyValue}</textarea></p><p class='cf-desc'>{$description}</p>\n"; 
    } 

    // type=hidden
    else if($this['type'] == 'hidden') {
      return "<input id='$id'{$type}{$class}{$name}{$value} />\n"; 
    } 

    // checkbox
    else if($this['type'] == 'checkbox') {
      return "<p><input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$required}{$readonly}{$checked}{$title} /><label for='$id'>$label</label>{$messages}</p><p class='cf-desc'>{$description}</p>\n"; 
    } 

    // radio
    else if($this['type'] == 'radio') {
      $ret = null;
      foreach($this['values'] as $val) {
        $id .= $val;
        $item = $onlyValue  = htmlentities($val, ENT_QUOTES, $this->characterEncoding);
        $value = " value='{$onlyValue}'";
        $checked = isset($this['checked']) && $val === $this['checked'] ? " checked='checked'" : null;    
        $ret .= "<p><input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$readonly}{$checked}{$title} /><label for='$id'>$item</label>{$messages}</p>\n"; 
      }
      return "<div><p class='cf-label'>{$label}</p>{$ret}<p class='cf-desc'>{$description}</p></div>";
    } 

    // custom for checkbox-multiple
    else if($this['type'] == 'checkbox-multiple') {
      $type = "type='checkbox'";
      $name = " name='{$this['name']}[]'";
      $ret = null;
      foreach($this['values'] as $val) {
        $id .= $val;
        $item = $onlyValue  = htmlentities($val, ENT_QUOTES, $this->characterEncoding);
        $value = " value='{$onlyValue}'";
        $checked = is_array($this['checked']) && in_array($val, $this['checked']) ? " checked='checked'" : null;    
        $ret .= "<p><input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$readonly}{$checked}{$title} /><label for='$id'>$item</label>{$messages}</p>\n"; 
      }
      return "<div><p>{$label}</p>{$ret}<p class='cf-desc'>{$description}</p></div>";
    } 

    // select
    else if($this['type'] == 'select') {
      $options = null;
      foreach($this['options'] as $optValue => $optText) {
        $options .= "<option value='{$optValue}'" . (($this['value'] == $optValue) ? " selected" : null) . ">{$optText}</option>\n";
      }
      return "<p><label for='$id'>$label</label><br/>\n<select id='$id'{$class}{$name}{$autofocus}{$required}{$readonly}{$checked}{$title}{$multiple}>\n{$options}</select>{$messages}</p><p class='cf-desc'>{$description}</p>\n"; 
    }

    // select-multiple
    else if($this['type'] == 'select-multiple') {
      $name = " name='{$this['name']}[]'";
      $options = null;
      foreach($this['options'] as $optValue => $optText) {
        $selected = is_array($this['values']) && in_array($optValue, $this['values']) ? " selected" : null;    
        $options .= "<option value='{$optValue}'{$selected}>{$optText}</option>\n";
      }
      return "<p><label for='$id'>$label</label><br/>\n<select id='$id' multiple{$size}{$class}{$name}{$autofocus}{$required}{$readonly}{$checked}{$title}{$multiple}>\n{$options}</select>{$messages}</p><p class='cf-desc'>{$description}</p>\n"; 
    }

    // file-multiple
    else if($this['type'] == 'file-multiple') {
      return "<p><label for='$id'>$label</label><br/>\n<input id='$id' type='file' multiple{$class}{$name}{$value}{$autofocus}{$required}{$readonly}{$placeholder}{$title}{$multiple}{$pattern}{$max}{$min}{$step}/>{$messages}</p><p class='cf-desc'>{$description}</p>\n";        
    } 

   // Everything else 
    else {
      return "<p><label for='$id'>$label</label><br/>\n<input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$required}{$readonly}{$placeholder}{$title}{$multiple}{$pattern}{$max}{$min}{$step}/>{$messages}</p><p class='cf-desc'>{$description}</p>\n";        
    }
  }



  /**
   * Validate the form element value according a ruleset.
   *
   * @param array $rules validation rules.
   * @param CForm $form the parent form.
   * returns boolean true if all rules pass, else false.
   */
  public function Validate($rules, $form) {
    $regExpEmailAddress = '/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';
    $tests = array(
      'fail' => array('message' => 'Will always fail.', 'test' => 'return false;'),
      'pass' => array('message' => 'Will always pass.', 'test' => 'return true;'),
      'not_empty' => array('message' => 'Can not be empty.', 'test' => 'return $value != "";'),
      'not_equal' => array('message' => 'Value not valid.', 'test' => 'return $value != $arg;'),
      'numeric' => array('message' => 'Must be numeric.', 'test' => 'return is_numeric($value);'),
      'email_adress' => array('message' => 'Must be an email adress.', 'test' => function($value) { return preg_match('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $value) === 1; } ),
      'match' => array('message' => 'The field does not match.', 'test' => 'return $value == $form[$arg]["value"] ;'),
      'must_accept' => array('message' => 'You must accept this.', 'test' => 'return $checked;'),
      'custom_test' => true,
    );

    // max tecken, min tecken, datum, tid, datetime, mysql datetime


    $pass = true;
    $messages = array();
    $value = $this['value'];
    $checked = $this['checked'];

    foreach($rules as $key => $val) {
      $rule = is_numeric($key) ? $val : $key;
      if(!isset($tests[$rule])) throw new Exception("Validation of form element failed, no such validation rule exists: $rule");
      $arg = is_numeric($key) ? null : $val;

      $test = ($rule == 'custom_test') ? $arg : $tests[$rule];
      $status = null;
      if(is_callable($test['test'])) {
        $status = $test['test']($value);
      } else {
        $status = eval($test['test']);
      }

      if($status === false) {
        $messages[] = $test['message'];
        $pass = false;
      }
    }

    if(!empty($messages)) {
      $this['validation-messages'] = $messages;
    } 
    return $pass;
  }


  /**
   * Use the element name as label if label is not set.
   *
   * @param string $append a colon as default to the end of the label.
   */
  public function UseNameAsDefaultLabel($append=':') {
    if(!isset($this['label'])) {
      $this['label'] = ucfirst(strtolower(str_replace(array('-','_'), ' ', $this['name']))).$append;
    }
  }


  /**
   * Use the element name as value if value is not set.
   */
  public function UseNameAsDefaultValue() {
    if(!isset($this['value'])) {
      $this['value'] = ucfirst(strtolower(str_replace(array('-','_'), ' ', $this['name'])));
    }
  }



  /**
   * Get the value of the form element.
   *
   * @return mixed the value of the form element.
   */
  public function GetValue() {
    return $this['value'];
  }



  /**
   * Get the value of the form element, if value is empty return null.
   *
   * @return mixed the value of the form element. Null if the value is empty.
   */
  public function GetValueNullIfEmpty() {
    return empty($this['value']) ? null : $this['value'];
  }


}


class CFormElementText extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'text';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementColor extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'color';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementDate extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'date';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementDatetime extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'datetime';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementDatetimeLocal extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'datetime-local';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementMonth extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'month';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementTime extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'time';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementWeek extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'week';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementNumber extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'number';
    $this->UseNameAsDefaultLabel();
  }
}



//class CFormElementProgress extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
 /* public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'progress';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementMeter extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  /*public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'meter';
    $this->UseNameAsDefaultLabel();
  }
}*/



class CFormElementRange extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'range';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementSearch extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type']     = 'search';
  }
}



class CFormElementSearchWidget extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type']     = 'search-widget';
  }
}



class CFormElementTel extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'tel';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementEmail extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'email';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementUrl extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'url';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementFile extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'file';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementFileMultiple extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'file-multiple';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementTextarea extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'textarea';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementHidden extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'hidden';
  }
}



class CFormElementPassword extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'password';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementRadio extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type']     = 'radio';
    //$this['checked']  = isset($attributes['checked']) ? $attributes['checked'] : false;
    //$this['value']    = isset($attributes['value']) ? $attributes['value'] : $name;
  }
}



class CFormElementCheckbox extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type']     = 'checkbox';
    $this['checked']  = isset($attributes['checked']) ? $attributes['checked'] : false;
    $this['value']    = isset($attributes['value']) ? $attributes['value'] : $name;
    $this->UseNameAsDefaultLabel(null);
  }
}



class CFormElementCheckboxMultiple extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'checkbox-multiple';
  }
}



class CFormElementSelect extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type']     = 'select';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementSelectMultiple extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type']     = 'select-multiple';
    $this->UseNameAsDefaultLabel();
  }
}



class CFormElementSubmit extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'submit';
    $this->UseNameAsDefaultValue();
  }
}



class CFormElementReset extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'reset';
    $this->UseNameAsDefaultValue();
  }
}



class CFormElementButton extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'button';
    $this->UseNameAsDefaultValue();
  }
}



class CForm implements ArrayAccess {

  /**
   * Properties
   */
  public $form;     // array with settings for the form
  public $elements; // array with all form elements
  public $output;   // array with messages to display together with the form
  

  /**
   * Constructor
   */
  public function __construct($form=array(), $elements=array()) {
    $this->form = $form;
    if(!empty($elements)) {
      foreach($elements as $key => $element) {
        $this->elements[$key] = CFormElement::Create($key, $element);
      }
    }
    $this->output = array();
  }


  /**
   * Implementing ArrayAccess for this->elements
   */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->elements[] = $value; } else { $this->elements[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->elements[$offset]); }
  public function offsetUnset($offset) { unset($this->elements[$offset]); }
  public function offsetGet($offset) { return isset($this->elements[$offset]) ? $this->elements[$offset] : null; }


  /**
   * Add a form element
   *
   * @param $element CFormElement the formelement to add.
   * @return $this CForm
   */
  public function AddElement($element) {
    $this[$element['name']] = $element;
    return $this;
  }
  

  /**
   * Remove an form element
   *
   * @param $name string the name of the element to remove from the form.
   * @return $this CForm
   */
  public function RemoveElement($name) {
    unset($this->elements[$name]);
    return $this;
  }
  

  /**
   * Set validation to a form element
   *
   * @param $element string the name of the formelement to add validation rules to.
   * @param $rules array of validation rules.
   * @return $this CForm
   */
  public function SetValidation($element, $rules) {
    $this[$element]['validation'] = $rules;
    return $this;
  }
  


  /**
   * Add output to display to the user what happened whith the form.
   *
   * @param string $str the string to add as output.
   * @return $this CForm.
   */
  public function AddOutput($str) {
    if(isset($_SESSION['form-output'])) {
      $_SESSION['form-output'] .= " $str";
    }
    else {
      $_SESSION['form-output'] = $str;
   }
    return $this;
  }



  /**
   * Get value of a form element
   *
   * @param $element string the name of the formelement.
   * @return mixed the value of the element.
   */
  public function Value($element) {
    return $this[$element]['value'];
  }
  

  /**
   * Return HTML for the form or the formdefinition.
   *
   * @param $options array with options affecting the form output.
   * @return string with HTML for the form.
   */
  public function GetHTML($options=array()) {
    $defaults = array(
      'start'          => false,  // Only return the start of the form element
      'columns'        => 1,      // Layout all elements in one column
      'use_buttonbar'  => true,   // Layout consequtive buttons as one element wrapped in <p>
      'use_fieldset'   => true,   // Wrap form fields within <fieldset>
      'legend'         => isset($this->form['legend']) ? $this->form['legend'] : null,   // Use legend for fieldset
    );
    $options = array_merge($defaults, $options);

    $form = array_merge($this->form, $options);
    $id     = isset($form['id'])      ? " id='{$form['id']}'" : null;
    $class  = isset($form['class'])   ? " class='{$form['class']}'" : null;
    $name   = isset($form['name'])    ? " name='{$form['name']}'" : null;
    $action = isset($form['action'])  ? " action='{$form['action']}'" : null;
    $method = isset($form['method'])  ? " method='{$form['method']}'" : " method='post'";

    if($options['start']) {
      return "<form{$id}{$class}{$name}{$action}{$method}>\n";
    }
    
    $fieldsetStart  = '<fieldset>';
    $legend         = null;
    $fieldsetEnd    = '</fieldset>';
    if(!$options['use_fieldset']) {
      $fieldsetStart = $fieldsetEnd = null;
    }

    if($options['use_fieldset'] && $options['legend']) {
      $legend = "<legend>{$options['legend']}</legend>";
    }
    
    $elementsArray  = $this->GetHTMLForElements($options);
    $elements       = $this->GetHTMLLayoutForElements($elementsArray, $options);
    $output         = $this->GetOutput();
    $html = <<< EOD
\n<form{$id}{$class}{$name}{$action}{$method}>
{$fieldsetStart}
{$legend}
{$elements}
{$output}
{$fieldsetEnd}
</form>\n
EOD;
    return $html;
  }
 

  /**
   * Return HTML for the elements
  *
   * @param $options array with options affecting the form output.
   * @return array with HTML for the formelements.
   */
  public function GetHTMLForElements($options=array()) {
    $defaults = array(
      'use_buttonbar' => true,
    );
    $options = array_merge($defaults, $options);

    $elements = array();
    reset($this->elements);
    while(list($key, $element) = each($this->elements)) {
      
      // Create a buttonbar?
      if(in_array($element['type'], array('submit', 'reset', 'button')) && $options['use_buttonbar']) {
        $name = 'buttonbar';
        $html = "<p class='buttonbar'>\n" . $element->GetHTML() . '&nbsp;';
        // Get all following submits (and buttons)
        while(list($key, $element) = each($this->elements)) {
          if(in_array($element['type'], array('submit', 'reset', 'button'))) {
            $html .= $element->GetHTML();
          } else {
            prev($this->elements);
            break;
          }
        }
        $html .= "\n</p>";
      }

      // Just add the element
      else {
        $name = $element['name'];
        $html = $element->GetHTML();
      }

      $elements[] = array('name'=>$name, 'html'=> $html);
    }

    return $elements;
  }

  


  /**
   * Place the elements according to a layout and return the HTML
   *
   * @param array $elements as returned from GetHTMLForElements().
   * @param array $options with options affecting the layout.
   * @return array with HTML for the formelements.
   */
  public function GetHTMLLayoutForElements($elements, $options=array()) {
    $defaults = array(
      'columns' => 1,
      'wrap_at_element' => false,  // Wraps column in equal size or at the set number of elements
    );
    $options = array_merge($defaults, $options);

    $html = null;
    if($options['columns'] === 1) {
      foreach($elements as $element) {
        $html .= $element['html'];
      }
    }
    else if($options['columns'] === 2) {
      $buttonbar = null;
      $col1 = null;
      $col2 = null;
      
      $e = end($elements);
      if($e['name'] == 'buttonbar') {
        $e = array_pop($elements);
        $buttonbar = "<div class='cform-buttonbar'>\n{$e['html']}</div>\n";
      }

      $size = count($elements);
      $wrapAt = $options['wrap_at_element'] ? $options['wrap_at_element'] : round($size/2);
      for($i=0; $i<$size; $i++) {
        if($i < $wrapAt) {
          $col1 .= $elements[$i]['html'];
        } else {
          $col2 .= $elements[$i]['html'];
        }
      }

      $html = "<div class='cform-columns-2'>\n<div class='cform-column-1'>\n{$col1}\n</div>\n<div class='cform-column-2'>\n{$col2}\n</div>\n{$buttonbar}</div>\n";
    }

    return $html;
  }
  


  /**
   * Get an array with all elements that failed validation together with their id and validation message.
   *
   * @return array with elements that failed validation.
   */
  public function GetValidationErrors() {
    $errors = array();
    foreach($this->elements as $name => $element) {
      if($element['validation-pass'] === false) {
        $errors[$name] = array('id' => $element->GetElementId(), 'label' => $element['label'], 'message' => implode(' ', $element['validation-messages']));
      }
    }
    return $errors;
  }



  /**
   * Get output messages as <output>.
   *
   * @return string/null with the complete <output> element or null if no output.
   */
  public function GetOutput() {
    if(!empty($this->output)) {
      return "<output>{$this->output}</output>";
    }
    return null;
  }



  /**
   * Init all element with values from session, clear all and fill in with values from the session.
   *
   */
  protected function InitElements($values) {
    // First clear all
    foreach($this->elements as $key => $val) {
      // Do not reset value for buttons
      if(in_array($this[$key]['type'], array('submit', 'reset', 'button'))) {
        continue;
      }

      // Reset the value
      $this[$key]['value'] = null;

      // Checkboxes must be cleared
      if(isset($this[$key]['checked'])) {
        $this[$key]['checked'] = false;
      }
    }

    // Now build up all values from $values (session)
    foreach($values as $key => $val) {

      // Take care of arrays as values (multiple-checkbox)
      if(isset($val['values'])) {
        $this[$key]['checked'] = $val['values'];
        //$this[$key]['values']  = $val['values'];
      } else {
        $this[$key]['value'] = $val['value'];
      }

      // Is this a checkbox?
      if($this[$key]['type'] === 'checkbox') {
        $this[$key]['checked'] = true;
      }

      // Is this a radio?
      else if($this[$key]['type'] === 'radio') {
        $this[$key]['checked'] = $val['value'];
      }

      // Keep track on validation messages if set
      if(isset($val['validation-messages'])) {
        $this[$key]['validation-messages'] = $val['validation-messages'];
        $this[$key]['validation-pass'] = false;
      }
  }
  }



  /**
   * Check if a form was submitted and perform validation and call callbacks.
   * The form is stored in the session if validation or callback fails. The page should then be redirected
   * to the original form page, the form will populate from the session and should be rendered again.
   * Form elements may remember their value if 'remember' is set and true.
   *
   * @return mixed, $callbackStatus if submitted&validates, false if not validate, null if not submitted. 
   *         If submitted the callback function will return the actual value which should be true or false.
   */
  public function Check() {
    $remember = null;
    $validates = null;
    $callbackStatus = null;
    $values = array();
    
    // Remember output messages in session
    if(isset($_SESSION['form-output'])) {
      $this->output = $_SESSION['form-output'];
      unset($_SESSION['form-output']);
    }

    $request = null;
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      $request = $_POST;
      unset($_SESSION['form-failed']);
      $validates = true;

      foreach($this->elements as $element) {

        // The form element has a value set
        if(isset($request[$element['name']])) {

          // Multiple choices comes in the form of an array
          if(is_array($request[$element['name']])) {
            $values[$element['name']]['values'] = $element['checked'] = $request[$element['name']];
          } else {
            $values[$element['name']]['value'] = $element['value'] = $request[$element['name']];
          }

          // If the element is a checkbox, set its value of checked.
          if($element['type'] === 'checkbox') {
            $element['checked'] = true;
          }

          // If the element is a radio, set the value to checked.
          if($element['type'] === 'radio') {
            $element['checked'] = $element['value'];
          }

          // Do validation of form element
          if(isset($element['validation'])) {
            $element['validation-pass'] = $element->Validate($element['validation'], $this);
            if($element['validation-pass'] === false) {
              $values[$element['name']] = array('value'=>$element['value'], 'validation-messages'=>$element['validation-messages']);
              $validates = false;
            }
          }

          // Hmmm.... Why did I need this remember thing?
          if(isset($element['remember']) && $element['remember']) {
            $values[$element['name']] = array('value'=>$element['value']);
            $remember = true;
          }

          // Carry out the callback if the form element validates
          if(isset($element['callback']) && $validates) {
            if(isset($element['callback-args'])) {
              $callbackStatus = call_user_func_array($element['callback'], array_merge(array($this), $element['callback-args']));
            } else {
              $callbackStatus = call_user_func($element['callback'], $this);
            }
          }
        } 

        // The form element has no value set
        else {

          // Set element to null, then we know it was not set.
          //$element['value'] = null;

          //echo $element['type'] . ':' . $element['name'] . ':' . $element['value'] . '<br>';

          // If the element is a checkbox, clear its value of checked.
          if($element['type'] === 'checkbox' || $element['type'] === 'checkbox-multiple') {
            $element['checked'] = false;
          }

          // Do validation even when the form element is not set? Duplicate code, revise this section and move outside this if-statement?
          if(isset($element['validation'])) {
            $element['validation-pass'] = $element->Validate($element['validation'], $this);
            if($element['validation-pass'] === false) {
              $values[$element['name']] = array('value'=>$element['value'], 'validation-messages'=>$element['validation-messages']);
              $validates = false;
            }
          }
        }
      }
    } 

    // Read form data from session if the previous post failed during validation.
    elseif(isset($_SESSION['form-failed'])) {
      $this->InitElements($_SESSION['form-failed']);
      unset($_SESSION['form-failed']);
    } 

    // Read form data from session if some form elements should be remembered
    elseif(isset($_SESSION['form-remember'])) {
      foreach($_SESSION['form-remember'] as $key => $val) {
        $this[$key]['value'] = $val['value'];
      }
      unset($_SESSION['form-remember']);
    }

    // Read form data from session, 
    // useful during test where the original form is displayed with its posted values
    elseif(isset($_SESSION['form-save'])) {
      $this->InitElements($_SESSION['form-save']);
      unset($_SESSION['form-save']);
    }
    
    
    // Prepare if data should be stored in the session during redirects
    // Did form validation or the callback fail?
    if($validates === false || $callbackStatus === false) {
      $_SESSION['form-failed'] = $values;
    }

    // Hmmm, why do I want to use this
    elseif($remember) {
      $_SESSION['form-remember'] = $values;
    }
    
    // Remember all posted values
    if(isset($this->saveInSession) && $this->saveInSession) {
      $_SESSION['form-save'] = $values;
    }


    return ($validates) ? $callbackStatus : $validates;
  }
  
  
}
