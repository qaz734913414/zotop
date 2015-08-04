<?php
defined('ZOTOP') OR die('No direct access allowed.');
defined('ZOTOP_UNINSTALL') OR die('No direct access allowed.');

/**
 * 卸载程序
 *
 * @package		system
 * @author		zotop team
 * @copyright	(c)2009 zotop team
 * @license		http://zotop.com/license.html
 */
$models = $this->db->from('user_model')->where('app','member')->getall();

// 卸载前检查数据表是否有数据，有则不允许删除
foreach($models as $model)
{
	if ( $this->db->from($model['tablename'])->count() ) return $this->error(t('无法卸载，[ %s ] 数据表尚有数据', $model['name'].'-'.$model['tablename']));
}

// 删除相关数据
foreach($models as $model)
{
	// 删除模型表

	$this->db->schema($model['tablename'])->drop();

	// 删除用户及用户组中的相关数据
	$this->db->from('user')->where('modelid',$model['id'])->delete();
	$this->db->from('user_model')->where('id',$model['id'])->delete();
	$this->db->from('user_group')->where('modelid',$model['id'])->delete();
	$this->db->from('user_field')->where('modelid',$model['id'])->delete();
}
?>