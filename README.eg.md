# Manual: how to build

*  **This is 9 processes you need to go through**

### 1. Build an vagrant internet environment
### 2. Install package
### 3. Install PHP(version 7.3)
### 4. Install composer
### 5. Install laravel
### 6. Install MySQL(version5.7)
### 7. Connect MYSQL
### 8. Install a nginx
### 9. Work laravel

## Conditions

| <span style="color: red; ">Content</span>| <span style="color: red; ">Version</span>
| :---: | :---: |
| PHP| 7.3|
| MYSQL | 5.7 |
| Nginx | 1.19.9 |
| Laravel | 6.0 |
| OS | CentOS7|

## 1. Build an vagrant internet environment


*   ### VirtualBox installation
#### <u>Mac</u>
* Choose **`OS X hosts`**, install **<span style="color: red; ">ver6.0.14</span>** from [Virtual Box Offical.](https://www.virtualbox.org/wiki/Download_Old_Builds_6_0)

* Make sure whether install properly or not, using under the command.

```$ virtualbox```
- [ ] Did VirtualBox's window display？
* If you varify, stop processing, typing `Control + c`
* ### Vagrant installation
#### <u>Mac</u>
`$ brew cask install vagrant`
* if it arises a error, implement this command.
`$ brew install --cask vagrant`
* make sure whether install properly or not, using this command.
`$ vagrant -v`
- [ ] Did you install Vagrant, typing the command?
* ### Vagrant box installation
* Designate Linux CentOS version7 box name centos/7 this time.
`$ vagrant box add centos/7`
* Be displayed four options on the screen and choose number 3 when you implemented.
```
1) hyperv
2) libvirt
3) virtualbox
4) vmware_desktop

Enter your choice: 3
```
* If you see under the display, you're succssful to downroad
```
Successfully added box 'centos/7' (v1902.01) for 'virtualbox'!
```
- [ ] Did you install Vagrant box？
<span style="color: red; ">Notice:</span> <span style="color: black; "><u>We can build an internet environment as much as we want :smile:</u></span>
* ### Prepare vagrant directory
#### 1. Create virtual_env_manual's directory.
`$ mkdir virtual_env_manual`
#### 2. Move the directory that you made.
`$ cd virtual_env_manual`
#### 3. Use vagrant box you downroaded just now.
`$ vagrant init centos/7`
* If you saw this message, you got to downroad properly.
```
A `Vagrantfile` has been placed in this directory. You are now
ready to `vagrant up` your first virtual environment! Please read
the comments in the Vagrantfile as well as documentation on
`vagrantup.com` for more information on using Vagrant.
```
* ### Edit vagrantfile
#### 1. Open vagrantfile.
`$ vi Vagrantfile`
#### 2. Comment out.
```
config.vm.network "forwarded_port", guest: 80, host: 8080
```
#### 3. Edit a content(IP Address )
```
config.vm.network "private_network", ip:"192.168.33.19"
```
#### 4. Edit a content.
```
config.vm.synced_folder "../data", "/vagrant_data"
```
⇩
```
config.vm.synced_folder "./", "/vagrant", type:"virtualbox"
```
* ### Vagrant plugin installation
* We're using `vagrant-vbguest` plugin this time.
#### 1. Install vagrant plugin.
```
$ vagrant plugin install vagrant-vbguest --plugin-version 0.21
```
#### 2. Make sure whether install properly or not.
`$ vagrant plugin list`
* ### Install useful tool Sahara.
#### 1. Install Sahara.
`$ vagrant plugin install sahara`
#### 2. Make sure a status.
`$ vagrant sandbox status`
⇩
`[default] VM is not created`
* ### Activate vagrant.
#### 1. Activate vagrant
`$ vagrant up`
* ### Login vagrant.
#### 1. Move vagrant directory
`$ cd virtual_env_manual`
#### 2. Login vagrant
`$ vagrant ssh`
* if you saw this message, you could login properly.
```
Welcome to your Vagrant-built virtual machine.
[vagrant@localhost ~]$
```
* Are you Guest Os or Host Os??
- [x] Guest Os
- [ ] Host Os
* ### Usage Sahara
#### 1. Make sure a status
`$ vagrant sandbox status`
⇩
`[default] Sandbox mode is off`
#### 2. Turn on sahara
`$ vagrant sandbox on`
⇩
```
[default] Starting sandbox mode...
0%...10%...20%...30%...40%...50%...60%...70%...80%...90%...100%
```
#### 3. Verity a status again
`$ vagrant sandbox status`
⇩
`[default] Sandbox mode is on`
#### 4. Commit
$ vagrant sandbox commit
* If you want to back, logout  and implement rollback command.
`$ vagrant sandbox rollback`
* Refer to this article [How to use sahara](https://qiita.com/sudachi808/items/09cbd3dd1f5c25c23eaf).
## Install package
`$ sudo yum -y groupinstall "development tools"`
## Install PHP(version 7.3)
#### 1. Install epel-release wget
`$ sudo yum -y install epel-release wget`
#### 2. Install Remi repository Setting packege
`$ sudo wget http://rpms.famillecollet.com/enterprise/remi-release-7.rpm`
#### 3. Install Remi's repository
`$ sudo rpm -Uvh remi-release-7.rpm`
#### 4. Install PHP & module
```
$ sudo yum -y install --enablerepo=remi-php73 php php-pdo php-mysqlnd php-mbstring php-xml php-fpm php-common php-devel php-mysql unzip
```
#### 5. Verity php version
`$ php -v`
⇩
```
PHP 7.3.27 (cli) (built: Feb  2 2021 10:32:50) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.3.27, Copyright (c) 1998-2018 Zend Technologies
```
- [ ] Is php version 7.3??
#### 6. Exit & sahara commit
```
$ exit
$ vagrant sandbox commit
```
## Install composer
```
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
$ php composer-setup.php
$ php -r "unlink('composer-setup.php');"
$ sudo mv composer.phar /usr/local/bin/composer
```
* Verity composer version.
`$ composer -v`
⇩
```______
  / ____/___  ____ ___  ____  ____  ________  _____
 / /   / __ \/ __ `__ \/ __ \/ __ \/ ___/ _ \/ ___/
/ /___/ /_/ / / / / / / /_/ / /_/ (__  )  __/ /
\____/\____/_/ /_/ /_/ .___/\____/____/\___/_/
                    /_/
Composer version 2.0.12 2021-04-01 10:14:59
```
- [ ] Did you install composer??

## Install laravel

`$ composer create-project "laravel/laravel=6.* laravel_app" `

* Copy laravel application
* Exit vagrant.

`$ exit`

* Move virtual_env_manua directory.

`$ cd  virtual_env_manual`

* Copy laravel_app in virtual_env_manual directory

`$ cp -r laravel_app absolote path up to directory`

## InstallMySQL(version5.7)

* Login vagrant

`$ vagrant ssh`

* Install under the wget

`$ sudo wget https://dev.mysql.com/get/mysql57-community-release-el7-7.noarch.rpm`

* install mysql57-community-release-el7-7.noarch.rpm

`$ sudo rpm -Uvh mysql57-community-release-el7-7.noarch.rpm`

* Install mysql-community-server(free)

`$ sudo yum install -y mysql-community-server`

* Verify MYSQL versiono

`$ mysql --version`
⇩
`mysql  Ver 14.14 Distrib 5.7.33, for Linux (x86_64) using  EditLine wrapper`

- [ ] Did you install MYSQL(version5.7)

## Connect MYSQL

* Start MYSQL.

`$ sudo systemctl start mysqld`

* Connect MYSQL as root user.

`$ mysql -u root -p`

* Display temporary password in mysqld.log.

```
$sudo cat /var/log/mysqld.log | grep 'temporary password'
```

* Be displayed temporary password.

```
$ 2021-04-10T12:51:27.292428Z 1 [Note] A temporary password is generated for root@localhost: temporary password
```

* Connect MYSQL as root user.

`$ mysql -u root -p`

* Type MYSQL password that you create.

`$ temporary password`

* You need to set password at least <span style="color: red; ">8 letters</span> &  use <span style="color: red; ">capital</span>, <span style="color: red; ">lower case letters</span> as well as <span style="color: red; ">symbol</span>

`mysql > set password = "New password";`

* Exit MYSQL.

`mysql> exit`

* Open my.cnf file.

`$ sudo vi /etc/my.cnf`

* Add this sentence.

```
# abbreviation
[mysqld]
# abbreviation
# read_rnd_buffer_size = 2M
datadir=/var/lib/mysql
socket=/var/lib/mysql/mysql.sock
# add this sentence
validate-password=OFF
```

* Restart MYSQL.

`$  sudo systemctl restart mysqld`

* Connect MYSQL as root user.

`$ mysql -u root -p`

* Type your MYSQL password.

`Enter password:`

* Create database.

`mysql> create database laravel_app;`

* Allow to connect from outside access.127.0.0.1:9000

```
mysql> GRANT ALL PRIVILEGES ON *.* TO root@"192.168.33.19" IDENTIFIED BY 'your MYSQL password' WITH GRANT OPTION;
```
* Verity a root user to allow from ip address.

```
mysql> select user, host from mysql.user;
```

⇩

```
 user              | host            |
+-------------------+-----------------+
| root              | 192.168.33.19   |
| mysql.session     | localhost       |
| mysql.sys         | localhost       |
| root              | localhost
```

* Exit MYSQL.

`mysql> exit`

* Exit vagrant.

`$ exit`

* Move laravel_app directory.

`$ cd  laravel_app`

* Edit .env file.

`$ vi .env`

```
$ DB_PASSWORD=
# ↓ Add your MYSQL password
DB_PASSWORD= registerd password
```

* Commit Sahara.

`$ vagrant sandbox commit`

## Install a nginx

* Create a file, using vim.

`$ sudo vi /etc/yum.repos.d/nginx.repo`

* Add these sentence.

```
[nginx]
name=nginx repo
baseurl=https://nginx.org/packages/mainline/centos/\$releasever/\$basearch/
gpgcheck=0
enabled=1
```

* Install nginx.

`$ sudo yum install -y nginx`

* Verity nginx version.

`$ nginx -v`

⇩

`nginx version: nginx/1.19.9`

- [ ] Did you install a nginx properly?

* Start nginx.

`$ sudo systemctl start nginx`

* Verity whether nginx is working or not.

`$ sudo systemctl status nginx`

⇩

```
Active: active (running) since Sun 2021-04-11 02:05:56 UTC; 1min 46s ago
```

- [ ] Is the nginx active?

## Work laravel

* Edit a default.con.

```
$ sudo vi /etc/nginx/conf.d/default.conf
```

```
server {
  listen       80;
  server_name  192.168.33.19; # change
  root /vagrant/laravel_app/public; # add
  index  index.html index.htm index.php; # add
  #charset koi8-r;
  #access_log  /var/log/nginx/host.access.log  main;
  location / {
      #root   /usr/share/nginx/html; # comment out
      #index  index.html index.htm;  # comment out
      try_files $uri $uri/ /index.php$is_args$args;  #add
  }
  # abbre
  #  Make sure remove comment out {}
  location ~ \.php$ {
  #    root           html;
      fastcgi_pass   127.0.0.1:9000;
      fastcgi_index  index.php;
      fastcgi_param  SCRIPT_FILENAME /$document_root/$fastcgi_script_name;  #change
      include        fastcgi_params;
  }
```

* Edit php-fpm.

`$ sudo vi /etc/php-fpm.d/www.conf`

```
user = apache #change
↓
user = vagrant
group = apache #change
↓
group = vagrant
```
<span style="color: red; ">Notice:</span> <span style="color: black; "><u>Make sure user = authority, this time is user. Otherwise you would encounter perpetual error like me :smile:</u></span>

* If you encoutered this error, when you open a browser.

```
 Forbidden 403
```
* Open a config file and .

`$ sudo vi /etc/selinux/config`

* Change this sentence.

```
# This file controls the state of SELinux on the system.
# SELINUX= can take one of these three values:
# enforcing - SELinux security policy is enforced.
# permissive - SELinux prints warnings instead of enforcing.
# disabled - No SELinux policy is loaded.
SELINUX=enforcing →　SELINUX=disabled　#change
```

* Exit vagrant.

`$ exit`

* Reload vagrant.

`$ vagrant reload`

* Login vagrant.

`$ vagrant ssh`

* Restart a nginx.

`$ sudo systemctl restart nginx`

* If you encoutered this error,

```
There is no existing directory at "/Users/hoge/workspace/SamplePrpject/storage/logs" and its not buildable: Permission denied
```
* Implement these commands.

```
$ exit
$ cd laravel_app
$ php artisan cache:clear
$ php artisan route:clear
$ php artisan config:clear
```

* If you encoutered this error,

```
Illuminate\Database\QueryException  : SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo failed: Name or service not known (SQL: select * from information_schema.tables where table_schema = default and table_name = migrations)
```

* Open .env

```
DB_CONNECTION=mysql
DB_HOST=192.168.33.19 #change
DB_PORT=3306
DB_DATABASE=laravel_app #change
DB_USERNAME=root
DB_PASSWORD= your MYSQL password #change
```


* Exit MYSQL.

`$ exit`

* move laravel_app directory.

`$ cd laravel_app`

* Migration.

`$ php artisan migrate`


* If you encountered this error,

```
The stream or file "/vagrant/laravel_app/storage/logs/laravel.log" could not be opened in append mode: failed to open stream: Permission denied
```
* Implement this command.

```
$ ls -la ./ | grep storage && ls -la storage/ | grep logs && ls -la storage/logs/ | grep laravel.log
```
* Move laravel_app directory.

`$ cd /vagrant/laravel_app`

* Give a nginx authority to login.

`$ sudo chmod -R 777 storage`

* If this error displayes your browser,

![](https://i.imgur.com/rxIPQwf.jpg)

* Try these commands.

```
1. Make sure you hard refresh the page; Clear the cache as well by doing:
$ php artisan cache:clear
2. Make sure you have the right permissions for your logs folder:
$ chmod -R 755 storage/logs
3. Make sure to generate a key for your application:
$ php artisan key:generate
```

```
file_put_contents(/vagrant/laravel_app/storage/framework/sessions/4Gq0Fyg26Om3bsEC6edfCzBiErTWg4KPMoLxwJnO): failed to open stream: Permission denied
```

## Check List

- [ ] Did you use vagrant?
- [ ] Did you set up ip 192.168.33.19?
- [ ] IS OS CentOS7?
- [ ] Is MySQL version 5.7?

- [ ] Did you use Nginx?
- [ ] Is php version 7.3?
- [ ] Is laravel version 6.?

### Reference

* [VagrantにSaharaを導入](https://qiita.com/sudachi808/items/09cbd3dd1f5c25c23eaf)
* [Vagrant upでboxから生成時にエラー【umount /mnt】](https://nakox.jp/web/coding/vagrant_error_umount)
* [Laravelの「There is no existing directory at "/Users/hoge/workspace/SamplePrpject/storage/logs" 」の解決方法](https://qiita.com/phper_sugiyama/items/ae308c2a61aa3dbc3bf3)
* [【Nginxエラー解決】Job for nginx.service failed because the control process exited with error code.](https://qiita.com/naota7118/items/4fe2578fec561795a960)
* [脱初心者を目指すなら知っておきたい便利なVimコマンド25選](https://qiita.com/jnchito/items/57ffda5712636a9a1e62)
* [laravel 5.7.15 419 Sorry, your session has expired. Please refresh and try again](https://stackoverflow.com/questions/53609222/laravel-5-7-15-419-sorry-your-session-has-expired-please-refresh-and-try-again)
* [Laravel】Laravelでバージョンを指定してインストールする方法](https://menta.work/post/detail/6134/IASoDSA5TqR7e5YFlm9w)
* [Markdown記法/書き方（見出し・表・リンク・画像・文字色など](https://notepm.jp/help/how-to-markdown)