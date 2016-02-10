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
	<li class=active>订单</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<?php if($this->session->userdata('level') > 5): ?>
	<!--<a class="btn btn-primary" title="添加新订单" href="<?php echo base_url('order/create'); ?>">添加新订单</a>-->
	<?php endif;?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th>订单ID</th><th>状态</th>
				<?php if($this->session->userdata('level') > 7): ?><th>公司ID</th><?php endif;?>
				<?php if($this->session->userdata('level') > 6): ?><th>品牌ID</th><?php endif;?>
				<?php if($this->session->userdata('level') > 5): ?><th>门店/分公司ID</th><?php endif;?>
				<th>桌号</th><th>会员</th><th>产品</th><th>数量</th><th>订单额</th><th>操作员</th><th>创建时间</th><th>确认时间</th><th>取消时间</th><th>最后编辑时间</th><th>最后编辑人</th>
				<?php if($this->session->userdata('level') > 4): ?><th>操作</th><?php endif; ?>
			</tr>
		</thead>
		<tbody>
<?php foreach ($orders as $order_item): ?>
	<tr>
		<td><?php echo $order_item['order_id']; ?></td>
		<td><?php echo status($order_item['status']); ?></td>
		<?php if($this->session->userdata('level') > 7): ?><td><?php echo $order_item['biz_id']; ?></td><?php endif;?>
		<?php if($this->session->userdata('level') > 6): ?><td><?php echo $order_item['brand_id']; ?></td><?php endif;?>
		<?php if($this->session->userdata('level') > 5): ?><td><?php echo $order_item['branch_id']; ?></td><?php endif;?>
		<td><?php echo $order_item['seat_id']; ?></td>
		<td>ID <?php echo $order_item['user_id']; ?><br><a href="<?php echo base_url('user/'.$order_item['user_id']); ?>" target=_blank><?php echo $order_item['user_lastname'].$order_item['user_firstname']; ?></a></td>
		<td>ID <?php echo $order_item['product_id']; ?><br><a href="<?php echo base_url('product/'.$order_item['product_id']); ?>" target=_blank><?php echo $order_item['product_name']; ?></a></td>
		<td><?php echo $order_item['quantity']; ?></td>
		<td><?php echo $order_item['total']; ?></td>
		<td>ID <?php echo $order_item['stuff_id']; ?><br><a href="<?php echo base_url('stuff/'.$order_item['stuff_id']); ?>" target=_blank><?php echo $order_item['stuff_lastname'].$order_item['stuff_firstname']; ?></a></td>
		<td><?php echo $order_item['time_create']; ?></td>
		<td><?php echo $order_item['time_confirm']; ?></td>
		<td><?php echo $order_item['time_cancel']; ?></td>
		<td><?php echo $order_item['time_edit']; ?></td>
		<td><?php echo $order_item['operator_id']; ?></td>
		<?php if($this->session->userdata('level') > 4): ?>
		<td>
			<ul class=list-unstyled>
				<?php if($order_item['status'] == 1): ?>
				<li><a title="确认<?php echo $order_item['order_id']; ?>" href="<?php echo base_url('order/confirm/'.$order_item['order_id']); ?>"><span class="glyphicon glyphicon-ok"></span></a></li>
				<li><a title="取消<?php echo $order_item['order_id']; ?>" href="<?php echo base_url('order/cancel/'.$order_item['order_id']); ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
				<?php elseif($order_item['status'] == 3): ?>
				<li><a title="删除<?php echo $order_item['order_id']; ?>" href="<?php echo base_url('order/delete/'.$order_item['order_id']); ?>"><span class="glyphicon glyphicon-trash"></span></a></li>
				<?php endif; ?>
			</ul>
		</td>
		<?php endif; ?>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
</div>