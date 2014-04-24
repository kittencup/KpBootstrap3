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
use Zend\Form\Form as ZfForm;
use Zend\Form\FormInterface;
use Zend\Form\View\Helper\FormRow as ZfFormRow;

class FormRow extends ZfFormRow
{
    protected $formAllowClass = array(
        'form-horizontal',
        'form-inline'
    );

    protected $defaultWrap = '<div class="form-group %s">%s%s%s</div>';
    protected $horizontalWrap = '<div class="form-group %s">%s<div class="%s">%s%s</div></div>';

    protected $horizontalLabelClass = 'col-sm-2';
    protected $horizontalInputWrapClass = 'col-sm-10';

    protected $hiddenClass = 'hidden';
    protected $errorClass = 'has-error';

    public function render(ElementInterface $element)
    {

        // 获取helper
        $errorHelper = $this->getElementErrorsHelper();
        $labelHelper = $this->getLabelHelper();
        $elementHelper = $this->getElementHelper();

        // 隐藏域 多个class
        $wrapClass = '';
        if ($element->getAttribute('type') == $this->hiddenClass) {
            $wrapClass .= $this->hiddenClass;
        }

        // submit 不需要class
        if ($element->getAttribute('type') !== 'submit') {
            $this->addElementClass($element, array('form-control'));
        }


        // 获取form 不存在 则创建个空的
        if(!($form = $element->getOption('_form'))){
            $form = new ZfForm();
        }

        switch ($this->getFormClass($form)) {
            case 'form-horizontal':

                $this->setHorizontalClass($form);
                $this->addLabelClass($element, array('control-label', $this->horizontalLabelClass));
                $errorHtml = $errorHelper($element);
                if (!empty($errorHtml)) {
                    $wrapClass .= ' ' . $this->errorClass;
                }
                return sprintf($this->horizontalWrap, $wrapClass, $labelHelper($element), $this->horizontalInputWrapClass, $elementHelper($element), $errorHtml);

            case 'form-inline':
                $this->addLabelClass($element, array('sr-only'));
                $errorHtml = $errorHelper($element);
                if (!empty($errorHtml)) {
                    $wrapClass .= ' ' . $this->errorClass;
                }

                return sprintf($this->defaultWrap, $wrapClass, $labelHelper($element), $elementHelper($element), $errorHtml);

            default:
                $errorHtml = $errorHelper($element);
                if (!empty($errorHtml)) {
                    $wrapClass .= ' ' . $this->errorClass;
                }
                return sprintf($this->defaultWrap, $wrapClass, $labelHelper($element), $elementHelper($element), $errorHtml);
        }


    }

    protected function setHorizontalClass(FormInterface $form)
    {
        if ($labelClass = $form->getAttribute('horizontalLabelClass')) {

            $this->horizontalLabelClass = $labelClass;
        }

        if ($inputWrapClass = $form->getAttribute('horizontalInputWrapClass')) {
            $this->horizontalInputWrapClass = $inputWrapClass;
        }
    }

    protected function addElementClass(ElementInterface $element, $classList)
    {

        $attributes = $element->getAttributes();

        if (isset($attributes['class'])) {
            $attributes['class'] = implode(' ', array_unique(array_merge(explode(' ', $attributes['class']), $classList)));
        } else {
            $attributes['class'] = implode(' ', $classList);
        }

        $element->setAttributes($attributes);

    }

    protected function addLabelClass(ElementInterface $element, $classList)
    {
        $labelAttributes = $element->getLabelAttributes();

        if (isset($labelAttributes['class'])) {
            $labelAttributes['class'] = implode(' ', array_unique(array_merge(explode(' ', $labelAttributes['class']), $classList)));
        } else {
            $labelAttributes['class'] = implode(' ', $classList);
        }

        $element->setLabelAttributes($labelAttributes);

    }

    protected function getFormClass(FormInterface $form)
    {
        $class = $form->getAttribute('class');

        if ($class) {
            $classList = explode(' ', $class);
            $intersectClass = array_intersect($classList, $this->formAllowClass);
            if (!empty($intersectClass)) {
                return array_pop($intersectClass);
            }
        }

        return 'default';
    }


}