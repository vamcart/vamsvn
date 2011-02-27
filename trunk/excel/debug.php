<?php

//------------------------------------------------------------------------
// ABC Excel Parser Pro (Debug class)
//
// Version: 4.0
// PHP compatibility: 4.3.x
// Copyright (c) 2002 Zakkis Technology, Inc.
// All rights reserved.
//
// This script parses a binary Excel file and store all data in an array.
// For more information see README.TXT file included in this distribution.
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
// "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
// LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
// FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
// REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
// INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
// (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
// SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
// HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
// STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
// ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
// OF THE POSSIBILITY OF SUCH DAMAGE.
//
//------------------------------------------------------------------------

define('ABC_CRITICAL',      0);
define('ABC_ERROR',         1);
define('ABC_ALERT',         2);
define('ABC_WARNING',       3);
define('ABC_NOTICE',        4);
define('ABC_INFO',          5);
define('ABC_DEBUG',         6);
define('ABC_TRACE',         7);
define('ABC_VAR_DUMP',      8);

define('ABC_NO_LOG',      -1);

$php_version = phpversion();

if( $php_version[0] == 4 && $php_version[1] <= 1 ) {
    if( !function_exists('var_export') ) {
        function var_export( $exp, $ret ) {
				ob_start();
				var_dump( $exp );
				$result = ob_get_contents();
				ob_end_clean();
				return $result;
		}
	}
}

function print_bt()
{
	print "<code>\n";
	$cs = debug_backtrace();
	for( $i = 1; $i < count($cs) ; $i++ )
	{
		$item = $cs[ $i ];
		
		for( $j = 0; $j < count($item['args']); $j++ )
			if( is_string($item['args'][$j]) )
				$item['args'][$j] = "\"" . $item['args'][$j] . "\"";
		$args = join(",", $item['args'] );
			
		if( isset( $item['class'] ) )
			$str = sprintf("%s(%d): %s%s%s(%s)",
				$item['file'],
				$item['line'],
				$item['class'],
				$item['type'],
				$item['function'],
				$args );
		else
			$str = sprintf("%s(%d): %s(%s)",
				$item['file'],
				$item['line'],
				$item['function'],
				$args );
		echo $str . "<br>\n";
	}
	print "</code>\n";
}

function _die( $str )
{
	print "Выполнение скрипта остановлено по причине: $str<br>\n";
	print_bt();
	exit();
}

class DebugOut
{

var $priorities = array(ABC_CRITICAL    => 'Критический',
                        ABC_ERROR       => 'Ошибка',
                        ABC_ALERT       => 'Предупреждение',
                        ABC_WARNING     => 'Внимание',
                        ABC_NOTICE      => 'Уведомление',
                        ABC_INFO        => 'Информация',
                        ABC_DEBUG       => 'Отладка',
                        ABC_TRACE       => 'Трассировка',
                        ABC_VAR_DUMP        => 'Дамп'
                        );
var $_ready = false;

var $_currentPriority = ABC_DEBUG;

var $_consumers = array();

var  $_filename;
var  $_fp;
var  $_logger_name;


 function DebugOut($name, $logger_name, $level ){
     $this->_filename = $name;
     $this->_currentPriority = $level;
     $this->_logger_name = $logger_name;
     if ($level > ABC_NO_LOG){
        $this->_openfile();
     }

     /*Регистрация деструктора*/
     register_shutdown_function(array($this,"close"));
 }



 function log($message, $priority = ABC_INFO) {
        // Прерывает обработку если $priority выше максимального уровня.
        if ($priority > $this->_currentPriority) {
            return false;
        }
        // Добавьте к массиву loglines
        return $this->_writeLine($message, $priority, strftime('%b %d %H:%M:%S'));
 }

 function dump($variable,$name) {
       $priority = ABC_VAR_DUMP;
       if ($priority > $this->_currentPriority ) {
            return false;
       }
       $time = strftime('%b %d %H:%M:%S');
       $message = var_export($variable,true);
       return fwrite($this->_fp,
                     sprintf("%s %s [%s] variable %s = %s \r\n",
                             $time,
                             $this->_logger_name,
                             $this->priorities[$priority],
                             $name,
                             $message)
                             );
 }

 function info($message) {
        return $this->log($message, ABC_INFO);
 }

 function debug($message) {
        return $this->log($message, ABC_DEBUG);
 }

 function notice($message) {
        return $this->log($message, ABC_NOTICE);
 }

 function warning($message) {
        return $this->log($message, ABC_WARNING);
 }

 function trace($message) {
        return $this->log($message, ABC_TRACE);
 }

 function error($message) {
        return $this->log($message, ABC_ERROR);
 }



 /**
  * Пишет линию в  logfile
  *
  * @param  string $line      Линия, чтобы писать
  * @param  integer $priority Приоритет этой линии / сообщения
  * @return integer           НЧисло записанных байтов или -1 если ошибка
  * @access private
  */
 function _writeLine($message, $priority, $time) {
    if( fwrite($this->_fp, sprintf("%s %s [%s] %s\r\n", $time, $this->_logger_name, $this->priorities[$priority], $message)) ) {
        return fflush($this->_fp);
    } else {
        return false;
    }
 }

 function _openfile() {
    if (($this->_fp = @fopen($this->_filename, 'a')) == false) {
        return false;
    }
        return true;
 }

 function close(){
    if($this->_currentPriority != ABC_NO_LOG){
        $this->info("Logger остановлен");
        return fclose($this->_fp);
    }
 }

 /*
  * Организаторские Функции.
  *
  */

 function Factory($name, $logger_name, $level) {
    $instance = new DebugOut($name, $logger_name, $level);
    return $instance;
 }


 function &getWriterSingleton($name, $logger_name, $level = ABC_DEBUG){

      static $instances;
      if (!isset($instances)){
        $instances = array();
      }
      $signature = serialize(array($name, $level));

      if (!isset($instances[$signature])) {
            $instances[$signature] = DebugOut::Factory($name, $logger_name, $level);
      }
      
      return $instances[$signature];
 }


 function attach(&$logObserver) {
    if (!is_object($logObserver)) {
        return false;
    }

    $logObserver->_listenerID = uniqid(rand());

    $this->_listeners[$logObserver->_listenerID] = &$logObserver;
 }

}

?>