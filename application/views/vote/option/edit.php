<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li><a href="<?php echo base_url('vote'); ?>">投票</a></li>
  <li><a href="<?php echo base_url('vote/option'); ?>">投票选项</a></li>
  <li class=active>新增</li>
</ol>
<div id=content>
<?php
	foreach ($options as $option):
	if(isset($error)){echo $error;}
	$attributes = array('class' => 'form-vote-option-create', 'role' => 'form');
	echo form_open_multipart(base_url('vote/option/edit/'.$option['vote_id'].'/'.$option['option_id']), $attributes);
?>
		<fieldset>
			<input name=option_id type=hidden value="<?php echo $option['option_id']; ?>">
			<label for=name>名称</label>
			<input class=form-control name=name type=text value="<?php echo $option['name']; ?>" placeholder="名称" required>
			<?php echo form_error('name'); ?>
			<label for=detail>详情</label>
			<input class=form-control name=detail type=text value="<?php echo $option['detail']; ?>" placeholder="详情">
			<label for=image>图片</label>
			<?php echo form_error('detail'); ?>
			<p class="alert alert-warning">为防止误删，图片上传后不可编辑，如果需要替换图片，请从<a href="<?php echo base_url('vote/option'); ?>" class=alert-link>投票选项列表</a>删除本项，并新建一个投票选项。</p>
		</fieldset>
		<button class="btn btn-primary">保存</button>
	</form>
	<?php endforeach; ?>
</div>