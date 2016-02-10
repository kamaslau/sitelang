<h2><?php echo $title; ?></h2>
<?php
	if(isset($error)){echo $error;}//若有错误提示信息则显示
	$attributes = array('class' => 'form-upload', 'role' => 'form');
	echo form_open(base_url('upload'), $attributes);
?>
	<fieldset>
		<input class=form-control name=file type=file placeholder="请选择需要上传的图片" required>
		<?php echo form_error('file'); ?>
	</fieldset>
	<button class="btn btn-block btn-primary" role=button>上传</button>
</form>