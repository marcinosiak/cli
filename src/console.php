<?php

  require_once("vendor/autoload.php");
  require_once('cli/Cli.class.php');

  use MarcinOsiak\Cli;
  use Keboola\Csv\CsvWriter;


  $cli = new Cli($_SERVER['argv']);
  $argv = $cli->getArgv();
  $cli->parseArg($argv);


  // Sprawdzam poprawność wprowadzonych parametrów
  if($cli->getOption() == false)
  {
    die("Niepoprawna opcja. Zastosuj csv:simple lub csv:extended");
  }

  if($cli->getUrl() == false)
  {
    die("Niepoprawny adres URL.");
  }

  if($cli->getDir() == false)
  {
    die("Nie moge utworzyc katalogu.");
  }



  // ustawiam ścieżkę do pliku csv
  $path = $cli->getDir()."/".$cli->getFileName();

  $rows = [
  	[
  		'title', 'description', 'link', 'pubDate', 'creator'
  	],
  ];

  // pobiera dane RSS/Atom
  $rss = Feed::loadRss($cli->getUrl());
  // i dodaje je do tablicy $rows[]
  foreach ($rss->item as $item)
  {
    $postDate = $item->pubDate;
    $pubDate = date('Y-m-d H:i:s',strtotime($postDate));

    array_push($rows, [$item->title, $item->description, $item->link, $pubDate, $item->creator]);
  }

  $option = $cli->getOption();

  // nadpisuje dane do pliku csv
  if($option == "csv:simple")
  {
    $csvFile = new CsvWriter($path);

    foreach ($rows as $row)
    {
      $csvFile->writeRow($row);
    }
  }
  // dopisuje dane do pliku csv
  elseif($option == "csv:extended")
  {
    $file = fopen($path, 'a');
    $csvFile = new CsvWriter($file);

    // gdy plik istnieje to kasuje pierwszy wiersz z nagłókami kolumn
    if(file_exists($path))
    {
      array_shift($rows);
    }

    // zapisuje do pliku
    foreach ($rows as $row)
    {
      $csvFile->writeRow($row);
    }
    fclose($file);
  }
