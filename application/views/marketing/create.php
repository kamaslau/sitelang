<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li><a href="<?php echo base_url('marketing'); ?>">营销活动</a></li>
  <li class=active>新增</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
<?php
	$attributes = array('class' => 'form-marketing-create', 'role' => 'form');
	echo form_open(base_url('marketing/create'), $attributes);
?>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=activity_id>活动ID</label>
				<div class="col-sm-10">
					<input class=form-control name=activity_id type=number step=1 min=0 value="<?php echo set_value('activity_id'); ?>" placeholder="请输入正确的活动ID" required>
					<?php echo form_error('activity_id'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=ad_id>素材ID</label>
				<div class="col-sm-10">
					<input class=form-control name=ad_id type=number step=1 min=0 value="<?php echo set_value('ad_id'); ?>" placeholder="请输入正确的素材ID" required>
					<?php echo form_error('ad_id'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=poster_id>投放位ID</label>
				<div class="col-sm-10">
					<input class=form-control name=poster_id type=number step=1 min=0 value="<?php echo set_value('poster_id'); ?>" placeholder="请输入正确的投放位ID" required>
					<?php echo form_error('poster_id'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for=stuff_id>推广人ID</label>
				<div class="col-sm-10">
					<input class=form-control name=stuff_id type=number step=1 min=0 value="<?php echo set_value('stuff_id'); ?>" placeholder="请输入正确的推广人ID（可选）">
					<?php echo form_error('stuff_id'); ?>
				</div>
			</div>
		</fieldset>
		<button class="btn btn-primary">生成营销链接</button>
	</form>
	<p id=pending>正在生成……</p>
	<ul id=results></ul>
</div>
<style>
	#pending,#results{display:none;}
</style>
<script>
	$(function(){
		$('form').submit(function(){
			var activity_id = $('[name=activity_id]').val();
			var ad_id = $('[name=ad_id]').val();
			var poster_id = $('[name=poster_id]').val();
			var stuff_id = $('[name=stuff_id]').val();
			var params = {'activity_id':activity_id,'ad_id':ad_id,'poster_id':poster_id,'stuff_id':stuff_id};
			var url_string = '/' + activity_id + '/' + ad_id + '/' + poster_id + '/1/' + stuff_id + '/';
			$('#results').html('').html(url_string).show();//默认推广人为内部员工身份
			
			
			$.post('<?php echo base_url('r/generate'); ?>' + url_string, params, function(data){
						$('#pending').slideDown(500);//提示正在处理
						$('#results').html('').show();//清空生成结果区内容
						$('#results').html(
							//'<li class=qrcode>'+
							//'	<h3>二维码</h3>'+
							//'		<img alt="二维码" src="' + '' + '">'+
							//'</li>'+
							'<li class="bg-success">'+
							'	<h3>链接</h3>'+
							'   <p>http://www.sitelang.cn/r/' + data + '</p>'+
							'</li>'
						);
						$('#pending').slideUp(800);//处理提示收起
					});
			
			return false;
		});
	});
</script>