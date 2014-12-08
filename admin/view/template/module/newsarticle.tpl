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
      <table id="module" class="list">
        <thead>
          <tr>
		  	<td class="center"><?php echo $entry_setting; ?></td>
            <td class="center"><?php echo $entry_limit; ?></td>
            <td class="center"><?php echo $entry_image; ?></td>
            <td class="center"><?php echo $entry_layout; ?></td>
            <td class="center"><?php echo $entry_position; ?></td>
            <td class="center"><?php echo $entry_status; ?></td>
            <td class="center"><?php echo $entry_sort_order; ?></td>
            <td colspan="2"></td>
          </tr>
        </thead>
        <?php $module_row = 0; ?>
        <?php foreach ($modules as $module) { ?>
        <tbody id="module-row<?php echo $module_row; ?>">
          <tr>
		  	<td class="center"><a id="setting-<?php echo $module_row; ?>" rel="fancybox" title="<?php echo $entry_setting;?>"><img src="view/image/product.png" title="<?php echo $entry_setting;?>" /></a></td>
            <td class="center"><input type="text" name="newsarticle_module[<?php echo $module_row; ?>][limit]" value="<?php echo $module['limit']; ?>" size="1" /></td>
            <td class="center"><input type="text" name="newsarticle_module[<?php echo $module_row; ?>][image_width]" value="<?php echo $module['image_width']; ?>" size="3" />
              <input type="text" name="newsarticle_module[<?php echo $module_row; ?>][image_height]" value="<?php echo $module['image_height']; ?>" size="3" />
              <?php if (isset($error_image[$module_row])) { ?>
              <span class="error"><?php echo $error_image[$module_row]; ?></span>
              <?php } ?></td>
            <td class="center"><select name="newsarticle_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
            <td class="center"><select name="newsarticle_module[<?php echo $module_row; ?>][position]">
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
              </select></td>
            <td class="center"><select name="newsarticle_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            <td class="center"><input type="text" name="newsarticle_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
            <td colspan="2" class="right"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
          </tr>
		  <tr id="setting-<?php echo $module_row; ?>">
		  	    <td class="center"><?php echo $text_showimg; ?><input name="newsarticle_module[<?php echo $module_row; ?>][show_img]" type="checkbox" <?php if(isset($module['show_img'])) echo 'checked="checked"'; ?>  /></td>
				<td class="center"><?php echo $text_descshow; ?><input name="newsarticle_module[<?php echo $module_row;?>][desc_show]" type="checkbox" <?php if(isset($module['desc_show'])) echo 'checked="checked"' ; ?>></td>
				<td class="center"><?php echo $text_desclimit; ?><input size="3" name="newsarticle_module[<?php echo $module_row; ?>][desc_limit]" type="text" value="<?php echo $module['desc_limit']; ?> "/></td>
				<td class="center"> <?php echo $text_showmore; ?><input name="newsarticle_module[<?php echo $module_row; ?>][more_show]" type="checkbox" <?php if(isset($module['more_show'])) echo 'checked="cheked"';?> /></td>
				<td class="center"> <?php echo $text_showdate; ?><input name="newsarticle_module[<?php echo $module_row; ?>][date_show]" type="checkbox" <?php if(isset($module['date_show'])) echo 'checked="checked"'; ?> /></td>
				<td class="center"> <?php echo $text_showcomment; ?><input  name="newsarticle_module[<?php echo $module_row; ?>][comment_show]" type="checkbox" <?php if(isset($module['comment_show'])) echo 'checked="checked"'; ?>/></td>
				<td class="center"> <?php echo $text_showvote; ?><input name="newsarticle_module[<?php echo $module_row; ?>][vote_show]" type="checkbox" <?php if(isset($module['comment_show'])) echo 'checked="checked"'; ?>/> </td>
				<td class="center"> <?php echo $text_showview; ?><input name="newsarticle_module[<?php echo $module_row; ?>][view_show]" type="checkbox" <?php if(isset($module['view_show'])) echo 'checked="checkrd"'; ?> /></td>
				 
				 <td class="center"><?php echo $text_order; ?><select name="newsarticle_module[<?php echo $module_row; ?>][art_order]">
				 	<option value="0" <?php if($module['art_order'] == 0) echo 'selected="selected"';?>>
						<?php echo $text_order_title;?>
					</option>
					<option value="1" <?php if($module['art_order'] == 1) echo 'selected="selected"';?>>
						<?php echo $text_order_creat;?>
					</option>
					<option value="2" <?php if($module['art_order'] == 2) echo 'selected="selected"';?>>
						<?php echo $text_order_modify;?>
					</option>
					<option value="3" <?php if($module['art_order'] == 3) echo 'selected="selected"';?>>
						<?php echo $text_order_vote;?>
					</option>
					<option value="4" <?php if($module['art_order'] == 4) echo 'selected="selected"';?>>
						<?php echo $text_order_view;?>
					</option>
				 </select>
			</td>
		  </tr>
		  <tr>
		  	<td colspan="4">
				<br/>
				<?php echo $text_category; ?>
				<?php echo $this->config->get('newsmodulecategory'); ?>
				<br/>

				<div class="scrollbox" style="height:200px;">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($news_categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (isset($module['newsmodulecategory']) && in_array($category['news_category_id'], $module['newsmodulecategory'])) { ?>
                    <input type="checkbox" name="newsarticle_module[<?php echo $module_row; ?>][newsmodulecategory][]" value="<?php echo $category['news_category_id']; ?>" checked="checked" />
                    <?php echo $category['news_category_name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="newsarticle_module[<?php echo $module_row; ?>][newsmodulecategory][]" value="<?php echo $category['news_category_id']; ?>" />
                    <?php echo $category['news_category_name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <!--<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php //echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php //echo $text_unselect_all; ?></a>-->
			</td>

		  	<td colspan="5">
				<br/>
				<?php echo $text_category2; ?>
				<?php echo $this->config->get('newsmodulecategory'); ?>
				<br/>

				<div class="scrollbox" style="height:200px;">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($news_categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (isset($module['newsmodulecategory2']) && in_array($category['news_category_id'], $module['newsmodulecategory2'])) { ?>
                    <input type="checkbox" name="newsarticle_module[<?php echo $module_row; ?>][newsmodulecategory2][]" value="<?php echo $category['news_category_id']; ?>" checked="checked" />
                    <?php echo $category['news_category_name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="newsarticle_module[<?php echo $module_row; ?>][newsmodulecategory2][]" value="<?php echo $category['news_category_id']; ?>" />
                    <?php echo $category['news_category_name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <!--<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php //echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php //echo $text_unselect_all; ?></a>-->
			</td>

		  </tr>
        </tbody>
        <?php $module_row++; ?>
        <?php } ?>
        <tfoot>
          <tr>
            <td  colspan="9" class="right"><a onclick="addModule();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
          </tr>
        </tfoot>
      </table>
    </form>
  </div>
</div>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;
function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '<td class="center"><a href="setting-module' + module_row + '" rel="fancybox"><img src="view/image/product.png" title="<?php echo $entry_setting;?>" /></a></td>';
	html += '    <td class="center"><input type="text" name="newsarticle_module[' + module_row + '][limit]" value="5" size="1" /></td>';
	html += '    <td class="center"><input type="text" name="newsarticle_module[' + module_row + '][image_width]" value="80" size="3" /> <input type="text" name="newsarticle_module[' + module_row + '][image_height]" value="80" size="3" /></td>';
	html += '    <td class="center"><select name="newsarticle_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="center"><select name="newsarticle_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="center"><select name="newsarticle_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="newsarticle_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td colspan="2" class="right"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '  </tr>';
		
	html += '<tr>';
	html +=	 '<td class="center">';
	html +=			'<?php echo $text_showimg; ?><input name="newsarticle_module[' + module_row + '][show_img]" type="checkbox" /></td>';
	html +=			'<td class="center"><?php echo $text_descshow; ?><input name="newsarticle_module[' + module_row + '][desc_show]" type="checkbox" checked="checked" /></td>';
	html +=			'<td class="center"><?php echo $text_desclimit; ?><input size="3" name="newsarticle_module[' + module_row + '][desc_limit]" type="text" value="120"/></td>';
	html +=			'<td class="center"><?php echo $text_showmore; ?><input name="newsarticle_module[' + module_row + '][more_show]" type="checkbox" /></td>';
	html +=			'<td class="center"><?php echo $text_showdate; ?><input name="newsarticle_module[' + module_row + '][date_show]" type="checkbox"/></td>';
	html +=			'<td class="center"><?php echo $text_showcomment; ?><input  name="newsarticle_module[' + module_row + '][comentt_show]" type="checkbox" /></td>';
	html +=		    '<td class="center"><?php echo $text_showvote; ?><input name="newsarticle_module[' + module_row + '][vote_show]" type="checkbox"/> </td>';
	html +=			'<td class="center"><?php echo $text_showview; ?><input name="newsarticle_module[' + module_row + '][view_show]" type="checkbox" /></td>';

	html +=			'<td class="center"><?php echo $text_order; ?><select name="newsarticle_module[' + module_row + '][art_order]">';
	html +=			 	'<option value="0">';
	html +=				'	<?php echo $text_order_title;?>';
	html +=				'</option>';
	html +=				'<option value="1" selected="selected">';
	html +=					'<?php echo $text_order_creat;?>';
	html +=				'</option>';
	html +=				'<option value="2">';
	html +=					'<?php echo $text_order_modify;?>';
	html +=				'</option>';
	html +=				'<option value="3">';
	html +=					'<?php echo $text_order_vote;?>';
	html +=				'</option>';
	html +=				'<option value="4" >';
	html +=					'<?php echo $text_order_view;?>';
	html +=				'</option>';
	html +=			 '</select>';
	html +=		'</td>';
	html +=	  '</tr>';


	html += '<tr>';
	html +=	' 	<td colspan="4">';
	html +=	'		<br/>';
	html +=	'		<?php echo $text_category; ?>';
	html +=	'		<br/>';
	html +=	'		<div class="scrollbox"  style="height:200px;">';
    html += '            <?php $class = "odd"; ?>';
  <?php foreach ($news_categories as $category) { ?>
  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
    html +=  '            <div class="<?php echo $class; ?>">';
    html +=   '             <input type="checkbox" name="newsarticle_module[<?php echo $module_row; ?>][newsmodulecategory][]" value="<?php echo $category['news_category_id']; ?>" />';
 	html +=   ' 		<?php echo $category['news_category_name']; ?>';
    html +=   '           </div>';
  <?php } ?>
    html +=   '         </div>';
    //html +=   '         <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a>';
	html +=		'</td>';

	html +=	' 	<td colspan="5">';
	html +=	'		<br/>';
	html +=	'		<?php echo $text_category2; ?>';
	html +=	'		<br/>';
	html +=	'		<div class="scrollbox"  style="height:200px;">';
    html += '            <?php $class = "odd"; ?>';
  <?php foreach ($news_categories as $category) { ?>
  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
    html +=  '            <div class="<?php echo $class; ?>">';
    html +=   '             <input type="checkbox" name="newsarticle_module[<?php echo $module_row; ?>][newsmodulecategory2][]" value="<?php echo $category['news_category_id']; ?>" />';
 	html +=   ' 		<?php echo $category['news_category_name']; ?>';
    html +=   '           </div>';
  <?php } ?>
    html +=   '         </div>';
    //html +=   '         <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a>';
	html +=		'</td>';

	html +=	  '</tr>';

	html += '</tbody>';
	$('#module tfoot').before(html);
	module_row++;
}

//--></script>
<script type="text/javascript"><!--
$('input[name=\'related_articles\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=news/article/autocomplete&token=<?php echo $token; ?>',
			type: 'POST',
			dataType: 'json',
			data: 'filter_name=' +  encodeURIComponent(request.term),
			success: function(data) {		
				response($.map(data, function(item) {
					return {
						label: item.article_name,
						value: item.article_id
					}
				}));
			}
		});
		
	}, 
	select: function(event, ui) {
		$('#related-article' + ui.item.value).remove();
		
		$('#article-related').append('<div id="related-article' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="article_related[]" value="' + ui.item.value + '" /></div>');

		$('#article-related div:odd').attr('class', 'odd');
		$('#article-related div:even').attr('class', 'even');
				
		return false;
	}
});

$('#article-related div img').live('click', function() {
	$(this).parent().remove();
	
	$('#article-related div:odd').attr('class', 'odd');
	$('#article-related div:even').attr('class', 'even');	
});
//--></script> 
<?php echo $footer; ?>