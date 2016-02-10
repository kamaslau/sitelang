<ol class=breadcrumb>
  <li><a href="<?php echo base_url(); ?>">首页</a></li>
  <li class=active>产品</li>
</ol>
<div id=content>
	<h2><?php echo $title ?></h2>
	<?php if ($this->session->userdata('level') > 5): ?>
	<a class="btn btn-primary" title="添加新产品" href="<?php echo base_url('product/create') ?>">添加新产品</a>
	<?php endif ?>
	<table class="table table-condensed table-hover table-responsive table-striped sortable">
		<thead>
			<tr><th>产品ID</th><th>图片</th><th>名称</th><th>详情</th><th>现金价</th><th>积分价</th><th>操作</th></tr>
		</thead>
		<tbody>
<?php foreach ($products as $product): ?>
	<tr>
		<td><?php echo $product['product_id'] ?></td>
	    <td><img class=thumbnail width=100 src="http://images.key2all.com/product/<?php echo $product['image'] ?>" alt="<?php echo $product['name'] ?>"></td>
	    <td><?php echo $product['name'] ?></td>
	    <td><?php echo $product['detail'] ?></td>
		<td><?php if (isset($product['price_cash'])){echo $product['price_cash'];}else{echo '-';} ?></td>
		<td><?php if (isset($product['price_credit'])){echo $product['price_credit'];}else{echo '-';} ?></td>
		<td>
			<?php if ($this->session->userdata('level') > 5): ?>
			<ul class=list-unstyled>
				<li><a title="编辑<?php echo $product['name'] ?>" href="<?php echo 'product/edit/'.$product['product_id']; ?>"><span class="glyphicon glyphicon-edit"></span></a></li>
				<?php if ($product['status'] == 1): ?>
				<li><a title="下架<?php echo $product['name'] ?>" href="<?php echo 'product/status/'.$product['product_id'].'/2'; ?>"><span class="glyphicon glyphicon-import"></span></a></li>
				<?php else: ?>
				<li><a title="上架<?php echo $product['name'] ?>" href="<?php echo 'product/status/'.$product['product_id'].'/1'; ?>"><span class="glyphicon glyphicon-export"></span></a></li>
				<?php endif ?>
			</ul>
			<?php endif ?>
		</td>
	</tr>
<?php endforeach ?>
		</tbody>
	</table>
</div>