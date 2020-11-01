CREATE USER 'actuary'@'%' IDENTIFIED BY 'SuperSecretDeveloper';
CREATE DATABASE IF NOT EXISTS `actuary`;
GRANT ALL PRIVILEGES ON `actuary`.* TO 'actuary'@'%';GRANT ALL PRIVILEGES ON `actuary\_%`.* TO 'actuary'@'%';
flush privileges;
