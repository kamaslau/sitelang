<ol class=breadcrumb>
	<li><a href="<?php echo base_url(); ?>">首页</a></li>
	<li><a href="<?php echo base_url('vote'); ?>">投票</a></li>
	<li class=active>投票选项</li>
</ol>
<div id=content>
	<h2><?php echo $title; ?></h2>
	<p><?php echo $content; ?></p>
	<p><a class="btn btn-primary" title="投票选项管理" href="<?php echo base_url('vote/option'); ?>">投票选项管理</a></p>
</div>