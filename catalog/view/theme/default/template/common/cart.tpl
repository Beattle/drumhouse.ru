  <!--<div class="basket-body">-->

  <?php if ($products) { ?>
        <table class="t-basket">
            <?php foreach ($products as $product) { ?>
				<tr>
					<td widht="20" align="right"><i class="del" onclick="removeCart('<?php echo $product['key']; ?>');"></i></td>
					<td widht="20" align="left">x&nbsp;<?php echo $product['quantity']; ?></td>
        		    <td widht="160" align="left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
		              <div>
		                <?php foreach ($product['option'] as $option) { ?>
		                  - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
		                <?php } ?>
		              </div>
                    </td>
        		    <td class="td1" widht="40" ><?php echo $product['total']; ?></td>
				</tr>
            <?php } ?>


		</table>

        <?php foreach ($totals as $total) { ?>
			<p class="total"><?php //echo $total['title']; ?>Итого:&nbsp;<?php echo $total['text']; ?></p>
		<?php } ?>

      	<ul class="basket-links">
      		<li><a href="<?php echo $checkout; ?>">Оформить<i></i></a></li>
      		<li><a href="<?php echo $cart; ?>">Открыть корзину<i></i></a></li>
      	</ul>

      	<i class="sh-line-wrap"><i class="sh-line"></i></i>

	<?php } else { ?>
		<div class="empty"><?php echo $text_empty; ?></div>
	<?php } ?>

  <!--</div>-->
