# 環境構築手順書

*  **laravel_appをログインまでの９つのステップ**

### 1. Vagrantでの環境構築
### 2. パッケージインストール
### 3. PHP(version 7.3)インストール
### 4. Composerインストール
### 5. Laravelインストール
### 6. MySQL(version5.7)インストール
### 7. MYSQL接続
### 8. Nginxインストール
### 9. Laravel_appを動かす

## 条件

| <span style="color: red; ">Content</span>| <span style="color: red; ">Version</span>
| :---: | :---: |
| PHP| 7.3|
| MYSQL | 5.7 |
| Nginx | 1.19.9 |
| Laravel | 6.0 |
| OS | CentOS7|

## 1. Vagrantでの環境構築


*   ### VirtualBox installation
#### <u>Macの場合</u>
* `OS X hosts`を選択し, [Virtual Box Offical.](https://www.virtualbox.org/wiki/Download_Old_Builds_6_0)から<span style="color: red; ">ver6.0.14</span>をインストール。

* インストールできているか確認。

```$ virtualbox```

- [ ] インストールできていましたか？

* できていれば, `Control + c`で処理を止めましょう。


* ### Vagrantをインストール
#### <u>Macの場合</u>

`$ brew cask install vagrant`

* もし、エラーが出たら、下のコマンドを実行しましょう！

`$ brew install --cask vagrant`

* Vagrantインストール出来たか確認。

`$ vagrant -v`

- [ ] Vagrantインストールできましたか?

* ### Vagrant boxをインストール

* 今回はcentos/7を使用します。

`$ vagrant box add centos/7`

* 下のような画面が表示されるので３を選択します。

```
1) hyperv
2) libvirt
3) virtualbox
4) vmware_desktop

Enter your choice: 3
```

* Successfullyが表示されていれば、インストール出来ています。

```
Successfully added box 'centos/7' (v1902.01) for 'virtualbox'!
```

- [ ] Vagrant boxインストールしましたか？

* ### Vagrant directoryを準備

#### 1.  virtual_env_manual's directory作成

`$ mkdir virtual_env_manual`

#### 2. 作成したdirectoryに移動

`$ cd virtual_env_manual`
#### 3. 先ほどダウンロードしたVagrant boxを使用。

`$ vagrant init centos/7`

* 下のようにメッセージが表示されれば、okです。


```
A `Vagrantfile` has been placed in this directory. You are now
ready to `vagrant up` your first virtual environment! Please read
the comments in the Vagrantfile as well as documentation on
`vagrantup.com` for more information on using Vagrant.
```

* ### Vagrantfile変更

#### 1. Vagrantfileを開く

`$ vi Vagrantfile`

#### 2. コメントアウト.

```
config.vm.network "forwarded_port", guest: 80, host: 8080
```

#### 3. 変更(IP Address )

```
config.vm.network "private_network", ip:"192.168.33.19"
```

#### 4. 変更

```
config.vm.synced_folder "../data", "/vagrant_data"
```
⇩
```
config.vm.synced_folder "./", "/vagrant", type:"virtualbox"
```


* ### Vagrant pluginをインストール

* `vagrant-vbguest` を使用。

#### 1. Vagrant pluginをダウンロード

```
$ vagrant plugin install vagrant-vbguest --plugin-version 0.21
```

#### 2. インストールできたか確認

`$ vagrant plugin list`

* ### Saharaという便利なツールを使用。

#### 1. Saharaインストール

`$ vagrant plugin install sahara`

#### 2. Statusを確認

`$ vagrant sandbox status`
⇩
`[default] VM is not created`



* ### Vagrantを起動.

#### 1. Vagrantを起動

`$ vagrant up`

* ### Vagrant にログイン

#### 1. virtual_env_manual directoryに移動

`$ cd virtual_env_manual`

#### 2. Login vagrant

`$ vagrant ssh`

* 下のようにメッセージ表示されれば、ログイン出ています。

```
Welcome to your Vagrant-built virtual machine.
[vagrant@localhost ~]$
```
* 今は Guest Os または Host Os??

- [x] Guest Os
- [ ] Host Os

* ### Saharaを使用

#### 1. Statusを確認

`$ vagrant sandbox status`
⇩
`[default] Sandbox mode is off`

#### 2. Saharaを起動

`$ vagrant sandbox on`

⇩
```
[default] Starting sandbox mode...
0%...10%...20%...30%...40%...50%...60%...70%...80%...90%...100%
```

#### 3. 再度statusを確認
`$ vagrant sandbox status`

⇩

`[default] Sandbox mode is on`

#### 4. コミット
$ vagrant sandbox commit

*　もしrollbackしたいときはこのコマンドを使用

`$ vagrant sandbox rollback`

* 使用方法はこの記事を参照しましょう。 [Saharaの使い方](https://qiita.com/sudachi808/items/09cbd3dd1f5c25c23eaf)


## パッケージをインストール

`$ sudo yum -y groupinstall "development tools"`



## PHP(version 7.3)インストール

#### 1. epel-release wgetをインストール

`$ sudo yum -y install epel-release wget`


#### 2. Remi repository setting packegeをインストール

`$ sudo wget http://rpms.famillecollet.com/enterprise/remi-release-7.rpm`

#### 3. Remi's repositoryをインストール

`$ sudo rpm -Uvh remi-release-7.rpm`


#### 4. PHP & moduleをインストール

```
$ sudo yum -y install --enablerepo=remi-php73 php php-pdo php-mysqlnd php-mbstring php-xml php-fpm php-common php-devel php-mysql unzip
```

#### 5. PHP versionを確認
`$ php -v`

⇩
```
PHP 7.3.27 (cli) (built: Feb  2 2021 10:32:50) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.3.27, Copyright (c) 1998-2018 Zend Technologies
```

- [ ] PHP versioは7.3ですか??

#### 6.　Vagrantからログアウトして、saharaでコミット

```
$ exit
$ vagrant sandbox commit
```

## Composerをインストール

```
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
$ php composer-setup.php
$ php -r "unlink('composer-setup.php');"
$ sudo mv composer.phar /usr/local/bin/composer
```

* Composer versionを確認.

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
- [ ] Composerをインストールできましたか??

## laravelをインストール

* laravel versionoを指定

`$ composer create-project "laravel/laravel=6.* laravel_app" `

* Vagrantをログアウト

`$ exit`

* virtual_env_manua directory　に移動

`$ cd  virtual_env_manual`

* laravel_appをvirtual_env_manua directory以下にコピー

`$ cp -r laravel_app absolote path up to directory`

## MySQL(version5.7)をインストール

* Vagrant ログイン

`$ vagrant ssh`

* wget以下をインストール

`$ sudo wget https://dev.mysql.com/get/mysql57-community-release-el7-7.noarch.rpm`

* mysql57-community-release-el7-7.noarch.rpmをインストール

`$ sudo rpm -Uvh mysql57-community-release-el7-7.noarch.rpm`

* mysql-community-server(free)をインストール

`$ sudo yum install -y mysql-community-server`

* MYSQL versionを確認

`$ mysql --version`
⇩
`mysql  Ver 14.14 Distrib 5.7.33, for Linux (x86_64) using  EditLine wrapper`

- [ ] MYSQL(version5.7)をインストールできましたか？

## MYSQL接続

* MYSQL　スタート

`$ sudo systemctl start mysqld`

* root userでMYSQLに接続

`$ mysql -u root -p`

* 一時的にパスワードが発行

```
$sudo cat /var/log/mysqld.log | grep 'temporary password'
```

* 一時的なパスワードが表示

```
$ 2021-04-10T12:51:27.292428Z 1 [Note] A temporary password is generated for root@localhost: temporary password
```

* root userでMYSQLに接続

`$ mysql -u root -p`

* 一時的なパスワードを入力

`$ temporary password`

* パスワードは <span style="color: red; ">8文字以上</span> & <span style="color: red; ">大文字</span>、 <span style="color: red; ">小文字</span>、<span style="color: red; ">マーク記号</span>で設定

`mysql > set password = "New password";`

* MYSQLをログアウト

`mysql> exit`

* my.cnf fileを開く

`$ sudo vi /etc/my.cnf`

* 以下を追加

```
# abbreviation

[mysqld]

# abbreviation

# read_rnd_buffer_size = 2M
datadir=/var/lib/mysql
socket=/var/lib/mysql/mysql.sock

# この内容を追加
validate-password=OFF
```

* MYSQLリスタート

`$  sudo systemctl restart mysqld`

* root userでMYSQLに接続

`$ mysql -u root -p`

* MYSQL passwordを入力

`Enter password:`

* Databaseを作成

`mysql> create database laravel_app;`

* 127.0.0.1:9000からの外部アクセスを許可

```
mysql> GRANT ALL PRIVILEGES ON *.* TO root@"192.168.33.19" IDENTIFIED BY 'your MYSQL password' WITH GRANT OPTION;
```
* 127.0.0.1:9000からの外部アクセスが許可されているか確認

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

* MYSQLログアウト

`mysql> exit`

* Vagrantログアウト

`$ exit`

* laravel_app directoryに移動

`$ cd  laravel_app`

* .env fileを開く

`$ vi .env`

```
$ DB_PASSWORD=
# ↓ Add your MYSQL password
DB_PASSWORD= registerd password
```

* Saharaコミット

`$ vagrant sandbox commit`

## Nginxをインストール

* ファイルを作成

```
$ sudo vi /etc/yum.repos.d/nginx.repo
```

* 以下を追加

```
[nginx]
name=nginx repo
baseurl=https://nginx.org/packages/mainline/centos/\$releasever/\$basearch/
gpgcheck=0
enabled=1
```

* Nginxをインストール

`$ sudo yum install -y nginx`

* Nginx versionを確認

`$ nginx -v`

⇩

`nginx version: nginx/1.19.9`

- [ ] Nginxインストールできましたか?

* Nginxをスタート

`$ sudo systemctl start nginx`

*  Nginx statusを確認

`$ sudo systemctl status nginx`

⇩

```
Active: active (running) since Sun 2021-04-11 02:05:56 UTC; 1min 46s ago
```

- [ ] Nginxはactiveになっていますか?

## Work laravel

* default.conを編集

```
$ sudo vi /etc/nginx/conf.d/default.conf
```

```
server {
  listen       80;
  server_name  192.168.33.19; # 変更

  root /vagrant/laravel_app/public; # 追加
  index  index.html index.htm index.php; # 追加

  #charset koi8-r;
  #access_log  /var/log/nginx/host.access.log  main;

  location / {
      #root   /usr/share/nginx/html; # comment out
      #index  index.html index.htm;  # comment out
      try_files $uri $uri/ /index.php$is_args$args;  #追加
  }

  # abbre

  #  Make sure remove comment out {}

  location ~ \.php$ {
  #    root           html;
      fastcgi_pass   127.0.0.1:9000;
      fastcgi_index  index.php;
      fastcgi_param  SCRIPT_FILENAME /$document_root/$fastcgi_script_name;  #変更
      include        fastcgi_params;
  }
```

* php-fpmを変更

`$ sudo vi /etc/php-fpm.d/www.conf`

```
user = apache #変更
↓
user = vagrant

group = apache #変更
↓
group = vagrant
```
<span style="color: red; ">Notice:</span> <span style="color: black; "><u>ユーザー・グループがvagrantになっているか確認しましょう。出ないと、無限ループエラーに出くわすでしょう:smile:</u></span>

* Browserを開いた時にこのエラーが表示されれば、

```
 Forbidden 403
```
* config fileを開き、

`$ sudo vi /etc/selinux/config`

* 以下を変更しましょう。

```
# This file controls the state of SELinux on the system.
# SELINUX= can take one of these three values:
# enforcing - SELinux security policy is enforced.
# permissive - SELinux prints warnings instead of enforcing.
# disabled - No SELinux policy is loaded.
SELINUX=enforcing →　SELINUX=disabled　#変更
```

* Vagrantをログアウト

`$ exit`

* Vagrantをリロード

`$ vagrant reload`

* Vagrantにログイン

`$ vagrant ssh`

* Nginxをリスタート

`$ sudo systemctl restart nginx`

* もし、このエラーに遭遇した場合、

```
There is no existing directory at "/Users/hoge/workspace/SamplePrpject/storage/logs" and its not buildable: Permission denied
```
* 以下のコマンドでclearにしましょう。

```
$ exit
$ cd laravel_app
$ php artisan cache:clear
$ php artisan route:clear
$ php artisan config:clear
```

* もし、このエラーに遭遇した場合、

```
Illuminate\Database\QueryException  : SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo failed: Name or service not known (SQL: select * from information_schema.tables where table_schema = default and table_name = migrations)
```

* .envを開く

```
DB_CONNECTION=mysql
DB_HOST=192.168.33.19 #変更
DB_PORT=3306
DB_DATABASE=laravel_app #変更
DB_USERNAME=root
DB_PASSWORD= your MYSQL password #変更
```


* MYSQLログアウト

`$ exit`

* laravel_app directoryに移動

`$ cd laravel_app`

* マイグレーション

`$ php artisan migrate`


* もし、このエラーに遭遇した場合

```
The stream or file "/vagrant/laravel_app/storage/logs/laravel.log" could not be opened in append mode: failed to open stream: Permission denied
```
* 以下のコマンドを実行しましょう。

```
$ ls -la ./ | grep storage && ls -la storage/ | grep logs && ls -la storage/logs/ | grep laravel.log
```
* laravel_app directorに移動

`$ cd /vagrant/laravel_app`

* Nginxに権限を付与

`$ sudo chmod -R 777 storage`

* ブラウザーで419エラーがでた場合、

![](https://i.imgur.com/rxIPQwf.jpg)

* 以下にコマンドを実行しましょう。

```
1. Make sure you hard refresh the page; Clear the cache as well by doing:

$ php artisan cache:clear

2. Make sure you have the right permissions for your logs folder:

$ chmod -R 755 storage/logs

3. Make sure to generate a key for your application:

$ php artisan key:generate
```

## チェックリスト

- [ ] Vagrantを使用しましたか?
- [ ] Ipは192.168.33.19ですか?
- [ ] OSはCentOS7ですか?
- [ ] MySQL version 5.7ですか?
- [ ] Nginxを使用しましたか?
- [ ] PHP version 7.3ですか?
- [ ] Laravel version 6.ですか?

### 参照サイト

* [VagrantにSaharaを導入](https://qiita.com/sudachi808/items/09cbd3dd1f5c25c23eaf)
* [Vagrant upでboxから生成時にエラー【umount /mnt】](https://nakox.jp/web/coding/vagrant_error_umount)
* [Laravelの「There is no existing directory at "/Users/hoge/workspace/SamplePrpject/storage/logs" 」の解決方法](https://qiita.com/phper_sugiyama/items/ae308c2a61aa3dbc3bf3)
* [【Nginxエラー解決】Job for nginx.service failed because the control process exited with error code.](https://qiita.com/naota7118/items/4fe2578fec561795a960)
* [脱初心者を目指すなら知っておきたい便利なVimコマンド25選](https://qiita.com/jnchito/items/57ffda5712636a9a1e62)
* [laravel 5.7.15 419 Sorry, your session has expired. Please refresh and try again](https://stackoverflow.com/questions/53609222/laravel-5-7-15-419-sorry-your-session-has-expired-please-refresh-and-try-again)
* [Laravel】Laravelでバージョンを指定してインストールする方法](https://menta.work/post/detail/6134/IASoDSA5TqR7e5YFlm9w)
* [Markdown記法/書き方（見出し・表・リンク・画像・文字色など](https://notepm.jp/help/how-to-markdown)