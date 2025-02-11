use PHPUnit\Framework\TestCase;

<?php

namespace App\Service\Parser;


class CsvParserTest extends TestCase
{
  private $csvParser;

  protected function setUp(): void
  {
    $this->csvParser = new CsvParser();
  }

  public function testParseValidCsv()
  {
    $csvContent = "name,age\nJohn Doe,30\nJane Doe,25";
    $expectedResult = [
      ['name' => 'John Doe', 'age' => 30],
      ['name' => 'Jane Doe', 'age' => 25],
    ];

    $result = $this->csvParser->parse($csvContent);

    $this->assertEquals($expectedResult, $result);
  }

  public function testParseEmptyCsv()
  {
    $csvContent = "";
    $expectedResult = [];

    $result = $this->csvParser->parse($csvContent);

    $this->assertEquals($expectedResult, $result);
  }

  public function testParseInvalidCsv()
  {
    $this->expectException(\Exception::class);

    $csvContent = "name,age\nJohn Doe,thirty";
    $this->csvParser->parse($csvContent);
  }
}