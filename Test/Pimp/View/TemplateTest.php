<?php

namespace Test\Pimp\View;

class TemplateTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $template = new \Pimp\View\Template();

        $this->assertInstanceOf('Pimp\View\TemplateInterface', $template);

        $text = $template->render('', array('test text'));

        $this->assertEquals('["test text"]', $text);
    }
}
