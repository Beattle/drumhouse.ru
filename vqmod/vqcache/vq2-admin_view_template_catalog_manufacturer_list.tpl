<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>

                <!--
                * simonfilters - 2.12.0 Build 0001 Code START
                *-->
                <td class="right">SimonFilters</td>
                <script>
                $(function(){
                    $("a.simonseesme").click(function(event){
                       event.preventDefault();
                       var $_this = $(this);
                       data = {
                            simonseesme : $_this.text().trim()=='Yes'?0:1
                       };
                       $.get($(this).attr("href"),data,function(data){
                            $_this.text( $_this.text().trim()=='Yes'?'No':'Yes' );
                       });
                    });
                });
                </script>
                <!--
                * simonfilters - 2.12.0 Build 0001 Code END
                *-->
                    
            
              <td class="right"><?php if ($sort == 'sort_order') { ?>
                <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($manufacturers) { ?>
            <?php foreach ($manufacturers as $manufacturer) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($manufacturer['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $manufacturer['name']; ?></td>

                <!--
                * simonfilters - 2.12.0 Build 0001 Code START
                *-->
                <td class="right">
                <a href="<?php echo $manufacturer['simonseesme_link'];?>" class="simonseesme">
                <?php echo $manufacturer['simonseesme']?'<font color="green">Yes</font>':'No'; ?>
                </a>
                </td>
                <!--
                * simonfilters - 2.12.0 Build 0001 Code END
                *-->
                    
            
              <td class="right"><?php echo $manufacturer['sort_order']; ?></td>
              <td class="right"><?php foreach ($manufacturer['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>