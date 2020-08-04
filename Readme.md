Apache config virtual host:

```
<VirtualHost *:80>
    ServerAdmin webmaster@test.com
    ServerName blog.local
    DocumentRoot "C:\www\blog.local\public"
    <Directory "C:\www\blog.local\public">
        Require all granted
        AllowOverride None
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-l
        RewriteRule ^(.*)$ index.php?url=$1 [QSA,L] 
    </Directory>
</VirtualHost>
```