<ul class=list-unstyled>
<?php foreach ($users as $user): ?>
	<li><?php echo $group = ($user['group'] == 1)?'普通会员':'充值会员'; ?></li>
    <li><?php echo $user['lastname'].$user['firstname'];echo $gender = ($user['gender'] == 0)?'女士':'先生'; ?></li>
	<li>手机号 <?php echo $user['mobile']; ?></li>
	<li>消费 <?php echo $user['summary']; ?>元</li>
	<li>积分 <?php echo $user['credit']; ?>分</li>
	<li>生日 <?php echo $user['dob']; ?></li>
	<li>加入时间 <?php echo $user['join']; ?></li>
<?php endforeach ?>
</ul>