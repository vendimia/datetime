<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Vendimia\DateTime\{DateTime, Date, Time};
use Vendimia\DateTime\Interval;

require __DIR__ . '/../vendor/autoload.php';

final class DateTimeTest extends TestCase
{
    public function testCreateDateTime()
    {
        $dt = new DateTime("2021-02-01 23:12:01");

        $this->assertEquals('2021-02-01 23:12:01', (string)$dt);
    }

    public function testCreateDate()
    {
        $dt = new Date("2021-02-01 23:12:01");

        $this->assertEquals('2021-02-01', (string)$dt);
    }

    public function testCreateTime()
    {
        $dt = new Time("2021-02-01 23:12:01");

        $this->assertEquals('23:12:01', (string)$dt);
    }

    public function testCreateDateTimeFromISO8601()
    {
        $dt = new DateTime("2021-09-08T03:46:42");
        $this->assertEquals('2021-09-08 03:46:42', (string)$dt);
    }

    public function testAddInterval()
    {
        $dt = new DateTime("2021-09-09T03:46:42");
        $this->assertEquals(
            '2021-09-10 03:46:42',
            (string)$dt->plus(Interval::day(1))
        );
    }
}
