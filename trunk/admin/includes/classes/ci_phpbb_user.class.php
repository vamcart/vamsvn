<?php
/*
ci_phpbb_user.class.php

Can be used without osCommerce

Released under GPL
===========================
Usage:
$phpbb_user = new phpbb_user();
$phpbb_user->get_session_logged_in();
$phpbb_user->get_session_user_id();
$phpbb_user->get_user_rank()==1 means "Site Admin"
*/

defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

class phpbb_user {
    var $path_to_phpbb;
    var $session_id;
    var $session=array();//contain info about users session
    var $user=array();//contain users profile
    var $group_id, $group_name;
    var $error;// sql queries errors


    function phpbb_user($path_to_phpbb='../../forum/') {
        global $_COOKIE;
        if (is_file($path_to_phpbb.'config.php') && is_file($path_to_phpbb.'includes/constants.php')) {
            $this->forum_exists=true;
            // Read some data from this forum:
            include_once($path_to_phpbb.'config.php');
            define('IN_PHPBB', true);
            include_once($path_to_phpbb.'includes/constants.php');
            define('IN_PHPBB', false);

            //Check if table exist:
            $forum_installed=false;
            $check_query=xtc_db_query("SHOW TABLE STATUS");
            while ($table=xtc_db_fetch_array($check_query)) {
                if (substr($table['Name'], 0, strlen($table_prefix))==$table_prefix)     $forum_installed=true;
            }

            if (!$forum_installed) {
                $this->forum_exists=false;
                return;
            }

            $query="SELECT * FROM ".CONFIG_TABLE." WHERE config_name='cookie_name'";
            $result=mysql_query($query);
            if ($result===false)     $this->sql_error($query);
            else {
                $name=mysql_fetch_array($result, MYSQL_ASSOC);
                $this->session_id=$_COOKIE[$name['config_value'].'_sid'];
            }
            //=========================================================
            $this->check_error();
            if ($this->session_id) {
                $query="SELECT * FROM ".SESSIONS_TABLE." WHERE session_id='".$this->session_id."'";
                $result=mysql_query($query);
                if ($result===false)     $this->sql_error($query);
                else     $this->session=mysql_fetch_array($result, MYSQL_ASSOC);
            } else $this->session['session_user_id']=-1;
            //=========================================================
            //Profile
            $this->check_error();
            $query="SELECT * FROM ".USERS_TABLE." WHERE user_id='".$this->session['session_user_id']."'";
            $result=mysql_query($query);
            if ($result===false)     $this->sql_error($query);
            else     $this->user=mysql_fetch_array($result, MYSQL_ASSOC);
            //=========================================================
            //Group
            $this->check_error();
            $query="SELECT ug.group_id, g.group_name  FROM ".USER_GROUP_TABLE." ug, ".GROUPS_TABLE." g
                            WHERE user_id='".$this->session['session_user_id']."' AND ug.group_id=g.group_id";
            $result=mysql_query($query);
            if ($result===false)     $this->sql_error($query);
            else {
                $rez=mysql_fetch_array($result, MYSQL_ASSOC);
                $this->group_id=$rez['group_id'];
                $this->group_name=$rez['group_name'];
            }
        } else $this->forum_exists=false;



    }


    function forum_exists() { return $this->forum_exists;}

    //ERROR begin ======================================
    function is_error() {return ($this->error ? true : false);}
    function get_error() {
        $error_msg=$this->error;
        unset($this->error);
        return $error_msg;
    }
    function sql_error($query='') {
        $this->error='SQL error : '.mysql_errno().' - '.mysql_error().'<br>'.$query;
    }
    function check_error() {
        if ($this->error)     {echo $this->error;exit;}
    }
    //ERROR end ========================================



    function get_session_user_id() { return $this->session['session_user_id'];}//user_id
    function get_session_start() { return $this->session['session_start'];}
    function get_session_time() { return $this->session['session_time'];}
    function get_session_ip() { return $this->session['session_ip'];}
    function get_session_page() { return $this->session['session_page'];}
    function get_session_logged_in() { return $this->session['session_logged_in'];}
    function get_session_admin() { return $this->session['session_admin'];}

