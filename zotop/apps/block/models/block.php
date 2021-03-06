<?php
defined('ZOTOP') OR die('No direct access allowed.');
/**
 * block_model
 *
 * @package		system
 * @author		zotop team
 * @copyright	(c)2009-2011 zotop team
 * @license		http://zotop.com/license.html
 */
class block_model_block extends model
{
	protected $pk = 'id';
	protected $table = 'block';

	/**
	 * 区块类型，当类型参数不为空时，返回类型名称
	 * 
	 * @param  string $type [description]
	 * @return [type]       [description]
	 */
	public function types($type='')
	{
		$types = array(
			'list'	=> t('列表'),
			//'hand'	=> t('手动'),
			'html'	=> t('内容'),
			'text'	=> t('文本'),
		);

		return $type ? $types[$type] : $types;
	}



	/**
	 *	列表中可以使用的字段 
	 *
	 * @param  array $fields 数据库中存储的字段集合,或者要显示的字段（用逗号隔开）
	 * @return array 返回当前字段结合
	 */
	public function fieldlist($fields='')
	{
		$fieldlist = array(
			'title'			=> array('show'=>1,'label'=>t('标题'),'type'=>'title','name'=>'title','minlength'=>1,'maxlength'=>50, 'required'=>'required'),
			'url'			=> array('show'=>0,'label'=>t('链接'),'type'=>'link','name'=>'url','required'=>'required'),
			'image'			=> array('show'=>0,'label'=>t('图片'),'type'=>'image','name'=>'image','required'=>'required','image_resize'=>1,'image_width'=>'','image_height'=>'','watermark'=>0),
			'description'	=> array('show'=>0,'label'=>t('摘要'),'type'=>'textarea','name'=>'description','required'=>'required','minlength'=>0,'maxlength'=>255),
			'time'			=> array('show'=>0,'label'=>t('日期'),'type'=>'datetime','name'=>'time','required'=>'required'),
		);
		
		// 直接返回全部
		if ( empty($fields) ) return $fieldlist;

		// 返回合并的数据
		if ( is_array($fields) ) return array_merge($fieldlist, $fields);

		// 显示的必填字段
		if ( $fields = explode(',', $fields) )
		{
			foreach ($fieldlist as $k=>$f)
			{
				$fieldlist[$k]['show'] = 1; 

				if ( !in_array($k, $fields) )
				{
					unset($fieldlist[$k]);
				}
			}			
		}

		return $fieldlist;
	}

	/**
	 * 列表允许选择的字段类型，当类型参数不为空时，返回类型名称
	 * 
	 * @param  string $type 类型
	 * @return mixed
	 */
	public function fieldtypes($type='')
	{
		$fieldtypes = zotop::filter('block.fieldtypes',array(
			'text'		=>	t('单行文本'),
			'textarea'	=>	t('多行文本'),
			'number'	=>	t('数字'),
			'url'		=>	t('网址'),
			'link'		=>	t('链接'),
			'image'		=>	t('图像'),
			'file'		=>	t('文件'),
			'date'		=>	t('日期'),
			'datetime'	=>	t('日期时间'),
			'editor'	=>	t('编辑器'),
		));

		return $type ? $fieldtypes[$type] : $fieldtypes;
	}	

    /**
     * 获取
     *
     */
	public function get($id, $field='')
	{
		$data = $this->getbyid($id);

		if ( $data )
		{
			if ( in_array($data['type'], array('list','hand')) )
			{
				$data['data'] 	= unserialize($data['data']);
				$data['data'] 	= is_array($data['data']) ? $data['data'] : array();
				$data['fields'] = unserialize($data['fields']);
			}

			$data['dataid'] = 'block-'.$id;
		}

		return $field ? $data[$field] : $data;
	}

    /**
     * 插入
     *
     */
	public function add($data)
	{
		$data['createtime'] = ZOTOP_TIME;
		$data['updatetime'] = ZOTOP_TIME;
		$data['userid'] 	= zotop::user('id');
		$data['listorder'] 	= $data['listorder'] ? $data['listorder'] : $this->max('listorder') + 1; // 默认排在后面

		if ( $data['fields'] )
		{
			foreach ($data['fields'] as $k => $f)
			{
				if ( !$f['show'] ) unset($data['fields'][$k]);
			}
		}		

		if ( $id = $this->insert($data) )
		{
			return $id;
		}

		return false;
	}

