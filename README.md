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

1、在view中输入所有的Form元素(默认表单)

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
                
                $this->setAttribute('class', 'form-inline');
                
                // ....
            }
        }
    ?>
    
    // Application/view/application/index/index.phtml
    <?php
        echo $this->form($form);
    ?>





