<?php

define('BASE_PATH', dirname(realpath(__FILE__)) . '/../');
define('UPLOAD_PATH', dirname(realpath(__FILE__)) . '/../uploads/');
define('UPLOAD_URL', 'uploads/');
define('AWS_BUCKET', 'reddittv');
define('USE_SQLITE', false);

// Since user auth is done via .htpasswd, there's no need to support per-user 
// CSRF tokens. Replace this when / if user auth gets added to admin panel.
define('CSRF_TOKEN', 'REPLACE_ME');

// Include RedbeanPHP
require_once(dirname(__FILE__).'/rb.php');

if (USE_SQLITE) {
	// SQLite Setup
	R::setup('sqlite:'.realpath(dirname(__FILE__)).'/database.s3db');
} else {
	// MySQL Setup
	$dbhost = '127.0.0.1';
	$dbport = '3306';
	$dbname = 'reddittv';

	$username = 'reddittv';
	$password = getenv('DB_PASS');

	R::setup("mysql:host=$dbhost;port=$dbport;
		dbname=$dbname",$username,$password);
}

// Free db from schema changes
R::freeze(true);

if(class_exists('Memcache')){
	// Connection constants
	define('MEMCACHED_HOST', '127.0.0.1');
	define('MEMCACHED_PORT', '3306');
	 
	// Connection creation
	$memcache = new Memcache;
	$cacheAvailable = $memcache->connect(MEMCACHED_HOST, MEMCACHED_PORT);
} else {
	$cacheAvailable = false;
}

?>