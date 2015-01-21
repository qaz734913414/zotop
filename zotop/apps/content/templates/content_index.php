{template 'header.php'}
<div class="side">
{template 'content/admin_side.php'}
</div>

<div class="main side-main">
	<div class="main-header">

		<div class="title">
		{if $keywords} {t('搜索 "%s"',$keywords)} {elseif $categoryid}	{$category['name']}	{else} {t('内容管理')} {/if}
		</div>

		{if !$keywords}
		<ul class="navbar">
			{loop $statuses $s $t}
			<li{if $status == $s} class="current"{/if}>
				<a href="{u('content/content/index/'.$categoryid.'/'.$s)}">{$t}</a>
				{if $statuscount[$s]}<span class="f12 red">({$statuscount[$s]})</span>{/if}
			</li>
			{/loop}
		</ul>
		{/if}

		<form action="{u('content/content/index')}" method="post" class="searchbar">
			{if $keywords}
			<input type="text" name="keywords" value="{$keywords}" placeholder="{t('请输入关键词')}" style="width:200px;" x-webkit-speech/>
			{else}
			<input type="text" name="keywords" value="{$keywords}" placeholder="{t('请输入关键词')}" x-webkit-speech/>
			{/if}
			<button type="submit"><i class="icon icon-search"></i></button>
		</form>

		<div class="action">

			{if count($postmodels) < 2}

				{loop $postmodels $i $m}
					<a class="btn btn-highlight btn-icon-text" href="{u('content/content/add/'.$categoryid.'/'.$m['id'])}" title="{$m['description']}">
						<i class="icon icon-add"></i><b>{$m['name']}</b>
					</a>
				{/loop}

			{else}
			<div class="menu btn-menu">
				<a class="btn btn-highlight btn-icon-text" href="javascript:void(0);"><i class="icon icon-add"></i><b>{t('添加')}</b><b class="arrow"></b></a>
				<div class="dropmenu">
					<div class="dropmenulist">
						{loop $postmodels $i $m}
							<a href="{u('content/content/add/'.$categoryid.'/'.$m['id'])}" data-placement="right" title="{$m['description']}"><i class="icon icon-item icon-{$m['id']}"></i>{$m['name']}</a>
						{/loop}
					</div>
				</div>
			</div>
			{/if}

			{if $categoryid}
			<a class="btn btn-icon-text" href="{u($category['url'])}" target="_blank" title="{t('访问栏目')}">
				<i class="icon icon-open"></i><b>{t('访问')}</b>
			</a>
			{/if}
		</div>

	</div><!-- main-header -->

	<div class="main-body scrollable">
		
		{if empty($data)}		
			<div class="nodata">{t('暂时没有任何数据')}</div>
		{else}

		{form::header()}
		<table class="table list sortable" id="datalist" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
			<td class="drag"></td>
			<td class="select"><input type="checkbox" class="checkbox select-all"></td>
			{if $keywords}
			<td class="w40 center">{t('状态')}</td>
			{/if}
			<td>{t('标题')}</td>
			<td class="w60 center">{t('权重')}</td>
			<td class="w60 center">{t('点击')}</td>
			<td class="w60">{t('模型')}</td>
			<td class="w80">{t('栏目')}</td>
			<td class="w120">{t('发布者/发布时间')}</td>
			</tr>
		</thead>
		<tbody>

		{loop $data $r}
			<tr data-listorder="{$r.listorder}" data-stick="{$r.stick}" data-id="{$r.id}">
				<td class="drag"></td>
				<td class="select"><input type="checkbox" class="checkbox" name="id[]" value="{$r['id']}"></td>
				{if $keywords}
				<td class="center"><i class="icon icon-{$r['status']} {$r['status']}" title="{$statuses[$r['status']]}"></i></td>
				{/if}
				<td>
					<div class="title textflow" {if $r['style']}style="{$r['style']}"{/if}>
					{$r['title']}
					{if $r['image']}<i class="icon icon-image green" data-src="{$r['image']}"></i>{/if}
					{if $r.stick}<i class="icon icon-up yellow" title="{t('置顶')}"></i>{/if}
					</div>
					<div class="manage">
						<a href="{$r['url']}" target="_blank">{t('访问')}</a>
						<s></s>

						<a href="{u('content/content/edit/'.$r['id'])}">{t('编辑')}</a>
						<s></s>
						{if $r.stick}
						<a href="{u('content/content/stick/'.$r['id'].'/0')}" class="ajax-post">{t('取消置顶')}</a>
						{else}
						<a href="{u('content/content/stick/'.$r['id'].'/1')}" class="ajax-post">{t('置顶')}</a>
						{/if}
						<s></s>

						{loop zotop::filter('content.manage',array(),$r) $m}
						<a href="{$m['href']}" {$m['attr']}>{$m['text']}</a>
						<s></s>
						{/loop}

						<a class="dialog-confirm" href="{u('content/content/delete/'.$r['id'])}">{t('删除')}</a>
					</div>
				</td>
				<td class="center">
					<a class="dialog-prompt" data-value="{$r['weight']}" data-prompt="{t('请输入权重[0-99]')}" href="{u('content/content/set/weight/'.$r['id'])}" title="{t('设置权重')}">
						<span class="{if $r['weight']}red{else}gray{/if}">{$r['weight']}</span>
					</a>
				</td>				
				<td class="center">{$r['hits']}</td>
				<td><div class="textflow">{$models[$r['modelid']]['name']}</div></td>
				<td><div class="textflow">{$categorys[$r['categoryid']]['name']}</div></td>
				<td>
					<div class="userinfo" role="{$r.userid}">{m('system.user.get', $r.userid, 'username')}</div>
					<div class="f12 time">{format::date($r['createtime'])}</div>
				</td>
			</tr>
		{/loop}
		
		</tbody>
		</table>
		{form::footer()}

		{/if}
	</div><!-- main-body -->
	<div class="main-footer">
		{if empty($data)}

		{else}
			<div class="pagination">{pagination::instance($total,$pagesize,$page)}</div>

			<input type="checkbox" class="checkbox select-all middle">

			{loop $statuses $s $t}
				{if $status != $s}
				<a class="btn operate" href="{u('content/content/operate/'.$s)}" rel="{$s}">{$t}</a>
				{/if}
			{/loop}

			<a class="btn operate" href="{u('content/content/operate/weight')}" rel="weight">{t('权重')}</a>
			<a class="btn operate" href="{u('content/content/operate/move')}" rel="move">{t('移动')}</a>
			<a class="btn operate" href="{u('content/content/operate/delete')}" rel="delete">{t('删除')}</a>
		{/if}

	</div><!-- main-footer -->

