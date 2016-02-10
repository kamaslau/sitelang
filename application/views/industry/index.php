<?php
	//显示权限名称
	function status($status)
	{
		switch($status)
		{
			case 0:
			  return '待开通';
			  break;
			case 1:
			  return '已开通';
			  break;
			case 2:
			  return '待关闭';
			  break;
			case 3:
			  return '已关闭';
			  break;
			default:
			  return '不明状态';
		}
	}
?>
<ol class=breadcrumb>
	<li><a href="<?php echo base_url(); ?>">首页</a></li>
	<li class=active>行业</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<?php if($this->session->userdata('level') > 5): ?>
	<a class="btn btn-primary" title="添加新行业" href="<?php echo base_url('industry/create'); ?>">添加新行业</a>
	<?php endif;?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr><th>状态</th><th>门店ID</th><th>负责人ID</th><th>行业ID</th><th>行业ID</th><th>名称</th><th>地区</th><th>电话</th><th>地址</th><?php if($this->session->userdata('level') > 5): ?><th>操作</th><?php endif;?></tr>
		</thead>
		<tbody>
<?php foreach ($branchs as $branch_item): ?>
	<tr>
		<td><?php echo $branch_item['status'].status( $branch_item['status'] ); ?></td>
	    <td><?php echo $branch_item['branch_id'] ?></td>
		<td><a href="<?php echo base_url('manager/'.$branch_item['stuff_id']); ?>" target=_blank><?php echo $branch_item['stuff_id']; ?></a></td>
		<td><?php echo $branch_item['industry_id'] ?></td>
		<td><?php echo $branch_item['industry_id'] ?></td>
		<td><?php echo $branch_item['name'] ?></td>
	    <td><?php echo $branch_item['region'] ?></td>
		<td><?php echo $branch_item['tel'] ?></td>
		<td><?php echo $branch_item['address'] ?></td>
		<td>
			<?php if($this->session->userdata('level') > 8)://if($this->session->userdata('level') > 4): ?>
			<ul class=list-unstyled>
				<li><a title="编辑<?php echo $branch_item['name'] ?>" href="<?php echo base_url('branch/edit/'.$branch_item['branch_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a></li>
				<?php
					if($this->session->userdata('level') > 5):
						if( in_array( $branch_item['status'] , array(1,2) ) ):
				?>
				<li><a title="关闭<?php echo $branch_item['name'] ?>" href="<?php echo base_url('branch/delete/'.$branch_item['branch_id']); ?>"><span class="glyphicon glyphicon-remove"></span></a></li>	
				<?php
						elseif( in_array( $branch_item['status'] , array(0,3) ) ):
				?>
				<li><a title="开通<?php echo $branch_item['name'] ?>" href="<?php echo base_url('branch/restore/'.$branch_item['branch_id']); ?>"><span class="glyphicon glyphicon-ok"></span></a></li>
				<?php
						endif;
					endif;
				?>
			</ul>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
</div>