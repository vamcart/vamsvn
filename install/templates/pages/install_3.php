<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  $dir_fs_document_root = $_POST['DIR_FS_DOCUMENT_ROOT'];
  if ((substr($dir_fs_document_root, -1) != '\\') && (substr($dir_fs_document_root, -1) != '/')) {
    if (strrpos($dir_fs_document_root, '\\') !== false) {
      $dir_fs_document_root .= '\\';
    } else {
      $dir_fs_document_root .= '/';
    }
  }
?>

<div class="mainBlock">
  <div class="stepsBox">
    <ol>
      <li>База данных</li>
      <li>Веб Сервер</li>
      <li style="font-weight: bold;">Настройки магазина</li>
      <li>Установка завершена!</li>
    </ol>
  </div>

  <h1>Установка VamShop</h1><br /><br /><br />

</div>

<div class="contentBlock">
  <div class="infoPane">
    <h3>Шаг 3: Настройки магазина</h3>

    <div class="infoPaneContents">
      <p>Укажите название своего интернет-магазина.</p>
      <p>Укажите и запомните email адрес и пароль, именно эти данные будут использоваться для входа в админку интернет-магазина.</p>
    </div>
  </div>

  <div class="contentPane">
    <h2>Настройки интернет-магазина</h2>

    <form name="install" id="installForm" action="install.php?step=4" method="post">

    <table border="0" width="99%" cellspacing="0" cellpadding="5" class="inputForm">
      <tr>
        <td class="inputField"><?php echo 'Название магазина<br />' . osc_draw_input_field('CFG_STORE_NAME', null, 'class="text"'); ?></td>
        <td class="inputDescription">Укажите название своего интернет-магазина.</td>
      </tr>
      <tr>
        <td class="inputField"><?php echo 'E-Mail Адрес<br />' . osc_draw_input_field('CFG_STORE_OWNER_EMAIL_ADDRESS', null, 'class="text"'); ?></td>
        <td class="inputDescription">E-Mail адрес администратора магазина.</td>
      </tr>
      <tr>
        <td class="inputField"><?php echo 'Пароль<br />' . osc_draw_input_field('CFG_ADMINISTRATOR_PASSWORD', null, 'class="text"'); ?></td>
        <td class="inputDescription">Укажите свой пароль, пароль будет использоваться в том числе и для входа в админку магазина.</td>
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
