# Lab_1
## 1. Pierwsze api restowe:
### a. Wersja PHP użyta: 8.1.2
### b. Wersja Framework Symfony użyta w projekcie: 6.0

## 2. Zadanie do wykonania:
### Na podstawie dostarczonego pliku xls przygotuj następujące API
#### a. Wyszukiwanie wszystkich wpisów dla konkretnego segmentu
#### b. Wyszukiwanie wszystkich wpisów dla konkretnego kraju
#### c. Wyszukiwanie wszystkich wpisów dla konkretnego produktu
#### d. Raport, który przedstawia zsumowane wartości Units sold dla segmentu i kraju
#### e. Metodę, która pozwala dodać nowy wpis do tabeli
#### f. Metodę, która pozwala usunąć wpis z tabeli
#### g. Metodę wyszukującą wybrany wpis z tabeli

## 2. Materiały:
- Dokumentacja opisująca singleton w framework Symfony: [Link](https://symfony.com/doc/current/service_container/shared.html)
- Dokumentacja pakietu wykorzystany do operacji na pliku arkuszu excel: [Link](https://phpspreadsheet.readthedocs.io/en/latest/)
- Dokumentacja pakietu użyty do stworzenia kolekcji obiektów i operacji na nich: [Link](https://www.doctrine-project.org/projects/doctrine-collections/en/1.6/index.html)


## 4. Endpointy:
### a. /lab1_api

- Endpoint zwracający listę wszystkich obiektów

### b. /get/segment/{segmentName}

- Endpoint zwracający listę obiektów dla danego segmentu
- {segmentName} - nazwa segmentu dla jakiego ma zwrócić obiekty

### c. /get/country/{countryName}

- Endpoint zwracający listę obiektów dla danego kraju
- {countryName} - nazwa kraju dla jakiego ma zwrócić obiekty

### d. /get/product/{productName}

- Endpoint zwracający listę obiektów dla danego produktu
- {productName} - nazwa produktu dla jakiego ma zwrócić obiekty

### e. /get/param/{param}/{paramName}

- Endpoint zwracający listę obiektów dla danego parametru (segment|country|product)
- {param} - nazwa parametr ma wyszukać, możliwe wartości segment | country | product
- {paramName} - nazwa kraju, segmentu lub produktu (w zależmości od wybranego parametru) dla jakiego ma zwrócić obiekty

### f. /sum/{segment}/{country}

- Endpoint zwracający sumę wartości Unit sold dla segmentu i kraju
- {segment} - nazwa segmentu dla którego ma zsumować
- {country} - nazwa kraju dla krtórego ma zsumować

### g. /add/{segment}/{country}/{product}/{unitSold}

- Endpoint zapisujący do pliku excel segment, kraj, produkt i ilość
- {segment} - nazwa segmentu którą ma zapisać do pliku excel
- {country} - nazwa kraju którą ma zapisać do pliku excel
- {product} - nazwa produktu którą ma zapisać do pliku excel
- {unitSold} - ilość jaką ma zapisac do pliku excel

### h. /delete/{id}

- Endpoid kasujący z pliku excel wiersz o podanym numerze
- {id} - numer wiersza który ma zostać skasowany

### i. /find/{id}

- Endpoint zwracający z pliku excel wiersz o podanym numerze
- {id} - numer wiersza który ma wyszukać

![Baal](https://static.wikia.nocookie.net/diablo/images/0/07/Diablo-2-Resurrected-Baal.jpg/revision/latest/scale-to-width-down/960?cb=20211216055244)
