<?php
/*
  ci_cip_manager.class.php
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2003 osCommerce
  Released under the GNU General Public License
*/

defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

class cip_manager {
    var $file_writeable;
    var $current_path;
    var $cip_net_ua;
    var $goto_array;
    var $ci_cip;
    var $cip;//From $_GET
    var $upload_directory_writeable;
    var $script_name;
    var $action;
    var $is_admin; //user is admin true/false
    var $logged_in;//user logged in true/false

    function cip_manager($current_path='') {
        global $phpbb_user;
        $this->current_path=$current_path;
        if (isset($_REQUEST['cip']))    $this->cip=$_REQUEST['cip'];
        if (isset($_REQUEST['action']))    $this->action=$_REQUEST['action'];
        if (isset($_REQUEST['contrib_dir']))    $this->contrib_dir=$_REQUEST['contrib_dir'];

        $this->ci_cip=CONTRIB_INSTALLER_NAME."_".CONTRIB_INSTALLER_VERSION;
        $this->script_name=basename($_SERVER['PHP_SELF']);

        //If this script is running on cip.net.ua server we must disallow some functions:
        if ($_SERVER['SERVER_ADDR']=='64.21.37.199'
                or strpos($_SERVER['PHP_SELF'], 'cip.net.ua'))     $this->cip_net_ua=true;
        else $this->cip_net_ua=false;

        if (is_object($phpbb_user) && $phpbb_user->forum_exists()) {
            if ($phpbb_user->get_user_level()==1)     $this->is_admin=true;
            else     $this->is_admin=false;
            $this->logged_in=$phpbb_user->get_session_logged_in();

            //$this->logged_in()
        }
    }

    //=========================================================
    //Methods
    //=========================================================

    function cip_net_ua() {return $this->cip_net_ua;}
    function contrib_dir() {return $this->contrib_dir;}
    function file_writeable() {return $this->file_writeable;}
    function current_path() {return $this->current_path;}
    function script_name() {return $this->script_name;}
    function ci_cip() {return $this->ci_cip;}
    function cip() {return $this->cip;}
    function action() {return $this->action;}
    function upload_directory_writeable() {return $this->upload_directory_writeable;}
    function is_admin() {return $this->is_admin;}
    function logged_in() {return $this->logged_in;}

    function is_cip_in_zip() {
        if (!isset($this->cip_in_zip))     $this->cip_in_zip=((substr($this->cip, -4)=='.zip') ? true : false);
        return $this->cip_in_zip;
    }


    //============================================================
    //  list

    function folder_contents() {
        global $fInfo;
        if (!$this->current_path)    return;
        $showuser = (function_exists('posix_getpwuid') ? true : false);
        $dir=dir($this->current_path);
        if (!is_object($dir))    return;
        while ($file = $dir->read()) {
            if ($file!='.' && (($file!='..') || ($this->current_path!=DIR_FS_CIP))) {
                $file_size=filesize($this->current_path.'/'.$file);

                if (!$this->cip_net_ua() || $this->is_admin()) {
                    $permissions = xtc_get_file_permissions(fileperms($this->current_path.'/'.$file));
                    if ($showuser) {
                        $user = @posix_getpwuid(fileowner($this->current_path . '/' . $file));
                        $group = @posix_getgrgid(filegroup($this->current_path . '/' . $file));
                    } else     $user = $group = array();
                }
                $path_parts = pathinfo($file);
                $one=array(
                            'name' => $file,
                            'ext'=>$path_parts['extension'],
                            'is_dir' => is_dir($this->current_path . '/' . $file),
                            'last_modified'=>filemtime($this->current_path.'/'.$file),
                            'size' => $file_size,
                            'permissions' => $permissions,
                            'user' => $user['name'],
                            'group' => $group['name']);

                $contents[] =$one;

                //if ($this->action=='upload' or !isset($this->cip) && !isset($fInfo) )     $fInfo = new objectInfo($one);
                if (isset($this->cip) && $this->cip== $one['name'])     $fInfo = new objectInfo($one);
                elseif (!isset($fInfo) )     $fInfo = new objectInfo($one);
            }
        }
        return $contents;
    }




