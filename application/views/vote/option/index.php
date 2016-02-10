<ol class=breadcrumb>
	<li><a href="<?php echo base_url(); ?>">首页</a></li>
	<li><a href="<?php echo base_url('vote'); ?>">投票</a></li>
	<li class=active>投票选项</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<?php if($this->session->userdata('level') > 5): ?>
	<a class="btn btn-primary" title="添加新选项" href="<?php echo base_url('vote/option/create'); ?>">添加新选项</a>
	<?php endif; ?>
	<div id=chart>
		<script>
		$(function(){
		    $('#chart').highcharts({
		            chart: {
		                type: 'bar'
		            },
		            title: {
		                text: '投票结果'
		            },
					subtitle: {
					    text: '根据得票数量从高到低排列'
					},
		            xAxis: {
		                type: 'category',
		                labels: {
		                    rotation: -45,
		                    align: 'right',
		                    style: {
		                        fontSize: '13px',
		                        fontFamily: 'Verdana, sans-serif'
		                    }
		                }
		            },
		            yAxis: {
		                min: 0,
		                title: {
		                    text: '得票数(票)'
		                }
		            },
		            legend: {
		                enabled: false
		            },
		            tooltip: {
		                pointFormat: '至今共获得<span>{point.y}票</span>',
		            },
		            series: [{
		                name: '得票数',
		                data: [
<?php
	foreach ($options as $option_item):
		if($option_item['status'] == 1):
			echo "['".$option_item['name']."',".$option_item['count'].'],';
		endif;
	endforeach;
?>
		                ],
		                dataLabels: {
		                    enabled: true,
		                    rotation: -90,
		                    color: '#ffffff',
		                    align: 'right',
		                    x: 4,
		                    y: 10,
		                    style: {
		                        fontSize: '12px',
		                        fontFamily: 'Arial, sans-serif',
		                        textShadow: '0 0 3px black'
		                    }
		                }
		            }]
			});
		});
		</script>
	</div>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th>选项ID</th><th>投票活动</th><th>名称</th><th>详情</th><th>图片</th><th>票数</th><th>状态</th><th>创建时间</th><th>删除时间</th><th>最后编辑时间</th><th>最后编辑人</th>
				<?php if($this->session->userdata('level') > 5): ?><th>操作</th><?php endif; ?>
			</tr>
		</thead>
		<tbody>
<?php foreach ($options as $option_item): ?>
	<tr<?php echo ($option_item['status'] == 1)?NULL:' class=danger'; ?>>
		<td><?php echo $option_item['option_id']; ?></td>
		<td>ID <?php echo $option_item['vote_id']; ?></td>
	    <td><?php echo $option_item['name']; ?></td>
	    <td><?php echo $option_item['detail']; ?></td>
		<!--http://images.key2all.com/activity/vote/1/-->
	    <td><img class=thumbnail width=100 src="http://sitelang.cn/uploads/activity/vote/<?php echo $option_item['vote_id']; ?>/<?php echo $option_item['image']; ?>" alt="<?php echo $option_item['name'] ?>"></td>
	    <td><?php echo $option_item['count']; ?></td>
		<td><?php echo ($option_item['status'] == 1)?'正常':'已删除'; ?></td>
		<td><?php echo $option_item['time_create']; ?></td>
		<td><?php echo ($option_item['status'] == 1)?'未删除':$option_item['time_delete']; ?></td>
		<td><?php echo ($option_item['time_edit'] == '0000-00-00 00:00:00')?'未编辑':$option_item['time_edit']; ?></td>
		<td><?php echo !isset($option_item['operator_id'])?'未编辑':$option_item['operator_id']; ?></td>
		<?php if($this->session->userdata('level') > 5): ?>
		<td>
			<ul class=list-unstyled>
				<li><a title="编辑<?php echo $option_item['name'] ?>" href="<?php echo base_url('vote/option/edit/'.$option_item['vote_id'].'/'.$option_item['option_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a></li>
				<?php if($option_item['status'] == 1): ?>
				<li><a title="删除<?php echo $option_item['name'] ?>" href="<?php echo base_url('vote/option/delete/'.$option_item['option_id']); ?>"><span class="glyphicon glyphicon-trash"></span></a></li>
				<?php else: ?>
				<li><a title="恢复<?php echo $option_item['name'] ?>" href="<?php echo base_url('vote/option/restore/'.$option_item['option_id']); ?>"><span class="glyphicon glyphicon-refresh"></span></a></li>
				<?php endif; ?>
			</ul>
		</td>
		<?php endif;?>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
</div>