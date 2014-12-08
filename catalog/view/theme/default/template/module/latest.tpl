			<h1><?php echo $heading_title; ?></h1>

            <div class="items">

                <?php if ($products) { ?>
                    <?php foreach ($products as $product) { ?>

    					<div class="b-item">
    					  <div class="item-title">
    					    <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?> <div class="item-im"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></div></a>
    						<span class="item-status">Хит!</span>
    					  </div>

                        <?php if ($product['rating']) { ?>
        				    <span class="star"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></span>
                        <?php } ?>

    					  <p class="item-info"><?php echo $product['description']; ?></p>
    					  <div class="item-bot">
                          <?php if ($product['price']) { ?>
                            <?php if (!$product['special']) { ?>
    						    <p class="item-price-old"><s><br /></s></p>
    						    <p class="item-price-new"><?php echo $product['price']; ?></p>
                            <?php } else { ?>
    						    <p class="item-price-old"><s><?php echo $product['price']; ?></s></p>
    							<p class="item-price-new"><?php echo $product['special']; ?></p>
                            <?php } ?>
                          <?php } ?>

    						<div class="item-to-basket">
    						  <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="item-basket-ico"></a>
    						  <p class="item-nal">Есть в наличии</p>
    						</div>
    					  </div>
    					</div>

                    <?php } ?>

                <?php } ?>
                <?php if (!$products) { ?>
                  <?php echo $text_empty; ?>
                <?php } ?>

            </div>
			<a href="<?php echo $continue; ?>"><?php echo $text_prompt; ?></a> &rarr;<br /><br />

            <div class="page-stats"><?php echo $pagination; ?></div>

			<p class="to-top"><a onclick="jQuery('html, body').animate({scrollTop: '0px'}, 800);" >Вверх страницы</a></p>

		<div class="clear"></div>


