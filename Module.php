<?php
/**
 * Kittencup Module
 *
 * @date 2014 14-4-17 上午9:08
 * @copyright Copyright (c) 2014-2015 Kittencup. (http://www.kittencup.com)
 * @license   http://kittencup.com
 */

namespace KpBootstrap3;

class Module
{
    public function getConfig()
    {
        return array(
            'kpBootstrap3' => array(
                'dateTime' => array(
                    'dateFormat' => 'Y-m-d H:i:s',
                    'datetimepicker' => true,
                    'datetimepickerAssertPath' => '/vendor/datetimepicker',
                    'datetimepickerOption' => array(
                        'format' => "yyyy-mm-dd hh:ii:ss",
                        'autoclose' => true,
                        'todayBtn' => true,
                    )
                )
            ),
            'view_helpers' => array(
                'invokables' => array(
                    'formPassword' => 'KpBootstrap3\Form\View\Helper\FormPassword',
                    'formDateTime' => 'KpBootstrap3\Form\View\Helper\FormDateTime',
                    'form' => 'KpBootstrap3\Form\View\Helper\Form',
                    'formRow' => 'KpBootstrap3\Form\View\Helper\FormRow',
                    'formElementErrors' => 'KpBootstrap3\Form\View\Helper\FormElementErrors',
                )
            )
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
