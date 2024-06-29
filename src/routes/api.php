<?php

foreach (config('mantis.plugins') as $plugin)
    if (is_file($file = "{$plugin['path']}/routes/api.php"))
        include_once $file;
