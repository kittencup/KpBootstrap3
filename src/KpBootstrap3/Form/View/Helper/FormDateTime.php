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
use Zend\Form\View\Helper\FormDateTime as ZfFormDateTime;
use DateTime;
use Zend\Validator\Date;


class FormDateTime extends ZfFormDateTime
{
    protected $configKey = 'kpBootstrap3';
    protected $defaultClass = 'form-control';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $locale = 'zh-CN';
    protected $datetimepickerJs = '/js/bootstrap-datetimepicker.min.js';
    protected $datetimepickerCss = '/css/bootstrap-datetimepicker.min.css';
    protected $datetimepickerLocaleJs = '/js/locales/bootstrap-datetimepicker.%s.js';

    public function __invoke(ElementInterface $element = null)
    {

        if ($element) {

            // 获取配置文件
            $config = $this->getConfig();

            // 设置local
            $this->setLocal($config);

            // bootstrap3 config;
            $kpBootstrap3Config = isset($config[$this->configKey]) ? $config[$this->configKey] : array();

            // 检查是否需要用到bootstrapDatetimepicker
            if ($this->checkDatetimepicker($kpBootstrap3Config)) {

                // js通过id激活Datetimepicker，如果表单为设置id则将name设置为id
                $this->setId($element);
                // 添加bootstrapDatetimepicker的js,css
                $this->addDatetimepicker($element, $kpBootstrap3Config);
            }

            // 设置 验证和格式化的 时间格式
            $this->setDateFormat($kpBootstrap3Config);
            // 格式化format
            $this->formatValue($element);

        }
        return parent::__invoke($element);
    }

    protected function setDateFormat($config)
    {
        if (isset($config['dateTime']['dateFormat'])) {
            $this->dateFormat = $config['dateTime']['dateFormat'];
        }
    }

    protected function formatValue(ElementInterface $element)
    {
        $value = $element->getValue();
        if (!empty($value)) {

            $dateValidator = new Date(array('format' => $this->dateFormat));

            if (!$dateValidator->isValid($value)) {
                $dateTime = new DateTime();
                $dateTime->setTimestamp($value);
                $element->setValue($dateTime->format($this->dateFormat));
            }
        }
    }

    protected function setId(ElementInterface $element)
    {
        $id = $element->getAttribute('id');
        if (empty($id)) {
            $element->setAttribute('id', $element->getAttribute('name'));
        }
    }


    protected function checkDatetimepicker($config)
    {
        return isset($config['dateTime']['datetimepicker']) && $config['dateTime']['datetimepicker'] === true && isset($config['dateTime']['datetimepickerAssertPath']);
    }

    protected function getConfig()
    {
        if (is_callable(array($this->getView(), 'getHelperPluginManager'))) {
            return $this->getView()->getHelperPluginManager()->getServiceLocator()->get('Config');
        }
        return array();
    }

    protected function setLocal($config)
    {
        if (isset($config['translator']['locale'])) {
            $this->locale = str_replace('_', '-', $config['translator']['locale']);
        }
    }

    /**
     * 添加Bootstrap3 Datetimepicker 的javascript,css
     * @DatetimepickerApi http://www.bootcss.com/p/bootstrap-datetimepicker/index.htm
     * @param ElementInterface $element
     */
    protected function addDatetimepicker(ElementInterface $element, $config)
    {
        $view = $this->getView();

        $name = $element->getAttribute('name');

        $datetimepickerAssertPath = $config['dateTime']['datetimepickerAssertPath'];

        $inlineScriptHelper = $view->plugin('inlineScript');
        $inlineScriptHelper('file',$datetimepickerAssertPath . $this->datetimepickerJs);
        $inlineScriptHelper('file',$datetimepickerAssertPath . sprintf($this->datetimepickerLocaleJs, $this->locale));
        $inlineScriptHelper('script',
                '$("#' . $name . '").datetimepicker({'
                . $this->createDatetimepickerOption($config) .
                '})'
        );

        $view->plugin('headLink')->prependStylesheet($datetimepickerAssertPath . $this->datetimepickerCss);

    }


    protected function createDatetimepickerOption($config)
    {

        if (isset($config['dateTime']['datetimepickerOption'])) {
            $phpOptions = $config['dateTime']['datetimepickerOption'];

            if (!isset($phpOptions['language'])) {
                $phpOptions['language'] = $this->locale;
            }

            $jsOptions = array();
            foreach ($phpOptions as $key => $option) {

                switch (gettype($option)) {
                    case 'string':
                        $option = '"' . $option . '"';
                        break;
                    case 'boolean':
                        $option = $option ? 'true' : 'false';
                        break;
                }

                $jsOptions[] = $key . ':' . $option;
            }

            return implode(',', $jsOptions);
        }
    }
}