    function draw_cip_list() {
        global $fInfo, $contents, $cip;
        for ($i=0, $n=sizeof($contents); $i<$n; $i++) {

            if ($contents[$i]['name'] == '..')     $goto_link=substr($this->current_path, 0, strrpos($this->current_path, '/'));
            else     $goto_link=$this->current_path.'/'.$contents[$i]['name'];

            //<TR>
            $output.='<tr';
            if (isset($fInfo) && is_object($fInfo) && ($contents[$i]['name'] == $fInfo->name)) {
                $output.=' id="defaultSelected" class="dataTableRowSelected"';
                $onclick_link = (($fInfo->is_dir) ?
                        'goto='.$goto_link : 'cip='.urlencode($fInfo->name) /*.'&action=edit'*/);
            } else {
                $output.=' class="dataTableRow"';
                $onclick_link = 'cip='.urlencode($contents[$i]['name']);
                //$contents[$i]['name'] ==$fInfo->name...
            }
            $output.=' onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">'."\n";


            //===============================================
            //Set icon and link
            if ($contents[$i]['is_dir']) {
                if ($contents[$i]['name'] == '..') {
                    $icon = xtc_image(DIR_WS_ADMIN_ICONS . 'folder_cip.gif', ICON_PREVIOUS_LEVEL);
                } elseif (($fInfo->is_dir && $this->current_path==DIR_FS_CIP) || $fInfo->name==CONFIG_FILENAME || $fInfo->ext=='zip')
                {


                    $cip = new CIP($contents[$i]['name']);
                    if (!$cip->does_have_install_xml())    unset($cip);
                    if ($this->is_ci_installed() && is_object($cip) && $cip->is_installed()) {
                        //Orange folder icon
                        $icon='<div style="float:left;">'.((isset($fInfo) && is_object($fInfo)
                                    && ($contents[$i]['name'] == $fInfo->name)) ?
                                    xtc_image(DIR_WS_ADMIN_ICONS.'folder_installed_open.gif', ICON_INSTALLED_CURRENT_FOLDER) :
                                    xtc_image(DIR_WS_ADMIN_ICONS.'folder_installed.gif', ICON_INSTALLED_FOLDER)).'</div>';
                    } else {
                        //Blue folder icon
                        $icon='<div style="float:left;">'.(isset($fInfo) && is_object($fInfo)
                                    && ($contents[$i]['name'] == $fInfo->name) ?
                                    xtc_image(DIR_WS_ADMIN_ICONS.'folder_open.gif', ICON_CURRENT_FOLDER) :
                                    xtc_image(DIR_WS_ADMIN_ICONS.'folder.gif', ICON_FOLDER)).'</div>';

                    }
                }
                $link = xtc_href_link($this->script_name(), 'goto=' . $goto_link);
            } else {
                //Not DIR
                switch($contents[$i]['ext']) {
                    case 'zip':
                        $file_icon='zip.gif';
                        $cip= new CIP($contents[$i]['name']);
                        break;
                    case 'xml': $file_icon='install.xml.gif'; break;
                    case 'jpg':
                    case 'gif':
                    case 'png': $file_icon='file_img.gif'; break;
                    default: $file_icon='file.gif'; break;
                }

                $icon='<div style="float:left;">'.xtc_image(DIR_WS_ADMIN_ICONS.$file_icon).'</div>';
                $link = xtc_href_link($this->script_name(), 'action=cip&filename=' . urlencode($contents[$i]['name']));
            }

            //Draw line:
            //=====================================================
            //Name +Icons:
            $output.='<td class="dataTableContent" valign="bottom"
            onclick="document.location.href=\''.
                    xtc_href_link($this->script_name(), $onclick_link).'\'"><a
                    href="'.$link.'">'.$icon.'&nbsp;</a>';
            if (is_object($cip)) {
                if ($cip->is_installed())     $output.='<abbr title="' . CIP_MANAGER_INSTALLED . '"><b>'.$contents[$i]['name'].'</b></abbr>';
                else    $output.='<abbr title="' . CIP_MANAGER_NOT_INSTALLED .'">'.$contents[$i]['name'].'</abbr>';
            } else    $output.=$contents[$i]['name'];
            $output.='</td>'."\n";
            //=====================================================
            //Downloads:
            if ($this->cip_net_ua()) {
                $output.='<td class="dataTableContent" align="center" onclick="document.location.href=\''.
                    xtc_href_link($this->script_name(), $onclick_link).'\'">';
                if ($contents[$i]['name']!= '..' and !$contents[$i]['is_dir']) {
                    if ($contents[$i]['ext']=='zip')     $downloads=$cip->get_downloads_counter();
                    $output.=(($downloads) ? $downloads : "-");
                }
                $output.='</td>'."\n";
             }
//=====================================================
//Action begin:
            $output.='<td class="dataTableContent" align="right">';
            $cip_buttons=array();
            if (!$contents[$i]['is_dir']) {
//DOWNLOAD Button
//                $cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS.'download.gif', ICON_FILE_DOWNLOAD)]=
//                    xtc_href_link($this->script_name(), 'action=download&filename='.
//                    urlencode($contents[$i]['name']));
//EDIT Button
                if (!$this->cip_net_ua() || $this->is_admin()) {
                    if($contents[$i]['ext']!='zip') {
                        $cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS . 'edit.gif', ICON_EDIT)]=
                            xtc_href_link($this->script_name(), 'cip='.
                            urlencode($contents[$i]['name']).'&action=edit');
                    } else {
                        if (!$this->cip_net_ua() || $this->is_admin()) {
//Install Buttons for ZIP
                            if (!$cip->is_installed() or ALWAYS_DISPLAY_INSTALL_BUTTON=='true') {
                                //install
								$cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS . 'empty.gif', ICON_EMPTY)] = "";
								$cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS . 'remove.gif', ICON_INSTALL)] = xtc_href_link($this->script_name(), 'cip=' . urlencode($contents[$i]['name']) . '&action=install');
                            }
//Remove Buttons for ZIP
                            if ($cip->is_installed() or ALWAYS_DISPLAY_REMOVE_BUTTON=='true') {
                                //Remove without data removing
                                $cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS . 'remove_wo_data.gif', ICON_REMOVE.' '.ICON_WITHOUT_DATA_REMOVING)]= xtc_href_link($this->script_name(), 'cip='.urlencode($contents[$i]['name']).'&action=remove');
                                $cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS . 'install.gif', ICON_REMOVE)]=
                                xtc_href_link($this->script_name(), 'cip='.urlencode($contents[$i]['name']).'&action=remove&remove_data=1');
                            }
