<?php
/* --------------------------------------------------------------
   $Id: parameters.php 1167 2009-04-29 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2009 VaM Shop
   --------------------------------------------------------------
   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

if (!empty($_POST['intervals']) && intval($_POST['param_id']) > 0)
{
    $_POST['intervals'] = explode('####', $_POST['intervals']);
    foreach($_POST['intervals'] as $k => $v)
    {
        $v = trim($v);
        if (!empty($v))
        {
            list($title, $values) = explode('%%%', $v);
            $values = empty($values) ? array() : explode('--values--', $values);
            $intervals[] = array('title' => $title, 'values' => $values);
        }
    }
    mysql_query("UPDATE products_parameters SET products_parameters_intervals = '".addcslashes(serialize($intervals), "'")."' WHERE products_parameters_id = ".$_POST['param_id']);
}

  if (is_array($_POST["orders"]) && sizeof($_POST["orders"]) > 0 ||
      is_array($_POST["titles"]) && sizeof($_POST["titles"]) > 0)
  {
      $updates = $deleted = $ids = array();

      if (is_array($_POST["titlename"]))
      foreach($_POST["titlename"] as $id => $order)
      {
      	  $ids[] = $id;
          $updates[$id][] = "products_parameters_titlename = '".addcslashes($order, "'")."'";
      }
      mysql_query("update products_parameters set products_parameters_useinsearch = 0, products_parameters_useinsdesc = 0 where products_parameters_id in (".implode(", ", $ids).")");

      if (is_array($_POST["titlesuff"]))
      foreach($_POST["titlesuff"] as $id => $order)
      {
          $updates[$id][] = "products_parameters_titlesuff = '".addcslashes($order, "'")."'";
      }

      if (is_array($_POST["useinsearch"]))
      foreach($_POST["useinsearch"] as $id => $order)
      {
          $updates[$id][] = "products_parameters_useinsearch = '".intval($order)."'";
      }

      if (is_array($_POST["useinsdesc"]))
      foreach($_POST["useinsdesc"] as $id => $order)
      {
          $updates[$id][] = "products_parameters_useinsdesc = '".intval($order)."'";
      }

      if (is_array($_POST["orders"]))
      foreach($_POST["orders"] as $id => $order)
      {
          $updates[$id][] = "products_parameters_order = '".intval($order)."'";
      }

      if (is_array($_POST["opened"]))
      foreach($_POST["opened"] as $id => $opened)
      {
          $updates[$id][] = "products_parameters_maxopened = '".intval($opened)."'";
      }

      if (is_array($_POST["titles"]))
      foreach($_POST["titles"] as $id => $title)
      {
          if (!empty($title))
          {
              if (!get_magic_quotes_gpc()) $title = addslashes($title);
              $updates[$id][] = "products_parameters_title = '".$title."'";
          }
      }

      if (is_array($_POST["selected"]) && (intval($_POST["to_group"]) > 0 || $_POST["to_group"] == "gr" || $_POST["to_group"] == "d"))
      foreach($_POST["selected"] as $id)
      {
          if (intval($id) > 0)
          {
              switch($_POST["to_group"])
              {
                  case "gr":
                    $updates[$id][] = "products_parameters_group = '0'";
                    break;
                  case "d":
                    $deleted[] = intval($id);
                    //$updates[$id][] = "products_parameters_group = '".($_POST["to_group"] == "gr" ? 0 : intval($_POST["to_group"]))."'";
                    break;
                  default:
                    $updates[$id][] = "products_parameters_group = IF(products_parameters_type = 'p', '".intval($_POST["to_group"])."', 0)";
              }
          }
      }

      if (is_array($deleted) && sizeof($deleted) > 0)
      {
          mysql_query("delete from products_parameters where products_parameters_id in (".implode(", ", $deleted).")");
          mysql_query("delete from products_parameters2products where products_parameters_id in (".implode(", ", $deleted).")");
          mysql_query("update products_parameters set products_parameters_group = 0 where products_parameters_group in (".implode(", ", $deleted).")");
      }

      if (is_array($updates) && sizeof($updates) > 0)
      {
          foreach($updates as $id => $update)
          {
            if (is_array($update) && sizeof($update) > 0 && intval($id) > 0) mysql_query("update products_parameters set ".implode(", ", $update)." where products_parameters_id = '".intval($id)."'");
          }
      }
  }

  if (is_array($_POST["values"]) && intval($_POST["pid"]) > 0)
  foreach($_POST["values"] as $id => $value)
  {
      if (!get_magic_quotes_gpc()) $value = addslashes($value);
      $exists = mysql_fetch_assoc(mysql_query("select count(*) as `count` from products_parameters2products where products_id = ".intval($_POST["pid"])." and products_parameters_id = ".intval($id)));
      if ($exists["count"] > 0)
      {
          if (!empty($value))
          	mysql_query("update products_parameters2products set products_parameters2products_value = '".$value."' where products_id = ".intval($_POST["pid"])." and products_parameters_id = ".intval($id));
          else
          	mysql_query("delete from products_parameters2products where products_id = ".intval($_POST["pid"])." and products_parameters_id = ".intval($id));
      }
      elseif (!empty($value))
      {
          mysql_query("insert into products_parameters2products (products_parameters_id, products_id, products_parameters2products_value)
          values (".intval($id).", ".intval($_POST["pid"]).", '".$value."')");
      }
  }


  if (!empty($_POST["new_param_name"]) && intval($_POST["category"]) > 0)
  {
      $products_parameters_title = $products_parameters_name = trim(get_magic_quotes_gpc() ? $_POST["new_param_name"] : addslashes($_POST["new_param_name"]));
      $categories_id = intval($_POST["category"]);
      $products_parameters_type = $_POST["new_param_type"] == "p" || $_POST["new_param_type"] == "g" ? $_POST["new_param_type"] : "p";

      $exists = intval(mysql_result(mysql_query("select count(*) from products_parameters where categories_id = ".$categories_id." and products_parameters_name = '".$products_parameters_title."' and products_parameters_type = '".$products_parameters_type."'"), 0, 0));
      if ($exists == 0)
      {
          $products_parameters_order = 1 + intval(mysql_result(mysql_query("select max(products_parameters_order) from products_parameters where categories_id = ".$categories_id.""), 0, 0));
          mysql_query("insert into products_parameters (products_parameters_name, products_parameters_order, categories_id, products_parameters_title, products_parameters_type)
                       values ('".$products_parameters_name."', '".$products_parameters_order."', '".$categories_id."', '".$products_parameters_title."', '".$products_parameters_type."')");
      }
      else
      {
          $add_error = ($products_parameters_type == "p" ? PARAMETER_TITLE : GROUP_TITLE)." ".NAMEEXISTS_TITLE;
      }
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/general.js"></script>
<script language="JavaScript">
<!--
function show(obj)
{
    if (typeof obj != 'object') obj = $(obj);
    if (obj) obj.style.display = '';
}

function hide(obj)
{
    if (typeof obj != 'object') obj = $(obj);
    if (obj) obj.style.display = 'none';
}

function showhide(obj)
{
    if (typeof obj != 'object') obj = $(obj);
    if (obj) obj.style.display = obj.style.display == 'none' ?  '' : 'none';
}

function $(id)
{
    return document.getElementById(id);
}

function $add(type)
{
    return document.createElement(type);
}

function getClientWidth()
{
    return document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientWidth:document.body.clientWidth;
}

function getClientHeight()
{
    return document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientHeight:document.body.clientHeight;
}

function getDocumentHeight()
{
    return (document.body.scrollHeight > document.body.offsetHeight)?document.body.scrollHeight:document.body.offsetHeight;
}

function getDocumentWidth()
{
    return (document.body.scrollWidth > document.body.offsetWidth)?document.body.scrollWidth:document.body.offsetWidth;
}


function center_box(obj)
{
    oCanvas = document.getElementsByTagName((document.compatMode && document.compatMode == "CSS1Compat") ? "HTML" : "BODY")[0];
    obj.style.top = Math.ceil(oCanvas.scrollTop + getClientHeight()/2 - obj.clientHeight/2) + 'px';
    obj.style.left = Math.ceil(oCanvas.scrollLeft + getClientWidth()/2 - obj.clientWidth/2) + 'px';
}

function in_array(v, a)
{
    if (typeof a != 'object' && typeof a != 'array') return false;
    for(var l = 0; l < a.length; l++)
    {
        if (v == a[l]) return true;
    }
    return false;
}

function delete_from_array(v, a)
{
    if (typeof a != 'object' && typeof a != 'array') return false;
    var t = new Array();
    for(var l = 0; l < a.length; l++)
    {
        if (v != (arguments[2] === true ? l : a[l])) t.push(a[l]);
    }
    return t;
}

function set_intervals_dialog_open(id)
{
    if (param_id > 0) set_intervals_dialog_close();
    param_id = id;
    selected_interval = -1;

    if (!set_intervals_box) set_intervals_box = $('set_intervals_box');

    set_intervals_dialog_clean();

    $('set_intervals_box_title_paramname').innerHTML = $('products_parameters_title_' + param_id).innerHTML;
    set_intervals_dialog_drawintervals();
    set_intervals_dialog_drawvalues()

    show(set_intervals_box);
    center_box(set_intervals_box);
}

function set_intervals_dialog_close()
{
    if (!set_intervals_box) set_intervals_box = $('set_intervals_box');
    hide(set_intervals_box);

    for(var i = 0; i < intervals_list[param_id].length; i++)
    {
        if (typeof intervals_list[param_id][i].default_title == 'undefined')
        {
            intervals_list[param_id] = delete_from_array(i, intervals_list[param_id], true);
        }
        else
        {
            intervals_list[param_id][i].title = intervals_list[param_id][i].default_title;
            intervals_list[param_id][i].values = new Array();
            if (typeof intervals_list[param_id][i].default_values == 'object')
            {
                for(var v = 0; v < intervals_list[param_id][i].default_values.length; v++)
                    intervals_list[param_id][i].values.push(intervals_list[param_id][i].default_values[v]);
            }
        }
    }
    $('set_intervals_box_editinterval_intervaltitle').value = '';
    param_id = 0;
}

function set_intervals_dialog_add_interval()
{
    if ($('set_intervals_box_editinterval_intervaltitle').value == '') {alert('Укажите название интервала!'); return;}
    intervals_list[param_id].push({'title': $('set_intervals_box_editinterval_intervaltitle').value, 'values': new Array()});
    add_interval(intervals_list[param_id].length - 1);
    $('set_intervals_box_editinterval_intervaltitle').value = '';
    set_selected(intervals_list[param_id].length - 1);
}

function set_intervals_dialog_delete_interval(interval_num)
{
    if (typeof intervals_list[param_id][interval_num].values == 'object')
    {
        for(var v = intervals_list[param_id][interval_num].values.length - 1; v >= 0; v--)
        {
            value = intervals_list[param_id][interval_num].values[v];
            release_value('set_intervals_box_intervals_list_values_' + param_id + '_' + value, value, interval_num);
        }
    }
    intervals_list[param_id][interval_num].title = '';
    unset_selected(interval_num);
    o = $('set_intervals_box_intervals_list_title_' + interval_num).parentElement.removeChild($('set_intervals_box_intervals_list_title_' + interval_num));
    delete o;
}

function set_intervals_dialog_drawintervals()
{
    for(var i = 0; i < intervals_list[param_id].length; i++)
    {
        add_interval(i);
    }
}

function set_intervals_dialog_drawvalues()
{
    if (typeof intervals_values_list[param_id] != 'object') return;
    for(var i = 0; i < intervals_values_list[param_id].length; i++)
    {
        add_value( i);
    }
}

function set_intervals_dialog_clean()
{
    temp = new Array('set_intervals_box_intervals_list', 'set_intervals_box_values_list');
    for(var l = 0; l < temp.length; l++)
    {
        il = $(temp[l]);
        d = il.getElementsByTagName('DIV');
        while(d.length > 0)
        {
            o = il.removeChild(d[0]);
            delete o;
        }
    }
}

function add_interval(interval_num)
{
    if (intervals_list[param_id][interval_num].title == '') return;
    div = $add('DIV');
    $('set_intervals_box_intervals_list').appendChild(div);
    div.id = 'set_intervals_box_intervals_list_' + param_id;

    div1 = $add('DIV');
    div.appendChild(div1);
    div1.id = 'set_intervals_box_intervals_list_title_' + interval_num;
    div1.innerHTML = '<b title="<?php echo ONECLICK_TITLE.DCLICK_TITLE; ?>" onmouseover="this.style.cursor=\'hand\'" onclick="set_selected(' + interval_num + ');" ondblclick="set_edit_interval(' + interval_num + ', this);">' + intervals_list[param_id][interval_num].title + '</b> <a href="javascript: void(0);" onclick="showhide(\'set_intervals_box_intervals_list_values_' + interval_num + '\');">значения</a> <a href="javascript: void(0);" onclick="set_intervals_dialog_delete_interval(' + interval_num + ');">удалить</a>';

    div2 = $add('DIV');
    div1.appendChild(div2);
    div2.id = 'set_intervals_box_intervals_list_values_' + interval_num;
    div2.style.display = 'none';
    if (typeof intervals_list[param_id][interval_num].values == 'object')
    {
        for(var value_num = 0; value_num < intervals_values_list[param_id].length; value_num++)
        {
            if (in_array(intervals_values_list[param_id][value_num].md5, intervals_list[param_id][interval_num].values))
            {
                div3 = $add('DIV');
                div2.appendChild(div3);
                div3.id = 'set_intervals_box_intervals_list_values_' + param_id + '_' + intervals_values_list[param_id][value_num].md5;
                div3.innerHTML = intervals_values_list[param_id][value_num].title + ' <a href="javascript: void(0);" onclick="release_value(\'' + div3.id + '\', \'' + intervals_values_list[param_id][value_num].md5 + '\', ' + interval_num + ');">&gt;&gt;&gt;</a>';
            }
        }
    }
}

function add_value(value_num)
{
    div = $add('DIV');
    $('set_intervals_box_values_list').appendChild(div);
    div.id = 'set_intervals_box_values_list_' + intervals_values_list[param_id][value_num].md5;
    div.innerHTML = '<a href="javascript: void(0);" onclick="unrelease_value(\'' + value_num + '\');">&lt;&lt;&lt;</a> ' + intervals_values_list[param_id][value_num].title;
    for(var i = 0; i < intervals_list[param_id].length; i++)
    {
        div.style.display = (div.style.display == 'none' || typeof intervals_list[param_id][i].values == 'object' && in_array(intervals_values_list[param_id][value_num].md5, intervals_list[param_id][i].values)) ? 'none' : '';
    }
}

function release_value(div, md5, interval_num)
{
    o = $(div).parentElement.removeChild($(div));
    delete o;
    setTimeout(function () {try{$('set_intervals_box_values_list_' + md5).style.display = '';} catch(e){}}, 1);
    intervals_list[param_id][interval_num].values = delete_from_array(md5, intervals_list[param_id][interval_num].values);
}

function unrelease_value(value_num)
{
    if (selected_interval < 0) {alert('Сначала выберете интервал!'); return;}

    $('set_intervals_box_values_list_' + intervals_values_list[param_id][value_num].md5).style.display = 'none';
    div3 = $add('DIV');
    $('set_intervals_box_intervals_list_values_' + selected_interval).appendChild(div3);
    div3.id = 'set_intervals_box_intervals_list_values_' + param_id + '_' + intervals_values_list[param_id][value_num].md5;
    div3.innerHTML = intervals_values_list[param_id][value_num].title + ' <a href="javascript: void(0);" onclick="release_value(\'' + div3.id + '\', \'' + intervals_values_list[param_id][value_num].md5 + '\', ' + selected_interval + ');">&gt;&gt;&gt;</a>';
    intervals_list[param_id][selected_interval].values.push(intervals_values_list[param_id][value_num].md5);
}

function set_edit_interval(id, obj)
{
    //obj.contentEditable = true;
    //return;
    if (typeof interval_title_edit_on == 'undefined') interval_title_edit_on = false;
    if (interval_title_edit_on) return;
    interval_title_edit_on = true;
    obj.title = '';
    obj.innerHTML = '<input style="width: 100px;" type="text" id="interval_title_edit_' + id + '" value="' + obj.innerHTML.replace(/"/g, '&quot;') + '" onblur="unset_edit_interval(' + id + ', this.parentElement)">';
    document.getElementById('interval_title_edit_' + id).focus();
}

function unset_edit_interval(id, obj)
{
    //obj.contentEditable = false;
    //return;
    interval_title_edit_on = false;
    obj.title = '<?php echo DCLICK_TITLE; ?>';
    intervals_list[param_id][id].title = $('interval_title_edit_' + id).value;
    obj.innerHTML = $('interval_title_edit_' + id).value;
}

function set_selected(interval_num)
{
    if (selected_interval >= 0) unset_selected(selected_interval);
    selected_interval = interval_num;
    $('set_intervals_box_intervals_list_title_' + interval_num).style['color'] = 'green';
}

function unset_selected(interval_num)
{
    selected_interval = -1;
    $('set_intervals_box_intervals_list_title_' + interval_num).style['color'] = 'black';
}

function save_intervals()
{
    $('save_param_id').value = param_id;
    h = $('save_intervals');
    for(var i = 0; i < intervals_list[param_id].length; i++)
    {
        if (intervals_list[param_id][i].title != '')
        {
            h.value += intervals_list[param_id][i].title + '%%%';
            if (typeof intervals_list[param_id][i].values == 'object')
            {
                temp = new Array();
                h.value += intervals_list[param_id][i].values.join('--values--');
            }
            h.value += '####';
        }
    }
    $('intervals_save').submit();
}

var param_id = 0;
var selected_interval = -1;
var tmp_intervals_list = false;
var intervals_list = new Array();
var intervals_values_list = new Array();
var orders_values_list = new Array();
//-->
</script>

<style>
#set_intervals_box {
    position: absolute;
    padding: 10px 10px 0;
    top: 200;
    left: 200;
    z-index: 100;
    min-height: 100px; /* For Modern Browsers */
    height: 100px; /* For IE */
    width: 250px;
    background: #FFFFFF;
    border: solid 2px #ACACAC;
    /*overflow: auto;*/
}
</style>

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<div id="set_intervals_box" style="display:none; width: 550px; height: 400px;">
    <h1 class="contentBoxHeading"><?php echo SET_INTERVALS_BOX_TITLE; ?> <span id="set_intervals_box_title_paramname"></span></h1>
    <?php echo SET_INTERVALS_BOX_EDITINTERVAL_INTERVALTITLE; ?>: <input type="text" id="set_intervals_box_editinterval_intervaltitle"> <span class="button"><input type="button" value="<?php echo SET_INTERVALS_ADDINTERVAL_BUTTON_TITLE; ?>" onclick="set_intervals_dialog_add_interval();"></span><br />
    <table>
    <tr>
        <td width="300" valign="top">
            <div id="set_intervals_box_intervals_list" style="height: 280px; overflow: auto;">
                <?php echo SET_INTERVALS_BOX_LISTINTERVAL_TITLE; ?>:<br />
            </div>
        </td>
        <td width="250" valign="top">
            <div id="set_intervals_box_values_list" style="height: 280px; overflow: auto;">
            <?php echo SET_INTERVALS_BOX_LISTVALUES_TITLE; ?>:<br />
            </div>
        </td>
    </tr>
    </table>
    <br />
    <span class="button"><input type="button" value="<?php echo SAVE_BUTTON_TITLE; ?>" onclick="save_intervals()"></span> <span class="button"><input type="button" value="<?php echo CANCEL_BUTTON_TITLE; ?>" onclick="set_intervals_dialog_close()"></span>
