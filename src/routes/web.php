<?php

foreach (config('mantis.plugins') as $plugin)
    if (is_file($file = "{$plugin['path']}/routes/web.php"))
        include_once $file;