//UNPACK Button
//                        $cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS.'unpack.gif', ICON_UNZIP)]=
//                            xtc_href_link($this->script_name(), 'cip=' . urlencode($contents[$i]['name']) . '&action=unpack');
                        }
                    }
                }
            } elseif ($contents[$i]['name']!= '..' && $this->current_path==DIR_FS_CIP) {

                if (is_object($cip) && (!$this->cip_net_ua() || $this->is_admin())) {
//Install Buttons for Folders
                    if (!$cip->is_installed() or ALWAYS_DISPLAY_INSTALL_BUTTON=='true') {
						$cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS . 'empty.gif', ICON_EMPTY)] = "";
						$cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS . 'remove.gif', ICON_INSTALL)] = xtc_href_link($this->script_name(), 'cip=' . urlencode($contents[$i]['name']) . '&action=install');
                    }
//Remove Buttons for Folders
                    if ($cip->is_installed() or ALWAYS_DISPLAY_REMOVE_BUTTON=='true') {
                        //Remove without data removing
                        $cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS . 'remove_wo_data.gif', ICON_REMOVE.' without data removing')]= xtc_href_link($this->script_name(), 'cip='.urlencode($contents[$i]['name']).'&action=remove');
                        $cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS . 'install.gif', ICON_REMOVE)]=
                            xtc_href_link($this->script_name(), 'cip='.urlencode($contents[$i]['name']).'&action=remove&remove_data=1');
                    }
//Pack Button
//                    $cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS . 'pack.gif', ICON_ZIP)]=
//                        xtc_href_link($this->script_name(), 'cip='.urlencode($contents[$i]['name']).'&action=pack');
                }
            }