</div>

<div id="set_orders_box" style="display:none; width: 550px; height: 400px;">
    <h1 class="contentBoxHeading"><?php echo SET_ORDERS_BOX_TITLE; ?> <span id="set_intervals_box_title_paramname"></span></h1>
    <table>
    <tr>
        <td width="300" valign="top">
            <div id="set_orders_box_intervals_list" style="height: 280px; overflow: auto;">
                <?php echo SET_ORDERS_BOX_LISTINTERVAL_TITLE; ?>:<br />
            </div>
        </td>
        <td width="250" valign="top">
            <div id="set_orders_box_values_list" style="height: 280px; overflow: auto;">
            <?php echo SET_INTERVALS_BOX_LISTVALUES_TITLE; ?>:<br />
            </div>
        </td>
    </tr>
    </table>
    <br />
    <span class="button"><input type="button" value="<?php echo SAVE_BUTTON_TITLE; ?>" onclick="save_orders()"></span> <span class="button"><input type="button" value="<?php echo CANCEL_BUTTON_TITLE; ?>" onclick="set_orders_dialog_close()"></span>
</div>


<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body width="100%" //-->
<table border="0"  cellspacing="2" cellpadding="2">
  <tr>
        <td width="100%">

        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><a class="button" href="<?php echo MANUAL_LINK_FILTERS; ?>" target="_blank"><span><?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>

