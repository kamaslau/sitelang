<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li><a href="<?php echo base_url('vote'); ?>">投票</a></li>
  <li><a href="<?php echo base_url('vote/option'); ?>">投票选项</a></li>
  <li class=active>新增</li>
</ol>
<div id=content>
<?php
	if(isset($error)){echo $error;}
	$attributes = array('class' => 'form-vote-option-create', 'role' => 'form');
	echo form_open_multipart(base_url('vote/option/create'), $attributes);
?>
		<fieldset>
			<input name=vote_id type=hidden value="1">
			<label for=name>名称</label>
			<input class=form-control name=name type=text value="<?php echo set_value('name'); ?>" placeholder="名称" required>
			<?php echo form_error('name'); ?>
			<label for=detail>详情</label>
			<input class=form-control name=detail type=text value="<?php echo set_value('detail'); ?>" placeholder="详情">
			<?php echo form_error('detail'); ?>
			<label for=userfile>图片</label>
			<input class=form-control name=userfile type=file value="<?php echo set_value('userfile'); ?>" placeholder="产品图片">
			<?php echo form_error('userfile'); ?>
		</fieldset>
		<button class="btn btn-primary">保存</button>
	</form>
</div>