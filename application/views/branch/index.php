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
  <li class=active>门店/分公司</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<?php if($this->session->userdata('level') > 7): ?>
	<a class="btn btn-primary" title="添加新门店" href="<?php echo base_url('branch/create'); ?>">添加新门店</a>
	<?php endif;?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th>门店ID</th><th>状态</th><th>负责人</th><th>公司</th><th>品牌</th><th>名称</th><th>地区</th><th>电话</th><th>地址</th>
				<?php if($this->session->userdata('level') > 7): ?><th>操作</th><?php endif;?>
				</tr>
		</thead>
		<tbody>
<?php foreach ($branchs as $branch_item): ?>
	<tr>
		<td><?php echo $branch_item['branch_id'] ?></td>
		<td><?php echo $branch_item['status'].status( $branch_item['status'] ); ?></td>
		<td>ID <?php echo $branch_item['stuff_id']; ?><br><a href="<?php echo base_url('stuff/'.$branch_item['stuff_id']); ?>" target=_blank><?php echo $branch_item['stuff_lastname'].$branch_item['stuff_firstname']; ?></a></td>
		<td>ID <?php echo $branch_item['biz_id']; ?><br><a href="<?php echo base_url('biz/'.$branch_item['biz_id']); ?>" target=_blank><?php echo $branch_item['biz_name']; ?></a></td>
		<td>ID <?php echo $branch_item['brand_id']; ?><br><a href="<?php echo base_url('brand/'.$branch_item['brand_id']); ?>" target=_blank><?php echo $branch_item['brand_name_cn'].'<br>'.$branch_item['brand_name_en']; ?></a></td>
		<td><?php echo $branch_item['name'] ?></td>
	    <td><?php echo $branch_item['region'] ?></td>
		<td><?php echo $branch_item['tel'] ?></td>
		<td><?php echo $branch_item['address'] ?></td>
		<?php if($this->session->userdata('level') > 7): ?>
		<td>
			<ul class=list-unstyled>
				<li><a title="编辑<?php echo $branch_item['name'] ?>" href="<?php echo base_url('branch/edit/'.$branch_item['branch_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a></li>
				<?php
					if($this->session->userdata('level') > 5):
						if( in_array( $branch_item['status'] , array(1,2) ) ):
				?>
				<li><a title="关闭<?php echo $branch_item['name'] ?>" href="<?php echo base_url('branch/delete/'.$branch_item['branch_id']); ?>"><span class="glyphicon glyphicon-eye-close"></span></a></li>	
				<?php
						elseif( in_array( $branch_item['status'] , array(0,3) ) ):
				?>
				<li><a title="开通<?php echo $branch_item['name'] ?>" href="<?php echo base_url('branch/restore/'.$branch_item['branch_id']); ?>"><span class="glyphicon glyphicon-eye-open"></span></a></li>
				<?php
						endif;
					endif;
				?>
			</ul>
		</td>
		<?php endif; ?>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
</div>