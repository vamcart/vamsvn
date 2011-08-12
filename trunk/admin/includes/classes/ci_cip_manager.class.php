<?php
/*
  ci_cip_manager.class.php
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2003 osCommerce
  Released under the GNU General Public License
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class cip_manager {
    var $file_writeable;
    var $current_path;
    var $ci_cip;
    var $cip;//From $_GET
    var $upload_directory_writeable;
    var $script_name;
    var $action;

    function cip_manager($current_path='') {
        $this->current_path=$current_path;
        if (isset($_REQUEST['cip']))    $this->cip=$_REQUEST['cip'];
        if (isset($_REQUEST['action']))    $this->action=$_REQUEST['action'];
        if (isset($_REQUEST['contrib_dir']))    $this->contrib_dir=$_REQUEST['contrib_dir'];

        $this->ci_cip=CONTRIB_INSTALLER_NAME."_".CONTRIB_INSTALLER_VERSION;
        $this->script_name=basename($_SERVER['PHP_SELF']);
    }

    //=========================================================
    //Methods
    //=========================================================

    function contrib_dir() {return $this->contrib_dir;}
    function file_writeable() {return $this->file_writeable;}
    function current_path() {return $this->current_path;}
    function script_name() {return $this->script_name;}
    function ci_cip() {return $this->ci_cip;}
    function cip() {return $this->cip;}
    function action() {return $this->action;}
    function upload_directory_writeable() {return $this->upload_directory_writeable;}

    function is_cip_in_zip() {
        if (!isset($this->cip_in_zip))     $this->cip_in_zip=((substr($this->cip, -4)=='.zip') ? true : false);
        return $this->cip_in_zip;
    }


    //============================================================
    //  list

    function folder_contents() {
        global $fInfo;
        if (!$this->current_path)    return;
        $dir=dir($this->current_path);
        if (!is_object($dir))    return;

        while ($file = $dir->read()) {
            if (!is_dir($this->current_path.'/'.$file)) {
                $path_parts = pathinfo($file);
                if ($path_parts['extension']=='zip') {
                  $file_size=filesize($this->current_path.'/'.$file);
                  $one=array('name' => $file, 'size' => $file_size);
                  $contents[]=$one;
                }
                if (isset($this->cip) && $this->cip==$file)     $fInfo = new objectInfo($one);
                elseif (!isset($fInfo) )     $fInfo = new objectInfo($one);
            }
        }
        return $contents;
    }




    function draw_cip_list() {
        global $fInfo, $contents, $cip;
        for ($i=0, $n=sizeof($contents); $i<$n; $i++) {

            if ($contents[$i]['name'] == '..') {
               $goto_link=substr($this->current_path, 0, strrpos($this->current_path, '/'));
            } else     $goto_link=$this->current_path.'/'.$contents[$i]['name'];

            if (isset($fInfo) && is_object($fInfo) && ($contents[$i]['name'] == $fInfo->name)) {
                $output.='<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'">';
                $onclick_link = (($fInfo->is_dir) ?
                        'goto='.$goto_link : 'cip='.urlencode($fInfo->name) /*.'&action=edit'*/);
            } else {
                $output.='<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'">'; 
                $onclick_link = 'cip='.urlencode($contents[$i]['name']);
                //$contents[$i]['name'] ==$fInfo->name...
            }
            //===============================================
            //Set  link
            $cip= new CIP($contents[$i]['name']);
            $link = vam_href_link($this->script_name(), 'action=cip&filename=' . urlencode($contents[$i]['name']));

//Draw line:


