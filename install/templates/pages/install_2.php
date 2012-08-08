<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  $www_location = 'http://' . $_SERVER['HTTP_HOST'];

  if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])) {
    $www_location .= $_SERVER['REQUEST_URI'];
  } else {
    $www_location .= $_SERVER['SCRIPT_FILENAME'];
  }

  $www_location = substr($www_location, 0, strpos($www_location, 'install'));

  $dir_fs_www_root = osc_realpath(dirname(__FILE__) . '/../../../') . '/';
?>

<div class="mainBlock">
  <div class="stepsBox">
    <ol>
      <li>База данных</li>
      <li style="font-weight: bold;">Веб Сервер</li>
      <li>Настройки магазина</li>
      <li>Установка завершена!</li>
    </ol>
  </div>

  <h1>Установка VamShop</h1><br /><br /><br />

</div>

<div class="contentBlock">
  <div class="infoPane">
    <h3>Шаг 2: Веб Сервер</h3>

    <div class="infoPaneContents">
      <p>На данном шаге определяется адрес интернет-магазина и путь до корневой директории магазина.</p>
    </div>
  </div>

  <div class="contentPane">
    <h2>Веб Сервер</h2>

    <form name="install" id="installForm" action="install.php?step=3" method="post">

    <table border="0" width="99%" cellspacing="0" cellpadding="5" class="inputForm">
      <tr>
        <td class="inputField"><?php echo 'WWW Адрес<br />' . osc_draw_input_field('HTTP_WWW_ADDRESS', $www_location, 'class="text"'); ?></td>
        <td class="inputDescription">Веб адрес интернет-магазина.</td>
      </tr>
      <tr>
        <td class="inputField"><?php echo 'Корневая директория магазина<br />' . osc_draw_input_field('DIR_FS_DOCUMENT_ROOT', $dir_fs_www_root, 'class="text"'); ?></td>
        <td class="inputDescription">Директория, где расположены файлы интернет-магазина.</td>
      </tr>
    </table>

    <p align="right"><span class="button"><button type="submit"><img src="images/icons/buttons/submit.png" alt="Продолжить" title=" Продолжить " width="12" height="12" />&nbsp;Продолжить</button></span>&nbsp;&nbsp;<a class="button" href="index.php"><span><img src="images/icons/buttons/cancel.png" alt="Отменить" title="Отменить" width="12" height="12"  />&nbsp;Отменить</span></a></p>

<?php
  reset($_POST);
  while (list($key, $value) = each($_POST)) {
    if (($key != 'x') && ($key != 'y')) {
      if (is_array($value)) {
        for ($i=0, $n=sizeof($value); $i<$n; $i++) {
          echo osc_draw_hidden_field($key . '[]', $value[$i]);
        }
      } else {
        echo osc_draw_hidden_field($key, $value);
      }
    }
  }
?>

    </form>
  </div>
</div>
