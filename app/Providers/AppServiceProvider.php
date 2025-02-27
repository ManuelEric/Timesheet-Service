<?php

namespace App\Providers;

use App\Services\ResponseService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /* swagger */
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /* pagination */
        Collection::macro('paginate', function ($perPage = 10, $page = null, $options = []) {
            $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
            $paginator = new LengthAwarePaginator(
                items: $this->forPage($page, $perPage),
                total: $this->count(),
                perPage: $perPage,
                currentPage: $page,
                options: $options
            );
    
            return $paginator->withPath(Request::url());
        });

        /* catch failed queue */
        // Queue::failing(function (JobFailed $event, ResponseService $responseService) {
        //     $responseService->storeErrorLog('Job failed!', $event->exception, [
        //         'queue' => $event->connectionName,
        //         'job' => $event->job
        //     ]);
        // });
    }
}
