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
    /**
     * 配置中的键值
     * @var string
     */
    protected $configKey = 'kpBootstrap3';

    /**
     * 日期格式化
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * 语言
     * @var string
     */
    protected $locale = 'zh-CN';

    /**
     * DateTimepicker Js
     * @var string
     */
    protected $datetimepickerJs = '/js/bootstrap-datetimepicker.min.js';

    /**
     *  DateTimepicker Css
     * @var string
     */
    protected $datetimepickerCss = '/css/bootstrap-datetimepicker.min.css';

    /**
     *  DateTimepicker 语言包 Js
     * @var string
     */
    protected $datetimepickerLocaleJs = '/js/locales/bootstrap-datetimepicker.%s.js';

    /**
     * $helper($elment);
     * @param ElementInterface $element
     * @return mixed
     */
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

    /**
     * 设置日期格式化
     * @param $config
     */
    protected function setDateFormat($config)
    {
        if (isset($config['dateTime']['dateFormat'])) {
            $this->dateFormat = $config['dateTime']['dateFormat'];
        }
    }

    /**
     * 格式化日期
     * value不符合dateFormate格式，则格式化value
     * @param ElementInterface $element
     */
    protected function formatValue(ElementInterface $element)
    {
        $value = (string)$element->getValue();

        if (!empty($value)) {

            $dateValidator = new Date(array('format' => $this->dateFormat));

            if (!$dateValidator->isValid($value)) {
                $dateTime = new DateTime();
                $dateTime->setTimestamp($value);
                $element->setValue($dateTime->format($this->dateFormat));
            }
        } else {
            // 如果value为空，可能是0 验证时候可能通不过，所以在这里清空
            $element->setValue('');
        }
    }

    /**
     * 给元素设置id
     * DateTimepicker 组件 需要 id 启动js
     * @param ElementInterface $element
     */
    protected function setId(ElementInterface $element)
    {
        $id = $element->getAttribute('id');
        if (empty($id)) {
            $element->setAttribute('id', $element->getAttribute('name'));
        }
    }


    /**
     * 检查配置，确定是否需要开启DateTimepicker组件
     * @param $config
     * @return bool
     */
    protected function checkDatetimepicker($config)
    {
        return isset($config['dateTime']['datetimepicker']) && $config['dateTime']['datetimepicker'] === true && isset($config['dateTime']['datetimepickerAssertPath']);
    }

    /**
     * 获取配置文件
     * @return array
     */
    protected function getConfig()
    {
        // @todo 给phpunit test用的
        if (is_callable(array($this->getView(), 'getHelperPluginManager'))) {
            return $this->getView()->getHelperPluginManager()->getServiceLocator()->get('Config');
        }
        return array();
    }

    /**
     * 设置语言
     * @param $config
     */
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
        $inlineScriptHelper('file', $datetimepickerAssertPath . $this->datetimepickerJs);
        $inlineScriptHelper('file', $datetimepickerAssertPath . sprintf($this->datetimepickerLocaleJs, $this->locale));
        $inlineScriptHelper('script',
            '$("#' . $name . '").datetimepicker({'
            . $this->createDatetimepickerOption($config) .
            '})'
        );

        $view->plugin('headLink')->prependStylesheet($datetimepickerAssertPath . $this->datetimepickerCss);

    }


    /**
     * 将php配置 转换为 js的配置
     * @param $config
     * @return string
     */
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