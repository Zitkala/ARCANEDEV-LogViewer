<?php

declare(strict_types=1);

namespace Zitkala\LogViewer\Tests\Commands;

use Zitkala\LogViewer\Tests\TestCase;

/**
 * Class     StatsCommandTest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class StatsCommandTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_display_stats(): void
    {
        $this->artisan('log-viewer2:stats')
             ->assertExitCode(0);
    }
}
