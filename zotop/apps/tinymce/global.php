<?php
//注册类库
zotop::register('tinymce_field',ZOTOP_PATH_APPS.DS.'tinymce'.DS.'libraries'.DS.'tinymce_field.php');

/**
 * 注册控件
 *
 * @param $attrs array 控件参数
 * @return string 控件代码
 */
form::field('editor',array('tinymce_field','editor'));
form::field('tinymce',array('tinymce_field','editor'));

zotop::add('tinymce.attrs',array('tinymce_field','init'));
zotop::add('tinymce.attrs',array('tinymce_field','tools'));
zotop::add('tinymce.attrs',array('tinymce_field','basic'));
zotop::add('tinymce.attrs',array('tinymce_field','standard'));
zotop::add('tinymce.attrs',array('tinymce_field','full'));
?>