    //Profile ==============================================
    function get_user_posts() { return $this->user['user_posts'];}
    function get_username() {return $this->user['username'];}
    function get_user_avatar() { return $this->user['user_avatar'];}
    function get_user_rank() { return $this->user['user_rank'];} //Can be changed.
    function get_user_level() { return $this->user['user_level'];} //0-User, 1-Admin. Can't be changed
    function get_user_email() { return $this->user['user_email'];}
    function get_user_icq() { return $this->user['user_icq'];}
    function get_user_website() { return $this->user['user_website'];}
    //function get_() { return $this->user[''];}
    //Posible parameters:
   //user_active , user_password , user_session_time , user_session_page , user_lastvisit , user_regdate , user_level , user_timezone , user_style , user_lang , user_dateformat , user_new_privmsg , user_unread_privmsg , user_last_privmsg , user_login_tries , user_last_login_try , user_emailtime , user_viewemail , user_attachsig , user_allowhtml , user_allowbbcode , user_allowsmile , user_allowavatar , user_allow_pm , user_allow_viewonline , user_notify , user_notify_pm , user_popup_pm , user_avatar_type , user_from , user_sig , user_sig_bbcode_uid , user_aim , user_yim , user_msnm , user_occ , user_interests , user_actkey , user_newpasswd


   //===================================================
   //Group
   //===================================================
   function get_group_id() { return $this->group_id;}
   function get_group_name() { return $this->group_name;}

    function get_admin_id() {
        //Levels: 0 - User, 1- Admin
        if (!isset($this->admin_id)) {
            $query="SELECT user_id, username FROM ".USERS_TABLE." WHERE user_level='1'";
            $result=mysql_query($query);
            if ($result===false)     $this->sql_error($query);
            else     $admin=mysql_fetch_array($result, MYSQL_ASSOC);
            $this->admin_id=$admin['user_id'];
            $this->admin_name=$admin['username'];
        }
        return $this->admin_id;
    }

    function get_admin_name() {
        if (!isset($this->admin_name))     $this->get_admin_id();
        return $this->admin_name;
    }




   //===================================================
   //Posts
   //===================================================

   function get_forum_id($name) {
        if ($this->error)    return;
        $query="SELECT forum_id FROM ".FORUMS_TABLE." WHERE forum_name='$name'";
        $result=mysql_query($query);
        if ($result===false)     $this->sql_error($query);
        else {
            $data=mysql_fetch_array($result, MYSQL_ASSOC);
            return $data['forum_id'];
        }
        return false;
    }

    function create_topic($cip_name='') {
        if (!$cip_name || $this->error)    return;
        $forum_id=$this->get_forum_id('Support for Contrib Installer Packages');
        if (!$forum_id) return;
        //Check if topic already exists:
        $topic_exists=$this->get_topic_id($cip_name);
        if ($topic_exists)    return;

        $query="INSERT INTO ".TOPICS_TABLE."
                        (topic_title, topic_poster, topic_time, forum_id, topic_status, topic_type, topic_vote)
                        VALUES ('$cip_name', ".$this->get_admin_id().", '".time()."', '".$forum_id."', 0, 0, 1)";
        $result=mysql_query($query);
        if ($result===false)     $this->sql_error($query);
        return mysql_insert_id(); //$topic_id
     }

    function get_topic_id($cip_name='') {
        if (!$cip_name || $this->error)    return;
        $query="SELECT topic_id FROM ".TOPICS_TABLE." WHERE topic_title='".$cip_name."' ";
        $result=mysql_query($query);
        if ($result===false)     $this->sql_error($query);
        else {
            $data=mysql_fetch_array($result, MYSQL_ASSOC);
            return $data['topic_id'];
        }
     }

    function create_post($topic_id='', $post_subject='', $post_text='') {
        if (!$topic_id or !$post_subject or !$post_text || $this->error)    return;
        //Create a topic
        $forum_id=$this->get_forum_id('Support for Contrib Installer Packages');
        $query="INSERT INTO ".POSTS_TABLE."
        (post_id , topic_id , forum_id , poster_id ,
        post_time , poster_ip ,
        post_username , enable_bbcode ,
        enable_html , enable_smilies, enable_sig ,
        post_edit_time , post_edit_count )
        VALUES (
         '', '".$topic_id."', '".$forum_id."', '".$this->get_admin_id()."',
         '".time()."', '".$this->session['session_ip']."',
         '".$this->get_admin_name()."' , '1',
         '0', '1', '1',
         NULL , '0'
        )";
        $result=mysql_query($query);
        if ($result===false)     $this->sql_error($query);
        $post_id=mysql_insert_id(); //post_id

        //Add a post text:
        $query="INSERT INTO ".POSTS_TEXT_TABLE."
                        (post_id, bbcode_uid, post_subject, post_text)
                        VALUES ('".$post_id."', '', '".$post_subject."' , '".$post_text."')";
        $result=mysql_query($query);
        if ($result===false)     $this->sql_error($query);

        //Update a forum's data:
        $query="UPDATE ".FORUMS_TABLE."
                        SET forum_posts=forum_posts+1, forum_topics=forum_topics+1,  forum_last_post_id='".$post_id."'
                        WHERE forum_id='".$forum_id."' ";
        $result=mysql_query($query);
        if ($result===false)     $this->sql_error($query);

        //Update a topic's data:
        $query="UPDATE ".TOPICS_TABLE."
                        SET topic_first_post_id=".$post_id.", topic_last_post_id=".$post_id."
                        WHERE topic_id='".$topic_id."' ";
        $result=mysql_query($query);
        if ($result===false)     $this->sql_error($query);

        return $post_id;
     }


