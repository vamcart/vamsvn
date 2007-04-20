<?php
/* --------------------------------------------------------------
   $Id: cip_manager.php 1249 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2005 Vlad Savitsky cip.net.ua

   Released under the GNU General Public License
   --------------------------------------------------------------*/

define('HEADING_TITLE', '��������� �������');

define('TABLE_HEADING_FILENAME', '��������');
define('TABLE_HEADING_SIZE', '������');
define('TABLE_HEADING_PERMISSIONS', '����� �������');
define('TABLE_HEADING_USER', '������������');
define('TABLE_HEADING_GROUP', '������');
define('TABLE_HEADING_UPLOADED', '��������');
define('TABLE_HEADING_ACTION', '��������');

define('TEXT_INFO_HEADING_UPLOAD', '���������');
define('TEXT_FILE_NAME', '��� �����:');
define('TEXT_FILE_SIZE', '������:');
define('TEXT_FILE_CONTENTS', '����������:');
define('TEXT_LAST_MODIFIED', '��������� ���������:');
define('TEXT_DELETE_INTRO', '�� ������������� ������ ������� ������ ����?');
define('TEXT_UPLOAD_INTRO', '�������� ���� ��� ��������.');
define('TEXT_UPLOAD_LIMITS','�� ������ ��������� ������ <b>ZIP ������</b>, �� ����� <b>'.round(MAX_UPLOADED_FILESIZE/1024).'Kb</b> � ������ <b>������ � ��������</b>!');

define('ERROR_DIRECTORY_NOT_WRITEABLE', '������: ��� ������� �� ������ � ������ ����������. ���������� ���������� ����� ������� ��: %s');
define('ERROR_FILE_NOT_WRITEABLE', '������: ��� ������� �� ������ � ������ ����. ���������� ���������� ����� ������� ��: %s');
define('ERROR_DIRECTORY_NOT_REMOVEABLE', '������: �� ���� ������� ������ ����������. ���������� ���������� ����� ������� ��: %s');
define('ERROR_FILE_NOT_REMOVEABLE', '������: �� ���� ������� ������ ����. ���������� ���������� ����� ������� ��: %s');
define('ERROR_FILE_ALREADY_EXISTS','���� %s  <b>��� ����������</b>.');

define('ICON_EDIT', '�������������');
define('ICON_INSTALL', '����������');
define('ICON_REMOVE', '������� ������');
define('ICON_DELETE_MODULE', '������� ����� � ������� �� ��������');
define('ICON_WITHOUT_DATA_REMOVING', '�������� ���������, ������������ �������');
define('ICON_EMPTY', '');
define('ICON_INSTALLED_CURRENT_FOLDER', '������� ����� ���� �����������');

define('CIP_MANAGER_SUPPORT','���������: ');
define('CIP_MANAGER_UPLOADER','������ �������: ');
define('CIP_MANAGER_SUPPORT_FORUM','����� ��������� ��� ������� ������ �� ����������� ����� ��������');
define('CIP_MANAGER_CONTRIBUTION_PAGE','����������� �������� ������');
define('CIP_MANAGER_SUPPORT_FORUM_DEVELOPER','����� ��������� ������� ������ �� ����� ������������');
define('CIP_MANAGER_INFO','���������� � ������: ');
define('CIP_MANAGER_INSTALLED','������ ����������');
define('CIP_MANAGER_NOT_INSTALLED','������ �� ��� ����������');
define('CIP_MANAGER_UPLOAD_NOTE','�� ������ ��������� <b>������ ZIP ������</b>, <br><b>�� ����� 500Kb</b><br>� <b>������ ������ � ��������</b>.');
define('CIP_MANAGER_XML_NOT_FOUND',' �� ������!');
define('CIP_MANAGER_GENERAL_INFO','���������� � �����: ');
define('CIP_MANAGER_IMAGE_PREVIEW','��������: ');
define('CIP_MANAGER_ENLARGE','���������');
define('CIP_MANAGER_INSTALLED','������ <b>����������!</b>');
define('CIP_MANAGER_REMOVED','������ <b>�����!</b>');

