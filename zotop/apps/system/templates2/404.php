<!DOCTYPE html>
<html>
<head>
	<title>{$title} {t('逐涛网站管理系统')}</title>
	<meta content="none" name="robots" />
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="{A('system.url')}/common/css/global.css"/>
	<script type="text/javascript" src="{A('system.url')}/common/js/jquery.js"></script>
	<script type="text/javascript" src="{A('system.url')}/common/js/zotop.js"></script>
	<script type="text/javascript" src="{A('system.url')}/common/js/jquery.plugins.js"></script>
	<script type="text/javascript" src="{A('system.url')}/common/js/global.js"></script>
	<link rel="shortcut icon" type="image/x-icon" href="{A('system.url')}/zotop.ico" />
	<link rel="icon" type="image/x-icon" href="{A('system.url')}/zotop.ico" />
	<link rel="bookmark" type="image/x-icon" href="{A('system.url')}/zotop.ico" />
	<style type="text/css">
		.message{padding:30px;}
		.content{font-size:26px;margin-bottom:25px;}
		.jump{margin-top:20px;font-size:14px;color:#333;}
		.jump a{font-size:14px;}
		.detail {margin-top:20px;}
		.action {margin-left:1px;margin-top:20px;}
		.action a{margin-right:5px;font-size:14px;}
	</style>
</head>
<body>
	<div class="message error">
		<h1 class="content">{$content}</h1>
		<p class="action">
			<a href="javascript:history.go(-1)">{t('返回前页')}</a>
			<a href="javascript:location.reload();">{t('重试')}</a>
		</p>
	</div>
</body>
</html>