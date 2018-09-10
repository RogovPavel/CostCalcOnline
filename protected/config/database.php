<?php

// This is the database connection configuration.
return array(
//	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	
	'connectionString' => 'mysql:host=pasharle.beget.tech;dbname=pasharle_ls_sql',
	'emulatePrepare' => true,
	'username' => 'pasharle_ls_sql',
	'password' => 'd13f15ff',
	'charset' => 'utf8',
	
);