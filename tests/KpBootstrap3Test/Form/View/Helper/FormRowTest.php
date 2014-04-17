<?php
/**
 * Kittencup Module
 *
 * @date 2014 14-4-17 下午3:17
 * @copyright Copyright (c) 2014-2015 Kittencup. (http://www.kittencup.com)
 * @license   http://kittencup.com
 */

namespace KpBootstrap3Test\Form\View\Helper;

use KpBootstrap3\Form\View\Helper\FormRow;
use Zend\Form\Element;
use PHPUnit_Framework_TestCase;
use Zend\Form\Form;


class FormRowTest extends PHPUnit_Framework_TestCase
{

    protected $helper;
    protected $element;

    public function setUp()
    {
        $this->element = new Element\Text('username', array('label' => 'username'));
        $this->helper = new FormRow();

    }

    public function testHtml()
    {
        $helper = $this->helper;
        $this->assertEquals('<div class="form-group "><label for="username">username</label></div>', $helper($this->element));
    }

    public function testHorizontalHtml()
    {
        $helper = $this->helper;
        $form = new Form();
        $form->setAttribute('class', 'form-horizontal')->setAttribute('horizontalLabelClass', 'col-sm-5')->setAttribute('horizontalInputWrapClass', 'col-sm-7');
        $this->element->setOption('_form', $form);
        $this->assertEquals('<div class="form-group "><label class="control-label col-sm-5" for="username">username</label><div class="col-sm-7"></div></div>', $helper($this->element));
    }

    public function testInlineHtml()
    {
        $form = new Form();
        $helper = $this->helper;
        $form->setAttribute('class', 'form-inline');
        $this->element->setOption('_form', $form);
        $this->assertEquals('<div class="form-group "><label class="sr-only" for="username">username</label></div>', $helper($this->element));

    }

    public function testHiddenHtml()
    {
        $this->element = new Element\Hidden('id', array('label' => 'id'));
        $helper = $this->helper;
        $this->assertEquals('<div class="form-group hidden"><label for="id">id</label></div>', $helper($this->element));
    }


}