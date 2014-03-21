<?php
// 
$joomlaroot    = isset($argv[1]) ? $argv[1] : die("First argument required and it should be absolute-joomla-root-path");
$i=2;
$args = array();
while($i <= $argc){

	if(isset($argv[$i]) && isset($argv[$i+1])){
		$key    = $argv[$i];
		$value  = $argv[$i+1];
		//echo "\n found args [ $key |:::| $value]";
	}else{
		break;
	}
	$args[$key]=$value;
        $i+=2;
}

// for including files require it
define('JPATH_PLATFORM', 1) ;
define('JPATH_BASE', $joomlaroot);

require $joomlaroot.'/configuration.php';
require $joomlaroot.'/libraries/joomla/registry/format.php';
require $joomlaroot.'/libraries/joomla/registry/format/php.php';

// formatter
$formatter = new JRegistryFormatPHP();

//load prev config
$config = new JConfig();

// update new config

foreach($args as $k=>$v){
	if(isset($config->$k)){
		$config->$k = $v;
		echo " Updating [$k |:::| $v]";
	}else{
		echo " ERROR **** Invalid config [$k |:::| $v]";
	}
}

$params = array('class' => 'JConfig', 'closingtag' => false);
$str = $formatter->objectToString($config, $params);
// write new config
file_put_contents($joomlaroot.'/configuration.php', $str);

echo PHP_EOL;
