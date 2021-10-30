<?php

declare(strict_types=1);

namespace Konair\HAP\Shared\Domain\Model\Entity;

use PHPUnit\Framework\TestCase;
use Konair\HAP\Shared\Domain\Model\Pen;
use Konair\HAP\Shared\Domain\Model\PenId;

final class AggregateRootTest extends TestCase
{
    public function testAggregateRootCreation(): void
    {
        $penId = PenId::create('P001');

        $domain = new Pen($penId);

        $this->assertTrue($domain->identification()->equalsTo($penId));
        $this->assertNull($domain->color());
        $this->assertCount(0, $domain->recordedEvents());
    }

    public function testColorChanging(): void
    {
        // given
        $penId = PenId::create('P001');
        $finalPenColor = 'red';

        $domain = new Pen($penId);

        // when
        $domain->changeColor($finalPenColor);

        // then
        $this->assertTrue($domain->identification()->equalsTo($penId));
        $this->assertSame($finalPenColor, $domain->color());
        $this->assertCount(1, $domain->recordedEvents());
    }

    public function testFlushEvents(): void
    {
        // given
        $penId = PenId::create('P001');
        $finalPenColor = 'red';

        $domain = new Pen($penId);
        $domain->changeColor($finalPenColor);

        // when
        $domain->clearEvents();

        // then
        $this->assertTrue($domain->identification()->equalsTo($penId));
        $this->assertSame($finalPenColor, $domain->color());
        $this->assertCount(0, $domain->recordedEvents());
    }
}
