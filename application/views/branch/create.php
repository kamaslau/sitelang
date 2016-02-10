<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li><a href="<?php echo base_url('branch'); ?>">门店/分公司</a></li>
  <li class=active>新增</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
<?php
	$attributes = array('class' => 'form-branch-create', 'role' => 'form');
	echo form_open(base_url('branch/create'), $attributes);
?>
		<fieldset>
			<select class=form-control name=industry_id required>
				<option value="-" <?php echo set_select('industry_id', '-'); ?>>所属行业</option>
				<?php foreach ($industries as $industry_item): ?>
				<option value=<?php echo $industry_item['industry_id'];?> <?php echo set_select('industry_id', $industry_item['industry_id']); ?>><?php echo $industry_item['name'] ?></option>
				<?php endforeach ?>
			</select>
			<?php echo form_error('industry_id') ?>
		</fieldset>
		<fieldset>
			<input class=form-control name=name type=text value="<?php echo set_value('name'); ?>" placeholder="门店/分公司名" required>
			<?php echo form_error('name'); ?>
			<input class=form-control name=tel type=tel value="<?php echo set_value('tel'); ?>" placeholder="电话（不填区号，固话、手机均可）" required>
			<?php echo form_error('tel'); ?>
			<input class=form-control name=address type=text value="<?php echo set_value('address'); ?>" placeholder="地址（仅填写除省、市之外的部分）" required>
			<?php echo form_error('address'); ?>
			<input class=form-control name=latitude type=number value="<?php echo set_value('latitude'); ?>" placeholder="纬度（以百度地图为准）" required>
			<?php echo form_error('latitude'); ?>
			<input class=form-control name=longitude type=number value="<?php echo set_value('longitude'); ?>" placeholder="经度（以百度地图为准）" required>
			<?php echo form_error('longitude'); ?>
			<input class=form-control name=time_open type=number min=0000 value="<?php echo set_value('time_open'); ?>" placeholder="营业开始时间 如：0830" required>
			<?php echo form_error('time_open'); ?>
			<input class=form-control name=time_end type=number max=2359 value="<?php echo set_value('time_end'); ?>" placeholder="营业结束时间 如：2230" required>
			<?php echo form_error('time_end'); ?>
		</fieldset>
		<button class="btn btn-primary">确定</button>
	</form>
</div>