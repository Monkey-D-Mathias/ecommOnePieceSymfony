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




# GitHub command

# Commit and add all files 

git commit -am nomDeLaBranche

# Push Commit

git push origin nomDeLaBranche

