This is a Supinfo group project.
---
**Team members are :**

**M1 project campus Guadeloupe**

 * 124898 Jan Moritz LINDEMANN
 * 164271 Lionel CHRISTANVAL
 * 165003 Steeve BULGARE
 * 162095 Jérémy CETOUT
 * 164340 Mike ROUSSEAU

The project can be downloaded here :

 - https://github.com/rgex/cubbyhole-server/blob/master/M1%20-%20Cubbyhole.pdf?raw=true

Other related project repositories are :

 - https://github.com/rgex/cubbyhole-worker

 - https://github.com/rgex/cubbyhole-mobileclient

 - https://github.com/rgex/cubbyhole-java


Overview
---

**File manager**
![alt tag](https://raw.githubusercontent.com/rgex/cubbyhole-server/master/screenshots/file-manager.png)



**User stats**


![alt tag](https://raw.githubusercontent.com/rgex/cubbyhole-server/master/screenshots/user-start-page.png)



**Business dashboard**


![alt tag](https://raw.githubusercontent.com/rgex/cubbyhole-server/master/screenshots/business-dashboard.png)

Server Setup
---

**Install apache2, mysql-server, php5, git, php5-gd, php5-mysql, curl, php5-curl.**
```
apt-get install apache2 mysql-server php5 git php5-gd php5-mysql curl php5-curl 
```
Create the database with the sql file that you will find in the sql folder.

**Execute this command in order to activate the url rewriting.**
```
a2enmod rewrite
```
**Download the source codes from Github.**
```
cd /var/www/
git clone https://github.com/rgex/cubbyhole-server
cd /var/www/cubbyhole-server
cp vhosts/cubbyhole-server /etc/apache2/sites-enabled/
service apache2 restart
```
**Install vendor libraries with composer**
```
php composer.phar install
```
**You can also update them**
```
php composer.phar update
```
install the worker (https://github.com/rgex/cubbyhole-worker)

Connect you on the cubbyhole server as an administrator and add the worker in the manage worker tab.


**Update the server at any time by executing**
```
cd /var/www/cubbyhole-server
git pull
```
**If you want to display the maintenance page**
```
git checkout maintenance-page
```
**To show the site again**
```
git checkout master
```
