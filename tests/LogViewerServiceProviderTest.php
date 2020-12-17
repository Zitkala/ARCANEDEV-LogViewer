<?php

declare(strict_types=1);

namespace Zitkala\LogViewer\Tests;

use Zitkala\LogViewer\LogViewerServiceProvider;

/**
 * Class     LogViewerServiceProviderTest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LogViewerServiceProviderTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  LogViewerServiceProvider */
    private $provider;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp(): void
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(LogViewerServiceProvider::class);
    }

    public function tearDown(): void
    {
        unset($this->provider);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated(): void
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Zitkala\Support\Providers\ServiceProvider::class,
            \Zitkala\Support\Providers\PackageServiceProvider::class,
            LogViewerServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides(): void
    {
        $expected = [];

        static::assertSame($expected, $this->provider->provides());
    }
}
