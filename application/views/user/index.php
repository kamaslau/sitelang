<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li class=active>会员</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr>
				<th>会员ID</th><th>姓名</th><th>性别</th><th>累计消费</th><th>积分余额</th><th>手机号</th><th>邮箱</th><th>生日</th><th>加入时间</th>
			<?php if($this->session->userdata('level') == '2'): ?>
				<th>操作</th>
			<?php endif; ?>
			</tr>
		</thead>
		<tbody>
<?php foreach ($users as $user_item): ?>
	<tr<?php
			if($user_item['group'] == 2):
				echo ' class=vip';
			endif;?>>
		<td><?php echo $user_item['user_id']; ?></td>
	    <td>
			<?php $name = $user_item['lastname'].$user_item['firstname'];echo $name; ?>
		</td>
	    <td><?php $gender = ($user_item['gender'] == 0)?'女士':'先生';echo $gender; ?></td>
		<td><?php echo $user_item['summary']; ?></td>
		<td><?php echo $user_item['credit']; ?></td>
		<td><?php echo $user_item['mobile']; ?></td>
		<td><?php echo $user_item['email']; ?></td>
		<td><?php echo $user_item['dob']; ?></td>
		<td><?php echo $user_item['time_create']; ?></td>
		<td>
			<?php if($this->session->userdata('level') == '2'): ?>
			<a title="会员等级调整" href="
		<?php
			if($user_item['group'] == 1):
				echo base_url('user/regroup/'.$user_item['user_id'].'/2');
			else:
				echo base_url('user/regroup/'.$user_item['user_id'].'/1');
			endif;
		?>
		"><span class="glyphicon glyphicon-sort"></span>
		<?php
			if($user_item['group'] == 1):
				echo '升为充值会员';
			else:
				echo '改为普通会员';
			endif;
		?>
			</a>
		<?php endif; ?>
		</td>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
</div>