<?php
	$bucket = 'key2all-images';// 空间名
	$form_api_secret = 'uv1j1O8W7vRtKjINzGtCfje66Yc=';// 表单 API 验证密匙：需要访问UPYUN管理后台的空间管理页面获取

	$options = array();
	$options['bucket'] = $bucket;

	// 授权过期时间：以页面加载完毕开始计时，60秒内有效
	$options['expiration'] = time()+60;

	// 保存路径：最终将以"/年/月/日/upload_待上传文件名"的形式进行保存
	$options['save-key'] = '/activity/vote/1/{year}{mon}{day}_{hour}{min}{sec}{.suffix}';

	// 文件类型限制：仅允许上传扩展名为 jpg,png 三种类型的文件
	$options['allow-file-type'] = 'jpg,png';
	
	// 文件大小限制：如 102400,1024000单位：Bytes含义：仅允许上传 10Kb～4Mb 的文件
	$options['content-length-range'] = '10240,4096000';
	
	// 图片宽度限制：仅允许上传宽度在 1～4096px 范围的图片文件
	$options['image-width-range'] = '1,4096';

	// 图片高度限制：仅允许上传高度在 1～4096px 范围的图片文件
	$options['image-height-range'] = '1,4096';

	// 同步跳转 url：表单上传完成后，使用 http 302 的方式跳转到该 URL
	$options['return-url'] = 'http://sitelang.cn/upload/';

	// 异步回调 url：表单上传完成后，云存储服务端主动把上传结果 POST 到该 URL
	// 请注意该地址必须公网可以正常访问
	// $options['notify-url'] = 'http://sitelang.cn/test.php';

	// 缩略类型：限定最长边，短边自适应
	//$options['x-gmkerl-type'] = 'fix_max';
	//$options['x-gmkerl-value'] = '1024';

	//保留 EXIF 信息) 1.仅搭配“破坏性处理”的参数使用时有效，其他处理均无效；2.“破坏性处理”包括裁剪(x-gmkerl-crop)、缩略类型(x-gmkerl-type)、自定义版本(x-gmkerl-thumbnail)
	$options['x-gmkerl-exif-switch'] = 'true';

	// 计算 policy 内容，具体说明请参阅"Policy 内容详解"
	$policy = base64_encode(json_encode($options));

	// 计算签名值，具体说明请参阅"Signature 签名"
	$signature = md5($policy.'&'.$form_api_secret);
	
	//根据错误提示信息进行错误说明
	function error($message)
	{
		switch($message)
		{
			case 'Not accept, No file data':
			  return '请选择需要上传的文件';
			  break;
			case 'Authorize has expired':
			  return '打开上传页面之后请在1分钟内上传';
			  break;
			case 'Not accept, File size too small':
			case 'Not accept, File size too large':
			  return '请上传大小在10KB~4MB之间的文件';
			  break;
			case 'Not accept, File type Error':
			case 'Not accept, Not an image file':
			  return '请上传jpg、png、gif格式的图片';
			  break;
  			case 'Not accept, Image width too small':
  			case 'Not accept, Image width too large':
  			  return '请上传宽度在1px~4096px之间的图片';
  			  break;
			case 'Not accept, Image height too small':
			case 'Not accept, Image height too large':
			  return '请上传高度在1px~4096px之间的图片';
			  break;
			default:
			  return $message;
		}
	}
?>
<ol class=breadcrumb>
	<li><a href="<?php echo base_url(); ?>">首页</a></li>
	<li class=active>上传</li>
</ol>
<div id=content>
<?php if(isset($_GET['code'])): ?>
	<?php if($this->input->get('code', TRUE) == 200): ?>
	<h2>上传成功</h2>
	<p class="alert alert-success">已经成功将图片上传，您可以<a href="<?php echo base_url('upload'); ?>" class=alert-link>再上传一张</a></p>
	<blockquote>文件路径 http://images.key2all.com<?php echo $this->input->get('url', TRUE); ?></blockquote>
	<?php else: ?>
	<h2>上传失败</h2>
	<div class="alert alert-danger">图片上传出现错误，<?php echo error($this->input->get('message', TRUE)); ?>，您可以<a href="<?php echo base_url('upload'); ?>" class=alert-link>重新上传</a></div>
	<blockquote>错误描述 <?php echo $this->input->get('code', TRUE); ?> <?php echo $this->input->get('message', TRUE); ?></blockquote>
	<?php endif; ?>
	<a class="btn btn-primary" id=upload href="<?php echo base_url('upload'); ?>"><?php echo ($this->input->get('code', TRUE) == '200')?'再上传一张':'重新上传'; ?></a>

<?php else: ?>
    <form method=post enctype="multipart/form-data" action="http://v0.api.upyun.com/<?php echo $bucket; ?>">
      <!-- 需要传递以下三个表单内容 -->
      <input type=hidden name=policy value="<?php echo $policy?>">
      <input type=hidden name=signature value="<?php echo $signature?>">
	  <div class=form-group>
	      <label for=file class="col-sm-2 control-label text-right">图片</label>
	      <div class=col-sm-10>
			  <input class=form-control type=file name=file placeholder="请选择需要上传的图片">
			  <p class=help-block><span class="label label-info">说明</span> 为保证显示效果和网页打开速度，请上传宽度和高度在<span class=text-info>0～4096px</span>之间的图片；显示效果最佳的图片尺寸为<span class=text-info>1024px*768px</span>。</p>
	      </div>
	  </div>
	  <div class="col-sm-offset-2 col-sm-10">
		  <a class="btn btn-primary" id=upload href=#>上传</a>
	  </div>
    </form>
	<script>
		$(function(){
			$('a#upload').click(function(){
				$('form').submit();
				/*
				$.post(
					'http://v0.api.upyun.com/<?php echo $bucket; ?>',
					{
						file: $('input[name=file]').val(),
						policy: $('input[name=policy]').val(),
						signature: $('input[name=signature]').val()
					},
					function(data){
						alert('Data: ' + data);
					}
				);
				*/
				return false;
			});
		});
	</script>
<?php endif; ?>
</div>