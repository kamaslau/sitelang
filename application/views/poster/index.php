<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li class=active>广告位</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th>广告位ID</th><th>名称</th><th>详情</th><th>负责人</th><th>最后修改时间</th><th>最后修改人</th>
				<?php if($this->session->userdata('level') > 4): ?><th>操作</th><?php endif;?>
			</tr>
		</thead>
		<tbody>
<?php foreach ($posters as $poster_item): ?>
	<tr>
		<td><?php echo $poster_item['poster_id']; ?></td>
		<td><?php echo $poster_item['name']; ?></td>
	    <td><?php echo ($poster_item['detail'] == NULL)?'无':$poster_item['detail']; ?></td>
		<td><?php echo ($poster_item['stuff_id'] == NULL)?'未指定':'ID '.$poster_item['stuff_id'].'<br><a href="'. base_url('stuff/'.$poster_item['stuff_id']).'" target=_blank>'.$poster_item['stuff_lastname'].$poster_item['stuff_firstname'].'</a>'; ?></td>
		<td><?php echo $poster_item['time_edit'] ?></td>
		<td><?php echo ($poster_item['operator_id'] == NULL)?'未修改':'ID '.$poster_item['stuff_id'].'<br><a href="'. base_url('stuff/'.$poster_item['operator_id']).'" target=_blank>'.$poster_item['operator_id'].'</a>'; ?></td>
		<?php if($this->session->userdata('level') > 4): ?>
		<td>
			<ul class=list-unstyled>
				<li><a title="查看<?php echo $poster_item['name'] ?>业绩详情" href="<?php echo base_url('poster/'.$poster_item['poster_id']); ?>"><span class="glyphicon glyphicon-info-sign"></span></a></li>
				<?php if($this->session->userdata('level') > 8): ?>
				<li><a title="编辑<?php echo $poster_item['name'] ?>" href="<?php echo base_url('poster/edit/'.$poster_item['poster_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a></li>
				<?php endif; ?>
			</ul>
		</td>
		<?php endif; ?>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
</div>