<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li><a href="<?php echo base_url('activity'); ?>">活动</a></li>
  <li class=active>删除</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
<?php
	$attributes = array('class' => 'form-activity-delete', 'role' => 'form');
	echo form_open(base_url('activity/delete'), $attributes);
?>
		<fieldset>
			<p>确定将该活动删除？</p>
			<input name=activiy_id type=hidden value="<?php echo $activity_id; ?>" required>
		</fieldset>
		<button class="btn btn-primary">确定</button>
	</form>
</div>