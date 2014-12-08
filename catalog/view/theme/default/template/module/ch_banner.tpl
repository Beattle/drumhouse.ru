<?php if ($visible) { ?>

  <?php if($box) { ?>
    <div class="box">
	<?php if($heading_title) { ?>
        <div class="box-heading"><?php echo $heading_title; ?></div>
	<?php } ?>
      <div class="box-content">
        <div class="box-category">

          <div class="main-txt">
            <?php if ($begin_description) { ?>
              <?php echo $begin_description; ?>
                <?php if ($end_description) { ?>
                  <p class="main-txt-more"><a onclick="showMore()" href="javascript:void(0)">Читать далее<i></i></a></p>
                  <div class="more-text" style="display:none;">
                    <?php echo $end_description; ?>
                    <p class="main-txt-less"><a onclick="hideMore()"href="javascript:void(0)">Свернуть<i></i></a></p>
                  </div>
                <?php } ?>
            <?php } ?>
          </div>

	    </div>
	  </div>
	</div>

  <?php } else { ?>

    <div class="main-txt">
      <?php if ($begin_description) { ?>
        <?php echo $begin_description; ?>
          <?php if ($end_description) { ?>
            <p class="main-txt-more"><a onclick="showMore()" href="javascript:void(0)">Читать далее<i></i></a></p>
            <div class="more-text" style="display:none;">
              <?php echo $end_description; ?>
              <p class="main-txt-less"><a onclick="hideMore()"href="javascript:void(0)">Свернуть<i></i></a></p>
            </div>
          <?php } ?>
      <?php } ?>
    </div>

  <?php } ?>
<?php } ?>
