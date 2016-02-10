<?php
	//显示权限名称
	function level($level)
	{
		switch($level)
		{
			case 0:
			  return '未授权';
			  break;
			case 1:
			  return '员工';
			  break;
			case 2:
			  return '财务';
			  break;
			case 3:
			  return '收银';
			  break;
  			case 4:
  			  return '经理';
  			  break;
  			case 5:
  			  return '店长';
  			  break;
  			case 8:
  			  return '管理员';
  			  break;
  			case 9:
  			  return '超级管理员';
  			  break;
			default:
			  return '不明权限';
		}
	}
?>
<ul class=list-unstyled>
<?php foreach ($stuffs as $stuff): ?>
	<li><?php echo level($stuff['level']); ?></li>
    <li><?php echo $stuff['lastname'].$stuff['firstname'];$gender = ($stuff['gender'] == 0)?'女士':'先生';echo $gender; ?></li>
	<li>手机号 <?php echo $stuff['mobile']; ?></li>
<?php endforeach ?>
</ul>