Prosty skrypt PHP uruchamiany z CLI
================

Skrypt ma za zadanie pobrać dane RSS/Atom z określonego adresu URL i zapisać je w pliku CSV


Jak użyć
-----
Skrypt wykonuje dwa polecenia:
1) Pobiera z URL dane RSS/Atom i zapisuje je do pliku określonego ścieżce PATH. Stare dane z pliku PATH.csv zostają nadpisane.

``` bash
$ php src/console.php [option] [url] [path]

```
np.

``` bash

$ php src/console.php csv:simple http://feeds.nationalgeographic.com/ng/News/News_Main data/simple.csv

```

2) Pobiera z URL dane RSS/Atom i zapisuje je do pliku określonego ścieżce PATH. Stare dane z pliku PATH.csv zostają dopisane.

``` bash

$ php src/console.php csv:extendeds http://feeds.nationalgeographic.com/ng/News/News_Main data_/ext.csv

```

Testing
-------

``` bash
$ phpunit
```
