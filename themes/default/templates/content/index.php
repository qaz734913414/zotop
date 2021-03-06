{template 'header.php'}

{if m('content.category.get',$category.rootid, 'childid')}
<nav class="nav nav-inline">
	<ul>
		<li><a href="{m('content.category.get',$category.rootid, 'url')}" {if $category.rootid==$category.id}class="active"{/if}>{t('全部')}</a></li>
		{content action="category" cid="$category.rootid"}
		<li><a href="{$r.url}" {if $r.id==$category.id}class="active"{/if}>{$r.name}</a></li>
		{/content}
	</ul>
</nav>
{else}
<div class="blank"></div>
{/if}

<div class="container">
{content action="category" cid="$category.id" return="c"}
	<div class="panel panel-default">
		<div class="panel-heading">			
			<div class="panel-action"><a class="more" href="{$c.url}">{t('更多')} <i class="fa fa-angle-right"></i></a></div>
			<div class="panel-title">{$c.name}</div>
		</div>

		{content cid="$c.id" size="1" image="true"}
		<div class="media media-sm">
			<a href="{$r.url}" title="{$r.title}">
				<div class="media-left"><img src="{$r.image width="400" height="300"}" alt="{$r.title}" class="media-object"/></div>
				<div class="media-body">
					<div class="media-heading">
						<span class="pull-right text-muted hidden-xs">{$r.createtime date="date"}</span>
						<h4 {$r.style}>{$r.title} {$r.new}</h4>
					</div>
					<div class="media-summary hidden-xs">{$r.summary length="200"}</div>
				</div>
			</a>
		</div>
		{/content}

		<ul class="list-group">
			{content cid="$c.id" size="8" ignore="$r.id"}
			<li class="list-group-item text-overflow">
				<span class="pull-right text-muted hidden-xs">{$r.createtime date="date"}</span>
				<a href="{$r.url}" title="{$r.title}" {$r.style}>{$r.title}</a>{$r.new}
			</li>
			{empty}
			<li class="list-group-item"><div class="nodata">{t('暂无数据')}</div></li>
			{/content}
		</ul>
	</div><!-- panel -->
{/content}
</div>

{template 'footer.php'}