<?php
/**
 * Kittencup Module
 *
 * @date 2014 14-4-17 下午3:17
 * @copyright Copyright (c) 2014-2015 Kittencup. (http://www.kittencup.com)
 * @license   http://kittencup.com
 */

namespace KpBootstrap3Test\Form\View\Helper;

use KpBootstrap3\Form\View\Helper\Form as FormHelper;
use Zend\Form\Element;
use PHPUnit_Framework_TestCase;
use Zend\Form\Form;
use Zend\View\Renderer\PhpRenderer;

class FormTest extends PHPUnit_Framework_TestCase
{

    protected $helper;
    protected $element;

    public function setUp()
    {
        $this->element = new Form();

        $this->helper = new FormHelper();
        $phpRenderer = new PhpRenderer();
        $phpRenderer->getHelperPluginManager()->setInvokableClass('formRow', 'KpBootstrap3\Form\View\Helper\FormRow');
        $phpRenderer->getHelperPluginManager()->setInvokableClass('formElementErrors', 'KpBootstrap3\Form\View\Helper\FormElementErrors');
        $phpRenderer->getHelperPluginManager()->setInvokableClass('formLabel', 'Zend\Form\View\Helper\FormLabel');
        $phpRenderer->getHelperPluginManager()->setInvokableClass('formElement', 'Zend\Form\View\Helper\FormElement');
        $phpRenderer->getHelperPluginManager()->setInvokableClass('formText', 'Zend\Form\View\Helper\FormText');
        $this->helper->setView($phpRenderer);
    }

    public function testHtml()
    {
        $helper = $this->helper;
        $this->element->add(array(
            'name' => 'username',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'username'
            )
        ));
        $this->assertEquals('<form action="" method="POST"><div class="form-group "><label for="username">username</label><input name="username" type="text" class="form-control" value=""></div></form>', $helper($this->element));
    }

    public function testFormClassHtml()
    {
        $helper = $this->helper;
        $this->element->setAttribute('class', 'form-horizontal');
        $this->assertEquals('<form action="" method="POST" class="form-horizontal"></form>', $helper($this->element));
    }


}