<br />

<a class="button" href="../filters/update_parameters.php?clear=1" target="_blank"><span><?php echo BUTTON_UPDATE_PARAMETERS; ?></span></a>

<br /><br />

<?php echo TEXT_UPDATE_PARAMETERS; ?>

  </td>
  </tr>
  <tr>
<!-- body_text  width="100%" //-->
    <td class="boxCenter" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">

            <form id="intervals_save" method="POST">
            <input type="hidden" name="param_id" id="save_param_id" value="">
            <input type="hidden" name="intervals" id="save_intervals" value="">
            </form>

            <form name="add_params_form" method="POST" onsubmit="if ($('new_param_name').value == '') {alert('Укажите название параметра!'); return false} else {return true}">
            <input type="hidden" name="pid" value="<?php echo $_REQUEST["pid"]; ?>">
            <input type="hidden" name="search_product" value="<?php echo htmlspecialchars($_REQUEST["search_product"]); ?>">

<?php
                  if ($_REQUEST["pid"] > 0)
                  {
                      $product = mysql_fetch_assoc(mysql_query("select products_description.products_id, products_name, categories_id from products_to_categories left join products_description using (products_id) where products_to_categories.products_id = '".$_REQUEST["pid"]."' order by categories_id desc"));
                      if ($product["categories_id"] > 0) $_REQUEST["category"] = $product["categories_id"];
                  }
                                                                                                                             //products_parameters left join categories_description using (categories_id)

