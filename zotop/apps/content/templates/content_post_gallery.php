<table class="field">
	<tbody>
	<tr>
		<td class="label">{form::label(t('标题'),'title',true)}</td>
		<td class="input">
			{form::field(array('type'=>'title','name'=>'title','value'=>$data['title'],'required'=>'required'))}
		</td>
	</tr>

	<tr>
		<td class="label">{form::label(t('组图'),'gallery',true)}</td>
		<td class="input">
			<?php echo form::field(array(
				'type'		=> 'gallery',
				'name'		=> 'gallery',
				'value'		=> is_array($data['gallery']) ? $data['gallery'] : array(),
				'dataid'	=> $data['dataid'],
				'image_resize'	=> $model['settings']['image_resize'],
				'image_width'	=> $model['settings']['image_width'],
				'image_height'	=> $model['settings']['image_height'],
				'image_quality' => $model['settings']['image_quality'],
				'watermark' => $model['settings']['watermark'],

			));?>
		</td>
	</tr>

	<tr>
		<td class="label">{form::label(t('缩略图'),'thumb',true)}</td>
		<td class="input">
			<?php echo form::field(array(
				'type'		=> 'image',
				'name'		=> 'thumb',
				'value'		=> $data['thumb'],
				'dataid'	=> $data['dataid'],
				'image_resize'	=> c('content.thumb_resize'),
				'image_width'	=> c('content.thumb_width'),
				'image_height'	=> c('content.thumb_height'),
				'image_quality' => c('content.thumb_quality'),
				'watermark'	=>false,
			));?>
		</td>
	</tr>

	<tr>
		<td class="label">{form::label(t('关键词'),'keywords',false)}</td>
		<td class="input">
			{form::field(array('type'=>'keywords','name'=>'keywords','value'=>$data['keywords'], 'data-source'=>'content'))}
		</td>
	</tr>
	<tr>
		<td class="label">{form::label(t('摘要'),'summary',false)}</td>
		<td class="input">
			{form::field(array('type'=>'summary,textarea','name'=>'summary','value'=>$data['summary'],'maxlength'=>500))}
		</td>
	</tr>

	<tr>
		<td class="label">{form::label(t('推荐到区块'),'commend',false)}</td>
		<td class="input">
			{form::field(array('type'=>'blockcommend','name'=>'blockids','value'=>$data['blockids']))}
		</td>
	</tr>
		
	<tr>
		<td class="label">{form::label(t('URL别名'),'alias',false)}</td>
		<td class="input">
			{form::field(array('type'=>'alias','name'=>'alias','value'=>$data['alias'],'data-source'=>'title','remote'=>u('content/content/check/alias','ignore='.$data['alias'])))}
		</td>
	</tr>
	<tr class="none">
		<td class="label">{form::label(t('独立模板'),'template',false)}</td>
		<td class="input">
			{form::field(array('type'=>'template','name'=>'template','value'=>$data['template']))}
		</td>
	</tr>
	<tr>
		<td class="label">{form::label(t('发布时间'),'createtime',false)}</td>
		<td class="input">
			{form::field(array('type'=>'datetime','name'=>'createtime','value'=>$data['createtime']))}
		</td>
	</tr>
	</tbody>
</table>
