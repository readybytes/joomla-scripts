<?php

require 'AWSSDKforPHP/aws.phar';

$help_message = "call this script as s3get.php BUCKET-NAME(e.g. [readybytes]) S3-FILE-PATH(e.g. backup/jpayplans.com/x.tar.gz) LOCAL-PATH(e.g. /tmp/backup.tgz)"; 

$bucket    = isset($argv[1]) ? $argv[1] : die($help_message);
$s3file    = isset($argv[2]) ? $argv[2] : die($help_message);
$localfile = isset($argv[3]) ? $argv[3] : die($help_message);

use Aws\S3\S3Client;

$client = S3Client::factory(array(
    'key'    => 'RBCONF_AWS_S3_ACCESS_KEY',
    'secret' => 'RBCONF_AWS_S3_SECRET_KEY'
));

$result = $client->getObject(array(
    'Bucket' => $bucket,
    'Key'    => $s3file,
    'SaveAs' => $localfile
));
