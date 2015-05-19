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
\n<form method='post'>
<fieldset>



</fieldset>
</form>\n
EOD;

        $this->assertEquals($res, $exp, "Empty form render missmatch.");
    }
}
