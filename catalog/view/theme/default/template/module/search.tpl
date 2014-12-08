<?php //var_dump($manufactureres)?>

	<div class="search mt23">
		<div class="search-in">
		<div class="search-title">
			<?php echo $entry_search; ?>
		</div>
		<div class="search-body">
			<div class="search-line">

				<select name="filter_path" onclick="$('select[name=\'filter_manufacturer_id\']').load('index.php?route=module/search/manufacturer&path=' + this.value + '&manufacturer_id=<?php echo $manufacturer_id; ?>');">
					<option value=""><?php echo $text_category; ?></option>
                    <?php foreach ($categories as $category) { ?>
                        <?php if ($category['category_id'] == $path) { ?>
    					    <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                        <?php } else { ?>
    					    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                        <?php } ?>

                        <?php if ($category['children']) { ?>
                            <?php foreach ($category['children'] as $child) { ?>
                                <?php if ($child['category_id'] == $path) { ?>
            					    <option value="<?php echo $child['category_id']; ?>" selected="selected"><?php echo $child['name']; ?></option>
                                <?php } else { ?>
            					    <option value="<?php echo $child['category_id']; ?>"><?php echo $child['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                    <?php } ?>
				</select>

				<select name="filter_manufacturer_id" onchange="$('select[name=\'filter_path\']').load('index.php?route=module/search/category&manufacturer_id=' + this.value + '&path=<?php echo $path; ?>');">
					<option value="-1"><?php echo $text_manufacturer; ?></option>
                    <?php foreach ($manufactureres as $manufacturer) { ?>
                        <?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?>
    					    <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
                        <?php } else { ?>
    					    <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
                        <?php } ?>
                    <?php } ?>
				</select>

			</div>
            <table>
                <tbody>
                <tr>
                    <td class="search-field">
                        <input id="search-name" type="text" placeholder="Поиск по названию" class="inp1" name="filter_name" value="<?php echo $filter_name; ?>" />
                        <input id="search-sku" type="text" placeholder="Поиск по артикулу" class="inp1" name="filter_name" value="" />
                    </td>
                    <td class="search-butn">
                        <input type="submit" id="button-search" value="<?php echo $button_search; ?>" class="btn1" />
                    </td>
                </tr>
                </tbody>
            </table>
		</div>
		</div>
	</div>


<script type="text/javascript"><!--
var inputs = $('.inp1');
inputs.keydown(function(e) {
	if (e.keyCode == 13) {
        search();
	}
});

$('#button-search').bind('click', function() {
    search();
});

var finish = false;

function search (){

        var empty = true;
        var sku   = false;
        finish = false;
        inputs.each(function(){
           if($.trim($(this).val()) !== ""){
                empty = false;
           }
            if ($.trim($(this).val()) && $(this).attr('id') == 'search-sku'){
                if(!finish){
               search_by_sku($(this).val());
               sku = true;
               }
            }
        });

    if(empty) {alert('Введите, пожалуйста, значение в поле'); return}
    if (empty == false && sku == false ){
        url = 'index.php?route=product/search';
        var filter_name = $('input[name=\'filter_name\']').attr('value');
        if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);
        }
        var filter_manufacturer_id = $('select[name=\'filter_manufacturer_id\']').attr('value');
        if (filter_manufacturer_id > 0) {
            url += '&filter_manufacturer_id=' + encodeURIComponent(filter_manufacturer_id);
        }
        var path = $('select[name=\'filter_path\']').attr('value');
        var filter_sub_category = false;
        var filter_description  = true;
        if (path != "") {
            url += '&path=' + encodeURIComponent(path);
            filter_sub_category = true;
        }
        if (filter_sub_category) {
            url += '&filter_sub_category=true';
        }
        if (filter_description) {
            url += '&filter_description=true';
        }
        location = url;
    }
}

function search_by_sku(sku){
    $.ajax({
        url:'index.php?route=product/search/search_by_sku',
        dataType:'html',
        type:'POST',
        cache:true,
        data:{sku:sku},
        success:function(data){
           var product = $(data);
            product.hide();
            if(document.getElementById("search-block-sku")) $('#search-block-sku').remove();
        $('.b-tabs2,#search, .content .items,.sort-by').animate({
            opacity:0
        }, 500, function (){
            $('.main-txt').after(product);
            product.fadeIn();
        });

        },complete:function(){
            finish = true;
        }
    })
}
//--></script>