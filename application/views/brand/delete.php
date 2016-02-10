<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li><a href="<?php echo base_url('brand'); ?>">品牌</a></li>
  <li class=active>删除</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
<?php
	$attributes = array('class' => 'form-brand-delete', 'role' => 'form');
	echo form_open(base_url('brand/delete'), $attributes);
?>
		<fieldset>

		</fieldset>
		<button class="btn btn-primary">确定删除</button>
	</form>
</div>