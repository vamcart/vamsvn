<?php
/*
ci_message.class.php
Released under the GNU General Public License

  Example usage:

  $message = new message();
  $message->add('Error: Error 1', 'error');
  $message->add('Error: Error 2', 'warning');

  $message->add('Message', 'log');
All types of messages will be stored in log file.

  if ($message->size() > 0) echo $message->output();

    if ($message->add($cip->get_error(), 'error'))    return;
    This function will return true if we have an error. So we could use if() to check and decide what to do.




*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

  class message extends tableBlock {
    var $size = 0;
    var $count_errors=0;

    function message() {
      global $message2Stack;
      $this->errors = array();
      if (isset($_SESSION['message2Stack'])) {
        for ($i = 0, $n = sizeof($_SESSION['message2Stack']); $i < $n; $i++) {
          $this->add($_SESSION['message2Stack'][$i]['text'], $_SESSION['message2Stack'][$i]['type']);
        }
        unset($_SESSION['message2Stack']);
      }
    }

    function add($message, $type = 'error') {
        if ($message) {
            $this->size++;
            switch ($type) {
                case 'log':
                    $this->add_log($message);
                    break;
                case 'notice':
                    $this->errors[] = array(
                        'params'=>'class="messageNotice"',
                        'text' =>vam_image(DIR_WS_ADMIN_ICONS.'wink.gif'). '&nbsp;' .
                                      str_replace(vam_image(DIR_WS_ADMIN_ICONS.'wink.gif'). '&nbsp;', '', $message),
                        'type'=>$type);

                    if(USE_LOG_SYSTEM=='true')   $this->add_log($type.": ".str_replace(vam_image(DIR_WS_ADMIN_ICONS.'wink.gif'). '&nbsp;', '', $message));
                    break;
                case 'removed':
                    $this->errors[] = array(
                        'params'=>'class="messageSuccess"',
                        'text' =>vam_image(DIR_WS_ADMIN_ICONS.'sad.gif'). '&nbsp;' .
                                      str_replace(vam_image(DIR_WS_ADMIN_ICONS.'sad.gif'). '&nbsp;', '', $message),
                        'type'=>$type);
                    if(USE_LOG_SYSTEM=='true')   $this->add_log($type.": ".str_replace(vam_image(DIR_WS_ADMIN_ICONS.'sad.gif'). '&nbsp;', '', $message));
                    break;
                case 'installed':
                    $this->errors[] = array(
                        'params'=>'class="messageSuccess"',
                        'text' =>vam_image(DIR_WS_ADMIN_ICONS.'biggrin.gif').'&nbsp;'.
                                      str_replace(vam_image(DIR_WS_ADMIN_ICONS.'biggrin.gif'). '&nbsp;', '', $message),
                        'type'=>$type);
                    if(USE_LOG_SYSTEM=='true')   $this->add_log($type.": ".str_replace(vam_image(DIR_WS_ADMIN_ICONS.'biggrin.gif'). '&nbsp;', '', $message));
                    break;
                case 'warning':
                    $this->errors[] = array(
                        'params'=>'class="messageWarning"',
                        'text' =>vam_image(DIR_WS_ADMIN_ICONS . 'tongue.gif', ICON_WARNING) . '&nbsp;' .
                                      str_replace(vam_image(DIR_WS_ADMIN_ICONS.'tongue.gif', ICON_WARNING). '&nbsp;', '', $message),
                        'type'=>$type);
                    if(USE_LOG_SYSTEM=='true')   $this->add_log($type.": ".str_replace(vam_image(DIR_WS_ADMIN_ICONS.'tongue.gif'). '&nbsp;', '', $message));
                    break;
                case 'success':
                    $this->errors[] = array(
                        'params'=>'class="messageSuccess"',
                        'text' =>vam_image(DIR_WS_ADMIN_ICONS . 'smile.gif', ICON_SUCCESS).'&nbsp;'.
                                      str_replace(vam_image(DIR_WS_ADMIN_ICONS . 'smile.gif', ICON_SUCCESS). '&nbsp;', '', $message),
                        'type' =>$type);
                    if(USE_LOG_SYSTEM=='true')   $this->add_log($type.": ".str_replace(vam_image(DIR_WS_ADMIN_ICONS.'smile.gif'). '&nbsp;', '', $message));
                    break;
                case 'error':
                default:
                    $this->count_errors++;
                    $this->errors[]=array(
                        'params' => 'class="messageError"',
                        'text' =>vam_image(DIR_WS_ADMIN_ICONS . 'shocked.gif', ICON_ERROR) . '&nbsp;' .
                                      str_replace(vam_image(DIR_WS_ADMIN_ICONS.'shocked.gif', ICON_ERROR). '&nbsp;', '', $message),
                        'type' =>$type);
                    if(USE_LOG_SYSTEM=='true')   $this->add_log($type.": ".str_replace(vam_image(DIR_WS_ADMIN_ICONS.'shocked.gif'). '&nbsp;', '', $message));
                    //break;
                    return true; //We recieved an error and main script should finish your work when this func return true.
            }
        }
        return false;// No message and no error! Cool!
    }

    function add_session($message, $type = 'error') {
      if (!isset($_SESSION['message2Stack'])) {
        $_SESSION['message2Stack'] = array();
      }

      $_SESSION['message2Stack'][] = array('text' => $message, 'type' => $type);
    }

    function reset() {
      $this->errors = array();
      $this->size = 0;
    }

    function output() {
      $this->table_data_parameters = 'class="messageBox"';
      return $this->tableBlock($this->errors);
    }

    function count_errors() {return $this->count_errors;}
    function get_errors() {return $this->errors;}

    function add_log($message) {
        if (!$message)    return;
        $message="\r\n". date("d.m.Y H:i:s"). "\r\n". $message. "\r\n=================================================";
        $log_filename="ci_log.txt";
        $log_path=DIR_FS_ADMIN_BACKUP.$log_filename;
        //Rotator:
        if(file_exists($log_path) and filesize($log_path)>500000) {
            if (!copy($log_path, $log_path."_".date("H.i.s_d.m.Y")))     $this->add('Can\'t rotate log file '.$log_path, 'error');
            else  unlink($log_path);
        }
        if(file_exists($log_path)) {
            //$content=file_get_contents($log_path);
            if (!is_writable($log_path)) {chmod($log_path, 0777);}
            file_put_contents($log_path, $message, FILE_APPEND);
        } else {
            $file=fopen($log_path, 'w');//Create new file
            fwrite($file, $message);
            fclose($file);
        }
    }


  }
?>
