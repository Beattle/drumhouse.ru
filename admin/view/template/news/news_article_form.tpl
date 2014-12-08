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
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a><a href="#tab-data"><?php echo $tab_data; ?></a><a href="#tab-related"><?php echo $tab_related; ?></a><a href="#tab-related-product"><?php echo $tab_related_product; ?></a><a href="#tab-design"><?php echo $tab_design; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>
          <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                <td><input type="text" name="news_description[<?php echo $language['language_id']; ?>][news_titles]" size="100" value="<?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['news_titles'] : ''; ?>" />
                  <?php if (isset($error_name[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_description; ?></td>
                <td><textarea name="news_description[<?php echo $language['language_id']; ?>][news_description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['news_description'] : ''; ?></textarea></td>
              </tr>
			   <tr>
                <td><?php echo $entry_meta_description; ?></td>
                <td><textarea name="news_description[<?php echo $language['language_id']; ?>][news_meta_description]" cols="40" rows="5"><?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['news_meta_description'] : ''; ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_meta_keyword; ?></td>
                <td><textarea name="news_description[<?php echo $language['language_id']; ?>][news_meta_keyword]" cols="40" rows="5"><?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['news_meta_keyword'] : ''; ?></textarea></td>
              </tr>
			  <tr>
                <td><?php echo $entry_tag; ?></td>
                <td><input type="text" name="news_tags[<?php echo $language['language_id']; ?>]" value="<?php echo isset($news_tags[$language['language_id']]) ? $news_tags[$language['language_id']] : ''; ?>" size="80" /></td>
              </tr>
            </table>
          </div>
          <?php } ?>
        </div>
        <div id="tab-data">
          <table class="form">
            <tr>
              <td><?php echo $entry_category; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($news_categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($category['news_category_id'], $news_caterory)) { ?>
                    <input type="checkbox" name="news_category[]" value="<?php echo $category['news_category_id']; ?>" checked="checked" />
                    <?php echo $category['news_category_name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="news_category[]" value="<?php echo $category['news_category_id']; ?>" />
                    <?php echo $category['news_category_name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>
            </tr>
            <tr>
              <td><?php echo $entry_store; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array(0, $news_store)) { ?>
                    <input type="checkbox" name="news_store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="news_store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($store['store_id'], $news_store)) { ?>
                    <input type="checkbox" name="news_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="news_store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            <tr>
              <td><?php echo $entry_keyword; ?></td>
              <td><input type="text" name="news_meta_keyword" value="<?php echo $news_meta_keyword; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_image; ?></td>
              <td valign="top">
				<div class="image"><img src="<?php echo $preview; ?>" alt="" id="thumb" />
                <input type="hidden" name="news_image" value="<?php echo $news_image; ?>" id="image" />
                <br /><a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a></div>
				</td>
            </tr>
            <tr>
              <td><?php echo $entry_comment; ?></td>
              <td><?php if ($news_comment) { ?>
                <input type="checkbox" name="news_comment" value="1" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="news_comment" value="1" />
                <?php } ?></td>
            </tr>
			 <tr>
              <td><?php echo $entry_top; ?></td>
              <td><?php if ($news_top) { ?>
                <input type="checkbox" name="news_top" value="1" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="news_top" value="1" />
                <?php } ?></td>
            </tr>
			
			 <tr>
              <td><?php echo $entry_showdate; ?></td>
              <td><?php if ($news_showdate) { ?>
                <input type="checkbox" name="news_showdate" value="1" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="news_showdate" value="1" />
                <?php } ?></td>
            </tr>
			 <tr>
              <td><?php echo $entry_showvote; ?></td>
              <td><?php if ($news_showvote) { ?>
                <input type="checkbox" name="news_showvote" value="1" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="news_showvote" value="1" />
                <?php } ?></td>
            </tr>
			 <tr>
              <td><?php echo $entry_showview; ?></td>
              <td><?php if ($news_showview) { ?>
                <input type="checkbox" name="news_showview" value="1" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="news_showview" value="1" />
                <?php } ?></td>
            </tr>
			
			 <tr>
              <td><?php echo $entry_showrelated; ?></td>
              <td><?php if ($news_showrelated) { ?>
                <input type="checkbox" name="news_showrelated" value="1" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="news_showrelated" value="1" />
                <?php } ?></td>
            </tr>
			<tr>
              <td><?php echo $entry_showproduct; ?></td>
              <td><?php if ($news_showproduct) { ?>
                <input type="checkbox" name="news_showproduct" value="1" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="news_showproduct" value="1" />
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="news_sort_order" value="<?php echo $news_sort_order; ?>" size="1" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="news_status">
                  <?php if ($news_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
          </table>
        </div>
		<div id="tab-related">
			<table class="list">
				<tr>
					<td><?php echo $entry_related; ?></td>
					<td><input type="text" name="related_articles" size="100" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<div class="scrollbox1" id="article-related">
	                  <?php $class = 'odd'; ?>
	                  <?php foreach ($articles_related as $article_related) { ?>
	                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
	                  <div id="related-article<?php echo $article_related['news_id']; ?>" class="<?php echo $class; ?>"> <?php echo $article_related['news_titles']; ?><img src="view/image/delete.png" />
	                    <input type="hidden" name="article_related[]" value="<?php echo $article_related['news_id']; ?>" />
	                  </div>
	                  <?php } ?>
	                </div>
					</td>
				</tr>
			</table>
		</div>
		<div id="tab-related-product">
			<table class="list">
				<tr>
					<td><?php echo $entry_related_product; ?></td>
					<td><input type="text" name="related_product" size="100" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<div class="scrollbox1" id="article-product">
	                  <?php $class = 'odd'; ?>
	                  <?php foreach ($articles_products as $article_product) { ?>
	                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
	                  <div id="product-related<?php echo $article_product['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $article_product['name']; ?><img src="view/image/delete.png" />
	                    <input type="hidden" name="article_product[]" value="<?php echo $article_product['product_id']; ?>" />
	                  </div>
	                  <?php } ?>
	                </div>
					</td>
				</tr>
			</table>
		</div>
        <div id="tab-design">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_store; ?></td>
                <td class="left"><?php echo $entry_layout; ?></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="left"><?php echo $text_default; ?></td>
                <td class="left"><select name="news_layout[0][layout_id]">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($news_layout[0]) && $news_layout[0] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php foreach ($stores as $store) { ?>
            <tbody>
              <tr>
                <td class="left"><?php echo $store['name']; ?></td>
                <td class="left"><select name="news_layout[<?php echo $store['store_id']; ?>][layout_id]">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($news_layout[$store['store_id']]) && $news_layout[$store['store_id']] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php } ?>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
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
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs();
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

<script type="text/javascript"><!--
$('input[name=\'related_product\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
		
	}, 
	select: function(event, ui) {
		$('#product-related' + ui.item.value).remove();
		
		$('#article-product').append('<div id="product-related' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="article_product[]" value="' + ui.item.value + '" /></div>');

		$('#article-product div:odd').attr('class', 'odd');
		$('#article-product div:even').attr('class', 'even');
				
		return false;
	}
});

$('#article-product div img').live('click', function() {
	$(this).parent().remove();
	
	$('#article-product div:odd').attr('class', 'odd');
	$('#article-product div:even').attr('class', 'even');	
});
//--></script> 

<style type="text/css">
	.scrollbox1 {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #CCCCCC;
    height: 300px;
    overflow-y: scroll;
    width: 450px;
}
</style>
<?php echo $footer; ?>