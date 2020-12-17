<?php

declare(strict_types=1);

namespace Zitkala\LogViewer\Providers;

use Zitkala\LogViewer\Contracts\LogViewer as LogViewerContract;
use Zitkala\LogViewer\Contracts\Utilities\Factory as FactoryContract;
use Zitkala\LogViewer\Contracts\Utilities\Filesystem as FilesystemContract;
use Zitkala\LogViewer\Contracts\Utilities\LogChecker as LogCheckerContract;
use Zitkala\LogViewer\Contracts\Utilities\LogLevels as LogLevelsContract;
use Zitkala\LogViewer\Contracts\Utilities\LogMenu as LogMenuContract;
use Zitkala\LogViewer\Contracts\Utilities\LogStyler as LogStylerContract;
use Zitkala\LogViewer\LogViewer;
use Zitkala\LogViewer\Utilities;
use Zitkala\Support\Providers\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class     DeferredServicesProvider
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DeferredServicesProvider extends ServiceProvider implements DeferrableProvider
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerLogViewer();
        $this->registerLogLevels();
        $this->registerStyler();
        $this->registerLogMenu();
        $this->registerFilesystem();
        $this->registerFactory();
        $this->registerChecker();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            LogViewerContract::class,
            LogLevelsContract::class,
            LogStylerContract::class,
            LogMenuContract::class,
            FilesystemContract::class,
            FactoryContract::class,
            LogCheckerContract::class,
        ];
    }

    /* -----------------------------------------------------------------
     |  LogViewer Utilities
     | -----------------------------------------------------------------
     */

    /**
     * Register the log viewer service.
     */
    private function registerLogViewer(): void
    {
        $this->singleton(LogViewerContract::class, LogViewer::class);
    }

    /**
     * Register the log levels.
     */
    private function registerLogLevels(): void
    {
        $this->singleton(LogLevelsContract::class, function ($app) {
            return new Utilities\LogLevels(
                $app['translator'],
                $app['config']->get('log-viewer2.locale')
            );
        });
    }

    /**
     * Register the log styler.
     */
    private function registerStyler(): void
    {
        $this->singleton(LogStylerContract::class, Utilities\LogStyler::class);
    }

    /**
     * Register the log menu builder.
     */
    private function registerLogMenu(): void
    {
        $this->singleton(LogMenuContract::class, Utilities\LogMenu::class);
    }

    /**
     * Register the log filesystem.
     */
    private function registerFilesystem(): void
    {
        $this->singleton(FilesystemContract::class, function ($app) {
            /** @var  \Illuminate\Config\Repository  $config */
            $config     = $app['config'];
            $filesystem = new Utilities\Filesystem($app['files'], $config->get('log-viewer2.storage-path'));

            return $filesystem->setPattern(
                $config->get('log-viewer2.pattern.prefix', FilesystemContract::PATTERN_PREFIX),
                $config->get('log-viewer2.pattern.date', FilesystemContract::PATTERN_DATE),
                $config->get('log-viewer2.pattern.extension', FilesystemContract::PATTERN_EXTENSION)
            );
        });
    }

    /**
     * Register the log factory class.
     */
    private function registerFactory(): void
    {
        $this->singleton(FactoryContract::class, Utilities\Factory::class);
    }

    /**
     * Register the log checker service.
     */
    private function registerChecker(): void
    {
        $this->singleton(LogCheckerContract::class, Utilities\LogChecker::class);
    }
}
