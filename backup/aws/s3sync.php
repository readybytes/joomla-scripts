<?php

require 'AWSSDKforPHP/aws.phar';

$help_message="s3sync.php task[put/get/list] local-path s3-bucket-name remote-path";
// task           : PUT will push new data, GET will pull data from bucket
// local-path     : localpath to be synced e.g. /backup/site1/bk-1234
// s3-bucket-name : provide bucket name only e.g. backup_bucket
// remote-path    : provide a path in above bucket e.g. site1, so sync will be done

// === example === 
// s3sync.php PUT /backup/site1/bk-1234 backup_bucket site1

$task       = isset($argv[1]) ? $argv[1] : die($help_message); // PUT or GET 
$localpath  = isset($argv[2]) ? $argv[2] : die($help_message); // localpath to be synced e.g. /backup/site1/bk-1234

$bucket     = isset($argv[3]) ? $argv[3] : 'RBCONF_AWS_S3_BACKUP_BUCKET'; // provide bucket name only e.g. mybackups
$remotepath = isset($argv[4]) ? $argv[4] : 'RBCONF_AWS_S3_BACKUP_FOLDER'; // provide a path in above bucket e.g. site1, so sync will be done

$debug 	    = false;// enable debug mode

// get only folder-name from full local-path
$folderName = str_replace(dirname($localpath),'',$localpath);

// create remote-path
$keyPrefix = $remotepath.$folderName;

use Aws\S3\S3Client;

$client = S3Client::factory(array(
    'key'    => 'RBCONF_AWS_S3_ACCESS_KEY',
    'secret' => 'RBCONF_AWS_S3_SECRET_KEY'
));

// what to do
if(stristr($task,'put')){
	$client->uploadDirectory($localpath, $bucket, $keyPrefix, array(
	    'concurrency' => 20,
	    'debug'       => $debug
	));
}elseif(stristr($task,'get')){
	$client->downloadBucket($localpath, $bucket, $keyPrefix, array(
		 'concurrency' => 20,
		'debug'       => $debug,
		'base_dir'	=> $keyPrefix
	));
}
