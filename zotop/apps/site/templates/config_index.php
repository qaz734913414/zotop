{template 'header.php'}

{template 'site/admin_side.php'}

<div class="main side-main">
	<div class="main-header">
		<div class="title">{$title}</div>
	</div><!-- main-header -->
	{form class="form-horizontal"}
	<div class="main-body scrollable">
		
		<div class="container-fluid">
			<div class="form-group">
				<div class="col-sm-2 control-label">{form::label(t('网站名称'),'name',true)}</div>
				<div class="col-sm-8">
					{form::field(array('type'=>'text','name'=>'name','value'=>c('site.name'),'required'=>'required'))}
					{form::tips(t('当前网站的名称，如<b>逐涛网</b>'))}
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2 control-label">{form::label(t('网站网址'),'url',true)}</div>
				<div class="col-sm-8">
					{form::field(array('type'=>'url','name'=>'url','value'=>c('site.url'),'required'=>'required'))}
					{form::tips(t('当前网站的网址，格式为：<b>http://www.zotop.com</b>'))}
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2 control-label">{form::label(t('网站主题'),'theme',true)}</div>
				<div class="col-sm-10">
					<ul class="themelist clearfix">
					{loop $themes $id $theme}
						<li {if c('site.theme')== $id}class="selected"{/if} title="{$theme['description']}">
							<label>
							<i class="fa fa-check"></i>
							<div class="image"><img src="{$theme['image']}"/></div>
							<div class="title text-overflow">
								<input type="radio" name="theme" value="{$id}" {if c('site.theme')== $id}checked="checked"{/if}/>
								&nbsp;{$theme['name']}
							</div>
							</label>
						</li>
					{/loop}
					</ul>
					<div class="help-block">
						{t('选择主题后，网站将以该主题和模板显示')} <a href="{u('system/theme')}">{t('更多主题，请进入主题和模板管理')}</a>
					</div>					
				</div>
			</div>

			<div class="form-group">
				<label for="weixin" class="col-sm-2 control-label">{t('站点LOGO')}</label>
				<div class="col-sm-8">
					{field type="image" name="logo" value="c('site.logo')"}
					<div class="help-block">{t('网站logo图片，推荐使用PNG格式图片')}</div>
				</div>
			</div>

			<div class="form-group">
				<label for="weixin" class="col-sm-2 control-label">{t('站点Favicon')}</label>
				<div class="col-sm-8">
					{field type="image" name="favicon" value="c('site.favicon')"}
					<div class="help-block">{t('收藏夹和浏览器地址栏左侧显示的小图标，宽高：16px*16px或32px*32px，格式：ico或png')}</div>
				</div>
			</div>							

			<div class="form-group">
				<div class="col-sm-2 control-label">{form::label(t('站点标语'),'url',false)}</div>
				<div class="col-sm-8">
					{form::field(array('type'=>'text','name'=>'slogan','value'=>c('site.slogan')))}
					<div class="help-block">{t('如：简洁、强大的企业网站系统')}</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-2 control-label">{form::label(t('版权信息'),'copyright',false)}</div>
				<div class="col-sm-8">
					{form::field(array('type'=>'text','name'=>'copyright','value'=>c('site.copyright')))}
					<div class="help-block">{t('如：Copyright©2013-$1 All Rights Reserved $2 版权所有',date('Y'),C('site.name'))}</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-2 control-label">{form::label(t('备案号'),'beian',false)}</div>
				<div class="col-sm-8">
					{form::field(array('type'=>'text','name'=>'beian','value'=>c('site.beian')))}
					<div class="help-block">{t('如果网站已经在工信部备案请输入备案号，如：京ICP备XXXXXX号')}</div>
				</div>
			</div>										

		</div>
	</div><!-- main-body -->
	<div class="main-footer">
		{form::field(array('type'=>'submit','value'=>t('保存')))}
	</div><!-- main-footer -->
	{form}

</div><!-- main -->

<style type="text/css">
.themelist{margin:0 0 -30px 0;zoom:1;padding:0}
.themelist li{position:relative;float:left;width:280px;overflow:hidden;margin:10px 20px 10px 0;background-color:#fff;padding:4px 4px 0 4px;border:3px solid #ebebeb;border-radius:4px;overflow:hidden;}
.themelist li:hover{border:3px solid #d5d5d5;}
.themelist li .image{width:100%;height:180px;line-height:0;overflow:hidden;cursor:pointer;}
.themelist li .image img{width:100%;}
.themelist li .title{padding:5px 0;height:30px;line-height:30px;overflow:hidden;font-size:16px;font-weight:normal;cursor:pointer;}
.themelist li .fa{position:absolute;top:4px;right:4px;display:none;z-index:2;color:#fff;font-size:16px;}
.themelist li input{display:none;}
.themelist li.selected {border:3px solid #66bb00;}
.themelist li.selected:after{width:0;height:0;border-top:40px solid #66bb00;border-left:40px solid transparent;position:absolute;display:block;right:0;content:"";top:0;z-index:1;}
.themelist li.selected .fa{display:block;}
</style>

<script type="text/javascript">
	$(function(){
		$('form.form').validate({submitHandler:function(form){
			var action = $(form).attr('action');
			var data = $(form).serialize();
			$(form).find('.submit').button('loading');
			$.post(action, data, function(msg){
				$.msg(msg);
				msg.state && location.reload();
			},'json');
		}});
	});

	$(function(){
		$('.themelist li').on('click',function(){
			$(this).addClass('selected').siblings("li").removeClass('selected'); //单选
		})
	})	
</script>
{template 'footer.php'}