</div><!-- main -->

<script type="text/javascript">
$(function(){
	var tablelist = $('#datalist').data('tablelist');

	//底部全选
	$('input.select-all').on('click',function(e){
		tablelist.selectAll(this.checked);
	});

	//操作
	$("a.operate").each(function(){
		$(this).on("click", function(event){ event.preventDefault();

			if( tablelist.checked() == 0 ){
				$.error('{t('请选择要操作的项')}');
				return false;
			}

			var rel = $(this).attr('rel');
			var href = $(this).attr('href');
			var text = $(this).text();
			var data = $('form').serializeArray();

			if ( rel == 'move' ) {

				var $dialog = $.dialog({
					title:text,
					url:"{u('content/category/select/'.$categoryid)}",
					width:400,
					height:300,
					ok:function(categoryid){
						if ( categoryid ){
							data.push({name:'categoryid',value:categoryid});
							$.loading();
							$.post(href,$.param(data),function(msg){
								if( msg.state ){
									$dialog.close();
								}
								$.msg(msg);
							},'json');
						}
						return false;
					},
					cancel:function(){}
				},true);

			}else if( rel == 'weight' ){

				var $dialog = $.prompt('{t('请输入权重[0-99],权重越大越靠前')}', function(newvalue){

					data.push({name:'weight',value:newvalue});

					$.loading();
					$.post(href, $.param(data), function(msg){
						if( msg.state ){
							$dialog.close();
						}
						$.msg(msg);
					},'json');

					return false;

				}, '0').title(text);

			}else{
				$.loading();
				$.post(href,$.param(data),function(msg){
					$.msg(msg);
				},'json');
			}

			return true;
		});

	});
});

$(function(){
	$('.icon-image').tooltip({placement:'auto bottom',container:'body',html:true,title:function(){
		return '<p style="margin-bottom:8px;font-size:14px;">{t('缩略图')}</p><img src="'+$(this).attr('data-src')+'" style="max-width:300px;max-height:200px;"/>';
	}});
});

// 排序
$(function(){
	var dragstop = function(evt,ui,tr){
		
		var oldindex = tr.data('originalIndex');
		var newindex = tr.prop('rowIndex');
		
		if(oldindex == newindex){return;}

		var id = tr.data('id');
		var target = ui.item.siblings('tr').eq(newindex-1);//要排到这一行之前

		var neworder = target.data('listorder') + 1;
		var newstick = newindex > oldindex ?  tr.data('stick') : target.data('stick');

		$.loading();
		$.post('{u('content/content/listorder')}',{id:tr.data('id'),listorder:neworder,stick:newstick},function(data){
			$.msg(data);
		},'json');		
	};	

	$("table.sortable").sortable({
		items: "tbody > tr",
		axis: "y",
		placeholder:"ui-sortable-placeholder",
		helper: function(e,tr){
			tr.children().each(function(){
				$(this).width($(this).width());
			});
			return tr;
		},
		start:function (event,ui) {
			ui.item.data('originalIndex', ui.item[0].rowIndex);
		},		
		stop:function(event,ui){
			dragstop.apply(this, Array.prototype.slice.call(arguments).concat(ui.item));
		}
	});
});
</script>
{template 'footer.php'}