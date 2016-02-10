<h2><?php echo $title; ?></h2>
<?php
	if(isset($error)){echo $error;}//若有错误提示信息则显示
	$attributes = array('class' => 'form-login col-lg-3 col-md-4 col-sm-6 col-xs-12', 'role' => 'form');
	echo form_open(base_url('login'), $attributes);
?>
	<fieldset>
		<input class=form-control name=mobile type=tel value="<?php echo $this->input->post('mobile') ? set_value('mobile') : $this->input->cookie($this->config->item('cookie_prefix').'manager_mobile'); ?>" size=11 pattern="\d{11}" placeholder="手机号" required>
		<?php echo form_error('mobile'); ?>
		<input class=form-control name=password type=password <?php if($this->input->cookie($this->config->item('cookie_prefix').'manager_mobile')){echo 'autofocus ';} ?>size=6 pattern="\d{6}" placeholder="密码（6位数字）" required>
		<?php echo form_error('password'); ?>
	</fieldset>
	<button class="btn btn-block btn-primary" role=button>登录</button>
</form>