    function add_topic_watch($topic_id='') {
        if (!$topic_id || $this->error)    return;
        //notify_status=1 when e-mail was sent
        //notify_status=0 when user are watching this topic
        //When user do NOT watching this topic there are no record in this table
        $query="INSERT INTO ".TOPICS_WATCH_TABLE."
                        ( topic_id , user_id , notify_status )
                        VALUES (
                         '".$topic_id."', '".$this->session['session_user_id']."', '0')";
        $result=mysql_query($query);
        if ($result===false)     $this->sql_error($query);
     }


     //Vote
     function add_vote($topic_id='', $vote_text='') {
         if (!$topic_id || $this->error)    return;
         $vote_id=$this->add_vote_desc($topic_id, $vote_text);
         $this->add_vote_results($vote_id);
         //$this->add_voters($vote_id);

     }

    function add_vote_desc($topic_id='', $vote_text='') {
        if (!$topic_id || $this->error)    return;
        if (!$vote_text)     $vote_text='What do you think about this CIP?';
        $query="INSERT INTO ".VOTE_DESC_TABLE."
                        (vote_id , topic_id , vote_text , vote_start , vote_length)
                        VALUES ('', '".$topic_id."', '".$vote_text."', '".time()."', '0')";
        $result=mysql_query($query);
        if ($result===false)     $this->sql_error($query);
        $vote_id=mysql_insert_id(); //post_id
        return $vote_id;
    }

    function add_vote_results($vote_id='', $votes='') {
        if (!$vote_id || $this->error)    return;
        if (!$votes) {
            $votes=array(
                '1'=>';-) Excellent!',
                '2'=>':-) Good',
                '3'=>':-| Bad',
                '4'=>':-( Terrible',
            );
        }
        foreach ($votes as $id=>$text) {
            $query="INSERT INTO ".VOTE_RESULTS_TABLE."
                            (vote_id , vote_option_id , vote_option_text , vote_result)
                            VALUES ('".$vote_id."', '".$id."', '".$text."', '0')";
            $result=mysql_query($query);
            if ($result===false)     $this->sql_error($query);
        }
     }


    function create_forum($name='', $desc='') {
        //Must be setted cat_id, forum_id
        exit;

        if (!$name || $this->error)    return;
        if (!$desc)    $desc=$name;
        //$name='Support for Contrib Installer Packages';
        $query="INSERT INTO ".FORUMS_TABLE."
                        (forum_id, cat_id, forum_name, forum_desc,
                        forum_status, forum_order, forum_posts, forum_topics,
                        forum_last_post_id, prune_next, prune_enable, auth_view,
                        auth_read, auth_post, auth_reply, auth_edit,
                        auth_delete, auth_sticky, auth_announce, auth_vote,
                        auth_pollcreate, auth_attachments)
                        VALUES (
                        '0', '0', '".$name."' , '".$desc."' ,
                        '0', '1', '0', '0',
                        '0', NULL , '0', '0',
                        '0', '0', '0', '0',
                        '0', '0', '0', '0',
                        '0', '0')";
        $result=mysql_query($query);
        if ($result===false)     $this->sql_error($query);
        return mysql_insert_id(); //$topic_id
     }


     //===================================================
     // Get site name and slogan from forum
     //===================================================

    function get_site_name() {return $this->get_config_vars('sitename');}
    function get_site_desc() {return $this->get_config_vars('site_desc');}
    function get_config_vars($var_name='') {
        $query="SELECT config_value FROM ".CONFIG_TABLE." WHERE config_name='".$var_name."' ";
        $result=mysql_query($query);
        if ($result===false)     $this->sql_error($query);
        else {
            $name=mysql_fetch_array($result, MYSQL_ASSOC);
            return $name['config_value'];
        }
    }



}
?>