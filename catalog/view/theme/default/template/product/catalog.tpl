<?php echo $header; ?>

    <div class="leftblock">

        <?php echo $content_top; ?>

		<div class="b-col">
			<h1 class="pt101"><?php echo $heading_title; ?></h1>

            <?php echo $column_center; ?>

			<div class="item-catalog">

                <?php foreach ($categories as $category) { ?>

				  <div class="b-item-catalog">
        		  <h5>
                    <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?>
                    <div class="b-item-catalog_img">
                      <div class="b-item-catalog_img10 b-item-catalog_img12">
                        <?php if ($category['image']) { ?>
                          <img src="<?php echo $category['image']; ?>" title="<?php echo $category['name']; ?>" alt="<?php echo $category['name']; ?>" />
                        <?php } ?>
                      </div>
                      <div class="b-item-catalog_img11"></div>
                    </div></a>
                  </h5>

                  <?php if ($category['children']) { ?>
        		  <ul class="b-item-catalog_sp">
                      <?php $k = 1; ?>
                      <?php foreach ($category['children'] as $child) { ?>
                          <?php if ($child['category_id'] == $child_id) { ?>
                            <li class="active">
                              <?php echo $child['name']; ?>
                            </li>
                          <?php } else { ?>
                            <li>
                              <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
                            </li>
                          <?php } ?>
                      <?php if ($k++ >= 4) break; ?>
                      <?php } ?>
                  </ul>
                  <?php } ?>
                  <?php if (count($category['children']) > 4) { ?>
        		    <p class="view-all-sp"><a onclick="showSubCategory(<?php echo $category['category_id']; ?>)" href="javascript:void(0)">Показать список <i></i></a></p>
                  <?php } ?>

					<div class="b-item-catalog_drop" id="cat_<?php echo $category['category_id']; ?>" style="display: none">
            		  <h5>
                        <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?>
                        <div class="b-item-catalog_img"><div class="b-item-catalog_img10 b-item-catalog_img12"></div></div></a>
                      </h5>

                      <?php if ($category['children']) { ?>
            		  <ul class="b-item-catalog_sp">
                          <?php foreach ($category['children'] as $child) { ?>
                              <?php if ($child['category_id'] == $child_id) { ?>
                                <li class="active">
                                  <?php echo $child['name']; ?>
                                </li>
                              <?php } else { ?>
                                <li>
                                  <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
                                </li>
                              <?php } ?>
                          <?php } ?>
                      </ul>
                      <?php } ?>
					  <p class="view-all-sp view-all-sp2"><a onclick="hideSubCategory()" href="javascript:void(0)">Скрыть список <i></i></a></p>
					  <i class="b-item-catalog_drop_bg"></i>
					</div>

				  </div>
                <?php } ?>

			</div>

        <?php echo $content_bottom; ?>

       	    <p class="to-top"><a onclick="jQuery('html, body').animate({scrollTop: '0px'}, 800);" >Вверх страницы</a></p>


		</div><!--end b-col-->
    </div><!--end leftblock-->

    <div class="rightblock">
        <?php echo $column_right; ?>
    </div><!--end rightblock -->
  <div class="clear"></div>

<script language="JavaScript" type="text/javascript">
    function hideSubCategory() {
        $('.b-item-catalog_drop').each(function() {
            //$(this).css('display', 'none');
            $(this).slideUp("fast");
            //$(this).fadeOut();
        });
        return false;
    }

    function showSubCategory(id) {
        $('.b-item-catalog_drop').each(function() {
            //$(this).css('display', 'none');
            $(this).slideUp("fast");
        });

        $('#cat_'+id).each(function() {
            //$(this).css('display', 'block');
            $(this).slideDown("fast");
        });
        return false;
    }
</script>

<?php echo $footer; ?>