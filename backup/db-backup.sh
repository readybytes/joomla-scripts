#!/bin/bash
adminuser='ROOT_USERNAME'
adminpwd='ROOT_PASSWORD'
ds=`date '+%Y-%d%b-%H:%M'`
db_name='RBCONF_MYSQL_DB_NAME'
dbfile="db-${ds}"
backup_storage='/backup/storage'
aws_scripts='/backup/aws'
AWS_S3_BACKUP_BUCKET='backups'
AWS_S3_BACKUP_FOLDER='site1/dbonly/'

# dump a new db backup
echo "backing up ..."
mysqldump --add-drop-table -h localhost -u ${adminuser} --password="${adminpwd}" ${db_name} > ${backup_storage}/${dbfile}

# compress file
echo "Compressing file"
file="${dbfile}.tar.gz"
cd ${backup_storage}
tar -czf ./${file} ./${dbfile}

#move to s3
echo "moving to s3 ..."
sudo php ${aws_scripts}/s3put.php ${backup_storage}/${file} ${AWS_S3_BACKUP_BUCKET} ${AWS_S3_BACKUP_FOLDER}/${file}

echo "removing local files ..."
sudo rm -f ${backup_storage}/${dbfile} ${backup_storage}/${file}
echo "done."
