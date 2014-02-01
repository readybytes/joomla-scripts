
Simple joomla srcipts to backup via phing.

Requirements:
1. Phing
2. PHP 5.3+ (Tested with 5.4)
3. AWS Account (if you would like to move backup to S3)
4. AWS PHP SDK : http://docs.aws.amazon.com/aws-sdk-php/guide/latest/installation.html#installing-via-phar 

Instructions:
1. Copy 'backup' folder to your server. (This folder should be outside your website folder)
2. Configure 'backup/global.prop', update variables as per your requirements All 'RBCONF_*' variable MUST be updated.
3. Backing up :
a. go to 'backup' folder
b. run command 'phing -f backup.xml backup'
4. Restoring backup
a. go to 'backup' folder
b. run command 'phing -f backup.xml recover -Drecover.date=2014-Feb-1.Sat.5-30'
c. Imp : This will overwrite without backing up the website. You should always backup before recovering.
