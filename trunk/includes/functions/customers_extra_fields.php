<?php
/* --------------------------------------------------------------
   $Id: articles.php 1249 2007-03-09 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   (c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  function vam_get_extra_fields($customer_id,$languages_id){
          $extra_fields_query = vam_db_query("select ce.fields_id, ce.fields_input_type, ce.fields_required_status, cei.fields_name, ce.fields_status, ce.fields_input_type from " . TABLE_EXTRA_FIELDS . " ce, " . TABLE_EXTRA_FIELDS_INFO . " cei where ce.fields_status=1 and cei.fields_id=ce.fields_id and cei.languages_id =" . $languages_id);
          $extra_fields_string ='';
          if(vam_db_num_rows($extra_fields_query)>0){
             while($extra_fields = vam_db_fetch_array($extra_fields_query)){
                  $value='';
                  if(isset($customer_id)){
                          $value_query = vam_db_query("select value from " . TABLE_CUSTOMERS_TO_EXTRA_FIELDS . " where customers_id=" . $customer_id . " and fields_id=" . $extra_fields['fields_id']);
                          $value_info = vam_db_fetch_array($value_query);
                          $value = $value_info['value'];
                  }

$extra_fields_string[] = array('NAME' => $extra_fields['fields_name'],
                                                   'VALUE' => (($extra_fields['fields_input_type']==0) ? vam_draw_input_field('fields_' . $extra_fields['fields_id'],$value) : vam_draw_textarea_field('fields_' . $extra_fields['fields_id'], 'soft', 50, 6,$value,'style="width:400px;"')) . ' ' . (($extra_fields['fields_required_status']==1) ? '<span class="inputRequirement">*</span>': '') 

);

             }
          }
          return $extra_fields_string;
  }

?>
