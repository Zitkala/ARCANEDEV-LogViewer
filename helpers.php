<?php

use Zitkala\LogViewer\Contracts;

if ( ! function_exists('log_viewer2')) {
    /**
     * Get the LogViewer instance.
     *
     * @return Zitkala\LogViewer\Contracts\LogViewer
     */
    function log_viewer2()
    {
        return app(Contracts\LogViewer::class);
    }
}

if ( ! function_exists('log_levels2')) {
    /**
     * Get the LogLevels instance.
     *
     * @return Zitkala\LogViewer\Contracts\Utilities\LogLevels
     */
    function log_levels2()
    {
        return app(Contracts\Utilities\LogLevels::class);
    }
}

if ( ! function_exists('log_menu2')) {
    /**
     * Get the LogMenu instance.
     *
     * @return Zitkala\LogViewer\Contracts\Utilities\LogMenu
     */
    function log_menu2()
    {
        return app(Contracts\Utilities\LogMenu::class);
    }
}

if ( ! function_exists('log_styler2')) {
    /**
     * Get the LogStyler instance.
     *
     * @return Zitkala\LogViewer\Contracts\Utilities\LogStyler
     */
    function log_styler2()
    {
        return app(Contracts\Utilities\LogStyler::class);
    }
}
