<?php
defined('ZOTOP') OR die('No direct access allowed.');
/**
 * 系统控制器操作类
 *
 * @package		zotop
 * @author		zotop team
 * @copyright	(c)2009 zotop team
 * @license		http://zotop.com/license.html
 */
class site_controller extends controller
{
    /**
     * 动作执行之前执行
     *
     */
    public function __init()
    {
		parent::__init();

		// 网站关闭后，后台和管理员可以继续访问网站
		if ( c('site.closed') and zotop::user('modelid') != 'admin' ) exit(c('site.closedreason'));

		// 开启主题模式
		define('ZOTOP_SITE',true);
		define('ZOTOP_THEME',C('site.theme'));

		// 加载主题的配置文件
		if ( file_exists(ZOTOP_PATH_THEMES.DS.ZOTOP_THEME.DS.'theme.php') )
		{
			C('theme', @include(ZOTOP_PATH_THEMES.DS.ZOTOP_THEME.DS.'theme.php'));
		}		

		// 加载主题的全局文件
		if ( file_exists(ZOTOP_PATH_THEMES.DS.ZOTOP_THEME.DS.'global.php') )
		{
			zotop::load(ZOTOP_PATH_THEMES.DS.ZOTOP_THEME.DS.'global.php');
		}

		// 初始化全局数据
		$this->assign('_USER',zotop::user());

		// hook
		zotop::run('site.init', $this);
    }
}
?>