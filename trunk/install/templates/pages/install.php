<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/
?>

<script type="text/javascript" src="ext/xmlhttp/xmlhttp.js"></script>
<script type="text/javascript">
<!--

  var dbServer;
  var dbUsername;
  var dbPassword;
  var dbName;

  var formSubmited = false;

  function handleHttpResponse_DoImport() {
    if (http.readyState == 4) {
      if (http.status == 200) {
        var result = /\[\[([^|]*?)(?:\|([^|]*?)){0,1}\]\]/.exec(http.responseText);
        result.shift();

        if (result[0] == '1') {
          document.getElementById('mBoxContents').innerHTML = '<p><img src="images/success.gif" align="right" hspace="5" vspace="5" border="0" />База данных успешно загружена.</p>';

          setTimeout("document.getElementById('installForm').submit();", 2000);
        } else {
          document.getElementById('mBoxContents').innerHTML = '<p><img src="images/failed.gif" align="right" hspace="5" vspace="5" border="0" />Возникла проблема при загрузке базы данных. Ошибка:</p><p><strong>%s</strong></p><p>Пожалуйста, проверьте указанные данные для подключения к базе данных и попробуйте снова.</p>'.replace('%s', result[1]);
        }
      }

      formSubmited = false;
    }
  }

  function handleHttpResponse() {
    if (http.readyState == 4) {
      if (http.status == 200) {
        var result = /\[\[([^|]*?)(?:\|([^|]*?)){0,1}\]\]/.exec(http.responseText);
        result.shift();

        if (result[0] == '1') {
          document.getElementById('mBoxContents').innerHTML = '<p><img src="images/progress.gif" align="right" hspace="5" vspace="5" border="0" />База данных в данный момент загружается. Пожалуйста, подождите.</p><p>&nbsp;</p>';

          loadXMLDoc("rpc.php?action=dbImport&server=" + urlEncode(dbServer) + "&username=" + urlEncode(dbUsername) + "&password=" + urlEncode(dbPassword) + "&name=" + urlEncode(dbName), handleHttpResponse_DoImport);
        } else {
          document.getElementById('mBoxContents').innerHTML = '<p><img src="images/failed.gif" align="right" hspace="5" vspace="5" border="0" />Возникла проблема при подключении к базе данных. Ошибка:</p><p><strong>%s</strong></p><p>Пожалуйста, проверьте указанные данные для подключения к базе данных и попробуйте снова.</p>'.replace('%s', result[1]);
          formSubmited = false;
        }
      } else {
        formSubmited = false;
      }
    }
  }

  function prepareDB() {
    if (formSubmited == true) {
      return false;
    }

    formSubmited = true;

    showDiv(document.getElementById('mBox'));

    document.getElementById('mBoxContents').innerHTML = '<p><img src="images/progress.gif" align="right" hspace="5" vspace="5" border="0" />Проверка подключения к базе данных..</p>';

    dbServer = document.getElementById("DB_SERVER").value;
    dbUsername = document.getElementById("DB_SERVER_USERNAME").value;
    dbPassword = document.getElementById("DB_SERVER_PASSWORD").value;
    dbName = document.getElementById("DB_DATABASE").value;

    loadXMLDoc("rpc.php?action=dbCheck&server=" + urlEncode(dbServer) + "&username=" + urlEncode(dbUsername) + "&password=" + urlEncode(dbPassword) + "&name=" + urlEncode(dbName), handleHttpResponse);
  }

//-->
</script>

<div class="mainBlock">
  <div class="stepsBox">
    <ol>
      <li style="font-weight: bold;">База данных</li>
      <li>Веб Сервер</li>
      <li>Настройки магазина</li>
      <li>Установка завершена!</li>
    </ol>
  </div>

  <h1>Установка VamShop</h1><br /><br /><br />

</div>

<div class="contentBlock">
  <div class="infoPane">
    <h3>Шаг 1: База данных</h3>

    <div class="infoPaneContents">
      <p>В базе данных хранится вся информация интернет-магазина, например информация о товарах, покупателях, заказах.</p>
      <p>Если Вы не знаете данные для доступа к базе данных, спросите у Вашего хостера.</p>
    </div>
  </div>

  <div id="mBox">
    <div id="mBoxContents"></div>
  </div>

  <div class="contentPane">
    <h2>База данных</h2>

    <form name="install" id="installForm" action="install.php?step=2" method="post" onsubmit="prepareDB(); return false;">

    <table border="0" width="99%" cellspacing="0" cellpadding="5" class="inputForm">
      <tr>
        <td class="inputField"><?php echo 'Сервер<br />' . osc_draw_input_field('DB_SERVER', 'localhost', 'class="text"'); ?></td>
        <td class="inputDescription">Адрес сервера базы данных.</td>
      </tr>
      <tr>
        <td class="inputField"><?php echo 'Имя пользователя<br />' . osc_draw_input_field('DB_SERVER_USERNAME', null, 'class="text"'); ?></td>
        <td class="inputDescription">Имя пользователя для подключения к базе данных.</td>
      </tr>
      <tr>
        <td class="inputField"><?php echo 'Пароль<br />' . osc_draw_password_field('DB_SERVER_PASSWORD', 'class="text"'); ?></td>
        <td class="inputDescription">Пароль для подключения к базе данных.</td>
      </tr>
      <tr>
        <td class="inputField"><?php echo 'Название базы<br />' . osc_draw_input_field('DB_DATABASE', null, 'class="text"'); ?></td>
        <td class="inputDescription">Название базы данных.</td>
      </tr>
    </table>

    <p align="right"><span class="button"><button type="submit"><img src="images/icons/buttons/submit.png" alt="Продолжить" title=" Продолжить " width="12" height="12" />&nbsp;Продолжить</button></span>&nbsp;&nbsp;<a class="button" href="index.php"><span><img src="images/icons/buttons/cancel.png" alt="Отменить" title="Отменить" width="12" height="12"  />&nbsp;Отменить</span></a></p>

    </form>
  </div>
</div>
