<?php
  namespace MarcinOsiak;

  class Cli
  {
    /**
     * Tablica argumentów - wszystkie argumenty wpisane w konsoli
     * @var array
     */
    private $argv;

    /**
     * opcja wpisana w konsoli, np. csv:simple
     * @var string
     */
    private $option;

    /**
     * adres url wpisany w konsoli
     * @var string
     */
    private $url;

    /**
     * ścieżka do pliku csv wpisana w konsoli
     * @var string
     */
    private $dir;

    /**
     * nazwa pliku csv wpisana w konsoli
     * @var string
     */
    private $file;

    /**
     * Pobiera wszystkie argumenty wpisane w konsoli
     */
    public function __construct($argv = [])
    {
      $this->argv = $argv;
    }

    /**
     * Sprawdzam składnię argumentów podanych w cli
     * @param array $argv - argumenty wpisane w konsoli
     */
    public function parseArg($argv)
    {

      if($argv[1] == "csv:simple" || $argv[1] == "csv:extended")
      {
        $this->option = $argv[1];
      }
      else
      {
        $this->option = null;
      }

      // Czy url jest poprawny
      if(filter_var($argv[2], FILTER_VALIDATE_URL))
      {
        $this->url = $argv[2];
      }
      else
      {
        $this->url = null;
      }


      if($this->createDir($argv[3]))
      {
        $path_parts = pathinfo($argv[3]);
        $this->file = $path_parts['basename'];
      }
      else
      {
        $this->dir = null;
      }
    }

    /**
     * Jeżeli w konsoli PATH będzie podana w postaci katalog/plik.csv lub katalog1/katalog2/plik.csv
     * To tworzę strukturę katalogów dla pliku csv
     * @param  string $dir_file - ścieżka do pliku
     *
     * Zwraca true jeśli nnie trzeba tworzyć katalogw lub gdy utworzył
     * Zwraca false jeśli nie udało się utworzyć struktury katalogów
     * @return bool
     */
    public function createDir($dir_file)
    {
      // ustawiam ścieżkę do pliku
      $path_parts = pathinfo($dir_file);

      // katalog/katalogi do utworzenia
      $dir = $path_parts['dirname'];

      // katalog już istnieje lub
      // jeśli $path_parts = "." to nie ma katalogw do utworzenia
      // w konsoli została podana tylko nazwa pliku
      if(file_exists($dir) || $dir == ".")
      {
        $this->dir = $dir;
        return true;
      }
      else
      {
        $is_create = mkdir($dir, 0777, true);
        $this->dir = $dir;

        /**
         * true - katalog został utworzony
         * false - nie udało się utworzyć katalogu
         */
        return $is_create;
      }
    }

    public function getDir()
    {
      return $this->dir;
    }

    public function getFileName()
    {
      return $this->file;
    }

    public function getUrl()
    {
      return $this->url;
    }

    public function getOption()
    {
      return $this->option;
    }

    public function getArgv()
    {
      return $this->argv;
    }

  }
