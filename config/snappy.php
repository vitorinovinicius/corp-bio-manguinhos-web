<?php

return array(

    'pdf' => array(
        'enabled' => true,
        'binary'  => env("SNAPPY_ENV") == "local" ? '"C:\wkhtmltopdf\bin\wkhtmltopdf.exe"' : 'xvfb-run wkhtmltopdf',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => env("SNAPPY_ENV") == "local" ? '"C:\wkhtmltopdf\bin\wkhtmltoimage.exe"' : 'xvfb-run wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),

);
