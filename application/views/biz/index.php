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
  <li class=active>公司</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<?php if($this->session->userdata('level') > 8): ?>
	<a class="btn btn-primary" title="添加新公司" href="<?php echo base_url('biz/create'); ?>">添加新公司</a>
	<?php endif;?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th>公司ID</th><th>状态</th><th>负责人</th><th>名称</th><th>地区</th><th>电话</th><th>地址</th><th>微博</th><th>微信</th><th>VI-Logo</th><th>VI-较浅识别色</th><th>VI-较深识别色</th>
				<?php if($this->session->userdata('level') > 7): ?><th>操作</th><?php endif;?>
			</tr>
		</thead>
		<tbody>
<?php foreach ($bizs as $biz_item): ?>
	<tr>
		<td><?php echo $biz_item['biz_id'] ?></td>
		<td><?php echo status($biz_item['status']); ?></td>
		<td>ID <?php echo $biz_item['stuff_id']; ?><br><a href="<?php echo base_url('stuff/'.$biz_item['stuff_id']); ?>" target=_blank><?php echo $biz_item['stuff_lastname'].$biz_item['stuff_firstname']; ?></a></td>
		<td><?php echo $biz_item['name'] ?></td>
	    <td><?php echo $biz_item['region'] ?></td>
		<td><?php echo $biz_item['tel'] ?></td>
		<td><?php echo $biz_item['address'] ?></td>
		<td><?php echo (!isset($biz_item['weibo']))?'无':'http://weibo.com/'.$biz_item['weibo']; ?></td>
		<td><?php echo (!isset($biz_item['wechat']))?'无':'<img src=http://qr.liantu.com/api.php?fg='.$biz_item['vi_color_dark'] .'&gc='.$biz_item['vi_color_light'].'&pt='.$biz_item['vi_color_dark'] .'&inpt='.$biz_item['vi_color_light'].'&w=320&m=10&logo='.$biz_item['vi_logo'].'&text=http://weixin.qq.com/r/'.$biz_item['wechat'].'>'; ?></td>
		<td><?php echo (!isset($biz_item['vi_logo']))?'无':'<img width=100 src="'.$biz_item['vi_logo'].'">'; ?></td>
		<!--较浅品牌标示色-->
		<?php if(isset($biz_item['vi_color_light'])): ?>
		<td style="color:#fff;background-color:#<?php echo $biz_item['vi_color_light']; ?>">#<?php echo $biz_item['vi_color_light']; ?></td>
		<?php else: ?>
		<td>无</td>
		<?php endif; ?>
		<!--较深品牌标示色-->
		<?php if(isset($biz_item['vi_color_light'])): ?>
		<td style="color:#fff;background-color:#<?php echo $biz_item['vi_color_dark']; ?>">#<?php echo $biz_item['vi_color_dark']; ?></td>
		<?php else: ?>
		<td>无</td>
		<?php endif; ?>
		<?php if($this->session->userdata('level') > 7): ?>
		<td>
			<ul class=list-unstyled>
				<li><a title="编辑<?php echo $biz_item['name'] ?>" href="<?php echo base_url('biz/edit/'.$biz_item['biz_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a></li>
				<?php
					if($this->session->userdata('level') > 6):
						if( in_array( $biz_item['status'] , array(1,2) ) ):
				?>
				<li><a title="关闭<?php echo $biz_item['name'] ?>" href="<?php echo base_url('biz/delete/'.$biz_item['biz_id']); ?>"><span class="glyphicon glyphicon-eye-close"></span></a></li>	
				<?php
						elseif( in_array( $biz_item['status'] , array(0,3) ) ):
				?>
				<li><a title="开通<?php echo $biz_item['name'] ?>" href="<?php echo base_url('biz/restore/'.$biz_item['biz_id']); ?>"><span class="glyphicon glyphicon-eye-open"></span></a></li>
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