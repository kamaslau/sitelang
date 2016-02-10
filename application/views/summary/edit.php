<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li><a href="<?php echo base_url('summary'); ?>">消费记录</a></li>
  <li class=active>编辑</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
<?php
	$attributes = array('class' => 'form-summary-edit', 'role' => 'form');
	echo form_open(base_url('summary/edit'), $attributes);
?>
		<fieldset>

		</fieldset>
		<button class="btn btn-primary">保存</button>
	</form>
</div>