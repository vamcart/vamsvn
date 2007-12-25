<?
	/**
	 * the php script used to get the list of file or folders under a specific folder
	 * @author Logan Cai (cailongqun @yahoo.com.cn)
	 * @link www.phpletter.com
	 * @since 22/May/2007
	 *
	 */
	
	if(!isset($manager))
	{
		/**
		 *  this is part of  script for processing image paste 
		 */
		$_GET = $_POST;
		include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "config.php");
		include_once(CLASS_MANAGER);
		define('URL_AJAX_FILE_MANAGER', CONFIG_URL_HOME);
		include_once(CLASS_SESSION_ACTION);
		$sessionAction = new SessionAction();
		include_once(DIR_AJAX_INC . "class.manager.php");
	
		$manager = new manager();
		$manager->setSessionAction($sessionAction);
		$selectedDocuments = $sessionAction->get();
		if(sizeof($selectedDocuments))
		{
			include_once(CLASS_FILE);
			$file = new file();
			foreach($selectedDocuments as $doc)
			{
				$sourcePath = $sessionAction->getFolder() . $doc;
				if($file->copyTo($sourcePath, $manager->getCurrentFolderPath()) && $sessionAction->getAction() == "cut")
				{//remove the souce files or folder
					
					$file->delete($sourcePath);
				}	
			}
			$sessionAction->set(array());
		}		
		$fileList = $manager->getFileList();
		$folderInfo = $manager->getFolderInfo();
			
	}

?><table class="tableList" id="tableList" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th width="5%"><a href="#" class="check_all" id="tickAll" title="<?php echo TIP_SELECT_ALL; ?>" onclick="checkAll('<?php echo TIP_SELECT_ALL; ?>', '<?php echo TIP_UNSELECT_ALL; ?>');">&nbsp;</a></th>
							<th width="6%" class="center">&nbsp;</th>
							<th width="48%" class="left"><?php echo LBL_NAME; ?></th>
							<th width="10%" class="center"><?php echo LBL_SIZE; ?></th>
							<th width="31%" class="center"><?php echo LBL_MODIFIED; ?></th>
						</tr>
					</thead>
					<tbody id="fileList">
