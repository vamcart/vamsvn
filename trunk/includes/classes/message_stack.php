<?php
/* -----------------------------------------------------------------------------------------
   $Id: message_stack.php 799 2007-02-06 20:23:03 VaM $ 

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(message_stack.php,v 1.1 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (message_stack.php,v 1.9 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (message_stack.php,v 1.9 2003/08/13); xt-commerce.com

   Released under the GNU General Public License
   Example usage:
   $messageStack = new messageStack();
   $messageStack->add('general', 'Error: Error 1', 'error');
   $messageStack->add('general', 'Error: Error 2', 'warning');
   if ($messageStack->size('general') > 0) echo $messageStack->output('general');
   ---------------------------------------------------------------------------------------*/

  class messageStack {
    var $messages;

// class constructor
    function messageStack() {
      $this->messages = array();
    }

// class methods
    function add($class, $message, $type = 'error') {
      $this->messages[] = array('class' => $class, 'type' => $type, 'message' => $message);
    }

    function add_session($class, $message, $type = 'error') {
      if (isset($_SESSION['messageToStack'])) {
        $messageToStack = $_SESSION['messageToStack'];
      } else {
        $messageToStack = array();
      }

      $messageToStack[] = array('class' => $class, 'text' => $message, 'type' => $type);

      $_SESSION['messageToStack'] = $messageToStack;

      $this->add($class, $message, $type);
    }

    function reset() {
      $this->messages = array();
    }

    function output($class) {
      $messages = '<ul>';
      for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
        if ($this->messages[$i]['class'] == $class) {
          switch ($this->messages[$i]['type']) {
            case 'error':
              $bullet_image = DIR_WS_IMAGES . 'icons/error.gif';
              break;
            case 'warning':
              $bullet_image = DIR_WS_IMAGES . 'icons/warning.gif';
              break;
            case 'success':
              $bullet_image = DIR_WS_IMAGES . 'icons/success.gif';
              break;
            default:
              $bullet_image = DIR_WS_IMAGES . 'icons/error.gif';
          }

          $messages .= '<li style="list-style-image: url(\'' . $bullet_image . '\')">' . $this->messages[$i]['message'] . '</li>';
        }
      }
      $messages .= '</ul>';

      return '<div class="messageStack">' . $messages . '</div>';
    }

    function outputPlain($class) {
      $message = false;

      for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
        if ($this->messages[$i]['class'] == $class) {
          $message = $this->messages[$i]['message'];
          break;
        }
      }

      return $message;
    }

    function size($class) {
      $class_size = 0;

      for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
        if ($this->messages[$i]['class'] == $class) {
          $class_size++;
        }
      }

      return $class_size;
    }

    function loadFromSession() {
      if (isset($_SESSION['messageToStack'])) {
        $messageToStack = $_SESSION['messageToStack'];

        for ($i=0, $n=sizeof($messageToStack); $i<$n; $i++) {
          $this->add($messageToStack[$i]['class'], $messageToStack[$i]['text'], $messageToStack[$i]['type']);
        }

        unset($_SESSION['messageToStack']);
      }
    }
  }
?>