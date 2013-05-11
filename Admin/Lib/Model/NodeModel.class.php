<?php
class NodeModel extends Model {
	protected $tableName = 'node';
	
	public function getNodeByMap($map = array(), $order = '', $limit = 30) {
		return $this->where($map)->order($order)->findPage($limit);
	}
	
	public function getAllNode($order = 'app_name ASC, mod_name ASC, act_name ASC, node_id ASC', $limit = 30) {
		$res		= $this->getNodeByMap(array(), $order, $limit);
		$all_node 	= array();
		$sub_node 	= array();
		foreach ($res['data'] as $v) {
			if ($v['parent_node_id'] == '0')
				$all_node[] = $v;
			else
				$sub_node[$v['parent_node_id']][] = $v;
		}
		
		foreach ($all_node as $k => $v) {
			if ( isset($sub_node[ $v['node_id'] ]) )
				$all_node[$k]['sub_node'] = $sub_node[ $v['node_id'] ];
		}
		$res['data']	= $all_node;
		return $res;
	}
	
	public function getNodeDetailById($node_id, $show_sub = true) {
		if ($show_sub) {
			$res  = $this->where("`node_id`=$node_id OR `parent_node_id`=$node_id")->order('parent_node_id ASC')->findAll();
			foreach ($res as $v) {
				if ($v['parent_node_id'] == '0')
					$node = $v;
				else 
					$node['sub_node'][] = $v;
			}
		}else {
			$node = $this->where("`node_id`=$node_id")->find();
		}
		return $node;
	}
	
	public function deleteNode($node_ids) {
		//防误操作
		if (empty($node_ids)) return false;
		
		if( is_array($node_ids) ) $node_ids = implode(',', $node_ids);
		$where = "node_id in (".$node_ids.") or parent_node_id in (".$node_ids.")";
		return $this->where($where)->delete();
	}
	
	public function isNodeEmpty($node_ids) {
		return true;
	}
}