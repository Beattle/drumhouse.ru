<!-- /**
 * User: Hipno
 * Date: 25.11.14
 * Time: 18:09
 * Project: drumhouse.ru
 */ -->
<div id="search-block-sku">
    <h1>Поиск по артикулу</h1>
    <?php if($product): ?>
<div class="b-item">
    <div class="item-title">
        <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?> <div class="item-im"><img src="<?php echo $product['thumb']; ?>" id="image<?php echo $product['product_id']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></div></a>
        <?php if ($product['status_new']) { ?>
            <div class="item-status">
                <span class="item-status-new"></span>
            </div>
        <?php } else {
            if ($product['status_hit']) { ?>
                <div class="item-status">
                    <span class="item-status-top"></span>
                </div>
            <?php } ?>
        <?php } ?>
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
    <?php else: ?>
        <span class="warn-message">Нет товаров, которые соответствуют критериям поиска</span>
    <?php endif; ?>
</div>
</div>
