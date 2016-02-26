server {  
  listen 80;
  server_name stateful.wordpress.com;
  
  access_log /var/log/nginx/access-stateful.wordpress.com.log;
  error_log /var/log/nginx/error-stateful.wordpress.com.log;

  location / {
    try_files $uri $uri/ /index.php;
    proxy_set_header Host $host;
    proxy_pass http://127.0.0.1:1337$request_uri;
  }  
}
