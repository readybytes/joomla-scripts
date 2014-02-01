<?php

require 'AWSSDKforPHP/aws.phar';

$help_message = "call this script as s3put.php \n ABS-LOCAL-PATH(e.g. /tmp/backup.tgz) \n BUCKET-NAME(e.g. [readybytes]) \n S3-FILE-PATH(e.g. backup/jpayplans.com/x.tar.gz) "; 

$localfile = isset($argv[1]) ? $argv[1] : die($help_message);
$bucket    = isset($argv[2]) ? $argv[2] : die($help_message);
$s3path    = isset($argv[3]) ? $argv[3] : die($help_message);

use Aws\S3\S3Client;

$client = S3Client::factory(array(
    'key'    => 'RBCONF_AWS_S3_ACCESS_KEY',
    'secret' => 'RBCONF_AWS_S3_SECRET_KEY'
));

// Upload an object by streaming the contents of a file
// $pathToFile should be absolute path to a file on disk
$result = $client->putObject(array(
    'Bucket'     => $bucket,
    'Key'        => $s3path,
    'SourceFile' => $localfile
));

// We can poll the object until it is accessible
$client->waitUntilObjectExists(array(
    'Bucket' => $bucket,
    'Key'    => $s3path
));
