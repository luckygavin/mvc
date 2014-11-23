<?php
/**
 * ActiveRecord
 */
class Criteria{
	public $condition=array(); //查询条件,where子句的东西
	public $select="*"; 	//代表了要查询的字段，默认select='*';
	public $limit;		//取几条数据，如果小于0，则不作处理
	public $offset;	//与limit合并起来，则表示:limit 10 offset 1,或者代表了:limit 1,10
	public $order;		//排序条件 
	public $distinct=false;	//是否唯一查询
	public $group;
	public $having;

	public function addCondition($condition){
		$condition[] = $condition;
	}

	
}
?>