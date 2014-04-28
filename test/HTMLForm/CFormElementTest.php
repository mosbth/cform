<?php

namespace Mos\HTMLForm;

/**
 * HTML Form elements.
 *
 */
class CFormElementTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test 
     *
     * @return void
     *
     */
    public function testCreateElement() 
    {
        $el = new \Mos\HTMLForm\CFormElement('test');

        $res = $el['name'];
        $exp = 'test';
        $this->assertEquals($res, $exp, "Created element name missmatch.");

        $res = $el->characterEncoding;
        $exp = 'UTF-8';
        $this->assertEquals($res, $exp, "Character encoding missmatch.");
    }





    /**
     * Test 
     *
     * @expectedException Exception
     *
     * @return void
     *
     */
    public function testValidationRuleNotFound() 
    {
        $el = new \Mos\HTMLForm\CFormElement('test');

        $el->validate('no-such-rule');
    }
}