- Pull the project from git provider `git clone https://github.com/nahapet93/apple-tree.git`
- Open the console and cd to your project root directory
- Run `php init`
- Run `composer install`
- Create a DB
- Set DB name and parameters in `common/config/main-local.php`
- Run `php yii migrate`
- Put this in apache vhosts configuration file (`C:\XAMPP\apache\conf\extra\httpd-vhosts.conf` for Windows, `/opt/lampp/etc/extra/httpd-vhosts.conf` for Linux)
```
<VirtualHost *:80>
	ServerName frontend.loc
	DocumentRoot "C:/xampp/htdocs/apple-tree/frontend/web/"
	   
	<Directory "C:/xampp/htdocs/apple-tree/frontend/web/">
		# use mod_rewrite for pretty URL support
		RewriteEngine on
		# If a directory or a file exists, use the request directly
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteCond %{REQUEST_FILENAME} !-d
		# Otherwise forward the request to index.php
		RewriteRule . index.php

		# use index.php as index file
		DirectoryIndex index.php

		# ...other settings...
		# Apache 2.4
		Require all granted
		   
		## Apache 2.2
		# Order allow,deny
		# Allow from all
	</Directory>
</VirtualHost>
   
<VirtualHost *:80>
	ServerName backend.loc
	DocumentRoot "C:/xampp/htdocs/apple-tree/backend/web/"
	   
	<Directory "C:/xampp/htdocs/apple-tree/backend/web/">
		# use mod_rewrite for pretty URL support
		RewriteEngine on
		# If a directory or a file exists, use the request directly
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteCond %{REQUEST_FILENAME} !-d
		# Otherwise forward the request to index.php
		RewriteRule . index.php

		# use index.php as index file
		DirectoryIndex index.php

		# ...other settings...
		# Apache 2.4
		Require all granted
		   
		## Apache 2.2
		# Order allow,deny
		# Allow from all
	</Directory>
</VirtualHost>
```
- Put this in hosts file (`C:\Windows\System32\Drivers\etc\hosts` for Windows, `/etc/hosts` for Linux)
```
127.0.0.1   frontend.loc
127.0.0.1   backend.loc
```
- Go to http://frontend.loc/site/signup in the browser
- Create a user
- Change the status from `9` to `10` in the `users` table
- Log in with created user credentials