?>
                <?php echo CATEGORIES_TITLE; ?>: <select name="category" id="select_category" onchange="location.href='?category=' + this.value;">
                <?php
                  $category_query = mysql_query("select DISTINCT categories_description.categories_id, categories_name from categories_description order by categories_name");
                  while ($category = vam_db_fetch_array($category_query))
                  {
                    if (intval($_REQUEST["category"]) < 1) $_REQUEST["category"] = $category["categories_id"];
                    //$categoryes = $category;
                    ?>
                    <option value="<?php echo $category["categories_id"]; ?>" <?php echo ($category["categories_id"] == $_REQUEST["category"] ? "selected" : ""); ?>><?php echo $category["categories_name"]; ?></option>
                    <?php
                  }
                ?>
                </select><br>
            <?php
            if (!empty($add_error)) echo "<font color=red>".$add_error."</font><br>";
            ?>
            <input type="text" name="new_param_name" id="new_param_name">
            <select name="new_param_type"><option value="p"><?php echo PARAMETER_TITLE; ?></option><option value="g"><?php echo GROUP_TITLE; ?></option></select>
            <span class="button"><button type="submit" value="<?php echo ADD_BUTTON_TITLE; ?>"><?php echo ADD_BUTTON_TITLE; ?></button></span>
            </form>

            <form name="params_form" method="POST" >
            <input type="hidden" name="pid" value="<?php echo $_REQUEST["pid"]; ?>">
            <table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent">&nbsp;</td>
                <td class="dataTableHeadingContent"><a href="?<?php echo ($_REQUEST["category"] > 0 ? "category=".$_REQUEST["category"]."&" : ""); ?>order=name"><?php echo PARAMETER_TITLE; ?></a></td>
                <td class="dataTableHeadingContent" align="right"><a href="?<?php echo ($_REQUEST["category"] > 0 ? "category=".$_REQUEST["category"]."&" : ""); ?>order=order"><?php echo ORDER_TITLE; ?></a></td>
                <td class="dataTableHeadingContent" align="right"><a href="?<?php echo ($_REQUEST["category"] > 0 ? "category=".$_REQUEST["category"]."&" : ""); ?>order=opened"><?php echo OPENED_TITLE; ?></a></td>
                <td class="dataTableHeadingContent" align="right"><a href="?<?php echo ($_REQUEST["category"] > 0 ? "category=".$_REQUEST["category"]."&" : ""); ?>order=useinsearch"><?php echo SEARCH_TITLE; ?></a></td>
                <!-- <td class="dataTableHeadingContent" align="right"><a href="?<?php echo ($_REQUEST["category"] > 0 ? "category=".$_REQUEST["category"]."&" : ""); ?>order=intervals"><?php echo INTERVALS_TITLE; ?></a></td>  -->
                <td class="dataTableHeadingContent" align="right"><a href="?<?php echo ($_REQUEST["category"] > 0 ? "category=".$_REQUEST["category"]."&" : ""); ?>order=titlename"><?php echo NAMEINTITLE_TITLE; ?></a></td>
                <td class="dataTableHeadingContent" align="right"><a href="?<?php echo ($_REQUEST["category"] > 0 ? "category=".$_REQUEST["category"]."&" : ""); ?>order=titlesuff"><?php echo SUFFINTITLE_TITLE; ?></a></td>
                <td class="dataTableHeadingContent" align="right"><a href="?<?php echo ($_REQUEST["category"] > 0 ? "category=".$_REQUEST["category"]."&" : ""); ?>order=useinsearch"><?php echo DESC_TITLE; ?></a></td>
                <?php
                if ($_REQUEST["pid"] > 0)
                {
                ?>
                <td class="dataTableHeadingContent" align="right">
                <?php
                if ($product["products_id"] > 0) echo $product["products_name"];
                ?>
                </td>
                <?php
                }
                ?>
              </tr>

