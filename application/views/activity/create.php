<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li><a href="<?php echo base_url('activity'); ?>">活动</a></li>
  <li class=active>新增</li>
</ol><div id=content>
	<h2><?php echo $title; ?></h2>
<?php
	$attributes = array('class' => 'form-activity-create form-horizontal', 'role' => 'form');
	echo form_open(base_url('activity/create'), $attributes);
?>
		<fieldset>
			<?php if($this->session->userdata('level') > 7): ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for=biz_id>参与公司</label>
					<div class="col-sm-10">
						<select class=form-control name=biz_id required>
							<option value="-"<?php echo set_select('biz_id', '-'); ?>>请选择</option>
							<?php foreach ($bizs as $biz): ?>
							<option value="<?php echo $biz['biz_id']; ?>"<?php echo set_select('biz_id', $biz['biz_id']); ?>><?php echo $biz['name']; ?></option>
							<?php endforeach; ?>
						</select>
						<?php echo form_error('biz_id'); ?>
					</div>
				</div>
			<?php else: ?>
				<input name=biz_id type=hidden value="<?php echo $this->session->userdata('biz_id'); ?>">
			<?php endif; ?>
			
			<?php if($this->session->userdata('level') > 6): ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for=brand_id>参与品牌</label>
					<div class="col-sm-10">
						<select class=form-control name=brand_id<?php if($this->session->userdata('level') > 7): ?> disabled<?php endif; ?>>
							<option value="-"<?php echo set_select('brand_id', '-'); ?>>请选择</option>
							<option value=""<?php echo set_select('brand_id', ''); ?>>所有品牌</option>
							<?php foreach ($brands as $brand): ?>
							<option value="<?php echo $brand['brand_id']; ?>"<?php echo set_select('brand_id', $brand['brand_id']); ?> data-biz_id="<?php echo $brand['biz_id']; ?>"><?php echo $brand['name']; ?></option>
							<?php endforeach; ?>
						</select>
						<?php echo form_error('brand_id'); ?>
					</div>
				</div>
			<?php else: ?>
				<input name=brand_id type=hidden value="<?php echo $this->session->userdata('brand_id'); ?>">
			<?php endif; ?>
			
			
			<?php if($this->session->userdata('level') > 5): ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for=branch_id>参与门店/分公司</label>
					<div class="col-sm-10">
						<select class=form-control name=branch_id<?php if($this->session->userdata('level') > 6): ?> disabled<?php endif; ?>>
							<option value="-"<?php echo set_select('branch_id', '-'); ?>>请选择</option>
							<option value=""<?php echo set_select('branch_id', ''); ?>>所有门店/分公司</option>
							<?php foreach ($branchs as $branch): ?>
							<option value="<?php echo $branch['branch_id']; ?>"<?php echo set_select('branch_id', $branch['branch_id']); ?> data-biz_id="<?php echo $branch['biz_id']; ?>" data-brand_id="<?php echo $branch['brand_id']; ?>"><?php echo $branch['name']; ?></option>
							<?php endforeach; ?>
						</select>
						<?php echo form_error('branch_id'); ?>
					</div>
				</div>
			<?php else: ?>
				<input name=branch_id type=hidden value="<?php echo $this->session->userdata('branch_id'); ?>">
			<?php endif; ?>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for=stuff_id>活动负责人</label>
				<div class="col-sm-10">
					<select class=form-control name=stuff_id disabled required>
						<option value="-"<?php echo set_select('stuff_id', '-'); ?>>请选择</option>
						<option value=""<?php echo set_select('stuff_id', ''); ?>>未指定</option>
						<?php foreach ($stuffs as $stuff): ?>
						<option value="<?php echo $stuff['stuff_id']; ?>"<?php echo set_select('stuff_id', $stuff['stuff_id']); ?> data-biz_id="<?php echo $stuff['biz_id']; ?>" data-brand_id="<?php echo $stuff['brand_id']; ?>" data-branch_id="<?php echo $stuff['branch_id']; ?>"><?php echo $stuff['lastname'].$stuff['firstname']; ?></option>
						<?php endforeach; ?>
					</select>
					<?php echo form_error('stuff_id'); ?>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=name>活动名称</label>
				<div class="col-sm-10">
					<input class=form-control name=name type=text value="<?php echo set_value('name'); ?>" placeholder="30个汉字以内" required>
					<?php echo form_error('name'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=url>活动网址(选填)</label>
				<div class="col-sm-10">
					<input class=form-control name=url type=url value="<?php echo set_value('url'); ?>" placeholder="http://" required>
					<?php echo form_error('url'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=time_start>开始时间(选填)</label>
				<div class="col-sm-10">
					<input class=form-control name=time_start type=date value="<?php echo set_value('time_start'); ?>" placeholder="YYYY-MM-DD">
					<?php echo form_error('time_start'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=time_end>结束时间(选填)</label>
				<div class="col-sm-10">
					<input class=form-control name=time_end type=date value="<?php echo set_value('time_end'); ?>" placeholder="YYYY-MM-DD">
					<?php echo form_error('time_end'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=detail>活动简介(选填)</label>
				<div class="col-sm-10">
					<textarea class="form-control" name=detail rows="5"><?php echo set_value('detail'); ?></textarea>
					<?php echo form_error('detail'); ?>
				</div>
			</div>
		</fieldset>
		<button class="btn btn-primary">确定</button>
	</form>
</div>
<script>
	$(function(){
		//jqueryUI日期选择器
	    $('input[name=time_start]').datepicker({
			defaultDate: "+1d",
			maxDate: "+1Y",
			changeMonth: true,
			onClose: function(selectedDate){
				$('input[name=time_end]').datepicker("option", "minDate", selectedDate);
			}
		});
		$('input[name=time_end]').datepicker({
			changeMonth: true,
			onClose: function(selectedDate){
				$('input[name=time_start]').datepicker("option", "maxDate", selectedDate);
			}
		});
		
		//链式选择
		$('select[name=biz_id]').change(function(){
			var biz_id = $(this).val();
			$('select[name=brand_id],select[name=stuff_id]').removeAttr('disabled');
			$('select[name=brand_id] option,select[name=stuff_id] option').show();
			$('select[name=brand_id] option[data-biz_id!='+biz_id+'],select[name=stuff_id] option[data-biz_id!='+biz_id+']').hide();
		});
		$('select[name=brand_id]').change(function(){
			$('select[name=branch_id]').removeAttr('disabled');
		});
		
		//表单验证
		$('form').submit(function(){
			<?php if($this->session->userdata('level') > 7): ?>
			var biz_id = $('select[name=biz_id]').val();
			if(biz_id == '-')
			{
				alert('请选择参与活动的公司');
				$('select[name=biz_id]').closest('.form-group').addClass('has-error');
				return false;
			}
			<?php endif; ?>
			
			<?php if($this->session->userdata('level') > 6): ?>
			var brand_id = $('select[name=brand_id]').val();
			if(brand_id == '-')
			{
				alert('请选择参与活动的品牌');
				$('select[name=brand_id]').closest('.form-group').addClass('has-error');
				return false;
			}
			<?php endif; ?>
			
			<?php if($this->session->userdata('level') > 5): ?>
			var branch_id = $('select[name=branch_id]').val();
			if(branch_id == '-')
			{
				alert('请选择参与活动的门店/分公司');
				$('select[name=branch_id]').closest('.form-group').addClass('has-error');
				return false;
			}
			<?php endif; ?>
			
			var stuff_id = $('select[name=stuff_id]').val();
			if(stuff_id == '-')
			{
				alert('请选择活动负责人');
				$('select[name=stuff_id]').closest('.form-group').addClass('has-error');
				return false;
			}
		});
	});
</script>