
      <div class="b-tabs2">
        <ul class="tab-nav2">
          <li class="active"><a href="#tab-body3"><?php echo $tab_title_1; ?></a><i class="div-l"></i><i class="blue-line"></i></li>
          <li><a href="#tab-body4"><?php echo $tab_title_2; ?></a><i class="blue-line"></i></li>
          <li><a href="#tab-body5"><?php echo $tab_title_3; ?></a></li>
        </ul>

		<div class="tab2-body" id="tab-body3">
            <div class="items">
                <?php if ($products_bestseller) { ?>
                    <?php foreach ($products_bestseller as $product) { ?>

    					<div class="b-item">
    					  <div class="item-title">
    					    <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?> <div class="item-im"><img src="<?php echo $product['thumb']; ?>" id="image<?php echo $product['product_id']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></div></a>
    					  </div>

                        <?php if ($product['rating']) { ?>
        				    <span class="star"><img src="catalog/view/theme/default/image/i/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></span>
                        <?php } ?>

    					  <p class="item-info">
                            <?php echo $product['description']; ?>
                          </p>
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
    						  <p class="item-nal"><?php echo $product['stock']; ?></p>
    						</div>
    					  </div>
    					</div>

                    <?php } ?>

                <?php } ?>
            </div>
            <?php if (!$products_bestseller) { ?>
                <p style="text-align:center;margin-bottom: 20px;"><?php echo $text_empty; ?></p>
            <?php } else { ?>
                <p class="view-all-tabcontent"><a href="<?php echo $continue_1; ?>"><?php echo $text_prompt_1; ?></a> &rarr;</p>
            <?php } ?>
        </div>

        <div class="tab2-body" id="tab-body4">
            <div class="items">
                <?php if ($products_latest) { ?>
                    <?php foreach ($products_latest as $product) { ?>

    					<div class="b-item">
    					  <div class="item-title">
    					    <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?> <div class="item-im"><img src="<?php echo $product['thumb']; ?>" id="image<?php echo $product['product_id']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></div></a>
    					  </div>

                        <?php if ($product['rating']) { ?>
        				    <span class="star"><img src="catalog/view/theme/default/image/i/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></span>
                        <?php } ?>

    					  <p class="item-info">
                            <?php echo $product['description']; ?>
                          </p>
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
    						  <p class="item-nal"><?php echo $product['stock'];?></p>
    						</div>
    					  </div>
    					</div>

                    <?php } ?>

                <?php } ?>

            </div>
            <?php if (!$products_latest) { ?>
                <p style="text-align:center;margin-bottom: 20px;"><?php echo $text_empty; ?></p>
            <?php } else { ?>
                <p class="view-all-tabcontent"><a href="<?php echo $continue_2; ?>"><?php echo $text_prompt_2; ?></a> &rarr;</p>
            <?php } ?>
        </div>

		<div class="tab2-body" id="tab-body5">
            <div class="items">
                <?php if ($products_special) { ?>
                    <?php foreach ($products_special as $product) { ?>

    					<div class="b-item">
    					  <div class="item-title">
    					    <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?> <div class="item-im"><img src="<?php echo $product['thumb']; ?>" id="image<?php echo $product['product_id']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></div></a>
    					  </div>

                        <?php if ($product['rating']) { ?>
        				    <span class="star"><img src="catalog/view/theme/default/image/i/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></span>
                        <?php } ?>

    					  <p class="item-info">
                            <?php echo $product['description']; ?>
                          </p>
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
    						  <p class="item-nal"><?php echo $product['stock']; ?></p>
    						</div>
    					  </div>
    					</div>

                    <?php } ?>

                <?php } ?>

            </div>
            <?php if (!$products_special) { ?>
                <p style="text-align:center;margin-bottom: 20px;"><?php echo $text_empty; ?></p>
            <?php } else { ?>
                <p class="view-all-tabcontent"><a href="<?php echo $continue_3; ?>"><?php echo $text_prompt_3; ?></a> &rarr;</p>
            <?php } ?>
        </div>
        </div>

	  <p class="to-top"><a onclick="jQuery('html, body').animate({scrollTop: '0px'}, 800);" >Вверх страницы</a></p>

	  <div class="clear">

	  </div>

<script type="text/javascript"><!--
$(document).ready(function(){
    //arrangeItem();
});
//--></script>
