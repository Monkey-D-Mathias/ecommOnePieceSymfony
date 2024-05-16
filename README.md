# ecommOnePieceSymfony





# Mettre à jour le WSL on Windows
wsl --update

# Install Ubuntu on WSL 
wsl --install -d Ubuntu

# Open a terminal in Ubuntu & create a folder then use command for dezip docker of teacher
git clone https://github.com/sprintcube/docker-compose-lamp.git .

# Copy and paste docker-compose.yaml

# Copy paste and rename file sample.env to .env and add lines below with ###

### If you already have the port 8025 in use, you can change it (for example if you have MailHog)
HOST_MACHINE_MH_HTTP_PORT=8025
 
### If you already have the port 1025 in use, you can change it (for example if you have MailHog)
HOST_MACHINE_MH_SMTP_PORT=1025

# Change the php version in .env 
PHPVERSION=php81

# Change the APACHE_DOCUMENT_ROOT into your .env to add /public in the end
APACHE_DOCUMENT_ROOT=/var/www/html to => APACHE_DOCUMENT_ROOT=/var/www/html/public


# Modify file .bashrc 
nano ~/.bashrc

# Add lines below into your file bashrc
### export GUID to ID to docker
GID=$(id -g)

export UID
export GID

# Save your modification into .bachrc
source ~/.bashrc


# Recuperer le docker du prof puis le dezipper dans un dossier

# Command for dezip a folder in Linux Ubuntu
unzip nomDuDossierADecompresser.zip .

# Copy sample.env and rename in .env & add this
HOST_MACHINE_MH_HTTP_PORT=8025

# Access to container specially
docker-exec -ti nomDuContainer(ex: lamps-php) bash


# Configure Shared 
# Add in .env docker under PHPVERSION
SHARED_DIRECTORY=./shared

# Add in docker-compose.yaml in services section volume
- ${SHARED_DIRECTORY-./shared}:/var/www/shared:rw

# And don't forget to delete all container and images and rebuild all 


# When you have this error in your docker => the container mysql8 restart 
# Go to the file in bin/mysql8/dockerFile and the code below
FROM mysql:8
RUN echo "[mysqld]" >> /etc/mysql/my.cnf
RUN echo "mysql_native_password=ON" >> /etc/mysql/my.cnf
# After that you need to delete all in your directory data/mysql (commande sudo rm -r /chemin/du/dossier)


# When you have this error in your docker => the container mysql8 restart 
# Go to the file in bin/mysql8/dockerFile and the code below
FROM mysql:8
RUN echo "[mysqld]" >> /etc/mysql/my.cnf
RUN echo "mysql_native_password=ON" >> /etc/mysql/my.cnf
# After that you need to delete all in your directory data/mysql (commande sudo rm -r /chemin/du/dossier)

# GitHub command

# Commit and add all files 

git commit -am nomDeLaBranche

# Push Commit

git push origin nomDeLaBranche

