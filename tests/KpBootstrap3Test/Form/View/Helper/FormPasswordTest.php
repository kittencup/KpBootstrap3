<?php
/**
 * Kittencup Module
 *
 * @date 2014 14-4-17 下午3:17
 * @copyright Copyright (c) 2014-2015 Kittencup. (http://www.kittencup.com)
 * @license   http://kittencup.com
 */

namespace KpBootstrap3Test\Form\View\Helper;

use KpBootstrap3\Form\View\Helper\FormPassword;
use Zend\Form\Element;
use PHPUnit_Framework_TestCase;
class FormPasswordTest extends PHPUnit_Framework_TestCase
{

    protected $helper;
    protected $element;

    public function setUp()
    {
        $this->element = new Element\Password('password');
        $this->helper = new FormPassword();
    }

    public function testHtml()
    {
        $helper = $this->helper;
        $this->assertEquals('<input type="password" name="password" value="">', $helper($this->element));
    }

    public function testValue()
    {
        $helper = $this->helper;
        $this->element->setValue(__NAMESPACE__);
        $this->assertEquals('<input type="password" name="password" value="">', $helper($this->element));
    }

}