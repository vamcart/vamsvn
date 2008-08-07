<?php

/**
* 
* Basic compiler for Savant2.
* 
* This is a simple compiler provided as an example.  It probably won't
* work with streams, but it does limit the template syntax in a
* relatively strict way.  It's not perfect, but it's OK for many
* purposes.  Basically, the compiler converts specialized instances of
* curly braces into PHP commands or Savant2 method calls.  It will
* probably mess up embedded JavaScript unless you change the prefix
* and suffix to something else (e.g., '<!-- ' and ' -->', but then it 
* will mess up your HTML comments ;-).
* 
* Use {$var} or {$this->var} to echo a variable.
* 
* Use {['pluginName', 'arg1', $arg2, $this->arg3]} to call plugins.
* 
* Use these for looping (normal PHP can go in the parens):
* 	{for ():} ... {endfor}
* 	{foreach ():} ... {endforeach}
* 	{while ():} ... {endwhile}
* 
* Use these for conditionals (normal PHP can go in the parens):
* 	{if ():}
* 	{elseif ():}
* 	{else:}
* 	{endif}
* 
* Use this to include a template:
* 	{tpl 'template.tpl.php'}
* 	{tpl $tplname}
* 
* 
* $Id: Savant2_Compiler_basic.php,v 1.4 2004/10/13 17:11:34 pmjones Exp $
* 
* @author Paul M. Jones <pmjones@ciaweb.net>
* 
* @package Savant2
* 
* @license http://www.gnu.org/copyleft/lesser.html LGPL
* 
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU Lesser General Public License as
* published by the Free Software Foundation; either version 2.1 of the
* License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful, but
* WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
*
*/

require_once 'Savant2/Compiler.php';

class Savant2_Compiler_basic extends Savant2_Compiler {
	
		
	/**
	* 
	* The template directive prefix.
	* 
	* @access public
	* 
	* @var array
	* 
	*/
	
	var $prefix = '{';
	
		
	/**
	* 
	* The template directive suffix.
	* 
	* @access public
	* 
	* @var array
	* 
	*/
	
	var $suffix = '}';
	
	
	/**
	* 
	* The subset of PHP commands to allow as template directives.
	* 
	* @access public
	* 
	* @var array
	* 
	*/
	
	var $command = array(
		'if', 'elseif', 'else', 'endif',
		'for', 'endfor',
		'foreach', 'endforeach',
		'while', 'endwhile'
	);
	
	
	/**
	* 
	* Whether or not to allow raw PHP in the template source.
	* 
	* @access public
	* 
	* @var string
	* 
	*/
	
	var $allowPHP = false;
	
	
	/**
	* 
	* The directory where compiled templates are saved.
	* 
	* @access public
	* 
	* @var string
	* 
	*/
	
	var $compileDir = null;
	
	
	/**
	* 
	* Whether or not to force every template to be compiled every time.
	* 
	* @access public
	* 
	* @var bool
	* 
	*/
	
	var $forceCompile = false;
	
	
	/**
	* 
	* Has the source template changed since it was last compiled?
	* 
	* @access public
	* 
	* @var string $tpl The source template file.
	* 
	*/
	
	function changed($tpl)
	{
		if (! file_exists($this->getPath($tpl)) ||
			filemtime($tpl) > filemtime($this->getPath($tpl))) {
			return true;
		} else {
			return false;
		}
	}
	
	
	/**
	* 
	* Saves the PHP compiled from template source.
	* 
	* @access public
	* 
	* @var string $tpl The source template file.
	* 
	*/
	
	function saveCompiled($tpl, $php)
	{
		$fp = fopen($this->getPath($tpl), 'w');
		if (! $fp) {
			return false;
		} else {
			$result = fwrite($fp, $php);
			fclose($fp);
			return $result;
		}
	}
	
	
	/**
	* 
	* Gets the path to the compiled PHP for a template source.
	* 
	* @access public
	* 
	* @var string $tpl The source template file.
	* 
	*/
	
	function getPath($tpl)
	{
		$dir = $this->compileDir;
		if (substr($dir, -1) != DIRECTORY_SEPARATOR) {
			$dir .= DIRECTORY_SEPARATOR;
		}
		return $dir . 'Savant2_' . md5($tpl);
	}
	
	
	/**
	* 
	* Compiles a template source into PHP code for Savant.
	* 
	* @access public
	* 
	* @var string $tpl The source template file.
	* 
	*/
	
	function compile($tpl)
	{
		// create a end-tag so that text editors don't
		// stop colorizing text
		$end = '?' . '>';
		
		if ($this->forceCompile || $this->changed($tpl)) {
			
			// get the template text
			$php = file_get_contents($tpl);
			
			// do we allow raw PHP?
			if (! $this->allowPHP) {
				// replace all instances of opening and closing tags.
				$php = str_replace('<?php', '&lt;?php', $php);
				$php = str_replace($end, '?&gt;', $php);
				
				// replace short tags if they're turned on
				if (ini_get('short_open_tag')) {
					$php = str_replace('<?', '&lt;?', $php);
					$php = str_replace('<?=', '&lt;?=', $php);

				}
			}
			
			// simple variable printing
			$php = str_replace($this->prefix . '$', '<?php echo $', $php);
			
			// commands
			foreach ($this->command as $cmd) {
				$php = str_replace($this->prefix . $cmd, "<?php $cmd", $php);
			}
			
			// pseudo-command for template includes
			// e.g., {tpl 'template.tpl.php'}
			$regex = '/' . preg_quote($this->prefix) . 'tpl (.*)?' .
				preg_quote($this->suffix) . '/';
				
			$php = preg_replace(
				$regex,
				"<?php include \$this->loadTemplate($1) $end",
				$php
			);
			
			// plugins
			$pre = $this->prefix . '[';
			$suf = ']' . $this->suffix;
			$php = str_replace($pre, '<?php $this->plugin(', $php);
			$php = str_replace($suf, ") $end", $php);
			
			// all closing tags
			$php = str_replace($this->suffix, " $end", $php);
			
			// save the compiled PHP
			$this->saveCompiled($tpl, $php);
		}
		
		// return the path to the compiled PHP script
		return $this->getPath($tpl);
	}
}
?>