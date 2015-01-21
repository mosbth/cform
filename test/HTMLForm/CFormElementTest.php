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

        $el->validate(['no-such-rule'], $el);
    }



    /**
     * Test
     *
     * @return void
     *
     */
    public function testGetValue()
    {
        $el = new \Mos\HTMLForm\CFormElement('test', ['value' => 42]);

        $res = $el['value'];
        $exp = 42;
        $this->assertEquals($res, $exp, "Form element value missmatch, array syntax.");

        $res = $el->getValue();
        $exp = 42;
        $this->assertEquals($res, $exp, "Form element value missmatch, method.");
    }



    /**
     * Test
     *
     * @return void
     *
     */
    public function testValidateEmail()
    {
        $el = new \Mos\HTMLForm\CFormElement('test');

        $el['value'] = 'mos@dbwebb.se';
        $res = $el->validate(['email_adress'], null);
        $this->assertTrue($res, "Validation email fails.");
    }



}
