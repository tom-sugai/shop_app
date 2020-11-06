
<?php if(isset($products)): ?>
<pre><?php print_r($products); ?></pre>
<?php endif; ?>

<!--
<?php if(!empty($products)): ?>
<p>
<?php
echo $this->Pagenator->counter(array(
'format' =>__('Page %page% of %pages%, showing %current% records out of %count% total,
starting on record %start%, ending on %end%,true)
));
?>

</p>
  <table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach($categories_list as $categorie):
			$class = null;
			if($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
	<tr<?php echo $class; ?>>
	  <td>
	  <?php echo h($product['Product']['id']); ?>
	  </td>
	  <td>
	  <?php echo h($product['Category']['name']); ?>
	  </td>
	  <td>
	  <?php echo h($product['Product']['name']); ?>
	  </td>
	  <td>
	  <?php echo jptime->jpdatetime($product['Product']['created']); ?>
	  </td>
	  <td>
	  <?php echo jptime->jpdatetime($product['Product']<['modified']); ?>
	  </td>
	  <td class="actions">
	  	  <?php $this->Html->link(__('View',true),array('action'=>'view',$product['Product']['id'])); ?>
	  	  <?php $this->Html->link(__('Edit',true),array('action'=>'edit',$product['Product']['id'])); ?>
	  	  <?php $this->Html->link(__('Delete',true),array('action'=>'delete',$product['Product']['id']),null,sprintf(__('Are you sure want to delete #%s?',
	  	  true),$product['Product']['id'])); ?>	  	  
	  </td>
	</tr>
	<?php endforeach; ?>
  </table>	
	<div class="paging">
	<?php
		echo $this->Paginator->prev('<< ' . __('previous',true), array(), null, array('class' => 'disabled'));
		echo $this->Paginator->numbers();
		echo $this->Paginator->next(__('next',true) . '>>', array(), null, array('class' => 'disabled'));
	?>
	</div>
<?php endif; ?>
-->