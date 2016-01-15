<?php

namespace Mos\HTMLForm;

/**
 * HTML Form elements.
 *
 */
class CFormTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @return void
     *
     */
    public function testCreate1()
    {
        $form = new \Mos\HTMLForm\CForm();
        $form->create();

        $res = $form->getHTML();
        $exp = <<<EOD
\n<form id='cform' method='post'>
<input type="hidden" name="mos/cform-id" value="cform" />
<fieldset>



</fieldset>
</form>\n
EOD;

        $this->assertEquals($res, $exp, "Empty form missmatch.");
    }



    /**
     * Test
     *
     * @return void
     *
     */
    public function testCreate2()
    {
        $form = new \Mos\HTMLForm\CForm();
        $form->create([
            "enctype" => "multipart/form-data"
        ]);

        $res = $form->getHTML();
        $exp = <<<EOD
\n<form id='cform' method='post' enctype='multipart/form-data'>
<input type="hidden" name="mos/cform-id" value="cform" />
<fieldset>



</fieldset>
</form>\n
EOD;

        $this->assertEquals($res, $exp, "Form with enctype missmatch.");
    }



    /**
     * Test
     *
     * @return void
     *
     */
/*    public function testCreate2()
    {
        $form = new \Mos\HTMLForm\CForm();

        $form->create([], [
            'test' => [
                'type' => 'select',
                'options' => [
                    'default' => 'Select...',
                    '01' => 'January',
                ],
            ],
        ]);
        
        echo $form->getHTML();
        $res = $form->getHTML();
        $exp = <<<EOD
\n<form method='post'>
<fieldset>



</fieldset>
</form>\n
EOD;

        $this->assertEquals($res, $exp, "Empty form render missmatch.");
    }*/
}
