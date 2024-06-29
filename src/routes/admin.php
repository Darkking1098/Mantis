<?php

foreach (config('mantis.plugins') as $plugin)
    if (is_file($file = "{$plugin['path']}/routes/admin.php"))
        include_once $file;
