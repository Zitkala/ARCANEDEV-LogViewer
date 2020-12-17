<?php

declare(strict_types=1);

namespace Zitkala\LogViewer\Tests\Commands;

use Zitkala\LogViewer\Tests\TestCase;

/**
 * Class     CheckCommandTest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CheckCommandTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_check(): void
    {
        $this->artisan('log-viewer2:check')
             ->assertExitCode(0);
    }
}
