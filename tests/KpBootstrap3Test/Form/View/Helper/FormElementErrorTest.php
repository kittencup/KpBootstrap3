<?php
/**
 * Kittencup Module
 *
 * @date 2014 14-4-17 下午3:17
 * @copyright Copyright (c) 2014-2015 Kittencup. (http://www.kittencup.com)
 * @license   http://kittencup.com
 */

namespace KpBootstrap3Test\Form\View\Helper;

use KpBootstrap3\Form\View\Helper\FormElementErrors;
use Zend\Form\Element;
use PHPUnit_Framework_TestCase;


class FormElementErrorTest extends PHPUnit_Framework_TestCase
{
    protected $helper;
    protected $element;

    public function setUp()
    {
        $this->element = new Element\Text('username', array('label' => 'username'));
        $this->helper = new FormElementErrors();
    }

    public function testHtml()
    {
        $helper = $this->helper;
        $this->element->setMessages(array('isEmpty' => '输入不能为空'));
        $this->assertEquals('<span class="help-block">输入不能为空</span>', $helper($this->element));
    }

}