<?php
/**
 * Kittencup Module
 *
 * @date 2014 14-4-15 下午8:41
 * @copyright Copyright (c) 2014-2015 Kittencup. (http://www.kittencup.com)
 * @license   http://kittencup.com
 */
namespace KpBootstrap3\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormPassword as ZfFormPassword;

class FormPassword extends ZfFormPassword
{
    public function __invoke(ElementInterface $element = null)
    {

        if ($element) {
            // 密码一般都是不会显示出来
            $element->setValue('');
        }
        return parent::__invoke($element);
    }
}