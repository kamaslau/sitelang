<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li class=active>活动</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<?php if($this->session->userdata('level') > 8): ?>
	<a class="btn btn-primary" title="新增活动" href="<?php echo base_url('activity/create'); ?>">新增活动</a>
	<a class="btn btn-info" title="创建营销链接" href="<?php echo base_url('marketing/create'); ?>">创建营销链接</a>
	<?php endif; ?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th>活动ID</th><th>名称</th><th>公司</th><th>品牌</th><th>门店/分公司</th><th>详情</th><th>活动网址</th><th>开始时间</th><th>结束时间</th><th>负责人</th><th>最后修改人</th><th>最后修改时间</th
				><?php if($this->session->userdata('level') > 4): ?><th>操作</th><?php endif;?>
			</tr>
		</thead>
		<tbody>
<?php foreach ($activities as $activity_item): ?>
	<tr>
	    <td><?php echo $activity_item['activity_id']; ?></td>
		<td><?php echo $activity_item['name']; ?></td>
		<td><?php echo $activity_item['biz_name']; ?></td>
		<td><?php echo ($activity_item['brand_name'] == NULL)?'全品牌':$activity_item['brand_name']; ?></td>
		<td><?php echo ($activity_item['branch_name'] == NULL)?'全门店/分公司':$activity_item['branch_name']; ?></td>
	    <td><?php echo ($activity_item['detail'] == NULL)?'无':$activity_item['detail']; ?></td>
		<td><?php echo ($activity_item['url'] == NULL)?'无':'http://'.$activity_item['url']; ?></td>
		<td><?php echo ($activity_item['time_start'] == NULL)?'永久':$activity_item['time_start']; ?></td>
		<td><?php echo ($activity_item['time_end'] == NULL)?'永久':$activity_item['time_end']; ?></td>
		<td><?php echo ($activity_item['stuff_id'] == NULL)?'未指定':'ID '.$activity_item['stuff_id'].'<br><a href="'. base_url('stuff/'.$activity_item['stuff_id']).'" target=_blank>'.$activity_item['stuff_lastname'].$activity_item['stuff_firstname'].'</a>'; ?></td>
		<td><?php echo ($activity_item['operator_id'] == NULL)?'未修改':'ID '.$activity_item['stuff_id'].'<br><a href="'. base_url('stuff/'.$activity_item['operator_id']).'" target=_blank>'.$activity_item['operator_id'].'</a>'; ?></td>
		<td><?php echo $activity_item['time_edit'] ?></td>
		<?php if($this->session->userdata('level') > 4): ?>
		<td>
			<ul class=list-unstyled>
				<li><a title="查看<?php echo $activity_item['name'] ?>业绩详情" href="<?php echo base_url('activity/'.$activity_item['activity_id']); ?>"><span class="glyphicon glyphicon-info-sign"></span></a></li>
				<?php if($this->session->userdata('level') > 8): ?>
				<li><a title="编辑<?php echo $activity_item['name'] ?>" href="<?php echo base_url('activity/edit/'.$activity_item['activity_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a></li>
				<li><a title="删除<?php echo $activity_item['name'] ?>" href="<?php echo base_url('activity/delete/'.$activity_item['activity_id']); ?>"><span class="glyphicon glyphicon-trash"></span></a></li>
				<?php endif; ?>
			</ul>
		</td>
		<?php endif; ?>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
</div>