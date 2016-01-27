server {
  listen 80;

  root /application/wordpress;
  index index.php index.html index.htm;

  server_name stateless.wordpress.com;

  access_log /var/log/nginx/access-$hostname.log;
  error_log /var/log/nginx/error-$hostname.log;

  location ~ \.php$ {
    fastcgi_pass localhost:9000;
    fastcgi_split_path_info ^(.+\.php)(/.*)$;
    fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
    fastcgi_buffer_size 4k;
    fastcgi_buffers 256 4k;
    fastcgi_max_temp_file_size 0;
    include fastcgi_params;
  }
}
