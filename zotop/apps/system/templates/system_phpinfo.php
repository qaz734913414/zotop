{template 'head.php'}

<div class="main">
	<div class="main-header">
		<a class="goback" href="javascript:history.go(-1);"><i class="fa fa-angle-left"></i>{t('返回')}</a>
		<div class="title">{$title}</div>
	</div>
	<div class="main-body scrollable">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
				{$phpinfo}
				</div>
			</div>			
		</div>
	</div>
	<div class="main-footer">
		<div class="footer-text">{t('服务器信息')}</div>
	</div>
</div>

{template 'foot.php'}