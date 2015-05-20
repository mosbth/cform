<?php

namespace Mos\HTMLForm;

/**
 * HTML Form elements.
 *
 */
class CFormElementSelectMultipleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @return void
     *
     */
    public function testCreate()
    {
        $name = "name";
        $attr = [
            "options" => []
        ];
        
        $elem = new \Mos\HTMLForm\CFormElementSelectMultiple($name, $attr);

        $res = $elem['name'];
        $exp = $name;
        $this->assertEquals($res, $exp, "Name missmatch.");

        $res = $elem['type'];
        $exp = "select-multiple";
        $this->assertEquals($res, $exp, "Type missmatch.");

        $res = $elem->getValue();
        $exp = null;
        $this->assertEquals($res, $exp, "Value missmatch.");

        $res = is_array($elem['options']) && empty($elem['options']);
        $exp = true;
        $this->assertEquals($res, $exp, "Type missmatch.");
    }



    /**
     * Test
     *
     * @expectedException \Mos\HTMLForm\CFormException
     *
     */
    public function testCreateException()
    {
        $name = "name";
        $attr = [];
        
        $elem = new \Mos\HTMLForm\CFormElementSelectMultiple($name, $attr);
    }



    /**
     * Test
     *
     * @return void
     *
     */
    public function testGetHTMLEmpty()
    {
        $name = "name";
        $attr = [
            "options" => []
        ];
        
        $elem = new \Mos\HTMLForm\CFormElementSelectMultiple($name, $attr);

        $res = $elem->getHTML();
        $exp = <<<EOD
<p>
<label for='form-element-name'>Name:</label>
<br/>
<select id='form-element-name' name='name[]' multiple>

</select>

</p>
<p class='cf-desc'></p>
EOD;
        $this->assertEquals($res, $exp, "Output HTML missmatch.");
    }



    /**
     * Test
     *
     * @return void
     *
     */
    public function testGetHTML()
    {
        $name = "name";
        $attr = [
            'options' => [
                'default' => 'Select...',
                '01' => 'January',
            ],
        ];
        
        $elem = new \Mos\HTMLForm\CFormElementSelectMultiple($name, $attr);

        $res = $elem->getHTML();
        $exp = <<<EOD
<p>
<label for='form-element-name'>Name:</label>
<br/>
<select id='form-element-name' name='name[]' multiple>
<option value='default'>Select...</option>
<option value='01'>January</option>

</select>

</p>
<p class='cf-desc'></p>
EOD;
        $this->assertEquals($res, $exp, "Output HTML missmatch.");
    }
}
