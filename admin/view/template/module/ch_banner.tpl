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
		<div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
			<a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
		</div>
	</div>
	<div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

			<table id="module" class="list">
			<thead>
				<tr>
					<td class="left"><?php echo $entry_layout; ?></td>
					<td class="left"><?php echo $entry_position; ?></td>
					<td class="left"><?php echo $entry_status; ?></td>
					<td class="center"><?php echo $entry_sort_order; ?></td>
					<td></td>
				</tr>
			</thead>
            <?php $module_row = 0; ?>
            <?php foreach ($modules as $module) { ?>
			<tbody id="module-row<?php echo $module_row; ?>">
				<tr>
					<td class="left"><select name="ch_banner_module[<?php echo $module_row; ?>][layout_id]">
					<?php foreach ($layouts as $layout) { ?>
						<?php if ($layout['layout_id'] == $module['layout_id']) { ?>
							<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
						<?php } else { ?>
							<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
						<?php } ?>
					<?php } ?>
					</select></td>
					<td class="left"><select name="ch_banner_module[<?php echo $module_row; ?>][position]">
					<?php if ($module['position'] == 'content_top') { ?>
						<option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
					<?php } else { ?>
						<option value="content_top"><?php echo $text_content_top; ?></option>
					<?php } ?>
					<?php if ($module['position'] == 'content_bottom') { ?>
						<option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
					<?php } else { ?>
						<option value="content_bottom"><?php echo $text_content_bottom; ?></option>
					<?php } ?>
					<?php if ($module['position'] == 'column_left') { ?>
						<option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
					<?php } else { ?>
						<option value="column_left"><?php echo $text_column_left; ?></option>
					<?php } ?>
					<?php if ($module['position'] == 'column_right') { ?>
						<option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
					<?php } else { ?>
						<option value="column_right"><?php echo $text_column_right; ?></option>
					<?php } ?>
                <?php if ($module['position'] == 'column_center') { ?>
                <option value="column_center" selected="selected"><?php echo $text_column_center; ?></option>
                <?php } else { ?>
                <option value="column_center"><?php echo $text_column_center; ?></option>
                <?php } ?>
					</select></td>
					<td class="left"><select name="ch_banner_module[<?php echo $module_row; ?>][status]">
					<?php if ($module['status']) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					<?php } ?>
					</select></td>
					<td class="center">
						<input type="text" name="ch_banner_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" />
					</td>
					<td class="left">
						<a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a>
					</td>
				</tr>
			</tbody>
            <?php $module_row++; ?>
            <?php } ?>
			<tfoot>
				<tr>
					<td colspan="4"></td>
					<td class="left"><a onclick="addModule();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
				</tr>
			</tfoot>
		</table>

		<table class="form">
			<?php foreach ($languages as $language) { ?>
				<tr>
					<td><?php echo $entry_title; ?></td> 
					<td> 
					<input type="text" name="ch_banner_title<?php echo $language['language_id']; ?>" id="ch_banner_title<?php echo $language['language_id']; ?>" size="30" value="<?php echo ${'ch_banner_title' . $language['language_id']}; ?>" />
					<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /><br />
					</td>
				</tr>
			<?php } ?> 

				<tr>
					<td><?php echo $entry_box; ?></td>
					<td>
						<?php if($ch_banner_box) {
						    $checked1 = ' checked="checked"';
						    $checked0 = '';
						} else {
						    $checked1 = '';
						    $checked0 = ' checked="checked"';
						} ?>
						<label for="ch_banner_box_1"><?php echo $entry_yes; ?></label>
						<input type="radio"<?php echo $checked1; ?> id="ch_banner_box_1" name="ch_banner_box" value="1" />
						<label for="ch_banner_box_0"><?php echo $entry_no; ?></label>
						<input type="radio"<?php echo $checked0; ?> id="ch_banner_box_0" name="ch_banner_box" value="0" />
					</td>
				</tr>

				<tr style="display: none;">
					<td><?php echo $entry_root; ?></td>
					<td>
						<?php if($ch_banner_root) {
						    $checked1 = ' checked="checked"';
						    $checked0 = '';
						} else {
						    $checked1 = '';
						    $checked0 = ' checked="checked"';
						} ?>
						<label for="ch_banner_root_1"><?php echo $entry_yes; ?></label>
						<input type="radio"<?php echo $checked1; ?> id="ch_banner_root_1" name="ch_banner_root" value="1" />
						<label for="ch_banner_root_0"><?php echo $entry_no; ?></label>
						<input type="radio"<?php echo $checked0; ?> id="ch_banner_root_0" name="ch_banner_root" value="0" />
					</td>
				</tr>

                <tr style="display: none;">
                  <td><?php echo $entry_category; ?></td>
                  <td>
                    <div class="scrollbox" style="width: 450px; height: 150px;">
                      <?php $class = 'odd'; ?>
                      <?php foreach ($categories as $category) { ?>
                      <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                      <div class="<?php echo $class; ?>">
                        <?php if ($ch_banner_category && in_array($category['category_id'], $ch_banner_category)) { ?>
                        <input type="checkbox" name="ch_banner_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                        <?php echo $category['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="ch_banner_category[]" value="<?php echo $category['category_id']; ?>" />
                        <?php echo $category['name']; ?>
                        <?php } ?>
                      </div>
                      <?php } ?>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td><?php echo $entry_html; ?></td>
                  <td><?php foreach ($languages as $language) { ?>
                      <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                      <textarea name="ch_banner_html<?php echo $language['language_id']; ?>" id="ch_banner_html<?php echo $language['language_id']; ?>" cols="86" rows="06"><?php echo ${'ch_banner_html' . $language['language_id']}; ?></textarea>
                      <?php } ?>
                  </td>
                </tr>

				<tr>
					<td colspan="2">
						<span style='text-align: center;'><b><?php echo $text_module_settings; ?></b></span>
					</td>
				</tr>
			</table>

    </form>
	</div>
		<br>
		<div style="text-align:center; color:#555555;">ch_banner v<?php echo $ch_banner_version; ?></div>
</div>
<?php echo $footer; ?>

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('ch_banner_html<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="ch_banner_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="ch_banner_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '      <option value="column_center"><?php echo $text_column_center; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="ch_banner_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="center"><input type="text" name="ch_banner_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script>