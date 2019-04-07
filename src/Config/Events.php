<?php namespace Tatter\Audits\Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Config\Services;

Events::on('post_system', function () {
	Services::audits()->save();
});