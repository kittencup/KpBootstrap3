KpBootstrap3 版本 0.0.1
============
Zend Framework 2 模块

介绍
------

使用Twitter Bootstrap 3的样式输出Form组件

安装
------

下载后放入Module文件夹，在config/application.config.php里配置

    <?php
    return array(
        'modules' => array(
            // ...
            'KpBootstrap3',
        ),
        // ...
    );
    ?>

Form的样式
-----------
Bootstrap3 的Form 有3种样式，默认表单(无class)、内联表单(form-inline)、水平表单(form-horizontal)

使用
-----------
KpBootstrap3 默认使用的是 无class的默认表单

1、在view中输出所有的Form元素(默认表单)

    // Application/view/application/index/index.phtml
    <?php
        echo $this->form($form);
    ?>

2、使用form-inline
    
    // Application/src/Application/Form/IndexForm.php
    <?php
        namespace Application\Form;
    
        class IndexForm
        {
            public function __construct()
            {
                parent :: __construct('index');
                
                // 设置form的class
                $this->setAttribute('class', 'form-inline');
                
                // ....
            }
        }
    ?>
    
    // Application/view/application/index/index.phtml
    <?php
        echo $this->form($form);
    ?>


3、使用form-horizontal

form-horizontal 默认会对Label和表单元素进行Grid布局，总共12格Grid，默认Label占2格(col-sm-2)，表单Layout占10格(col-sm-10)

可以设置label和表单Layout的class属性

    // Application/src/Application/Form/IndexForm.php
    <?php
        namespace Application\Form;
    
        class IndexForm
        {
            public function __construct()
            {
                parent :: __construct('index');
                
                // 设置form的class
                $this->setAttribute('class', 'form-horizontal');
                
                // 设置Label所使用的grid类
                $this->setAttribute('horizontalLabelClass', 'col-sm-5')
                
                // 设置表单Layout所使用的grid类
                $this->setAttribute('horizontalInputWrapClass', 'col-sm-5')
                
                // ....
            }
        }
    ?>
    
    // Application/view/application/index/index.phtml
    <?php
        echo $this->form($form);
    ?>

4、重写了元素 dateTime 配合Bootstrap3的datetimepicker js组件

组件下载地址 http://www.bootcss.com/p/bootstrap-datetimepicker/

    // KpBootstrap3/Module.php
    <?php
    class Module
    {
        public function getConfig()
        {
            return array(
                'kpBootstrap3' => array(
                    'dateTime' => array(
                        // 时间戳 转换 日期的格式，只支持 时间戳和此格式的数据判断
                        'dateFormat' => 'Y-m-d H:i:s',
                        // 对于dateTime类型 是否开启 datetimepicker 组件
                        'datetimepicker' => true,
                        // datetimepicker 的组件js css所在文件夹
                        'datetimepickerAssertPath' => '/vendor/datetimepicker',
                        // datetimepicker 的选项
                        'datetimepickerOption' => array(
                            'format' => "yyyy-mm-dd hh:ii:ss",
                            'autoclose' => true,
                            'todayBtn' => true,
                        )
                    )
                ),
        }
    }
    ?>
