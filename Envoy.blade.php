<?php
@include('vendor/autoload.php')
@import('package/Envoy.blade.php')

@setup
    $now = new DateTime();
    $environment = isset($env) ? $env : "testing";
@endsetup

@servers(['web' => ['user@192.168.1.1']])
@servers(['localhost' => '127.0.0.1'])

@task('foo', ['on' => 'web'])
    ls -la

@endtask


//运行时，传递变量：envoy run deploy --branch=master

@servers(['web' => '192.168.1.1'])

@task('deploy', ['on' => 'web'])
    cd site
    @if ($branch)
        git pull origin {{ $branch }}
    @endif

    php artisan migrate
@endtask