<?php

if (isset($_REQUEST["category"])) {
  $order = $_REQUEST["order"] == "name" ? "products_parameters_name" : "products_parameters_order";
  $join = $_REQUEST["pid"] > 0 ? "left join products_parameters2products on (products_parameters.products_parameters_id = products_parameters2products.products_parameters_id and products_id  = ".intval($_REQUEST["pid"]).")" : "";
  $fields = $_REQUEST["pid"] > 0 ? "products_parameters.products_parameters_id, products_parameters_useinsdesc, products_parameters_useinsearch, products_parameters_intervals, products_parameters_titlename, products_parameters_titlesuff, products_parameters_name, products_parameters_order, categories_id, products_parameters_title, products_parameters_type, products_parameters_group, products_parameters_maxopened, products_id, products_parameters2products_value" :
                                   "products_parameters.products_parameters_id, products_parameters_useinsdesc, products_parameters_useinsearch, products_parameters_intervals, products_parameters_titlename, products_parameters_titlesuff, products_parameters_name, products_parameters_order, categories_id, products_parameters_title, products_parameters_type, products_parameters_group, products_parameters_maxopened";
  $parameters_query = mysql_query("select $fields from products_parameters $join where categories_id = ".$_REQUEST["category"]." order by ".$order);
  $params = array(0 => array());
  $p_ids = array();
  while ($parameters = vam_db_fetch_array($parameters_query))
  {
      //echo $parameters["products_parameters_title"]." [".$parameters["products_parameters_id"]."]: ".$parameters["products_parameters_type"]."<br>";

      if ($parameters["products_parameters_type"] == "g")
         $params[$parameters["products_parameters_id"]] = is_array($params[$parameters["products_parameters_id"]]) ? array_merge($params[$parameters["products_parameters_id"]], $parameters) : $parameters;
      else
         $params[$parameters["products_parameters_group"]]["params"][] = $parameters;
      $p_ids[] = $parameters["products_parameters_id"];
  }
}
  if (sizeof($p_ids) > 0)
  {
      $values_query = mysql_query("SELECT products_parameters2products_value, products_parameters_id, products_parameters2products_md5, products_parameters2products_order FROM `products_parameters2products` WHERE products_parameters_id IN (".implode(",", $p_ids).") and products_parameters2products_value != '' ORDER by products_parameters2products_value");
      while ($value = vam_db_fetch_array($values_query))
      {
          if (strlen($value['products_parameters2products_value']) > 40)
          {
              $value['products_parameters2products_value'] = iconv("utf-8", "windows-1251", $value['products_parameters2products_value']);
              $value['products_parameters2products_value'] = substr($value['products_parameters2products_value'], 0, 40);
              $value['products_parameters2products_value'] = iconv("windows-1251", "utf-8", $value['products_parameters2products_value']);
          }
          $value['products_parameters2products_value'] = str_replace("\r", "\\r", $value['products_parameters2products_value']);
          $value['products_parameters2products_value'] = str_replace("\n", "\\n", $value['products_parameters2products_value']);
          $value['products_parameters2products_value'] = str_replace("'", "", $value['products_parameters2products_value']);
          $value['products_parameters2products_value'] = htmlspecialchars($value['products_parameters2products_value']);

          if (!is_array($intervals_values_list[$value['products_parameters_id']])) $intervals_values_list[$value['products_parameters_id']] = array();
          if (!is_array($orders_values_list[$value['products_parameters_id']])) $orders_values_list[$value['products_parameters_id']] = array();

          if (!isset($intervals_values_list[$value['products_parameters_id']][$value['products_parameters2products_md5']])) $intervals_values_list[$value['products_parameters_id']][$value['products_parameters2products_md5']] = "{'title': '".$value['products_parameters2products_value']."', 'md5': '".$value['products_parameters2products_md5']."'}";
          //if (!isset($orders_values_list[$value['products_parameters_id']][$value['products_parameters2products_md5']])) $orders_values_list[$value['products_parameters_id']][$value['products_parameters2products_md5']] = "{'".$value['products_parameters2products_value']."': ".$value['products_parameters2products_order']."}";
      }
  }

  if (is_array($params))
  foreach($params as $parameters)
  {
      if (!empty($parameters['products_parameters_title']))
      {
      ?>
              <tr class="dataTableHeadingRow">
                <td class="dataTableContent" align="right"><input type="checkbox" name="selected[]" value="<?php echo $parameters['products_parameters_id']; ?>"></td>
                <td style="font-weight: bold; text-align: center;" title="<?php echo DCLICK_TITLE; ?>" class="dataTableContent" onmouseover="this.style.cursor='hand'" ondblclick="set_edit(<?php echo $parameters['products_parameters_id']; ?>, this);"><?php echo htmlspecialchars($parameters['products_parameters_title']); ?></td>
                <td class="dataTableContent" align="right"><input type="text" size="3" name="orders[<?php echo $parameters['products_parameters_id']; ?>]" value="<?php echo $parameters['products_parameters_order']; ?>"></td>
                <?php
                if ($_REQUEST["pid"] > 0)
                {
                ?>
                <td class="dataTableContent" align="right"></td>
                <?php
                }
                ?>
              </tr>
      <?php
      }

      if (is_array($parameters["params"]))
      foreach($parameters["params"] as $p)
      {
      ?>
              <tr class="dataTableHeadingRow">
                <td class="dataTableContent" align="right"><input type="checkbox" name="selected[]" value="<?php echo $p['products_parameters_id']; ?>"></td>
                <td title="<?php echo DCLICK_TITLE; ?>" id="products_parameters_title_<?php echo $p['products_parameters_id']; ?>" class="dataTableContent" onmouseover="this.style.cursor='hand'" ondblclick="set_edit(<?php echo $p['products_parameters_id']; ?>, this);"><?php echo htmlspecialchars($p['products_parameters_title']); ?></td> 
                <td class="dataTableContent" align="right"><input type="text" size="3" name="orders[<?php echo $p['products_parameters_id']; ?>]" value="<?php echo $p['products_parameters_order']; ?>"></td>
                <td class="dataTableContent" align="right"><input type="text" size="3" name="opened[<?php echo $p['products_parameters_id']; ?>]" value="<?php echo $p['products_parameters_maxopened']; ?>"></td>
                <td class="dataTableContent" align="right"><input type="checkbox" name="useinsearch[<?php echo $p['products_parameters_id']; ?>]" value="1" <?php echo ($p['products_parameters_useinsearch'] == 1 ? 'checked' : ''); ?>></td>

                <!-- </td> -->
                <td class="dataTableContent" align="right"><input type="text" size="30" name="titlename[<?php echo $p['products_parameters_id']; ?>]" value="<?php echo $p['products_parameters_titlename']; ?>"></td>
                <td class="dataTableContent" align="right"><input type="text" size="3" name="titlesuff[<?php echo $p['products_parameters_id']; ?>]" value="<?php echo $p['products_parameters_titlesuff']; ?>"></td>
                <td class="dataTableContent" align="right"><input type="checkbox" name="useinsdesc[<?php echo $p['products_parameters_id']; ?>]" value="1" <?php echo ($p['products_parameters_useinsdesc'] == 1 ? 'checked' : ''); ?>></td>

                <?php
                if ($_REQUEST["pid"] > 0)
                {
                ?>
                <td class="dataTableContent" align="right"><input type="text" size="50" name="values[<?php echo $p['products_parameters_id']; ?>]" value="<?php echo $p['products_parameters2products_value']; ?>"></td>
                <?php
                }
                ?>
              </tr>
      <?php
      }
  }
