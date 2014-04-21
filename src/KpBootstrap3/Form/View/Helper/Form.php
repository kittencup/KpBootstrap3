<?php
/**
 * Kittencup Module
 *
 * @date 2014 14-4-15 下午8:41
 * @copyright Copyright (c) 2014-2015 Kittencup. (http://www.kittencup.com)
 * @license   http://kittencup.com
 */
namespace KpBootstrap3\Form\View\Helper;

use Zend\Form\FormInterface;
use Zend\Form\View\Helper\Form as ZfForm;

class Form extends ZfForm
{

    public function render(FormInterface $form)
    {
        if (method_exists($form, 'prepare')) {
            $form->prepare();
        }

        $formContent = '';

        foreach ($form as $element) {
            if ($element instanceof FieldsetInterface) {
                $formContent .= $this->getView()->formCollection($element);
            } else {
                // 将$form 传给$element
                $element->setOption('_form', $form);
                $formContent .= $this->getView()->formRow($element);
            }
        }

        return $this->openTag($form) . $formContent . $this->closeTag();
    }


}