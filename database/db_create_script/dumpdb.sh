# El archivo deberá ejecutarse desde la raíz del proyecto para que sirva
mysqldump -u golfuser --password="golfuser" --no-data golf > database/db_create_script/createdb.sql