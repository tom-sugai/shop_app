<div class="products cartlist">
<h2><?php echo __('Cart List'); ?></h2>



  <table celpadding="0" cellspacing="0">
  	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
  
    <?php
    $i = 0;
    foreach ($products as $product):
      $class = null;
      if($i++ % 2 == 0) {
        $class = ' class="altrow"';
      }
    ?>

	<tr<?php echo $class; ?>>
		<td><?php echo __('Id'); ?></td>
		<td><?php echo h($product['Product']['id']); ?></td>
		<td><?php echo h($product['Product']['name']); ?></td>
		<td><?php echo h($product['Product']['created']); ?></td>
		<td><?php echo h($product['Product']['modified']); ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('delete',true), array('action' => 'delcart', $product['Product']['id'])); ?>
		</td>	</tr>
	<?php endforeach; ?>	
  </table>
  
   <div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Cart'), array('controller' => 'products', 'action' => 'cartlist')); ?> </li>
		<li><?php echo $this->Html->link(__('Product List'), array('action' => 'index')); ?></li>
	</ul>
  </div>
</div>

