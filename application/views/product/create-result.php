<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li><a href="<?php echo base_url('product'); ?>">产品</a></li>
  <li><a href="<?php echo base_url('product/create'); ?>">新增</a></li>
  <li class=active>新增成功</li>
</ol>
<div class=content>
	<ul id=created class=list-unstyled>
		<li>品名 <?php echo $product['name']; ?></li>
		<li>成分 <?php echo $product['detail']; ?></li>
		<li><img alt="<?php echo $product['name']; ?>" src="<?php echo base_url($product['image']); ?>"></li>
	</ul>
	<a class="btn btn-primary" title="新增产品" href="<?php echo base_url('product/create'); ?>">再新建一个产品</a>
	<a class=btn title="查看全部产品" href="<?php echo base_url('product'); ?>">查看全部产品</a>
</div>