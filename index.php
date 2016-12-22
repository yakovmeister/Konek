<?php

require('vendor/autoload.php');

use Yakovmeister\Konek\Database\DB;


var_dump(DB::instance("users")->all());