<tr class="even" id="topRow" onclick="setDocInfo('folder', '0');">
							<td><input type="checkbox" name="check[]" id="check0" disabled="disabled"  />
								<input type="hidden" name="folderPath0" value="<?php echo transformFilePath($folderInfo['path']); ?>" id="folderPath0" />
								<input type="hidden" name="folderFile0" value="<?php echo $folderInfo['file']; ?>" id="folderFile0" />
								<input type="hidden" name="folderSubdir0" id="folderSubdir0" value="<?php echo $folderInfo['subdir']; ?>" />
								<input type="hidden" name="folderCtime0" id="folderCtime0" value="<?php echo date(DATE_TIME_FORMAT,$folderInfo['ctime']); ?>" />
								<input type="hidden" name="folderMtime0" id="folderMtime0" value="<?php echo date(DATE_TIME_FORMAT,$folderInfo['mtime']); ?>" />
								<input type="hidden" name="fileReadable0" id="folderReadable0" value="<?php echo $folderInfo['is_readable']; ?>" />
								<input type="hidden" name="folderWritable0" id="folderWritable0" value="<?php echo $folderInfo['is_writable']; ?>" />
								<input type="hidden" name="itemType0" id="itemType0" value="folder" />
							</td>
							<td>
							<?
								if(strtolower($folderInfo['path']) ==  strtolower(CONFIG_SYS_ROOT_PATH))
								{//this is root folder
									?>
									<span class="folderParent">&nbsp;</span>
									<?
								}else
								{
									?>

									<a href="<?php echo appendQueryString(URL_AJAX_FILE_MANAGER, "path=" . getParentPath($folderInfo['path'])); ?>" title="<?php echo TIP_FOLDER_GO_UP; ?>"><span class="folderParent">&nbsp;</span></a>
									<?
								}
						?>
							</td>
							<td class="left" id="<?php echo $folderInfo['path']; ?>">
							<?
							if($folderInfo['path'] ==  CONFIG_SYS_ROOT_PATH)
							{
								echo "&nbsp;";
							}else
							{
							?>
									<a href="<?php echo appendQueryString(URL_AJAX_FILE_MANAGER, "path=" . getParentPath($folderInfo['path'])); ?>" title="<?php echo TIP_FOLDER_GO_UP; ?>">...</a>
							<?
							}
						?>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<?
							$count = 1;
							$css = "";
							//list all documents (files and folders) under this current folder, 
							foreach($fileList as $file)
							{
								$css = ($css == "" || $css == "even"?"odd":"even");
								$strDisabled = ($file['is_writable']?"":" disabled");
								$strClass = ($file['is_writable']?"left":" leftDisabled");
								if($file['type'] == 'file')
								{

								?>
								<tr class="<?php echo $css; ?>" id="row<?php echo $count; ?>"  >
									<td onclick="setDocInfo('<?php echo $file['type']; ?>', '<?php echo $count; ?>');"><input type="checkbox" name="check[]" id="check<?php echo $count; ?>" value="<?php echo $file['name']; ?>" <?php echo $strDisabled; ?> />
										<input type="hidden" name="fileName<?php echo $count; ?>" value="<?php echo $file['name']; ?>" id="fileName<?php echo $count; ?>" />
										<input type="hidden" name="fileSize<?php echo $count; ?>" value="<?php echo transformFileSize($file['size']); ?>" id="fileSize<?php echo $count; ?>" />
										<input type="hidden" name="fileType<?php echo $count; ?>" value="<?php echo $file['fileType']; ?>" id="fileType<?php echo $count; ?>" />
										<input type="hidden" name="fileCtime<?php echo $count; ?>" id="fileCtime<?php echo $count; ?>" value="<?php echo date(DATE_TIME_FORMAT,$file['ctime']); ?>" />
										<input type="hidden" name="fileMtime<?php echo $count; ?>" id="fileMtime<?php echo $count; ?>" value="<?php echo date(DATE_TIME_FORMAT,$file['mtime']); ?>" />
										<input type="hidden" name="fileReadable<?php echo $count; ?>" id="fileReadable<?php echo $count; ?>" value="<?php echo $file['is_readable']; ?>" />
										<input type="hidden" name="fileWritable<?php echo $count; ?>" id="fileWritable<?php echo $count; ?>" value="<?php echo $file['is_writable']; ?>" />
										<input type="hidden" name="filePreview<?php echo $count; ?>" id="filePreview<?php echo $count; ?>" value="<?php echo $file['preview']; ?>" />
										<input type="hidden" name="filePath<?php echo $count; ?>" id="filePath<?php echo $count; ?>" value="<?php echo $file['path']; ?>" />
										<input type="hidden" name="fileUrl<?php echo $count; ?>" id="fileUrl<?php echo $count; ?>" value="<?php echo getFileUrl($file['path']); ?>" />
										<input type="hidden" name="itemType<?php echo $count; ?>" id="itemType<?php echo $count; ?>" value="file" />
										</td>
									<td><a href="<?php echo $file['path']; ?>" target="_blank"><span class="<?php echo $file['cssClass']; ?>"><span id="flag<?php echo $count; ?>" class="<?php echo $file['flag']; ?>">&nbsp;</span></span></a></td>
									<td class="<?php echo $strClass; ?>"  id="<?php echo $file['path']; ?>"><?php echo $file['name']; ?></td>
									<td><?php echo transformFileSize($file['size']); ?></td>
									<td><?php echo date(DATE_TIME_FORMAT,$file['mtime']); ?></td>
								</tr>
								<?
								}else
								{
									?>
									<tr class="<?php echo $css; ?>" id="row<?php echo $count; ?>" >
										<td onclick="setDocInfo('folder', '<?php echo $count; ?>');"><input type="checkbox" name="check[]" id="check<?php echo $count; ?>" value="<?php echo $file['name']; ?>" <?php echo $strDisabled; ?>/>
											<input type="hidden" name="folderName<?php echo $count; ?>" id="folderName<?php echo $count; ?>" value="<?php echo $file['name']; ?>" />
											<input type="hidden" name="folderPath<?php echo $count; ?>" value="<?php echo transformFilePath($file['path']); ?>" id="folderPath<?php echo $count; ?>" />
											<input type="hidden" name="folderFile<?php echo $count; ?>" value="<?php echo $file['file']; ?>" id="folderFile<?php echo $count; ?>" />
											<input type="hidden" name="folderSubdir<?php echo $count; ?>" id="folderSubdir<?php echo $count; ?>" value="<?php echo $file['subdir']; ?>" />
											<input type="hidden" name="folderCtime<?php echo $count; ?>" id="folderCtime<?php echo $count; ?>" value="<?php echo date(DATE_TIME_FORMAT,$file['ctime']); ?>" />
											<input type="hidden" name="folderMtime<?php echo $count; ?>" id="folderMtime<?php echo $count; ?>" value="<?php echo date(DATE_TIME_FORMAT,$file['mtime']); ?>" />
											<input type="hidden" name="fileReadable<?php echo $count; ?>" id="folderReadable<?php echo $count; ?>" value="<?php echo $file['is_readable']; ?>" />
											<input type="hidden" name="folderWritable<?php echo $count; ?>" id="folderWritable<?php echo $count; ?>" value="<?php echo $file['is_writable']; ?>" />
											<input type="hidden" name="itemType<?php echo $count; ?>" id="itemType<?php echo $count; ?>" value="folder" />
										</td>
										<td><a href="<?php echo appendQueryString(URL_AJAX_FILE_MANAGER, "path=" . $file['path']); ?>" title="<?php echo TIP_FOLDER_GO_DOWN; ?>"><span class="<?php echo ($file['file']||$file['subdir']?$file['cssClass']:"folderEmpty"); ?>"><span id="flag<?php echo $count; ?>" class="<?php echo $file['flag']; ?>">&nbsp;</span></span></a></td>
										<td class="<?php echo $strClass; ?>" id="<?php echo $file['path']; ?>"><?php echo $file['name']; ?></td>
										<td>&nbsp;</td>
										<td><?php echo date(DATE_TIME_FORMAT,$file['mtime']); ?></td>
									</tr>
									<?
								}
								$count++;
							}
						?>	
					</tbody>
				</table>