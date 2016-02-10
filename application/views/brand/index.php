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
  <li class=active>品牌</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<?php if($this->session->userdata('level') > 7): ?>
	<a class="btn btn-primary" title="添加新品牌" href="<?php echo base_url('brand/create'); ?>">添加新品牌</a>
	<?php endif;?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th>品牌ID</th><th>状态</th><th>负责人</th><th>公司</th><th>名称</th><th>微博</th><th>微信</th><th>VI-Logo</th><th>VI-较浅识别色</th><th>VI-较深识别色</th><th>最后编辑时间</th><th>最后编辑人</th>
				<?php if($this->session->userdata('level') > 7): ?><th>操作</th><?php endif;?>
			</tr>
		</thead>
		<tbody>
<?php foreach ($brands as $brand_item): ?>
	<tr>
		<td><?php echo $brand_item['brand_id']; ?></td>
		<td><?php echo $brand_item['status'].status( $brand_item['status'] ); ?></td>
		<td>ID <?php echo $brand_item['stuff_id']; ?><br><a href="<?php echo base_url('stuff/'.$brand_item['stuff_id']); ?>" target=_blank><?php echo $brand_item['stuff_lastname'].$brand_item['stuff_firstname']; ?></a></td>
		<td>ID <?php echo $brand_item['biz_id']; ?><br><a href="<?php echo base_url('biz/'.$brand_item['biz_id']); ?>" target=_blank><?php echo $brand_item['biz_name']; ?></a></td>
		<td><?php echo $brand_item['name']; ?><br><?php echo $brand_item['name_en']; ?></td>
		<td><?php echo (!isset($brand_item['weibo']))?'无':'http://weibo.com/'.$brand_item['weibo']; ?></td>
		<td><?php echo (!isset($brand_item['wechat']))?'无':'<img src=http://qr.liantu.com/api.php?fg='.$brand_item['vi_color_dark'] .'&gc='.$brand_item['vi_color_light'].'&pt='.$brand_item['vi_color_dark'] .'&inpt='.$brand_item['vi_color_light'].'&w=320&m=10&logo='.$brand_item['vi_logo'].'&text=http://weixin.qq.com/r/'.$brand_item['wechat'].'>'; ?></td>
		<td><?php echo (!isset($brand_item['vi_logo']))?'无':'<img width=100 src="'.$brand_item['vi_logo'].'">'; ?></td>
		<!--较浅品牌标示色-->
		<?php if(isset($brand_item['vi_color_light'])): ?>
		<td style="color:#fff;background-color:#<?php echo $brand_item['vi_color_light']; ?>">#<?php echo $brand_item['vi_color_light']; ?></td>
		<?php else: ?>
		<td>无</td>
		<?php endif; ?>
		<!--较深品牌标示色-->
		<?php if(isset($brand_item['vi_color_light'])): ?>
		<td style="color:#fff;background-color:#<?php echo $brand_item['vi_color_dark']; ?>">#<?php echo $brand_item['vi_color_dark']; ?></td>
		<?php else: ?>
		<td>无</td>
		<?php endif; ?>
		<td><?php echo $brand_item['time_edit']; ?></td>
		<td><?php echo $brand_item['operator_id']; ?></td>
		<?php if($this->session->userdata('level') > 7): ?>
		<td>
			<ul class=list-unstyled>
				<li><a title="编辑<?php echo $brand_item['name'] ?>" href="<?php echo base_url('brand/edit/'.$brand_item['brand_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a></li>
				<?php
					if($this->session->userdata('level') > 5):
						if( in_array( $brand_item['status'] , array(1,2) ) ):
				?>
				<li><a title="关闭<?php echo $brand_item['name'] ?>" href="<?php echo base_url('brand/delete/'.$brand_item['brand_id']); ?>"><span class="glyphicon glyphicon-eye-close"></span></a></li>	
				<?php
						elseif( in_array( $brand_item['status'] , array(0,3) ) ):
				?>
				<li><a title="开通<?php echo $brand_item['name'] ?>" href="<?php echo base_url('brand/restore/'.$brand_item['brand_id']); ?>"><span class="glyphicon glyphicon-eye-open"></span></a></li>
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