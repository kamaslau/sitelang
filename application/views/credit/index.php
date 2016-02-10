<?php
	function action($action)
	{
		if($action == 1){return '+';}
		if($action == 2){return '换购 -';}
	}
	
	function type($type)
	{
		if($type == 1){return '注册';}
		if($type == 2){return '签到';}
		if($type == 3){return '消费';}
		if($type == 4){return '退回';}
	}
?>
<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li class=active>积分</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr><th>会员ID</th><th>类型</th><th>数额</th><th>时间</th><th>操作员工ID</th></tr>
		</thead>
		<tbody>
<?php foreach ($credits as $credit_item): ?>
	<tr>
		<td><a href="<?php echo base_url('user/'.$credit_item['user_id']); ?>" target=_blank><?php echo $credit_item['user_id']; ?></a></td>
	    <td><?php echo type($credit_item['type']).action($credit_item['action']); ?></td>
		<td><?php echo $credit_item['amount']; ?></td>
		<td><?php echo $credit_item['time_create']; ?></td>
		<td><a href="<?php echo base_url('stuff/'.$credit_item['stuff_id']); ?>" target=_blank><?php echo $credit_item['stuff_id']; ?></a></td>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
</div>