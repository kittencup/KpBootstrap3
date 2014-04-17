KpBootstrap3
============
版本 0.0.1

介绍
------

使用Twitter Bootstrap 3 的样式输出Form组建

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
        namespace KpUser\Form;
    
        class IndexForm extends UserForm
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
        namespace KpUser\Form;
    
        class IndexForm extends UserForm
        {
            public function __construct()
            {
                parent :: __construct('index');
                
                // 设置form的class
                $this->setAttribute('class', 'form-horizontal');
                
                // 对Label的类进行设置
                $this->setAttribute('horizontalLabelClass', 'col-sm-5')
                
                // 对表单Layout的类进行设置
                $this->setAttribute('horizontalInputWrapClass', 'col-sm-5')
                
                // ....
            }
        }
    ?>
    
    // Application/view/application/index/index.phtml
    <?php
        echo $this->form($form);
    ?>

