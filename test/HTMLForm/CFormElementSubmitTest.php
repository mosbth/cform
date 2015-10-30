<?php

namespace Mos\HTMLForm;

/**
 * HTML Form elements.
 *
 */
class CFormElementSubmitTest extends \PHPUnit_Framework_TestCase
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
        $attr = [];
        
        $elem = new \Mos\HTMLForm\CFormElementSubmit($name, $attr);

        $res = $elem['name'];
        $exp = $name;
        $this->assertEquals($res, $exp, "Name missmatch.");

        $res = $elem['type'];
        $exp = "submit";
        $this->assertEquals($res, $exp, "Type missmatch.");

        $res = $elem->getValue();
        $exp = "Name";
        $this->assertEquals($res, $exp, "Value missmatch.");
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
        $attr = [];
        
        $elem = new \Mos\HTMLForm\CFormElementSubmit($name, $attr);

        $res = $elem->getHTML();
        $exp = <<<EOD
<span>
<input id='form-element-name' type='submit' name='name' value='Name' />
</span>
EOD;
        $this->assertEquals($res, $exp, "Output HTML missmatch.");
    }



    /**
     * Test
     *
     * @return void
     *
     */
    public function testGetHTMLFormNoValidate()
    {
        $name = "name";
        $attr = [
            "formnovalidate" => true
        ];
        
        $elem = new \Mos\HTMLForm\CFormElementSubmit($name, $attr);

        $res = $elem->getHTML();
        $exp = <<<EOD
<span>
<input id='form-element-name' type='submit' name='name' value='Name' formnovalidate='formnovalidate' />
</span>
EOD;
        $this->assertEquals($res, $exp, "Output HTML missmatch.");
    }
}
