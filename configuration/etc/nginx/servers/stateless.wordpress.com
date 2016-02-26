server {
  listen 80;
  server_name stateless.wordpress.com;

  root /application/wordpress;
  index index.php;

  access_log /var/log/nginx/access-stateless.wordpress.com.log;
  error_log /var/log/nginx/error-stateless.wordpress.com.log;

  location ~ \.php$ {
    fastcgi_pass localhost:1337;
    fastcgi_split_path_info ^(.+\.php)(/.*)$;
    fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
    fastcgi_buffer_size 4k;
    fastcgi_buffers 256 4k;
    fastcgi_max_temp_file_size 0;
    include fastcgi_params;
  }
}
