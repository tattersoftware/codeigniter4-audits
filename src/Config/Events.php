<?php namespace Tatter\Audits\Config;

use CodeIgniter\Events\Events;

Events::on('post_system', function () {
	services('audits')->save();
});