//Delete Button
            if (!$this->cip_net_ua() || $this->is_admin()) {
                if ($contents[$i]['name']!= '..' and $this->current_path==DIR_FS_CIP
                    or ($this->current_path !=DIR_FS_CIP and !$contents[$i]['is_dir']))
                {
                    $cip_buttons[xtc_image(DIR_WS_ADMIN_ICONS . 'cip_delete.gif', ICON_DELETE_MODULE)]=
                        xtc_href_link($this->script_name(), 'cip=' . urlencode($contents[$i]['name']).'&action=delete');
                }
            }

			foreach ($cip_buttons as $img => $link) {
				if ($link != "") {
					$btns .= '<a href="' . $link . '">' . $img . '</a>&nbsp;';
				} else {
					$btns .= $img . '&nbsp;';
				}
			}
            $output.=substr($btns, 0, -6).'</td>';
            unset($btns);
            //Action end:
            //====================================================
                if ($this->current_path==DIR_FS_CIP &&
                    (SHOW_SIZE_COLUMN=='true' || $this->is_admin()))
                {
                //Size
                $output.='<td class="dataTableContent" align="right" onclick="document.location.href=\''.
                        xtc_href_link($this->script_name(), $onclick_link).'\'">'.
                        ($contents[$i]['is_dir'] ? '&nbsp;' :
                        (number_format($contents[$i]['size']/1024, 1, ',', ' ') )).'</td>'."\n";
                }
//Uploader's Profile begin
                if ($this->current_path==DIR_FS_CIP &&
                    (SHOW_UPLOADER_COLUMN=='true' || $this->is_admin()))
                {
                    $output.='<td class="dataTableContent">&nbsp;';
                    if (is_object($cip) && $cip->get_uploader_id()) {
                        $output.='<b><a href="'.HTTP_SERVER.
                            '/forum/profile.php?mode=viewprofile&u='.$cip->get_uploader_id().'"
                            title="View Uploader\'s Profile">'.$this->get_username($cip->get_uploader_id()).'</a></b>';
                    }
                    $output.='</td>'."\n";
                }
//Uploaded
                if ($this->current_path==DIR_FS_CIP && SHOW_UPLOADED_COLUMN=='true') {
                    $output.='<td class="dataTableContent" onclick="document.location.href=\''.
                        xtc_href_link($this->script_name(), $onclick_link).'\'">&nbsp; '.
                        //25.12.2006 = m.d.Y
                        date("m.d.Y", $contents[$i]['last_modified']) .'</td>'."\n";
                }
//Permissions Column
                if (SHOW_PERMISSIONS_COLUMN=='true' || $this->is_admin()) {
                    $output.='<td class="dataTableContent" align="center" onclick="document.location.href=\''. xtc_href_link($this->script_name(), $onclick_link).'\'">'. $contents[$i]['permissions'].'</td>'."\n";
                    }
//User/Group Column
                if (SHOW_USER_GROUP_COLUMN=='true'|| $this->is_admin()) {
                    $output.='<td class="dataTableContent" onclick="document.location.href=\''. xtc_href_link($this->script_name(), $onclick_link).'\'">'.($contents[$i]['user'] ? $contents[$i]['user'] : '-').' / '. ($contents[$i]['group'] ? $contents[$i]['group'] : '-').'</td>'."\n";
                }
//Play and Info Buttons
            $output.='<td class="dataTableContent" align="right" onclick="document.location.href=\''.
                    xtc_href_link($this->script_name(), $onclick_link).'\'">';
            if (isset($fInfo) && is_object($fInfo) && ($fInfo->name == $contents[$i]['name'])
                && $contents[$i]['name'] != '..')
            {
                $output.=xtc_image(DIR_WS_ADMIN_ICONS.'play.gif');
            } elseif ($contents[$i]['name']!= '..') {
                $output.='<a href="'.xtc_href_link($this->script_name(), 'cip='.
                                urlencode($contents[$i]['name'])).'">'.xtc_image(DIR_WS_ADMIN_ICONS. 'info.gif', IMAGE_ICON_INFO).'</a>';
            }
            $output.='</td>'."\n";
