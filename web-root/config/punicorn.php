
# set port or socket to listen to
$this->listen(1337);

# set number of child processes that will accept/manage
# requests
$this->worker_processes(10);

# set the interval which master will check worker health
$this->health_check_interval(60);

# set web root
# root "/var/www/punicorn"
$this->root("/var/www/punicorn");