		<div class="recomend">
			<p class="recomend-title">
				<?php echo $heading_title; ?>
				<i class="basket-arr"></i>
				<i class="recomend-ico"></i>
			</p>
			<div class="recomend-body">
                <?php foreach ($products as $product) { ?>

				<div class="recomend-body_item">
				  <p class="recomend-body_item-title">
					<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
				  </p>
				  <div class="recomend-body_item_im">
				  	 <p class="recomend-body_item_im_star"><img src="catalog/view/theme/default/image/i/star.gif" alt="<?php echo $product['reviews']; ?>" /></p>
				  	 <!--<p class="recomend-body_item_im_star"><img src="catalog/view/theme/default/image/stars-<?php //echo $product['rating']; ?>.png" alt="<?php //echo $product['reviews']; ?>" /></p>-->
					 <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" id="image<?php echo $product['product_id']; ?>" alt="<?php echo $product['name']; ?>" /></a>
				  </div>
				  <div class="recomend-body_item_txt">

                    <?php if ($product['price']) { ?>
                      <?php if (!$product['special']) { ?>
  		                <p class="item-price-old"><s><br /></s></p>
  		                <p class="item-price-new"><?php echo $product['price']; ?></p>
                      <?php } else { ?>
  		                <p class="item-price-old"><s><?php echo $product['price']; ?></s></p>
  			            <p class="item-price-new"><?php echo $product['special']; ?></p>
                      <?php } ?>
                    <?php } ?>

				  	<p><a href="<?php echo $product['href']; ?>">Подробнее...</a></p>
				  </div>
				</div>

                <?php } ?>

				<i class="sh-line-wrap"><i class="sh-line"></i></i>
			</div>
		</div>