?>
            </table>

<?php echo SELECTED_TITLE; ?>:
<select name="to_group" onchange="if (!to_switch(this.value, this.options[this.selectedIndex].text)) this.selectedIndex = 0;"><option value=""></option><option value="gr"><?php echo REMOVEFROMGROUP_TITLE; ?></option>
<?php
foreach($params as $parameters)
{
    if (!empty($parameters['products_parameters_title']))
    {
    ?>
    <option value="<?php echo $parameters['products_parameters_id']; ?>"><?php echo MOVE2GROUP_TITLE; ?>: <?php echo htmlspecialchars($parameters['products_parameters_title']); ?></option>
    <?php
    }
}
?>
<option value="d"><?php echo DELETE_TITLE; ?></option>
</select>

<script language="JavaScript">
<!--
function to_switch(value, title)
{
    switch(value)
    {
        case 'd':
            m = '<?php echo DELETE_CONFIRM_MESSAGE1; ?>';
            break;
        case 'gr':
            m = '<?php echo DELETE_CONFIRM_MESSAGE2; ?>';
            break;
        case 'use':
            m = '<?php echo DELETE_CONFIRM_MESSAGE3; ?>';
            break;
        case 'notuse':
            m = '<?php echo DELETE_CONFIRM_MESSAGE4; ?>';
            break;
        default:
            m = '<?php echo DELETE_CONFIRM_MESSAGE5; ?>' + value + '?';
            break;
    }
    return confirm(m);
}


