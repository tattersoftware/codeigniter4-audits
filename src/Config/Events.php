<?php

namespace Tatter\Audits\Config;

use CodeIgniter\Events\Events;

Events::on('post_system', static function () {
    service('audits')->save();
});
