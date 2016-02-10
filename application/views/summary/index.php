<?php
	function status($status)
	{
		switch($status)
		{
			case 1:
			  return '待确认';
			  break;
			case 2:
			  return '已确认';
			  break;
			case 3:
			  return '已取消';
			  break;
  			case 4:
  			  return '已删除';
  			  break;
			default:
			  return '未获取订单状态';
		}
	}
?>
<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li class=active>消费记录</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<?php if($this->session->userdata('level') > 5): ?>
	<a class="btn btn-primary" title="添加新消费记录" href="<?php echo base_url('summary/create'); ?>">添加新消费记录</a>
	<?php endif;?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th>消费记录ID</th>
				<th>状态</th>
				<?php if($this->session->userdata('level') > 7): ?><th>公司ID</th><?php endif;?>
				<?php if($this->session->userdata('level') > 6): ?><th>品牌ID</th><?php endif;?>
				<?php if($this->session->userdata('level') > 5): ?><th>门店/分公司ID</th><?php endif;?>
				<th>桌号</th><th>流水号</th><th>会员ID</th><th>金额</th><th>备注</th><th>操作员</th><th>创建时间</th><th>确认时间</th><th>取消时间</th><th>最后编辑时间</th><th>最后编辑人</th>
				<?php if($this->session->userdata('level') > 5): ?><th>操作</th><?php endif;?>
			</tr>
		</thead>
		<tbody>
<?php foreach ($summarys as $summary_item): ?>
	<tr>
		<td><?php echo $summary_item['summary_id']; ?></td>
		<td><?php echo status($summary_item['status']); ?></td>
		<?php if($this->session->userdata('level') > 7): ?><td><?php echo $summary_item['biz_id']; ?></td><?php endif;?>
		<?php if($this->session->userdata('level') > 6): ?><td><?php echo $summary_item['brand_id']; ?></td><?php endif;?>
		<?php if($this->session->userdata('level') > 5): ?><td><?php echo $summary_item['branch_id']; ?></td><?php endif;?>
		<td><?php echo $summary_item['seat_id']; ?></td>
		<td><?php echo (!isset($summary_item['serial_id']))?'未绑定':$summary_item['serial_id']; ?></td>
		<td>ID <?php echo $summary_item['user_id']; ?><br><a href="<?php echo base_url('user/'.$summary_item['user_id']); ?>" target=_blank><?php echo $summary_item['user_lastname'].$summary_item['user_firstname']; ?></a></td>
		<td><?php echo $summary_item['amount']; ?></td>
		<td><?php echo $summary_item['note']; ?></td>
		<td>ID <?php echo $summary_item['stuff_id']; ?><br><a href="<?php echo base_url('stuff/'.$summary_item['stuff_id']); ?>" target=_blank><?php echo $summary_item['stuff_lastname'].$summary_item['stuff_firstname']; ?></a></td>
		<td><?php echo $summary_item['time_create']; ?></td>
		<td><?php echo $summary_item['time_confirm']; ?></td>
		<td><?php echo $summary_item['time_cancel']; ?></td>
		<td><?php echo $summary_item['time_edit']; ?></td>
		<td><?php echo $summary_item['operator_id']; ?></td>
		<?php if($this->session->userdata('level') > 8): ?>
		<td>
			<ul class=list-unstyled>
				<?php if($summary_item['status'] == 1): ?>
				<li><a title="确认<?php echo $summary_item['summary_id']; ?>" href="<?php echo base_url('summary/confirm/'.$summary_item['summary_id']); ?>"><span class="glyphicon glyphicon-ok"></span></a></li>
				<li><a title="取消<?php echo $summary_item['summary_id']; ?>" href="<?php echo base_url('summary/cancel/'.$summary_item['summary_id']); ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
				<?php elseif($summary_item['status'] == 3): ?>
				<li><a title="删除<?php echo $summary_item['summary_id']; ?>" href="<?php echo base_url('summary/delete/'.$summary_item['summary_id']); ?>"><span class="glyphicon glyphicon-trash"></span></a></li>
				<?php endif; ?>
			</ul>
		</td>
		<?php endif; ?>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
</div>