    /**
     * 编辑
     *
     */
	public function edit($data, $id)
	{
		if ( empty($data['name']) ) return $this->error(t('区块名称不能为空'));

		$data['updatetime'] = ZOTOP_TIME ;

		if ( $data['fields'] )
		{
			foreach ($data['fields'] as $k => $f)
			{
				if ( !$f['show'] ) unset($data['fields'][$k]);
			}
		}			

		if ( $this->where('id',$id)->data($data)->update() )
		{
			$this->clearcache($id);

			return $id;
		}

		return false;
	}

    /**
     * 更新数据
     *
     */
	public function savedata($data, $id)
	{
		if ( $this->where('id',$id)->data('data',$data)->data('updatetime',ZOTOP_TIME)->update() )
		{
			$this->clearcache($id);
			return $id;
		}

		return false;
	}

	/**
	 * 清空缓存数据
	 *
	 * @param string $id ID
	 * @return bool
	 */
	public function clearcache($id='')
	{
		// 删除全部区块缓存
		if ( empty($id) ) 
		{
			return folder::clear(BLOCK_PATH_CACHE);
		}

		// 删除多个区块缓存
		if ( is_array($id) )
		{
			return array_map(array($this,'clearcache'), $id);
		}

		// 删除指定区块缓存
		file::delete(BLOCK_PATH_CACHE.DS."{$id}.html");
		return true;
	}


	/**
	 * 根据区块的编号发布区块
	 *
	 * @param string $id 区块编号
	 * @param object $tpl 模板对象
	 * @return bool
	 */
	public function publish($attrs, $tpl)
	{	
		$block = $this->get($attrs['id']);

		// 自动创建区块
		if ( empty($block) and is_array($attrs) )
		{
			$block               = $attrs;
			$block['categoryid'] = empty($block['categoryid']) ?  1 : $block['categoryid'];
			$block['type']       = empty($block['type']) ?  'list' : $block['type'];
			$block['template']   = empty($block['template']) ? "block/{$block['type']}.php" : $block['template'];
			$block['fields']     = empty($block['fields']) ? $this->fieldlist('title,url') : $this->fieldlist($block['fields']);
			$block['listorder']  = empty($block['listorder']) ?  $block['id'] : $block['listorder'];
			$block['data']       = in_array($block['type'],array('list','hand')) ? array() : '';


			if ( !$this->add($block) )
			{
				return $this->error();
			}
		}

		if ( is_array($block['data']) )
		{
			foreach($block['data'] as &$d)
			{
				$d['url']   = U($d['url']);
				$d['style'] = $d['style'] ? 'style="'.$d['style'].'"' : '';
			}
		}

		$content = $tpl->assign($block)->render($block['template']);	

		file::put(BLOCK_PATH_CACHE.DS."{$attrs['id']}.html", $content);

		return $content;
	}

	/**
     * 获取排序过的全部数据
     *
     */
	public function select()
	{
		return $this->db()->orderby('listorder','asc')->select();
	}

	/**
	 * 根据传入的编号顺序排序
	 *
	 * @param string $id ID
	 * @return bool
	 */
	public function order($ids)
	{
		foreach( (array)$ids as $i=>$id )
		{
			$this->update(array('listorder' => $i+1), $id);
		}

		return true;
	}

	/**
	 * 删除区块
	 *
	 * @param string $id ID
	 * @return bool
	 */
	public function delete($id)
	{
		if ( $block = $this->getbyid($id) )
		{
			//删除区块的时候同时删除全部数据
			if ( in_array($block['type'], array('list','hand')) )
			{
				m('block.datalist')->db()->where('blockid',$id)->delete();
			}

			if ( parent::delete($id) )
			{
				$this->clearcache($id);
				return true;
			}

			return false;
		}

		return $this->error(t('编号为 %s 的数据不存在', $id));
	}
}
?>