define('CONTRIB_INSTALLER_NAME','��������� �������');
define('CONTRIB_INSTALLER_VERSION','2.0.6');
define('CONFIG_FILENAME','install.xml');
define('INIT_CONTRIB_INSTALLER', 'contrib_installer.php');

define('CANT_CREATE_DIR_TEXT', '�� ���� ������� ����������: ');
define('COLUDNT_REMOVE_DIR_TEXT', '�� ���� ������� ����������: ');
define('WRITE_PERMISSINS_NEEDED_TEXT', '���������� ����� ������� �� ������ ���: ');
define('COULDNT_REMOVE_FILE_TEXT', '�� ���� ������� ����: ');
define('COULDNT_COPY_TO_TEXT', '�� ���� ����������� ����: ');
define('COULDNT_FIND_TEXT', '�� ���� ����� ');
define('NO_CONTRIBUTION_NAME_TEXT', '�� ������� �������� ������.');
define('NAME_OF_FILE_MISSING_IN_ADDFILE_SECTION_TEXT', '�������� �������������� �����.');
define('NO_QUERY_TAG_IN_SQL_SECTION_TEXT', '��� ���� query.');
define('NO_REMOVE_QUERY_NESSESARY_FOR_SQL_QUERY_TEXT', '��� ������������ ������� �� �������� ��� SQL �������: ');
define('NAME_OF_DIR_MISSING_IN_MAKE_DIR_SECTION_TEXT', '�������� ������������� ����������.');
define('IN_THE_FILE_TEXT', '� �����: ');
define('NO_INSTALL_TAG_IN_PHP_SECTION_TEXT', '��� ���� INSTALL.');
define('NO_REMOVE_TAG_IN_PHP_SECTION_TEXT', '��� ���� REMOVE.');
define('FILE_NOT_EXISTS_TEXT', '���� �� ������');
define('NAME_OF_FILE_MISSING_IN_DEL_FILE_SECTION_TEXT', '�������� �������������� �����.');
define('ERROR_COULD_NOT_OPEN_XML', '�� ���� ������� XML �: ');
define('TEXT_NOT_ORIGINAL_TEXT', '�� ������������ ����� � find �������. ');
define('TEXT_HAVE_BEEN_FOUND', '��� ������ ');
define('TEXT_TIMES', ' ���!');
define('NO_COMMENTS_TAG_IN_DESCRIPTION_SECTION_TEXT', '��� ���� comments � ������� ��������');
define('NO_CREDITS_TAG_IN_DESCRIPTION_SECTION_TEXT', '��� ���� credits � ������� ��������');
define('NO_CONTRIB_REF_PARAMETER_IN_DETAILS_TAG_TEXT', '��� ��������� contrib_ref � ���� details');
define('NO_FORUM_REF_PARAMETER_IN_DETAILS_TAG_TEXT', '��� ��������� forum_ref � ���� details');
define('NO_CONTRIB_TYPE_PARAMETER_IN_DETAILS_TAG_TEXT', '��� ��������� contrib_type � ���� details');
define('NO_STATUS_PARAMETER_IN_DETAILS_TAG_TEXT', '��� ��������� status � ���� details');
define('NO_LAST_UPDATE_PARAMETER_IN_DETAILS_TAG_TEXT', '��� ��������� last_update � ���� details');

define('TEXT_INFO_SUPPORT', '���������');
define('TEXT_INFO_CONTRIB', '���������� � ������');
define('CONTRIBS_PAGE_ALT','����������� �������� ������');
define('CONTRIBS_PAGE','����������� �������� ������');

define('CONTRIBS_FORUM_ALT','����� ��������� ������� ������ �� ����������� ����� ��������');
define('CONTRIBS_FORUM','����� ��������� ������� ������ �� ����������� ����� ��������');

define('CIP_STATUS_REMOVED_ALT', '������ �� ��� ����������');
define('CIP_STATUS_INSTALLED_ALT', '������ ����������');

define('CIP_USES', 'CIP ����������');
define('TEXT_DOESNT_EXISTS', ' �� ����������');

define('MSG_WAS_INSTALLED','������ ����������!');
define('MSG_WAS_APPLIED',' ��� ����� ����������!');
define('MSG_WAS_REMOVED','������ �����!');

define('TEXT_POST_INSTALL_NOTES','POST INSTALL NOTES');

?>