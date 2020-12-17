<?php

declare(strict_types=1);

namespace Zitkala\LogViewer\Http\Routes;

use Zitkala\LogViewer\Http\Controllers\LogViewerController;
use Zitkala\Support\Routing\RouteRegistrar;

/**
 * Class     LogViewerRoute
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LogViewerRoute extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Map all routes.
     */
    public function map(): void
    {
        $attributes = (array) config('log-viewer2.route.attributes');

        $this->group($attributes, function() {
            $this->name('log-viewer2::')->group(function () {
                $this->get('/', [LogViewerController::class, 'index'])
                     ->name('dashboard'); // log-viewer2::dashboard

                $this->mapLogsRoutes();
            });
        });
    }

    /**
     * Map the logs routes.
     */
    private function mapLogsRoutes(): void
    {
        $this->prefix('logs')->name('logs.')->group(function() {
            $this->get('/', [LogViewerController::class, 'listLogs'])
                 ->name('list'); // log-viewer2::logs.list

            $this->delete('delete', [LogViewerController::class, 'delete'])
                 ->name('delete'); // log-viewer2::logs.delete

            $this->prefix('{date}')->group(function() {
                $this->get('/', [LogViewerController::class, 'show'])
                     ->name('show'); // log-viewer2::logs.show

                $this->get('download', [LogViewerController::class, 'download'])
                     ->name('download'); // log-viewer2::logs.download

                $this->get('{level}', [LogViewerController::class, 'showByLevel'])
                     ->name('filter'); // log-viewer2::logs.filter

                $this->get('{level}/search', [LogViewerController::class, 'search'])
                     ->name('search'); // log-viewer2::logs.search
            });
        });
    }
}
