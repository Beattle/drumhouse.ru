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
<div class="box">
  <div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><?php echo $entry_category . ' #1:'; ?></td>
          <td>
            <select name="href_1">
              <option value="0" selected="selected"><?php echo $text_none; ?></option>
              <?php foreach ($categories as $category) { ?>
              <?php if ($category['category_id'] == $href_1) { ?>
              <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_category . ' #2:'; ?></td>
          <td>
            <select name="href_2">
              <option value="0" selected="selected"><?php echo $text_none; ?></option>
              <?php foreach ($categories as $category) { ?>
              <?php if ($category['category_id'] == $href_2) { ?>
              <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_category . ' #3:'; ?></td>
          <td>
            <select name="href_3">
              <option value="0" selected="selected"><?php echo $text_none; ?></option>
              <?php foreach ($categories as $category) { ?>
              <?php if ($category['category_id'] == $href_3) { ?>
              <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_category . ' #4:'; ?></td>
          <td>
            <select name="href_4">
              <option value="0" selected="selected"><?php echo $text_none; ?></option>
              <?php foreach ($categories as $category) { ?>
              <?php if ($category['category_id'] == $href_4) { ?>
              <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
        </tr>

      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>