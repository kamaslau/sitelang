<?php
	//显示权限名称
	function level($level)
	{
		switch($level)
		{
			case 0:
			  return '未授权';
			  break;
			case 1:
			  return '员工';
			  break;
			case 2:
			  return '财务';
			  break;
			case 3:
			  return '收银';
			  break;
  			case 4:
  			  return '经理';
  			  break;
  			case 5:
  			  return '门店\分公司管理员';
  			  break;
			case 6:
			  return '品牌管理员';
			  break;
  			case 7:
  			  return '公司管理员';
  			  break;
  			case 8:
  			  return '系统管理员';
  			  break;
  			case 9:
  			  return '超级管理员';
  			  break;
			default:
			  return '其它权限';
		}
	}
?>
<ol class=breadcrumb>
	<li><a href="<?php echo base_url(); ?>">首页</a></li>
	<li class=active>员工</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<?php if($this->session->userdata('level') > 4): ?>
	<a class="btn btn-primary" title="增加新员工" href="<?php echo base_url('stuff/create'); ?>">增加新员工</a>
	<?php endif;?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr><th>员工ID</th><th>姓名</th><th>性别</th><th>权限</th><th>公司</th><th>品牌</th><th>门店/分公司</th><th>职位</th><th>手机号</th><th>邮箱</th><th>生日</th><th>操作</th></tr>
		</thead>
		<tbody>
<?php foreach ($stuffs as $stuff_item): ?>
			<tr>
				<td><?php echo $stuff_item['stuff_id']; ?></td>
			    <td><?php $name = $stuff_item['lastname'].$stuff_item['firstname'];echo $name; ?></td>
			    <td><?php $gender = ($stuff_item['gender'] == 0)?'女士':'先生';echo $gender; ?></td>
				<td><?php echo $stuff_item['level'].'（'.level($stuff_item['level']).'）'; ?></td>
				<td><?php echo $stuff_item['biz_name']; ?></td>
				<td><?php echo $stuff_item['brand_name']; ?></td>
				<td><?php echo $stuff_item['branch_name']; ?></td>
				<td><?php echo $stuff_item['title']; ?></td>
				<td><?php echo $stuff_item['mobile']; ?></td>
				<td><?php echo $stuff_item['email']; ?></td>
				<td><?php echo $stuff_item['dob']; ?></td>
				<td>
					<ul class=list-unstyled>
					<?php if( ($this->session->userdata('level') > 4) || ($this->session->userdata('stuff_id') == $stuff_item['stuff_id']) ): ?>
						<?php if($this->session->userdata('level') > $stuff_item['level']): ?>
						<li><a title="编辑<?php echo $name; ?>" href="<?php echo base_url('stuff/edit/'.$stuff_item['stuff_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a></li>
						<li><a title="取消<?php echo $name; ?>授权" href="<?php echo base_url('stuff/delete/'.$stuff_item['stuff_id']); ?>"><span class="glyphicon glyphicon-off"></span></a></li>
						<?php endif; ?>
						<?php if( !empty($stuff_item['refer']) ): ?>
						<li><a class=generate href=# title="生成<?php echo $name; ?>的推广码"><span class="glyphicon glyphicon-qrcode"></span></a></li>
						<?php endif; ?>
					<?php endif; ?>
					</ul>
				</td>
			</tr>
<?php
	if( !empty($stuff_item['refer']) ):
		$engine = 'http://qr.liantu.com/api.php?fg='.$stuff_item['vi_color_dark'] .'&gc='.$stuff_item['vi_color_light'].'&pt='.$stuff_item['vi_color_dark'] .'&inpt='.$stuff_item['vi_color_light'].'&w=320&m=10&logo='.$stuff_item['vi_logo'].'&text=';
		
		$speedAdd = 'N:'.$stuff_item['lastname'].';'.$stuff_item['firstname']."\n";
		
		if( isset($stuff_item['brand_name']) ):
			$speedAdd.= 'ORG:'.$stuff_item['brand_name'].$stuff_item['branch_name']."\n";
			if( isset($stuff_item['branch_name']) ):
				$speedAdd.= 'TEL;WORK;VOICE:'.$stuff_item['branch_tel']."\n";
			endif;
		else:
			$speedAdd.= 'ORG:'.$stuff_item['biz_name']."\n";
		endif;

		if( isset($stuff_item['title']) ):
			$speedAdd.= 'TITLE:'.$stuff_item['title']."\n";
		endif;
		$speedAdd.= 'TEL;CELL:'.$stuff_item['mobile']."\n";
		$speedAdd.= 'URL;WORK:'.'http://qddian.com/sitelang/referral/1/1/1/1/1/'.$stuff_item['stuff_id']."\n";
		
		$speedAdd = urlencode('BEGIN:VCARD'."\n".$speedAdd.'END:VCARD');
		$trackLink = 'http://qddian.com/sitelang/referral/1/1/1/1/1/'.$stuff_item['stuff_id'];
?>
			<tr class="qrcode">
				<td colspan=12 class=row>
					<figure class="front col-lg-6">
						<figcaption class=text-center>SpeedAdd（<?php echo $name; ?>名片正面）</figcaption>
						<img class=center-block src="<?php echo $engine.$speedAdd; ?>">
					</figure>
					<figure class="back col-lg-6">
						<figcaption class=text-center>TrackLink（<?php echo $name; ?>名片背面）</figcaption>
						<img class=center-block src="<?php echo $engine.$trackLink; ?>">
					</figure>
				</td>
			</tr>
	<?php endif; ?>
<?php endforeach ?>
		</tbody>
	</table>
</div>