function set_edit(id, obj)
{
    obj.ondblclick = function() {};
    //document.write(obj.innerHTML.replace(/"/, '&quot;'));
    obj.title = '';
    obj.innerHTML = '<input style="width: 100%;" type="text" id="titles_' + id + '" name="titles[' + id + ']" value="' + obj.innerHTML.replace(/"/g, '&quot;') + '">';
    document.getElementById('titles_' + id).focus();
}
//-->
</script>
            <span class="button"><button type="submit" value="<?php echo SAVE_BUTTON_TITLE; ?>"><?php echo SAVE_BUTTON_TITLE; ?></button></span>
            </form>
            </td>
            <form action="">
            <input type="hidden" name="category" value="<?php echo $_REQUEST["category"]; ?>">
            <td style="padding-left: 50px;" valign="top">
            <?php echo SEARCHPRODUCT_TITLE; ?>:<br>
            <input type="text" name="search_product" value="<?php echo htmlspecialchars($_REQUEST["search_product"]); ?>"> <span class="button"><button type="submit" value="<?php echo SEARCH_BUTTON_TITLE; ?>"><?php echo SEARCH_BUTTON_TITLE; ?></button></span>

            <?php
            if (!empty($_REQUEST["search_product"]))
            {
                $_REQUEST["search_product"] = get_magic_quotes_gpc() ? $_REQUEST["search_product"] : addslashes($_REQUEST["search_product"]);
                $p_query = "select products_description.products_id, products_name from products_to_categories left join products_description using (products_id) where language_id = '".$_SESSION['languages_id']."' and categories_id = '".$_REQUEST["category"]."' and products_name regexp('".$_REQUEST["search_product"]."')";
                $p = mysql_query($p_query);
                ?>
                <table width="100%">
                <?php
                while ($product = mysql_fetch_array($p))
                {
                    ?>
                    <tr class="dataTableHeadingRow">
                        <td title="<?php echo CLICK_TITLE; ?>" class="dataTableContent" onmouseover="this.style.cursor='hand'" onclick="location.href = 'parameters.php?category=<?php echo $_REQUEST["category"]; ?>&search_product=<?php echo urlencode($_REQUEST["search_product"]); ?>&pid=<?php echo $product["products_id"]; ?>'"><?php echo $product["products_name"]; ?></td>
                    </tr>
                    <?php
                }
                ?>
                </table>
                <?php
            }
            ?>

            </form>
            </td>

          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>