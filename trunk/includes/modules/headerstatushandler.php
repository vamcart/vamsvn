<?php
/*
  $Id: headerstatushandler, v 1.0 2013/07/01 by Jack York - oscommerce-solution.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2013 oscommerce-solution.com

  Released under the GNU General Public License
*/

      $invalidProduct = RTN_GOOD;
      if (! isset($_GET['products_id']) || $_GET['products_id'] == 0) {
          $invalidProduct = RTN_410;
      } else  {
          $invalidProduct = IsProduct($_GET['products_id'], $PHP_SELF, $_SESSION['languages_id']);
      }
      switch ($invalidProduct) {
          case RTN_404:
          header("HTTP/1.1 404 Not Found");
          break;

          case RTN_410:
          header("HTTP/1.1 410 Gone");
          break;

          default: break;
      }