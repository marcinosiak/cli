<?php
  require_once('src/cli/Cli.class.php');

  use PHPUnit\Framework\TestCase;
  use MarcinOsiak\Cli;

  class CliTest extends TestCase
  {

    /**
     * Obiekt $cli bez dodatkowych argumentów
     */
    public function testEmptyComandLine()
    {
        $cli = new Cli();
        $argv = $cli->getArgv();

        $this->assertEquals(0, count($argv));
    }

    /**
     * Testuje prawidłowo podanych argumentów
     */
    public function testParseArgv()
    {
        $cli = new Cli(['src/console.php', 'csv:simple', 'http://test.pl', 'directory/file.csv']);
        $argv = $cli->getArgv();
        $cli->parseArg($argv);

        $this->assertEquals('csv:simple', $cli->getOption());
        $this->assertEquals('http://test.pl', $cli->getUrl());
        $this->assertEquals('directory', $cli->getDir());
        $this->assertEquals('file.csv', $cli->getFileName());
        rmdir('directory');
    }

    /**
     * Testuje prawidłowo podanych argumentów - PATH bez katalogu
     */
    public function testParseArgvWithoutDir()
    {
        $cli = new Cli(['src/console.php', 'csv:simple', 'http://test.pl', 'file.csv']);
        $argv = $cli->getArgv();
        $cli->parseArg($argv);

        $this->assertEquals('.', $cli->getDir());
        $this->assertEquals('file.csv', $cli->getFileName());
    }

    /**
     * Źle podana opcja w wierszu poleceń
     */
    public function testParseArgBadOption()
    {
      $cli = new Cli(['src/console.php', 'some:option', 'http://test.pl', 'file.csv']);
      $argv = $cli->getArgv();
      $cli->parseArg($argv);

      $this->assertNull($cli->getOption());
    }

    /**
     * Źle podany url w wierszu poleceń
     */
    public function testParseArgBadUrl()
    {
      $cli = new Cli(['src/console.php', 'csv:simple', 'some.url', 'file.csv']);
      $argv = $cli->getArgv();
      $cli->parseArg($argv);

      $this->assertNull($cli->getUrl());
    }

    /**
     * Test tworzenia katalogu
     */
    public function testCreateDir()
    {
      $cli = new Cli();
      // bez katalogu
      $this->assertTrue($cli->createDir('file.csv'));
      // utwórz katalog data_csv
      $this->assertTrue($cli->createDir('data_csv/file.csv'));
      // katalog data_csv już istnieje
      $this->assertTrue($cli->createDir('data_csv/file.csv'));
      rmdir('data_csv');
    }


  }