//=====================================================
//Action begin:
            $cip_buttons=array();
            $output.='<td class="dataTableContentCIP" align="center">';
            //Install Buttons for ZIP
            if (!$cip->is_installed() or ALWAYS_DISPLAY_INSTALL_BUTTON=='true') {
                //install
//                $output.= vam_image(DIR_WS_ADMIN_ICONS . 'empty.gif', ICON_EMPTY).'&nbsp;';
                $output.= '<a href="'.vam_href_link($this->script_name(), 'cip='.urlencode($contents[$i]['name']) . '&action=install').'">'.vam_image(DIR_WS_ADMIN_ICONS . 'remove.gif', ICON_INSTALL).'</a>&nbsp;';
            }
            //Remove Buttons for ZIP
            if ($cip->is_installed() or ALWAYS_DISPLAY_REMOVE_BUTTON=='true') {
                //Remove without data removing
//                $output.= '<a href="'.vam_href_link($this->script_name(), 'cip='.urlencode($contents[$i]['name']).'&action=remove').'">'.vam_image(DIR_WS_ADMIN_ICONS . 'remove_wo_data.gif', ICON_REMOVE.' '.ICON_WITHOUT_DATA_REMOVING).'</a>&nbsp;';

                $output.= '<a href="'.vam_href_link($this->script_name(), 'cip='.urlencode($contents[$i]['name']).'&action=remove&remove_data=1').'">'.vam_image(DIR_WS_ADMIN_ICONS . 'install.gif', ICON_REMOVE).'</a>&nbsp;';
            }
            //UNPACK Button
            if (SHOW_PACK_BUTTONS=='true') {
              $output.= '<a href="'.vam_href_link($this->script_name(), 'cip='. urlencode($contents[$i]['name']) .'&action=unpack').'">'.vam_image(DIR_WS_ADMIN_ICONS.'unpack.gif', ICON_UNZIP).'</a>&nbsp;';
            }

            //$cip_buttons[vam_image(DIR_WS_ADMIN_ICONS.'cip_delete.gif', ICON_DELETE)]= vam_href_link($this->script_name(), 'cip=' . urlencode($contents[$i]['name']).'&action=delete');

//Action end:
//====================================================
//Name:
            $output.='<td class="dataTableContentCIP" valign="bottom"
            onclick="document.location.href=\''.vam_href_link($this->script_name(), $onclick_link).'\'">';
            if (is_object($cip)) {
                if ($cip->is_installed())     $output.='<abbr title="'.CIP_STATUS_INSTALLED_ALT.'"><b>'.$contents[$i]['name'].'</b></abbr>';
                else    $output.='<abbr title="'.CIP_STATUS_REMOVED_ALT.'">'.$contents[$i]['name'].'</abbr>';
            } else    $output.=$contents[$i]['name'];
            $output.='</td>'."\n";
//====================================================
                if ($this->current_path==DIR_FS_CIP && SHOW_SIZE_COLUMN=='true') {
                  //Size
                  $output.='<td class="dataTableContentCIP" align="right" onclick="document.location.href=\''.
                        vam_href_link($this->script_name(), $onclick_link).'\'">'.
                        ($contents[$i]['is_dir'] ? '&nbsp;' :
                        (number_format($contents[$i]['size']/1024, 1, ',', ' ') )).'</td>'."\n";
                }
//Play and Info Buttons
            $output.='<td class="dataTableContentCIP" align="center" width="15%" onclick="document.location.href=\''.
                    vam_href_link($this->script_name(), $onclick_link).'\'">';
            if (isset($fInfo) && is_object($fInfo) && ($fInfo->name == $contents[$i]['name'])
                && $contents[$i]['name'] != '..')
            {
                $output.=vam_image(DIR_WS_ADMIN_ICONS.'play.gif');
            } elseif ($contents[$i]['name']!= '..') {
                $output.='<a href="'.vam_href_link($this->script_name(), 'cip='.
                                urlencode($contents[$i]['name'])).'">'.vam_image(DIR_WS_ADMIN_ICONS. 'info.gif', IMAGE_ICON_INFO).'</a>';
            }
            //Delete Button
            $output.= '<a href="'.vam_href_link($this->script_name(), 'cip=' . urlencode($contents[$i]['name']). '&action=deleteconfirm'). '"  onclick="return confirmSubmit()">'.vam_image(DIR_WS_ADMIN_ICONS . 'cip_delete.gif', ICON_DELETE).'</a>';
            $output.='</td>'."\n";
