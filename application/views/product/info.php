<ul class=list-unstyled>
<?php foreach ($products as $product): ?>
	<li><img class=thumbnail src="http://images.key2all.com/product/<?php echo $product['image']; ?>" alt="<?php echo $product['name'] ?>"></li>
	<li><?php echo $product['name']; ?></li>
	<li>现金价格 <?php echo $product['price_cash']; ?>元</li>
	<li>积分价格 <?php echo $product['price_credit']; ?>个</li>
	<li><?php echo $group = ($product['credit_group'] == 1)?'普通会员':'充值会员'; ?>即可换购</li>
<?php endforeach ?>
</ul>