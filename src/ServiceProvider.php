<?php

namespace Xolvio\TruckvisionApi;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public function register()
    {/*
        $this->mergeConfigFrom( __DIR__ . '/../config/gitlab-report.php', 'gitlab-report');

        $this->app->singleton(GitlabReportService::class, function(Container $app) {
            return new GitlabReportService($url, $token, $project_id, $labels);
        });

        $this->app->alias(GitlabReportService::class, 'gitlab.report');*/
    }

    public function provides()
    {
//        return ['gitlab.report', GitlabReportService::class];
    }
}