<?php
/**
 * Kittencup Module
 *
 * @date 2014 14-4-17 下午3:17
 * @copyright Copyright (c) 2014-2015 Kittencup. (http://www.kittencup.com)
 * @license   http://kittencup.com
 */

namespace KpBootstrap3Test\Form\View\Helper;

use KpBootstrap3\Form\View\Helper\FormDateTime;

use Zend\Form\Element;
use PHPUnit_Framework_TestCase;

class FormDateTimeTest extends PHPUnit_Framework_TestCase
{

    protected $helper;
    protected $element;

    public function setUp()
    {
        $this->element = new Element\DateTime('regtime');
        $this->helper = new FormDateTime();
    }

    public function testHtmlValueNull()
    {
        $helper = $this->helper;
        $this->assertEquals('<input type="datetime" name="regtime" value="">', $helper($this->element));
    }

    public function testHtmlValueDate()
    {
        $helper = $this->helper;
        $time = time();
        $defaultFormat = 'Y-m-d H:i:s';

        $this->element->setValue((string)$time);
        $this->assertEquals('<input type="datetime" name="regtime" value="' . date($defaultFormat, $time) . '">', $helper($this->element));
    }


}