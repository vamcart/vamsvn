<?php
  function vam_get_manufacturers_name($manufacturers_id, $language_id = 0) {
    global $languages_id;

    if ($language_id == 0) $language_id = $_SESSION['languages_id'];
    if ($manufacturers_id > 0) {
    $manufacturers_query = vam_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$manufacturers_id . "'");
    $manufacturers = vam_db_fetch_array($manufacturers_query);

    return $manufacturers['manufacturers_name'];
    }
  }