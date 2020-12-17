<?php

declare(strict_types=1);

namespace Zitkala\LogViewer\Tests\Tables;

use Zitkala\LogViewer\Contracts\Table as TableContract;
use Zitkala\LogViewer\Tables\StatsTable;
use Zitkala\LogViewer\Tests\TestCase;

/**
 * Class     StatsTableTest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class StatsTableTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Zitkala\LogViewer\Tables\StatsTable */
    private $table;

    /** @var array */
    private $rawData;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->table = new StatsTable(
            $this->rawData = $this->getLogViewerInstance()->stats(),
            $this->getLogLevelsInstance()
        );
    }

    protected function tearDown(): void
    {
        unset($this->table);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated(): void
    {
        static::assertInstanceOf(StatsTable::class, $this->table);
    }

    /** @test */
    public function it_can_make_instance(): void
    {
        $this->table = StatsTable::make(
            $this->getLogViewerInstance()->stats(),
            $this->getLogLevelsInstance()
        );

        static::assertTable($this->table);
    }

    /** @test */
    public function it_can_get_header(): void
    {
        static::assertTableHeader($this->table);
    }

    /** @test */
    public function it_can_get_rows(): void
    {
        static::assertTableRows($this->table);
    }

    /** @test */
    public function it_can_get_footer(): void
    {
        static::assertTableFooter($this->table);
    }

    /** @test */
    public function it_can_get_raw_data(): void
    {
        static::assertEquals(
            $this->rawData,
            $this->table->data()
        );
    }

    /** @test */
    public function it_can_get_totals(): void
    {
        $totals = $this->table->totals();

        static::assertInstanceOf(\Illuminate\Support\Collection::class, $totals);
    }

    /** @test */
    public function it_can_get_json_data_for_chart(): void
    {
        $json = $this->table->totalsJson();

        static::assertJson($json);
    }

    /** @test */
    public function it_can_get_stats_table_via_log_viewer2(): void
    {
        /** @var  \Zitkala\LogViewer\Contracts\LogViewer  $logViewer */
        $logViewer = $this->app->make(\Zitkala\LogViewer\Contracts\LogViewer::class);

        static::assertTable($logViewer->statsTable());
    }

    /** @test */
    public function it_can_get_stats_table_via_log_factory(): void
    {
        /** @var  \Zitkala\LogViewer\Contracts\Utilities\Factory  $logFactory */
        $logFactory = $this->app->make(\Zitkala\LogViewer\Contracts\Utilities\Factory::class);

        static::assertTable($logFactory->statsTable());
    }

    /* -----------------------------------------------------------------
     |  Custom Assertions
     | -----------------------------------------------------------------
     */

    /**
     * Assert table instance.
     *
     * @param  \Zitkala\LogViewer\Contracts\Table  $table
     */
    protected static function assertTable(TableContract $table): void
    {
        static::assertTableHeader($table);
        static::assertTableRows($table);
        static::assertTableFooter($table);
    }

    /**
     * Assert table header.
     *
     * @param  \Zitkala\LogViewer\Contracts\Table  $table
     */
    protected static function assertTableHeader(TableContract $table): void
    {
        $header = $table->header();

        static::assertCount(10, $header);
        // TODO: Add more assertions to check the content
    }

    /**
     * Assert table rows.
     *
     * @param  \Zitkala\LogViewer\Contracts\Table  $table
     */
    protected static function assertTableRows(TableContract $table): void
    {
        foreach ($table->rows() as $date => $row) {
            static::assertDate($date);
            static::assertCount(10, $row);

            foreach ($row as $key => $value) {
                switch ($key) {
                    case 'date':
                        static::assertDate($value);
                        break;

                    case 'all':
                        static::assertEquals(8, $value);
                        break;

                    default:
                        static::assertEquals(1, $value);
                        break;
                }
            }
        }
    }

    /**
     * Assert table footer.
     *
     * @param  \Zitkala\LogViewer\Contracts\Table  $table
     */
    protected static function assertTableFooter(TableContract $table): void
    {
        foreach ($table->footer() as $key => $value) {
            static::assertEquals($key === 'all' ? 16 : 2, $value);
        }
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the LogViewer instance.
     *
     * @return \Zitkala\LogViewer\Contracts\LogViewer
     */
    protected function getLogViewerInstance()
    {
        return $this->app->make(\Zitkala\LogViewer\Contracts\LogViewer::class);
    }

    /**
     * Get the LogLevels instance.
     *
     * @return \Zitkala\LogViewer\Contracts\Utilities\LogLevels
     */
    protected function getLogLevelsInstance()
    {
        return $this->app->make(\Zitkala\LogViewer\Contracts\Utilities\LogLevels::class);
    }
}
