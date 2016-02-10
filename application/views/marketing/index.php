<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li class=active>营销</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<?php if($this->session->userdata('level') > 8): ?>
	<a class="btn btn-primary" title="添加新营销活动" href="<?php echo base_url('marketing/create'); ?>">添加新营销活动</a>
	<?php endif;?>
	<h3>活动</h3>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th>ID</th><th>公司</th><th>品牌</th><th>门店/分公司</th><th>名称</th><th>详情</th><th>网址</th><th>开始时间</th><th>结束时间</th><th>负责人</th><th>最后修改人</th><th>最后修改时间</th><?php if($this->session->userdata('level') > 4): ?><th>操作</th><?php endif;?>
			</tr>
		</thead>
		<tbody>
<?php foreach ($activities as $activity_item): ?>
	<tr>
	    <td><?php echo $activity_item['activity_id']; ?></td>
		<td><?php echo $activity_item['biz_name']; ?></td>
		<td><?php echo ($activity_item['brand_name'] == NULL)?'全品牌':$activity_item['brand_name']; ?></td>
		<td><?php echo ($activity_item['branch_name'] == NULL)?'全门店/分公司':$activity_item['branch_name']; ?></td>
		<td><?php echo $activity_item['name']; ?></td>
	    <td><?php echo ($activity_item['detail'] == NULL)?'无':$activity_item['detail']; ?></td>
		<td><?php echo 'http://'.$activity_item['url']; ?></td>
		<td><?php echo ($activity_item['time_start'] == NULL)?'永久':$activity_item['time_start']; ?></td>
		<td><?php echo ($activity_item['time_end'] == NULL)?'永久':$activity_item['time_end']; ?></td>
		<td><?php echo ($activity_item['stuff_id'] == NULL)?'未指定':'ID '.$activity_item['stuff_id'].'<br><a href="'. base_url('manager/'.$activity_item['stuff_id']).'" target=_blank>'.$activity_item['stuff_lastname'].$activity_item['stuff_firstname'].'</a>'; ?></td>
		<td><?php echo ($activity_item['operator_id'] == NULL)?'未修改':'ID '.$activity_item['stuff_id'].'<br><a href="'. base_url('manager/'.$activity_item['operator_id']).'" target=_blank>'.$activity_item['operator_id'].'</a>'; ?></td>
		<td><?php echo $activity_item['time_edit'] ?></td>
		<td>
			<?php if($this->session->userdata('level') > 4): ?>
			<ul class=list-unstyled>
				<li><a title="查看<?php echo $activity_item['name'] ?>业绩详情" href="<?php echo base_url('activity/'.$activity_item['activity_id']); ?>">业绩详情</a></li>
				<?php if($this->session->userdata('level') > 8): ?>
				<li><a title="编辑<?php echo $activity_item['name'] ?>" href="<?php echo base_url('activity/edit/'.$activity_item['activity_id']); ?>">编辑</a></li>
				<?php endif; ?>
			</ul>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
	
	<h3>素材</h3>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr><th>ID</th><th>活动</th><th>名称</th><th>详情</th><th>负责人</th><th>最后修改人</th><th>最后修改时间</th><?php if($this->session->userdata('level') > 4): ?><th>操作</th><?php endif;?></tr>
		</thead>
		<tbody>
<?php foreach ($ads as $ad_item): ?>
	<tr>
	    <td><?php echo $ad_item['ad_id']; ?></td>
		<td>ID <?php echo $ad_item['activity_id']; ?><br><?php echo '<a href=" '.base_url('activity/'.$ad_item['activity_id']).'" target=_blank>'.$ad_item['activity_name']; ?></td>
		<td><?php echo $ad_item['name']; ?></td>
	    <td><?php echo ($ad_item['detail'] == NULL)?'无':$ad_item['detail']; ?></td>
		<td><?php echo ($ad_item['stuff_id'] == NULL)?'未指定':'ID '.$ad_item['stuff_id'].'<br><a href="'. base_url('manager/'.$ad_item['stuff_id']).'" target=_blank>'.$ad_item['stuff_lastname'].$ad_item['stuff_firstname'].'</a>'; ?></td>
		<td><?php echo ($ad_item['operator_id'] == NULL)?'未修改':'ID '.$ad_item['stuff_id'].'<br><a href="'. base_url('manager/'.$ad_item['operator_id']).'" target=_blank>'.$ad_item['operator_id'].'</a>'; ?></td>
		<td><?php echo $ad_item['time_edit'] ?></td>
		<td>
			<?php if($this->session->userdata('level') > 4): ?>
			<ul class=list-unstyled>
				<li><a title="查看<?php echo $ad_item['name'] ?>业绩详情" href="<?php echo base_url('ad/'.$ad_item['ad_id']); ?>"><span class="glyphicon glyphicon-info-sign"></span></a></li>
				<?php if($this->session->userdata('level') > 8): ?>
				<li><a title="编辑<?php echo $ad_item['name'] ?>" href="<?php echo base_url('ad/edit/'.$ad_item['ad_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a></li>
				<?php endif; ?>
			</ul>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
	
	<h3>投放位</h3>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr><th>ID</th><th>名称</th><th>详情</th><th>负责人</th><th>最后修改人</th><th>最后修改时间</th><?php if($this->session->userdata('level') > 4): ?><th>操作</th><?php endif;?></tr>
		</thead>
		<tbody>
<?php foreach ($posters as $poster_item): ?>
	<tr>
		<td><?php echo $poster_item['poster_id']; ?></td>
		<td><?php echo $poster_item['name']; ?></td>
	    <td><?php echo ($poster_item['detail'] == NULL)?'无':$poster_item['detail']; ?></td>
		<td><?php echo ($poster_item['stuff_id'] == NULL)?'未指定':'ID '.$poster_item['stuff_id'].'<br><a href="'. base_url('stuff/'.$poster_item['stuff_id']).'" target=_blank>'.$poster_item['stuff_lastname'].$poster_item['stuff_firstname'].'</a>'; ?></td>
		<td><?php echo ($poster_item['operator_id'] == NULL)?'未修改':'ID '.$poster_item['stuff_id'].'<br><a href="'. base_url('manager/'.$poster_item['operator_id']).'" target=_blank>'.$poster_item['operator_id'].'</a>'; ?></td>
		<td><?php echo $poster_item['time_edit'] ?></td>
		<td>
			<?php if($this->session->userdata('level') > 4): ?>
			<ul class=list-unstyled>
				<li><a title="查看<?php echo $poster_item['name'] ?>业绩详情" href="<?php echo base_url('poster/'.$poster_item['poster_id']); ?>"><span class="glyphicon glyphicon-info-sign"></span></a></li>
				<?php if($this->session->userdata('level') > 8): ?>
				<li><a title="编辑<?php echo $poster_item['name'] ?>" href="<?php echo base_url('poster/edit/'.$poster_item['poster_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a></li>
				<?php endif; ?>
			</ul>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
</div>