//Play and Info Buttons end
            $output.='</tr>';
        }
        return $output;
    }//function end




    function draw_info() {
        global $fInfo, $phpbb_user, $message, $cip;
        $heading = array();
        $contents = array();

        switch ($this->action) {
        case 'delete':
            $heading[] = array('text' => '<b>' . $fInfo->name . '</b>');

            $contents = array('form' => xtc_draw_form('file', $this->script_name(), 'cip=' . urlencode($fInfo->name) . '&action=deleteconfirm'));
            $contents[] = array('text' => TEXT_DELETE_INTRO);
            $contents[] = array('text' => '<br><b>' . $fInfo->name . '</b>');
            $contents[] = array('align' => 'center', 'text' => '<br><input type="submit" class="button" value="' . BUTTON_DELETE .'">&nbsp;<a class="button" href="' . xtc_href_link($this->script_name(), (xtc_not_null($fInfo->name) ? 'cip=' . urlencode($fInfo->name) : '')) . '">' . BUTTON_CANCEL . '</a>');
            break;
        case 'upload':
            if(!$this->cip_net_ua() or $this->logged_in()) {
                $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_UPLOAD . '</b>');

                $contents = array('form' => xtc_draw_form('file', $this->script_name(), 'action=processuploads', 'post', 'enctype="multipart/form-data"'));
                $contents[] = array('text' => TEXT_UPLOAD_INTRO);
                $contents[]=array('text'=> CIP_MANAGER_UPLOAD_NOTE);

                $file_upload = '';
                for ($i=1; $i<11; $i++) $file_upload .= $i. (($i>9) ? '&nbsp;' :  '&nbsp;&nbsp;&nbsp;').xtc_draw_file_field('file_' . $i) . '<br>';

                $contents[] = array('text' => '<br>' . $file_upload);
                $contents[] = array('align' =>'left', 'text'=>'<br>'.(($this->upload_directory_writeable()) ? '<input type="submit" class="button" value="' . BUTTON_UPLOAD .'">' : '') . '&nbsp;<a class="button" href="' .
                                        xtc_href_link($this->script_name(), (isset($this->cip) ? 'cip=' . urlencode($this->cip) : '')) . '">' .
                                        BUTTON_CANCEL . '</a>');

                break;
            }
        default:
            //This is 'info':
            if (isset($fInfo) && is_object($fInfo)) {
                $heading[] = array('text' => '<b>' . $fInfo->name . '</b>');
                //if (!$fInfo->is_dir) $contents[] = array('align' => 'center', 'text' => '<a href="' . xtc_href_link($this->script_name(), 'info=' . urlencode($fInfo->name) . '&action=edit') . '">' . xtc_image_button('button_edit.gif', IMAGE_EDIT) . '</a>');
                //=================//
                //  Print a contrib info:    //
                //=================//
                if (($fInfo->is_dir && $this->current_path==DIR_FS_CIP)|| $fInfo->name==CONFIG_FILENAME || $fInfo->ext=='zip') {
                    $cip= new CIP( (($fInfo->is_dir or $fInfo->ext=='zip') ? $fInfo->name : basename($this->current_path)));
                    $cip->read_xml();


                    if($cip->get_count_php_tags()) {
                        $message->add('CIP uses &#060;<b>php</b>&#062; ! <b>Please,'. ($cip->is_cip_in_zip() ? ' unpack and' : '') .' check '.CONFIG_FILENAME.'</b>: '. $cip->get_count_php_tags(), 'notice');
                         //echo '<pre>'.htmlspecialchars($tag->write_to_xml())."</pre><br>";

                    }

                    //Print description:
                    $description=$cip->get_data($cip->get_description_id());
                    if ($description) {
                        if (is_object($phpbb_user)) {
                            $topic_id=$phpbb_user->get_topic_id($cip->get_cip_name());
                        }
                        $array=$this->cip_description($description->data, ($phpbb_user->forum_exists() ? $cip->get_uploader_id() : ''), $topic_id);
                        foreach ($array as $value)     $contents[]=$value;
                    } else $contents[]=array('text'=>'<font style="color:red;">'.CONFIG_FILENAME. '' .CIP_MANAGER_XML_NOT_FOUND . '</font>');
                }


                //=============
                //General Info
                //=============

                $contents[] = array('text' =>(count($contents)>0 ? '<hr>': '').'<h3>' . CIP_MANAGER_GENERAL_INFO . '</h3>');
                $contents[] = array('text' =>'<b>'.TEXT_FILE_NAME.'</b> '.$fInfo->name);
                if (!$fInfo->is_dir)    $contents[] = array('text' =>'<b>'.TEXT_FILE_SIZE.' </b>'.number_format($fInfo->size).' bytes');
                $contents[] = array('text' =>'<b>'.TEXT_LAST_MODIFIED.'</b> '.
                            strftime(DATE_TIME_FORMAT, $fInfo->last_modified));
                if (!$this->cip_net_ua() or $this->is_admin()) {
                    $contents[] = array('text' =>'<b>'.TABLE_HEADING_PERMISSIONS.': </b>'.$fInfo->permissions);
                    $contents[] = array('text' =>'<b>'.TABLE_HEADING_USER.': </b>'.$fInfo->user);
                    $contents[] = array('text' =>'<b>'.TABLE_HEADING_GROUP.': </b>'.$fInfo->group);
                }


                // Image!!! Show it.
                //==================================================
                //PrintArray($fInfo);
                if($fInfo->ext=='gif' || $fInfo->ext=='jpg' || $fInfo->ext=='png') {
                    $img_path=HTTP_SERVER.DIR_WS_ADMIN. str_replace(DIR_FS_ADMIN, '',  $this->current_path).'/'.$fInfo->name;
                    $contents[] = array('text' => '<hr><h3>' . CIP_MANAGER_IMAGE_PREVIEW . '</h3><center>
                                                                        <a href="'.$img_path.'" title="' . CIP_MANAGER_ENLARGE . '" target="_blank">'.
                                                                        xtc_image($img_path, CIP_MANAGER_ENLARGE, 250, 250).'</a></center><br>');
                }//end of Image
                //==================================================
            }
        }
        //Prints an error message at the right column
        if ($message->size>0)    array_unshift($contents, array('text' => $message->output()."<br>"));

        //Prints an error message at the right column
        //if (!$heading)    $heading[]=array('text' => '<b>Error</b>');
        if ( (xtc_not_null($heading)) or (xtc_not_null($contents)) ) {
            $box = new box;
            return '<td width="'.(($this->cip_net_ua() && !$this->is_admin()) ? '35' : '30').'%" valign="top">' . "\n". $box->infoBox($heading, $contents).'</td>' . "\n";
        }

    }


    //===========================================================
    // Chain begin
    function draw_chain() {
        //$chain='<a title="Top level folder: '.DIR_FS_CIP.'/" href="'.xtc_href_link($this->script_name, 'action=reset').'">Top</a>/ ';
        foreach ($this->goto_array() as $folder){
            if ($folder['id'] and $folder['text']) {
             $chain.='<a title="go to this folder" href="'.xtc_href_link($this->script_name,
                            'goto='.urlencode($folder['id'])).'">'.$folder['text'].'</a>/ ';
            }
        }
        return $chain;
    }
    function goto_array() {
        $in_directory = substr(substr(DIR_FS_CIP, strrpos(DIR_FS_CIP, '/')), 1);
        $current_path_array = explode('/', $this->current_path);
        $document_root_array = explode('/', DIR_FS_CIP);
        $goto_array = array(array('id' => DIR_FS_CIP, 'text' => $in_directory));
        for ($i=0, $n=sizeof($current_path_array); $i<$n; $i++) {
            if ((isset($document_root_array[$i]) && ($current_path_array[$i] != $document_root_array[$i])) || !isset($document_root_array[$i])) {
                $goto_array[]=array('id'=>implode('/', array_slice($current_path_array, 0, $i+1)),
                                            'text'=>$current_path_array[$i]);
            }
        }
        return $goto_array;
    }
    // Chain end
    //===========================================================











    //========================================================
    //========================================================
    //========================================================
    function check_action() {
        if (!$this->action)    return;
        if ($this->action=='pack')     if (!$this->cip_net_ua or $this->is_admin())     $this->pack();
        if ($this->action=='unpack')    if (!$this->cip_net_ua or $this->is_admin())     $this->unpack();
        if ($this->action=='install') {
            if (!$this->cip_net_ua or $this->ci_cip or $this->is_admin()) {
                $this->install();
                //$this->reload_page();
            }
        }
        if ($this->action=='remove') {
            if (!$this->cip_net_ua or $this->ci_cip or $this->is_admin())     $this->remove();
        }
        if ($this->action=='reset') {
            xtc_session_unregister('current_path');
            $this->reload_page();
        }
        if ($this->action=='deleteconfirm') {
            if (!$this->cip_net_ua or $this->ci_cip or $this->is_admin())    $this->deleteconfirm();
        }
        if ($this->action=='save')    $this->save();
        if ($this->action=='processuploads')    $this->processuploads();
        if ($this->action=='download')    $this->check_download();
        if ($this->action=='upload')    $this->check_upload();
        if ($this->action=='edit')    if (!$this->cip_net_ua or $this->is_admin())     $this->edit();
        if ($this->action=='delete') {
            if ((!$this->cip_net_ua or $this->is_admin()) && strstr($this->cip, '..')) {
                $this->reload_page();
            }
        }
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
        $message->add(CIP_MANAGER_INSTALLED, 'installed');
		    $cips = $this->getDependedCips($cip);
        if (is_array($cips) and count($cips)>0 ){
          foreach($cips as $cp){
            $cp->compute_dependencies();
            if ($cp->get_error())    return;
                $message->add("CIP ".$cp->getIdent()." was aplied!", 'installed');
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
        $message->add(CIP_MANAGER_REMOVED, 'removed');
        $cips = $this->getDependedCips($cip);
        if (is_array($cips) and count($cips)>0 ){
          foreach($cips as $cp){
            $cp->compute_dependencies();
            if ($cp->get_error())    return;
                $message->add("CIP ".$cp->getIdent()." was aplied!", 'installed');
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



    function save() {
        global $_POST;
        if ($fp = fopen($this->current_path.'/'.$_POST['filename'], 'w+')) {
            fputs($fp, stripslashes($_POST['file_contents']));
            fclose($fp);
            $this->reload_page('cip='.urlencode($_POST['filename']));
        }
    }



    function processuploads() {
        global $phpbb_user, $cip, $message;
        if ($this->cip_net_ua && !$this->logged_in())  return;
        for ($i=1; $i<11; $i++) {
            if ($_FILES['file_' . $i][error] == 0) {
                //if (new upload_cip('file_'.$i, $this->current_path, '777', array('zip', 'tgz', 'gz'))) {
                if (new upload_cip('file_'.$i, $this->current_path, '777', array('zip'))) {

                    //Check if archive has install.xml and is it well formed xml file.
                    $cip= new CIP(urldecode($_FILES['file_' . $i]['name']));
                    $cip->read_xml();

                    //Watch support topic for this CIP:
                    if (is_object($phpbb_user)) {
                        $topic_id=$phpbb_user->create_topic($cip->get_cip_name());
                        if ($topic_id) {
                            if($phpbb_user->is_error())     $this->error($phpbb_user->get_error());
                            $post_text="<font style=\"font-size:20px;\">Uploaded new CIP: ".$cip->get_cip_name()."</font ><br><br>";
                            $description=$cip->get_data($cip->get_description_id());

                            if ($description) {
                                if (is_object($phpbb_user)) {
                                    $topic_id=$phpbb_user->get_topic_id($cip->get_cip_name());
                                }
                                $array=$this->cip_description($description->data,
                                    ($phpbb_user->forum_exists() ? $cip->get_uploader_id() : ''), $topic_id);
                                foreach ($array as $value)     $post_text.=addslashes($value['text'])."\r\n";
                            }
                            $phpbb_user->create_post($topic_id, $cip->get_cip_name(), $post_text);
                            $phpbb_user->add_topic_watch($topic_id);
                            $phpbb_user->add_vote($topic_id, 'What do you think about "'.$cip->get_cip_name().'"?');
                            if($phpbb_user->is_error())     $this->error($phpbb_user->get_error());
                        }
                    }
                }
            }
        }
    }



    function check_download() {
        global $cip, $phpbb_user, $message;
        $cip= new CIP($_GET['filename']);

        $cip->set_downloads_counter();
        //Watch support topic
        if ($this->cip_net_ua() && $this->logged_in()) {
            $phpbb_user->add_topic_watch($phpbb_user->get_topic_id($cip->get_cip_name()));
            if($phpbb_user->is_error())     $this->error($phpbb_user->get_error());
        }
        header('Content-type: application/x-octet-stream');
        header('Content-disposition: attachment; filename=' . urldecode($_GET['filename']));
        readfile($this->current_path . '/' . urldecode($_GET['filename']));
        exit;
    }



    function check_upload() {
        global $message, $phpbb_user;
        $this->upload_directory_writeable=true;
        if (!is_writeable($this->current_path)) {
            $this->upload_directory_writeable = false;
            $this->error(sprintf(ERROR_DIRECTORY_NOT_WRITEABLE, $this->current_path));
        }
        //if ($cip_net_ua && !$this->logged_in()) {// NOT loged in
        if ($this->cip_net_ua() && !$this->logged_in()) {// NOT loged in
            $message->add('Only registered users can upload CIPs. This will make our server more secure. <b>Please, register</b>.', 'notify');
        }
    }



    function edit() {
        global $message;
        if (strstr($this->cip, '..'))    return;
        $file=$this->current_path.'/'.$this->cip;
        if (!is_file($file))     $this->error('No file '.$file);
        else {
            $this->file_writeable = true;
            if (!is_writeable($file)) {
                $this->file_writeable = false;
                $this->error(sprintf(ERROR_FILE_NOT_WRITEABLE, $file));
            }
        }
    }
    //========================================================
    //========================================================
    //========================================================
    //========================================================
















    function is_ci_installed() {
        if ($this->error)     return false;
        //Check if self-install was made:
        $query = xtc_db_query("SELECT * FROM ".TABLE_CONFIGURATION." WHERE configuration_key='DIR_FS_CIP'");
        if (xtc_db_num_rows($query)==0
            or !file_exists(DIR_FS_CIP.'/'.$this->ci_cip. '/'.CONFIG_FILENAME)
            or !is_dir(DIR_FS_CIP)
            or !is_dir(DIR_FS_CIP.'/'.$this->ci_cip)
            )    return false;
        else return true;
    }



    function cip_description($data='', $uploader_id='', $topic_id='') {
        $contents[] = array('text' =>'<h3>' . CIP_MANAGER_SUPPORT . '</h3>');
        if ($uploader_id) {
            $contents[] = array('text' =>'<b>&#8226;&nbsp;</b>' . CIP_MANAGER_UPLOADER . '<b><a href="'.HTTP_SERVER.
                '/forum/profile.php?mode=viewprofile&u='.$uploader_id.
                '">'.$this->get_username($uploader_id).'</a></b>');
        }
        if ($topic_id) {
            $contents[]=array('text'=>'<b>&#8226;&nbsp;<a href="'.HTTP_SERVER. '/forum/viewtopic.php?t='.$topic_id.'">' . CIP_MANAGER_SUPPORT_FORUM_DEVELOPER . '</a></b><br>');
        }

        if (!$data)    return $contents;
        foreach ($data as $key=>$value) {
            //$value=strip_tags($value); //remove all HTML and PHP tags
            $value=htmlspecialchars($value);//convert to entries...
            if ($key=='contrib_ref') {
                if ($value) {
                $contents[]=array('text'=>'<b>&#8226;&nbsp;<a href="'. (defined(TEXT_LINK_CONTR) ? TEXT_LINK_CONTR :
                                        'http://www.oscommerce.com/community/contributions,'). $value.'" >' . CIP_MANAGER_CONTRIBUTION_PAGE . '</a></b>');
                }
            } elseif ($key=='forum_ref') {
                if ($value) {
                $contents[]=array('text'=>'<b>&#8226;&nbsp;<a href="'. (defined(TEXT_LINK_FORUM) ? TEXT_LINK_FORUM :
                                    'http://forums.oscommerce.com/index.php?showtopic=').$value. '">' . CIP_MANAGER_SUPPORT_FORUM . '</a></b>');
                }
                $contents[] = array('text' => '<hr><h3>' . CIP_MANAGER_INFO . '</h3>');
            } else 
            
            		if (function_exists('iconv') && 'UTF-8' != strtoupper($charset)) $value = iconv("UTF-8", 'cp1251', $value);
            
            $contents[]=array('text'=>'<b>'.$key.'</b>: '.nl2br($value));
        }
        return $contents;
    }


    function reload_page($param='') {
        global $message;
        $errors=$message->get_errors();
        foreach ($errors as $error)     $message->add_session($error['text'], $error['type']);
        xtc_redirect(xtc_href_link(basename($_SERVER['PHP_SELF']),
                                '&selected_box=contrib_installer'.($param ? '&'.$param : '')));
    }

    function get_username($id='') {
        if(!$id || $this->error)    return;
        $query="SELECT username FROM ".USERS_TABLE." WHERE user_id='".$id."'";
        $result=mysql_query($query);
        if ($result===false)     $this->sql_error($query);
        else {
            $user=mysql_fetch_array($result, MYSQL_ASSOC);
            return $user['username'];
        }
    }

    function error($text='') {
        global $message;
        $this->error=$message->add($text);
    }

	function getDependedCips($cip){
		if($cip->is_ci()) return null;
		$cips = array();
		$query = "select * from ".TABLE_CIP_DEPEND." where cip_ident_req='".$cip->getIdent()."' and cip_req_type=2";
		$rq = xtc_db_query($query);
		while($rs=xtc_db_fetch_array($rq)){
			$query = "select * from ".TABLE_CIP." where cip_ident='".$rs['cip_ident']."' and cip_installed=1";
			$rq1 = xtc_db_query($query);
			if($rs1=xtc_db_fetch_array($rq1)){
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