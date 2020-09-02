<?php
/* --------------------------------------------------------------
   $Id: upload.php 950 2007-02-08 12:17:21Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(upload.php,v 1.1 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (upload.php,v 1.7 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (upload.php,v 1.7 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
//defined( '_VALID_VAM_FRONT' ) or die( 'Direct Access to this location is not allowed.' );

  class upload {
    var $file, $filename, $destination, $permissions, $extensions, $tmp_filename, $prefix;

    function __construct($file = '', $destination = '', $permissions = '777', $extensions = array('jpg', 'jpeg', 'JPG', 'png', 'PNG', 'webp', 'WEBP', 'svg', 'SVG'), $prefix = '') {

      $this->set_file($file);
      $this->set_destination($destination);
      $this->set_permissions($permissions);
      $this->set_extensions($extensions);
	  $this->set_prefix($prefix);

      if (vam_not_null($this->file) && vam_not_null($this->destination)) {
        if ( ($this->parse() == true) && ($this->save() == true) ) {
          return true;
        } else {
          return false;
        }
      }
    }

    function parse() {
      global $messageStack;
	  
      if (isset($_FILES[$this->file])) {
        $file = array('name' => $_FILES[$this->file]['name'],
                      'type' => $_FILES[$this->file]['type'],
                      'size' => $_FILES[$this->file]['size'],
                      'tmp_name' => $_FILES[$this->file]['tmp_name']);
      } elseif (isset($_FILES[$this->file])) {

        $file = array('name' => $_FILES[$this->file]['name'],
                      'type' => $_FILES[$this->file]['type'],
                      'size' => $_FILES[$this->file]['size'],
                      'tmp_name' => $_FILES[$this->file]['tmp_name']);
      } else {
        $file = array('name' => $GLOBALS[$this->file . '_name'],
                      'type' => $GLOBALS[$this->file . '_type'],
                      'size' => $GLOBALS[$this->file . '_size'],
                      'tmp_name' => $GLOBALS[$this->file]);
      }

      if ( vam_not_null($file['tmp_name']) && ($file['tmp_name'] != 'none') && is_uploaded_file($file['tmp_name']) ) {
        if (sizeof($this->extensions) > 0) {
          if (!in_array(strtolower(substr($file['name'], strrpos($file['name'], '.')+1)), $this->extensions)) {
            $messageStack->add('uploads', 'Ошибка: нельзя закачивать файлы данного типа (допускаются форматы jpg и png)', 'error');
            
            return false;
          }
        }

        $this->set_file($file);
        $this->set_filename($file['name']);
        $this->set_tmp_filename($file['tmp_name']);
		

        return $this->check_destination();
      } else {

        if ($file['tmp_name']=='none') 
		$messageStack->add('uploads', 'Предупреждение: Ни одного файла не загружено.', 'warning');

        return false;
      }
    }

    function save() {
      global $messageStack;

      if (substr($this->destination, -1) != '/') $this->destination .= '/';

      // GDlib check
      if (!function_exists(imagecreatefromgif)) {

        // check if uploaded file = gif
        if ($this->destination==DIR_FS_CATALOG_ORIGINAL_IMAGES) {
            // check if merge image is defined .gif
            if (strstr(PRODUCT_IMAGE_THUMBNAIL_MERGE,'.gif') ||
                strstr(PRODUCT_IMAGE_INFO_MERGE,'.gif') ||
                strstr(PRODUCT_IMAGE_POPUP_MERGE,'.gif')) {

                $messageStack->add('uploads', 'Отсутствует GDlib GIF-поддержка, соеденить картинки неудалось', 'error');
                return false;

            }
            // check if uploaded image = .gif
            if (strstr($this->filename,'.gif')) {
             $messageStack->add('uploads', 'Отсутствует GDlib Gif-поддержка, обработка картинки GIF неудалась', 'error');
             return false;
            }

        }

      }
	  
	  $file_end = $this->prefix . $this->filename; // имя файла с префиксом
      	  
      if (move_uploaded_file($this->file['tmp_name'], $this->destination . $file_end)) {
     
	 $orig_size = getimagesize($this->destination . $file_end);
	 $orig_width = $orig_size[0];
	 $orig_height = $orig_size[1];	  
	  
	  // меняем размер картинки jpg
	  if (strstr($file_end,'.jpg') || strstr($file_end,'.JPG')) {	  
	  $new_height = 600;
	  $new_width = '';
	  $img = imagecreatefromjpeg($this->destination . $file_end);
	  // если не указана одна из сторон задаем ей пропорциональное значение
		if( ! $new_width )
			$new_width = round( $orig_width*($new_height/$orig_height) );
		if( ! $new_height )
			$new_height = round( $orig_height*($new_width/$orig_width) );
      $bild_neu = imagecreatetruecolor($new_width, $new_height); 
	  imagecopyresampled($bild_neu, $img, 0,0,0,0, $new_width, $new_height, $orig_width, $orig_height);
	  imageinterlace($bild_neu, 1);
	  imagejpeg($bild_neu, $this->destination . $file_end, 80);
      imagedestroy($bild_neu);
	  }
	  
	  // меняем размер картинки png
	  if (strstr($file_end,'.png') || strstr($file_end,'.PNG')) {
		$new_height = 500;
	    $new_width = '';
	    $img = imagecreatefrompng($this->destination . $file_end);
		// если не указана одна из сторон задаем ей пропорциональное значение
		if( ! $new_width )
			$new_width = round( $orig_width*($new_height/$orig_height) );
		if( ! $new_height )
			$new_height = round( $orig_height*($new_width/$orig_width) );
		if(!$img) return false;
		$bild_neu = imagecreatetruecolor($new_width, $new_height);
		// Transparente Farbe des Quell-Bildes abfragen
		$colorTransparent = imagecolortransparent($bild_neu);
		// Parlette kopieren
		imagepalettecopy($bild_neu, $img);
		// Zielbild mit transparenter Farbe fьllen
		imagefill($bild_neu,0,0,$colorTransparent);
		// Die Fьllfarbe als transparent deklarieren
		imagecolortransparent($bild_neu, $colorTransparent);
		imagecopyresampled($bild_neu, $img, 0,0,0,0, $new_width, $new_height, $orig_width, $orig_height);
		imagepng($bild_neu, $this->destination . $file_end);
		imagedestroy($bild_neu);		  
	  }
	  
	  // устанавливаем права доступа
	  chmod($this->destination . $file_end, $this->permissions);
	  

        $messageStack->add('uploads', ' Файл ' . $this->filename .' успешно загружен. <br />', 'success');
        return true;
      } else {
        $messageStack->add('uploads', 'Ошибка: Файл ' . $this->filename .'  не был загружен. <br />', 'error');
        return false;
      }
    }

    function set_file($file) {
      $this->file = $file;
    }

    function set_destination($destination) {
      $this->destination = $destination;
    }

    function set_permissions($permissions) {
      $this->permissions = octdec($permissions);
    }

    function set_filename($filename) {
      $this->filename = $filename;
    }

    function set_tmp_filename($filename) {
      $this->tmp_filename = $filename;
    }

    function set_extensions($extensions) {
      if (vam_not_null($extensions)) {
        if (is_array($extensions)) {
          $this->extensions = $extensions;
        } else {
          $this->extensions = array($extensions);
        }
      } else {
        $this->extensions = array();
      }
    }
	
	function set_prefix($prefix) {
	$this->prefix = $prefix;
	}

    function check_destination() {
      global $messageStack;

      if (!is_writeable($this->destination)) {
        if (is_dir($this->destination)) {
          $messageStack->add('uploads', sprintf('Ошибка: Каталог защищён от записи, установите необходимые права доступа.', $this->destination), 'error');
        } else {
          $messageStack->add('uploads', sprintf('Ошибка: Каталог не существует!', $this->destination), 'error');
        }

        return false;
      } else {
        return true;
      }
    }

  }
?>