<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li class=active>素材</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr><th>素材ID</th><th>名称</th><th>详情</th><th>负责人</th><th>创建时间</th><th>最后修改时间</th><th>最后修改人</th><?php if($this->session->userdata('level') > 4): ?><th>操作</th><?php endif;?></tr>
		</thead>
		<tbody>
<?php foreach ($ads as $ad_item): ?>
	<tr>
	    <td><?php echo $ad_item['ad_id']; ?></td>
		<td><?php echo $ad_item['name']; ?></td>
	    <td><?php echo ($ad_item['detail'] == NULL)?'无':$ad_item['detail']; ?></td>
		<td><?php echo ($ad_item['stuff_id'] == NULL)?'未指定':'ID '.$ad_item['stuff_id'].'<br><a href="'. base_url('stuff/'.$ad_item['stuff_id']).'" target=_blank>'.$ad_item['stuff_lastname'].$ad_item['stuff_firstname'].'</a>'; ?></td>
		<td><?php echo $ad_item['time_create'] ?></td>
		<td><?php echo $ad_item['time_edit'] ?></td>
		<td><?php echo ($ad_item['operator_id'] == NULL)?'未修改':'ID '.$ad_item['stuff_id'].'<br><a href="'. base_url('stuff/'.$ad_item['operator_id']).'" target=_blank>'.$ad_item['operator_id'].'</a>'; ?></td>
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
</div>