<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li><a href="<?php echo base_url('product'); ?>">产品</a></li>
  <li class=active>新增</li>
</ol>
<div id=content>
<?php
	if(isset($error)){echo $error;}
	$attributes = array('class' => 'form-product-create form-horizontal', 'role' => 'form');
	echo form_open_multipart(base_url('product/create'), $attributes);
?>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=name>名称</label>
				<div class="col-sm-10">
					<input class=form-control name=name type=text value="<?php echo set_value('name'); ?>" placeholder="名称" required>
					<?php echo form_error('name'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=detail>详情</label>
				<div class="col-sm-10">
					<input class=form-control name=detail type=text value="<?php echo set_value('detail'); ?>" placeholder="详情" required>
					<?php echo form_error('detail'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=userfile>产品图片</label>
				<div class="col-sm-10">
					<input class=form-control name=userfile type=file value="<?php echo set_value('userfile'); ?>" placeholder="产品图片">
					<?php echo form_error('userfile'); ?>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=price_cash>现金价格</label>
				<div class="col-sm-10">
					<div class="input-group">
						<div class="input-group-addon">￥</div>
						<input class=form-control name=price_cash type=number step=0.01 value="<?php echo set_value('price_cash'); ?>" placeholder="现金价格">
					</div>
					<?php echo form_error('price_cash'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=credit_rate>消费兑换积分的倍数</label>
				<div class="col-sm-10">
					<input class=form-control name=credit_rate type=number step=0.1 min=0 value=1 placeholder="消费兑换积分的倍数" required>
					<?php echo form_error('credit_rate'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=price_credit>积分价格</label>
				<div class="col-sm-10">
					<input class=form-control name=price_credit type=number step=0.01 value="<?php echo set_value('price_credit'); ?>" placeholder="积分价格">
					<?php echo form_error('price_credit'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=credit_group>可用积分兑换本品的<br>会员类型</label>
				<div class="col-sm-10">
					<select class=form-control name=credit_group>
						<option value=1 <?php echo set_select('credit_group', '1', TRUE); ?>>所有会员</option>
						<option value=2 <?php echo set_select('credit_group', '2'); ?>>充值会员</option>
					</select>
					<?php echo form_error('credit_group'); ?>
				</div>
			</div>
		</fieldset>
		<button class="btn btn-primary">保存</button>
	</form>
</div>