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
    <div class="left"></div>
    <div class="right"></div>
    <div class="heading">
      <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <div class="vtabs"><a href="#tab-order"><?php echo $tab_order; ?></a><a href="#tab-product"><?php echo $tab_product; ?></a><a href="#tab-payment"><?php echo $tab_payment; ?></a><a href="#tab-shipping"><?php echo $tab_shipping; ?></a><?php /* <a href="#tab-total"><?php echo $tab_total; ?></a> */ ?></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-order" class="vtabs-content">
        <table class="form">
          <tr>
            <td><?php echo $text_order_id; ?></td>
            <td>#<?php echo $order_id; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_invoice_no; ?></td>
            <td><?php echo $invoice_no; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_store_name; ?></td>
            <td><?php echo $store_name; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_store_url; ?></td>
            <td><a onclick="window.open('<?php echo $store_url; ?>');"><u><?php echo $store_url; ?></u></a></td>
          </tr>
          <?php if ($customer) { ?>
          <tr>
            <td><?php echo $text_customer; ?></td>
            <td><a href="<?php echo $customer; ?>"><?php echo $firstname; ?> <?php echo $lastname; ?></a></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td><?php echo $text_customer; ?></td>
            <td><?php echo $firstname; ?> <?php echo $lastname; ?></td>
          </tr>
          <?php } ?>
          <?php if ($customer_group) { ?>
          <tr>
            <td><?php echo $text_customer_group; ?></td>
            <td><?php echo $customer_group; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $text_ip; ?></td>
            <td><?php echo $ip; ?></td>
          </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_email; ?></td>
              <td><input type="text" name="email" value="<?php echo $email; ?>" />
                <?php if ($error_email) { ?>
                <span class="error"><?php echo $error_email; ?></span>
                <?php  } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
              <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" />
                <?php if ($error_telephone) { ?>
                <span class="error"><?php echo $error_telephone; ?></span>
                <?php  } ?></td>
            </tr>
          <tr>
            <td>Дополнительный телефон:</td>
            <td><input type="text" name="fax" value="<?php echo $fax; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $text_total; ?></td>
            <td><?php echo $total; ?>
              <?php if ($credit && $customer) { ?>
              <?php if (!$credit_total) { ?>
              <img src="view/image/add.png" alt="<?php echo $text_credit_add; ?>" title="<?php echo $text_credit_add; ?>" id="credit_add" class="icon" />
              <?php } else { ?>
              <img src="view/image/delete.png" alt="<?php echo $text_credit_remove; ?>" title="<?php echo $text_credit_remove; ?>" id="credit_remove" class="icon" />
              <?php } ?>
              <?php } ?></td>
          </tr>
          <?php if ($reward && $customer) { ?>
          <tr>
            <td><?php echo $text_reward; ?></td>
            <td><?php echo $reward; ?>
              <?php if (!$reward_total) { ?>
              <img src="view/image/add.png" alt="<?php echo $text_reward_add; ?>" title="<?php echo $text_reward_add; ?>" id="reward_add" class="icon" />
              <?php } else { ?>
              <img src="view/image/delete.png" alt="<?php echo $text_reward_remove; ?>" title="<?php echo $text_reward_remove; ?>" id="reward_remove" class="icon" />
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php if ($order_status) { ?>
          <tr>
            <td><?php echo $text_order_status; ?></td>
            <td id="order-status"><?php echo $order_status; ?></td>
          </tr>
          <?php } ?>
          <?php if ($comment) { ?>
          <tr>
            <td><?php echo $text_comment; ?></td>
            <td><?php echo $comment; ?></td>
          </tr>
          <?php } ?>
          <?php if ($affiliate) { ?>
          <tr>
            <td><?php echo $text_affiliate; ?></td>
            <td><a href="<?php echo $affiliate; ?>"><?php echo $affiliate_firstname; ?> <?php echo $affiliate_lastname; ?></a></td>
          </tr>
          <tr>
            <td><?php echo $text_commission; ?></td>
            <td><?php echo $commission; ?>
              <?php if (!$commission_total) { ?>
              <img src="view/image/add.png" alt="<?php echo $text_commission_add; ?>" title="<?php echo $text_commission_add; ?>" id="commission_add" class="icon" />
              <?php } else { ?>
              <img src="view/image/delete.png" alt="<?php echo $text_commission_remove; ?>" title="<?php echo $text_commission_remove; ?>" id="commission_remove" class="icon" />
              <?php } ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $text_date_added; ?></td>
            <td><?php echo $date_added; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_date_modified; ?></td>
            <td><?php echo $date_modified; ?></td>
          </tr>
        </table>
      </div>
<?php /*      
      <div id="tab-order" class="vtabs-content">
          <table class="form">
            <tr>
              <td><?php echo $entry_store; ?></td>
              <td><select name="store_id">
                  <option value="0"><?php echo $text_default; ?></option>
                  <?php foreach ($stores as $store) { ?>
                  <?php if ($store['store_id'] == $store_id) { ?>
                  <option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_customer; ?></td>
              <td><input type="text" name="customer" value="<?php echo $customer; ?>" />
                <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" /></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
              <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" />
                <?php if ($error_firstname) { ?>
                <span class="error"><?php echo $error_firstname; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
              <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" />
                <?php if ($error_lastname) { ?>
                <span class="error"><?php echo $error_lastname; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_email; ?></td>
              <td><input type="text" name="email" value="<?php echo $email; ?>" />
                <?php if ($error_email) { ?>
                <span class="error"><?php echo $error_email; ?></span>
                <?php  } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
              <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" />
                <?php if ($error_telephone) { ?>
                <span class="error"><?php echo $error_telephone; ?></span>
                <?php  } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_fax; ?></td>
              <td><input type="text" name="fax" value="<?php echo $fax; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_order_status; ?></td>
              <td><select name="order_status_id">
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_comment; ?></td>
              <td><textarea name="comment" cols="40" rows="5"><?php echo $comment; ?></textarea></td>
            </tr>
            <tr>
              <td><?php echo $entry_affiliate; ?></td>
              <td><input type="text" name="affiliate" value="<?php echo $affiliate; ?>" />
                <input type="hidden" name="affiliate_id" value="<?php echo $affiliate_id; ?>" /></td>
            </tr>
          </table>
        </div>
*/ ?>        
        <div id="tab-product" class="vtabs-content">
          <table id="product" class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_product; ?></td>
                <td class="left"><?php echo $entry_model; ?></td>
                <td class="right"><?php echo $entry_quantity; ?></td>
                <td class="right"><?php echo $entry_price; ?></td>
                <td></td>
              </tr>
            </thead>
            <?php $product_row = 0; ?>
            <?php foreach ($order_products as $order_product) { ?>
            <tbody id="product-row<?php echo $product_row; ?>">
              <tr>
                <td class="left"><input type="text" name="order_product[<?php echo $product_row; ?>][name]" value="<?php echo $order_product['name']; ?>" row="<?php echo $product_row; ?>" id="order_product_name_<?php echo $order_product['product_id']; ?>" />
                  <!--<input type="hidden" name="order_product[<?php echo $product_row; ?>][order_product_id]" value="<?php echo $order_product['order_product_id']; ?>" />-->
                  <input type="hidden" name="order_product[<?php echo $product_row; ?>][product_id]" value="<?php echo $order_product['product_id']; ?>"  id="order_product_id_<?php echo $order_product['product_id']; ?>" />
                  <br />
<?php /*                  
                  <?php $option_row = 0; ?>
                  <?php foreach ($order_product['option'] as $option) { ?>
                  <?php if ($option['type'] == 'select') { ?>
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <?php echo $option['name']; ?><br />
                  <select name="order_product[<?php echo $product_row; ?>][option][<?php echo $option_row; ?>][option_value_id]">
                    <option value=""><?php echo $text_select; ?></option>
                    <?php foreach ($option['option_value'] as $option_value) { ?>
                    <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                    </option>
                    <?php } ?>
                  </select>
                  <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'radio') { ?>
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <?php echo $option['name']; ?><br />
                  <?php foreach ($option['option_value'] as $option_value) { ?>
                  <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                  <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                  </label>
                  <br />
                  <?php } ?>
                  <?php } ?>
                  <?php if ($option['type'] == 'checkbox') { ?>
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <?php echo $option['name']; ?><br />
                  <?php foreach ($option['option_value'] as $option_value) { ?>
                  <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                  <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                  </label>
                  <br />
                  <?php } ?>
                  <?php } ?>
                  <?php if ($option['type'] == 'text') { ?>
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <?php echo $option['name']; ?><br />
                  <input type="text" name="order_product[<?php echo $product_row; ?>][<?php echo $option_row; ?>][option_value]" value="<?php echo $option['option_value']; ?>" />
                  <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'textarea') { ?>
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <?php echo $option['name']; ?><br />
                  <textarea name="order_product[<?php echo $product_row; ?>][option][<?php echo $option_row; ?>][option_value]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
                  <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'file') { ?>
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <?php echo $option['name']; ?><br />
                  <input type="text" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option_row; ?>][option_value]" value="<?php echo $option['option_value']; ?>" />
                  <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'date') { ?>
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <?php echo $option['name']; ?><br />
                  <input type="text" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option_row; ?>][option_value]" value="<?php echo $option['option_value']; ?>" class="date" />
                  <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'datetime') { ?>
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <?php echo $option['name']; ?><br />
                  <input type="text" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option_row; ?>][option_value]" value="<?php echo $option['option_value']; ?>" class="datetime" />
                  <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'time') { ?>
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <?php echo $option['name']; ?><br />
                  <input type="text" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option_row; ?>][option_value]" value="<?php echo $option['option_value']; ?>" class="time" />
                  <br />
                  <?php } ?>
                  <?php $option_row++; ?>
                  <?php } ?></td>
*/ ?>                  
                <td class="left"><input type="text" name="order_product[<?php echo $product_row; ?>][model]" value="<?php echo $order_product['model']; ?>" /></td>
                <td class="right"><input type="text" name="order_product[<?php echo $product_row; ?>][quantity]" value="<?php echo $order_product['quantity']; ?>" size="3" /></td>
                <td class="right"><input type="text" name="order_product[<?php echo $product_row; ?>][price]" value="<?php echo $order_product['price']; ?>" size="10" /></td>
                <td class="left"><a onclick="$('#product-row<?php echo $product_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
              </tr>
            </tbody>
            <?php $product_row++; ?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="4"></td>
                <td class="left"><a onclick="addProduct();" class="button"><span><?php echo $button_add_product; ?></span></a></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div id="tab-payment" class="vtabs-content">
          <table class="form">
<?php /*          
            <tr>
              <td><?php echo $entry_address; ?></td>
              <td><select name="payment_address">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($addresses as $address) { ?>
                  <option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname'] . ' ' . $address['lastname'] . ', ' . $address['address_1'] . ', ' . $address['city'] . ', ' . $address['country']; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
*/ ?>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
              <td><input type="text" name="payment_firstname" value="<?php echo $payment_firstname; ?>" />
                <?php if ($error_payment_firstname) { ?>
                <span class="error"><?php echo $error_payment_firstname; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
              <td><input type="text" name="payment_lastname" value="<?php echo $payment_lastname; ?>" />
                <?php if ($error_payment_lastname) { ?>
                <span class="error"><?php echo $error_payment_lastname; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_company; ?></td>
              <td><input type="text" name="payment_company" value="<?php echo $payment_company; ?>" /></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>
              <td><input type="text" name="payment_address_1" value="<?php echo $payment_address_1; ?>" />
                <?php if ($error_payment_address_1) { ?>
                <span class="error"><?php echo $error_payment_address_1; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_address_2; ?></td>
              <td><input type="text" name="payment_address_2" value="<?php echo $payment_address_2; ?>" /></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_city; ?></td>
              <td><input type="text" name="payment_city" value="<?php echo $payment_city; ?>" />
                <?php if ($error_payment_city) { ?>
                <span class="error"><?php echo $error_payment_city; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_postcode; ?></td>
              <td><input type="text" name="payment_postcode" value="<?php echo $payment_postcode; ?>" />
                <?php if ($error_payment_postcode) { ?>
                <span class="error"><?php echo $error_payment_postcode; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_country; ?></td>
              <td><select name="payment_country_id" onchange="$('select[name=\'payment_zone_id\']').load('index.php?route=sale/customer/zone&token=<?php echo $token; ?>&country_id=' + this.value + '&zone_id=<?php echo $payment_zone_id; ?>');">
                  <option value="false"><?php echo $text_select; ?></option>
                  <?php foreach ($countries as $country) { ?>
                  <?php if ($country['country_id'] == $payment_country_id) { ?>
                  <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                <?php if ($error_payment_country) { ?>
                <span class="error"><?php echo $error_payment_country; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
              <td><select name="payment_zone_id">
                </select>
                <?php if ($error_payment_zone) { ?>
                <span class="error"><?php echo $error_payment_zone; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_payment; ?></td>
              <td><input type="text" name="payment_method" value="<?php echo $payment_method; ?>" /></td>
            </tr>
          </table>
        </div>
        <div id="tab-shipping" class="vtabs-content">
          <table class="form">
<?php /*          
            <tr>
              <td><?php echo $entry_address; ?></td>
              <td><select name="shipping_address">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($addresses as $address) { ?>
                  <option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname'] . ' ' . $address['lastname'] . ', ' . $address['address_1'] . ', ' . $address['city'] . ', ' . $address['country']; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
*/ ?>            
            <tr>
              <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
              <td><input type="text" name="shipping_firstname" value="<?php echo $shipping_firstname; ?>" />
                <?php if ($error_shipping_firstname) { ?>
                <span class="error"><?php echo $error_shipping_firstname; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
              <td><input type="text" name="shipping_lastname" value="<?php echo $shipping_lastname; ?>" />
                <?php if ($error_shipping_lastname) { ?>
                <span class="error"><?php echo $error_shipping_lastname; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_company; ?></td>
              <td><input type="text" name="shipping_company" value="<?php echo $shipping_company; ?>" /></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>
              <td><input type="text" name="shipping_address_1" value="<?php echo $shipping_address_1; ?>" />
                <?php if ($error_shipping_address_1) { ?>
                <span class="error"><?php echo $error_shipping_address_1; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_address_2; ?></td>
              <td><input type="text" name="shipping_address_2" value="<?php echo $shipping_address_2; ?>" /></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_city; ?></td>
              <td><input type="text" name="shipping_city" value="<?php echo $shipping_city; ?>" />
                <?php if ($error_shipping_city) { ?>
                <span class="error"><?php echo $error_shipping_city; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_postcode; ?></td>
              <td><input type="text" name="shipping_postcode" value="<?php echo $shipping_postcode; ?>" />
                <?php if ($error_shipping_postcode) { ?>
                <span class="error"><?php echo $error_shipping_postcode; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_country; ?></td>
              <td><select name="shipping_country_id" onchange="$('select[name=\'shipping_zone_id\']').load('index.php?route=sale/customer/zone&token=<?php echo $token; ?>&country_id=' + this.value + '&zone_id=<?php echo $shipping_zone_id; ?>');">
                  <option value="false"><?php echo $text_select; ?></option>
                  <?php foreach ($countries as $country) { ?>
                  <?php if ($country['country_id'] == $shipping_country_id) { ?>
                  <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                <?php if ($error_shipping_country) { ?>
                <span class="error"><?php echo $error_shipping_country; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
              <td><select name="shipping_zone_id">
                </select>
                <?php if ($error_shipping_zone) { ?>
                <span class="error"><?php echo $error_shipping_zone; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_shipping; ?></td>
              <td><input type="text" name="shipping_method" value="<?php echo $shipping_method; ?>" /></td>
            </tr>
            <tr>
              <td>Стоимость доставки</td>
              <td><input type="text" name="shipping_price" value="<?php echo $shipping_price; ?>" /></td>
            </tr>
          </table>
        </div>
<?php /*          
        <div id="tab-total" class="vtabs-content">
          <table class="form">
            <tr>
              <td><?php echo $entry_coupon; ?></td>
              <td><input type="text" name="payment_method" value="<?php echo $payment_method; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_voucher; ?></td>
              <td><input type="text" name="payment_method" value="<?php echo $payment_method; ?>" /></td>
            </tr>
          </table>
          <table class="list" id="total">
            <thead>
              <tr>
                <td class="right">Title:</td>
                <td class="right">Amount:</td>
                <td class="right">Sort Order:</td>
                <td></td>
              </tr>
            </thead>
            <?php $total_row = 0; ?>
            <?php foreach ($order_totals as $order_total) { ?>
            <tbody id="total-row<?php echo $total_row; ?>">
              <tr>
                <td class="right"><input type="hidden" name="order_total[<?php echo $total_row; ?>][order_total_id]" value="<?php echo $order_total['order_total_id']; ?>" />
                  <input type="text" name="order_total[<?php echo $total_row; ?>][title]" value="<?php echo $order_total['title']; ?>" /></td>
                <td class="right"><input type="hidden" name="order_total[<?php echo $total_row; ?>][text]" value="<?php echo $order_total['text']; ?>" />
                  <input type="text" name="order_total[<?php echo $total_row; ?>][value]" value="<?php echo $order_total['value']; ?>" /></td>
                <td class="right"><input type="text" name="order_total[<?php echo $total_row; ?>][sort_order]" value="<?php echo $order_total['sort_order']; ?>" /></td>
                <td class="left"><a onclick="$('#total-row<?php echo $product_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
              </tr>
            </tbody>
            <?php $total_row++; ?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="3"></td>
                <td class="left"><a onclick="addTotal();" class="button"><span>Add Totals</span></a></td>
              </tr>
              <tr>
                <td colspan="3"></td>
                <td class="left"><a onclick="calculate();" class="button"><span>Calculate</span></a></td>
              </tr>
            </tfoot>
          </table>
        </div>
*/ ?>        
      </form>
    </div>
  </div>
  <code id="test"></code> </div>
<? /*  
<script type="text/javascript"><!--
$('.product_autocomplete').autocomplete({
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
	    alert($(event.currentTarget).attr('row'));
		$(event.currentTarget).val(ui.item.label);
		//$('#order_product_id_' + ui.item.value).val(ui.item.value);
		
		return false;
	}
});
//--></script>
*/ ?>
<script type="text/javascript"><!--
var product_row = <?php echo $product_row; ?>;

function addProduct() {
    html  = '<tbody id="product-row' + product_row + '">';
    html += '  <tr>';
    html += '    <td class="left"><input type="text" name="order_product[' + product_row + '][name]" value="" /><input type="hidden" name="order_product[' + product_row + '][product_id]" value="" /></td>';
    html += '    <td class="left"><input type="text" name="order_product[' + product_row + '][model]" value="" /></td>';
	html += '    <td class="right"><input type="text" name="order_product[' + product_row + '][quantity]" value="1" size="3" /></td>';	
	html += '    <td class="right"><input type="text" name="order_product[' + product_row + '][price]" value="" size="10" /></td>';
    html += '    <td class="left"><a onclick="$(\'#product-row' + product_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
    html += '  </tr>';
	html += '</tbody>';
	
	$('#product tfoot').before(html);

	productautocomplete(product_row);
	
	product_row++;
}

function productautocomplete(product_row) {
	$('input[name=\'order_product[' + product_row + '][name]\']').autocomplete({
		delay: 0,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>',
				type: 'POST',
				dataType: 'json',
				data: 'filter_name=' +  encodeURIComponent(request.term),
				success: function(data) {	
					response($.map(data, function(item) {
						return {
							label: item.name,
							value: item.product_id,
							model: item.model,
							price: item.price
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			$('input[name=\'order_product[' + product_row + '][product_id]\']').attr('value', ui.item.value);
			$('input[name=\'order_product[' + product_row + '][name]\']').attr('value', ui.item.label);
			$('input[name=\'order_product[' + product_row + '][model]\']').attr('value', ui.item.model);
			$('input[name=\'order_product[' + product_row + '][price]\']').attr('value', ui.item.price);
			
			return false;
		}
	});
}

$('#product tbody').each(function(index, element) {
	productautocomplete(index);
});		
//--></script> 
<script type="text/javascript"><!--
/*
$('input[name=\'affiliate\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/affiliate/autocomplete&token=<?php echo $token; ?>',
			type: 'POST',
			dataType: 'json',
			data: 'filter_name=' +  encodeURIComponent(request.term),
			success: function(data) {	
				response($.map(data, function(item) {
					return {
						label: item.name,
						value: item.affiliate_id,
					}
				}));
			}
		});
	}, 
	select: function(event, ui) { 
		$('input[name=\'affiliate\']').attr('value', ui.item.label);
		$('input[name=\'affiliate_id\']').attr('value', ui.item.value);
			
		return false; 
	}
});
*/

/*
function calculate() {
	$.ajax({
		url: '<?php echo $store_url; ?>index.php?route=checkout/manual&token=<?php echo $token; ?>',
		type: 'POST',
		dataType: 'html',
		data: $('#tab-order :input, #tab-payment :input, #tab-shipping :input, #tab-product :input'),
		success: function(json) {
			$('#test').html(json);
			
			$('.autocomplete div').remove();
			
			shipping = json['product'];
			shipping = json['shipping'];
			total = json['total'];
			
		}
	});		
}
*/
/*
$('input[name=\'shipping_method\']').catcomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'http://dev.opencart.com/index.php?route=checkout/manual/shipping&token=<?php echo $token; ?>',
			type: 'POST',
			dataType: 'html',
			data: $('#tab-shipping :input, #tab-product :input'),
			success: function(data) {	
				alert(data);
				//'filter_name=' +  encodeURIComponent(request.term) . 
				/*
				response($.map(data, function(item) {
					return {
						category: item.customer_group,
						label: item.name,
						value: item.customer_id,
						customer_group_id: item.customer_group_id
					}
				}));
				
			}
		});
	}, 
	select: function(event, ui) { 
			
		return false; 
	}
});

function getPaymentMethods() {
	$.ajax({
		url: 'index.php?route=checkout/manual/shipping&token=<?php echo $token; ?>',
		type: 'POST',
		dataType: 'json',
		data: $('#tab-shipping :input, #tab-product :input'),
		success: function(json) {
			
			
			/*
			$('.autocomplete div').remove();
			
			shipping = json['product'];
			shipping = json['shipping'];
			total = json['total'];
		
		}
	});		
}

function getTotals() {
	$.ajax({
		url: 'index.php?route=checkout/manual/total&token=<?php echo $token; ?>',
		type: 'POST',
		dataType: 'json',
		data: $('#form :input'),
		success: function(json) {

		}
	});		
}
*/

$('select[name=\'payment_zone_id\']').load('index.php?route=sale/customer/zone&token=<?php echo $token; ?>&country_id=' + <?php echo $payment_country_id; ?> + '&zone_id=<?php echo $payment_zone_id; ?>');
$('select[name=\'payment_zone_id\']').val('<?php echo $payment_zone_id; ?>');
$('select[name=\'shipping_zone_id\']').load('index.php?route=sale/customer/zone&token=<?php echo $token; ?>&country_id=' + <?php echo $shipping_country_id; ?> + '&zone_id=<?php echo $shipping_zone_id; ?>');
$('select[name=\'shipping_zone_id\']').val('<?php echo $shipping_zone_id; ?>');
//--></script> 
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script> 
<script type="text/javascript"><!--
$('.vtabs a').tabs();
//--></script> 

<?php echo $footer; ?>