//Play and Info Buttons end
            $output.='</tr>';
        }
        return $output;
    }//function end




    function draw_info() {
        global $fInfo, $message, $cip;
        $heading = array();
        $contents = array();

        switch ($this->action) {
        case 'upload':
            $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_UPLOAD . '</b>');
            $contents = array('form' => vam_draw_form('file', $this->script_name(), 'action=processuploads', 'post', 'enctype="multipart/form-data"'));
            $contents[] = array('text' => TEXT_UPLOAD_INTRO);
            $contents[]=array('text'=>TEXT_UPLOAD_LIMITS);
            $file_upload = '';
            for ($i=1; $i<11; $i++) {
              $file_upload .= $i. (($i>9) ? '&nbsp;' : '&nbsp;&nbsp;&nbsp;'). vam_draw_input_field('cip_'.$i, '', 'size="50"', false, 'file'). '<br>';
            }
            $contents[] = array('text' => '<br>' . $file_upload);
            $contents[] = array('align' =>'left',
                  'text'=>'<br>'.(($this->upload_directory_writeable()) ? '<span class="button"><button type="submit" value="&nbsp;' . BUTTON_UPLOAD .'&nbsp;">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_UPLOAD .'</button></span>' : '') . '&nbsp;<a class="button" href="' . vam_href_link($this->script_name(), (isset($this->cip) ? 'cip=' . urlencode($this->cip) : '')) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a><br /><br />');
            break;

        default:
            //This is 'info':
            if (isset($fInfo) && is_object($fInfo)) {
                $heading[] = array('text' => '<b>' . $fInfo->name . '</b>');
                //  Prints a contrib info:
                $cip= new CIP($fInfo->name);
                $cip->read_xml();

                if($cip->get_count_php_tags()) {
                    $message->add(CIP_USES.' &#060;<b>php</b>&#062 ('.$cip->get_count_php_tags().')!', 'notice');
                }

                //Print description:
                $description=$cip->get_data($cip->get_description_id());
                if ($description) {
                    $array=$this->cip_description($description->data);
                    foreach ($array as $value)     $contents[]=$value;
                } else $contents[]=array('text'=>'<font style="color:red;">'.CONFIG_FILENAME. TEXT_DOESNT_EXISTS.'!!!</font>');
            }
        }
        //Prints an error message at the right column
//        if ($message->size>0)    array_unshift($contents, array('text' => $message->output()."<br>"));

        //Prints an error message at the right column
        //if (!$heading)    $heading[]=array('text' => '<b>Error</b>');
        if ( (vam_not_null($heading)) or (vam_not_null($contents)) ) {
            $box = new box;
            return '<td width="30%" valign="top">' . "\n". $box->infoBox($heading, $contents).'</td>' . "\n";
        }

    }


    //========================================================
    //========================================================
    //========================================================
    function check_action() {
        if (!$this->action)    return;
        if ($this->action=='pack')    $this->pack();
        if ($this->action=='unpack')    $this->unpack();
        if ($this->action=='install')  $this->install();
        if ($this->action=='remove')     $this->remove();
        if ($this->action=='deleteconfirm')    $this->deleteconfirm();
        if ($this->action=='processuploads')    $this->processuploads();
        if ($this->action=='upload')    $this->check_upload();
    }



    function pack() {
        if (strstr($this->cip, '..'))    return;
        $cip= new CIP($this->cip);
        $cip->pack_cip();
    }



    function unpack() {
        if (strstr($this->cip, '..'))    return;
        $cip= new CIP(urldecode($this->cip));
        if (!$cip->is_unpacked())    $cip->unpack_cip();
    }



    function install() {
        global $message, $cip;
        if (strstr($this->cip, '..'))    return;
        $cip= new CIP($this->cip);
        $cip->install();
        if ($cip->get_error())    return;
        $message->add(MSG_WAS_INSTALLED, 'installed');
        //Show post install message:
        if ($cip->post_install_notes()) {
          $message->add('<b>'.TEXT_POST_INSTALL_NOTES.':</b><br />'.$cip->post_install_notes(), 'warning');
        }
        $cips = $this->getDependedCips($cip);
        if (is_array($cips) and count($cips)>0 ){
          foreach($cips as $cp){
            $cp->compute_dependencies();
            if ($cp->get_error())    return;
                $message->add("CIP ".$cp->getIdent().MSG_WAS_APPLIED, 'installed');
                $message->add('<b>'.TEXT_POST_INSTALL_NOTES.':</b><br />'.$cp->post_install_notes(), 'warning');
          }
        }

        // We should reload page.
        // We will reload all CIP's data and
        // we will not see in Admin Area's menu constants names instead of their values.
        $this->reload_page('cip='.$this->cip);
    }

    function remove() {
        global $message, $cip;
        if (strstr($this->cip, '..'))    return;
        $cip= new CIP($this->cip);
        $cip->remove();
        if ($cip->get_error())    return;
        $message->add(MSG_WAS_REMOVED, 'removed');
        $cips = $this->getDependedCips($cip);
        if (is_array($cips) and count($cips)>0 ){
          foreach($cips as $cp){
            $cp->compute_dependencies();
            if ($cp->get_error())    return;
                $message->add("CIP ".$cp->getIdent().MSG_WAS_APPLIED, 'installed');
          }
        }
        $this->reload_page('cip='.$this->cip);
    }



    function deleteconfirm() {
        global  $message, $cip;
        if (strstr($this->cip, '..'))    return;
        $cip= new CIP($this->cip);
        $cip->unregister;
	ci_remove($this->current_path.'/'.$this->cip);
//        if (is_dir($this->current_path.'/'.$this->cip)) {
//            $message->add(ci_remove($this->current_path.'/'.$this->cip));
//        } else {
//            $message->add("Couldn't remove ".$this->current_path.'/'.$this->cip);
//        }
    }



    function processuploads() {
        global $cip, $message;
        for ($i=1; $i<11; $i++) {
            if ($_FILES['cip_' . $i][error] == 0) {
                if (new upload_cip('cip_'.$i, $this->current_path, '777', array('zip'))) {
                    //Check if archive has install.xml and is it well formed xml file.
                    $cip= new CIP(urldecode($_FILES['cip_' . $i]['name']));
                    $cip->read_xml();
                }
            }
        }
    }


    function check_upload() {
        global $message;
        $this->upload_directory_writeable=true;
        if (!is_writeable($this->current_path)) {
            $this->upload_directory_writeable = false;
            $this->error(sprintf(ERROR_DIRECTORY_NOT_WRITEABLE, $this->current_path));
        }
    }

    //========================================================
    //========================================================
    //========================================================
    //========================================================
















    function is_ci_installed() {
        if ($this->error)     return false;
        //Check if self-install was made:
        $query = vam_db_query("SELECT * FROM ".TABLE_CONFIGURATION." WHERE configuration_key='DIR_FS_CIP'");
        if (vam_db_num_rows($query)==0
            or !file_exists(DIR_FS_CIP.'/'.$this->ci_cip. '/'.CONFIG_FILENAME)
            or !is_dir(DIR_FS_CIP)
            or !is_dir(DIR_FS_CIP.'/'.$this->ci_cip)
            )    return false;
        else return true;
    }



    function cip_description($data='') {
        if (!$data)    return $contents;
        $contents[] = array('text' =>'<h3>'.TEXT_INFO_SUPPORT.':</h3>');
        foreach ($data as $key=>$value) {
            $value=htmlspecialchars($value);//convert to entries...
            if ($key=='contrib_ref') {
                if ($value) {
                $contents[]=array('text'=>'<b>&#8226;&nbsp;<a href="'. (!defined(TEXT_LINK_CONTR) ? TEXT_LINK_CONTR : 'http://vamshop.ru?'). $value.'" title= "'. CONTRIBS_PAGE_ALT . '">' . CONTRIBS_PAGE .'</a></b>');
                }
            } elseif ($key=='forum_ref') {
                if ($value) {
                $contents[]=array('text'=>'<b>&#8226;&nbsp;<a href="'. (!defined(TEXT_LINK_FORUM) ? TEXT_LINK_FORUM : 'http://vamshop.ru?').$value. '" title="'. CONTRIBS_FORUM_ALT. '">'. CONTRIBS_FORUM.'</a></b>');
                }
                $contents[] = array('text' => '<hr><h3>'.TEXT_INFO_CONTRIB.':</h3>');
            } else $contents[]=array('text'=>'<b>'.$key.'</b>: '.nl2br($value));
        }
        return $contents;
    }


    function reload_page($param='') {
        global $message;
        $errors=$message->get_errors();
        foreach ($errors as $error)     $message->add_session($error['text'], $error['type']);
        vam_redirect(vam_href_link(basename($_SERVER['PHP_SELF']),
                                '&selected_box=contrib_installer'.($param ? '&'.$param : '')));
    }

    function error($text='') {
        global $message;
        $this->error=$message->add($text);
    }

    function getDependedCips($cip){
        if($cip->is_ci()) return null;
        $cips = array();
        $query = "select * from ".TABLE_CIP_DEPEND." where cip_ident_req='".$cip->getIdent()."' and cip_req_type=2";
        $rq = vam_db_query($query);
        while($rs=vam_db_fetch_array($rq)){
          $query = "select * from ".TABLE_CIP." where cip_ident='".$rs['cip_ident']."' and cip_installed=1";
          $rq1 = vam_db_query($query);
          if($rs1=vam_db_fetch_array($rq1)){
            if(file_exists(DIR_FS_CIP.'/'.$rs1['cip_folder_name'].".zip")){
                    $cips[] = new CIP($rs1['cip_folder_name'].".zip");
            }else if(is_dir(DIR_FS_CIP.'/'.$rs1['cip_folder_name'])){
                    $cips[] = new CIP($rs1['cip_folder_name']);
            }
          }
        }
        return $cips;
    }
}//class end
?>