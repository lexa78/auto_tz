## Что нужно сделать
- после клонирования репозитория, перед запуском команды **docker-compose up --build**, необходимо заполнить блок для БД в 
**.env** файле, либо скопировать его из файла **.env.example**
- если, в процессе выполнения команды, будет возникать ошибка **groupadd: invalid group ID 'sail'**, нужно в **.env** 
файл добавить **WWWGROUP=1000** и **WWWUSER=1000** и повторить вызов команды
- в **.env** файл необходимо добавить строчку **XML_VALIDATION_SCHEME_PATH = app/scheme/data.xsd**
- в **.env** файл добавить параметр **DEFAULT_XML_FILE_PATH** и присвоить ему значение расположения XML файла по 
умолчанию. Или просто скопировать последнюю строчку из **.env.example** в **.env**
- создать указанную папку(-ки) в директории **/storage/app** и положить туда нужный файл
- вместо предыдущего пункта можно выполнить команду **php artisan xmlFile:create**
- чтобы задать путь к обрабатываемому файлу, отличный от дефолтного, нужно выполнить команду 
**php artisan xmlFile:handle (путь до файла с его наименованием без скобок)** например 
**php artisan xmlFile:handle /asd/qwe.txt** Подразумевается, что файл **qwe.txt** находится по пути 
**/storage/app/asd/qwe.txt**   

## **********
Я не стал делать множественную вставку в **Catalog** в файле **app\Console\Commands\HandleXMLFile.php**, так как не знаю
размера реального XML файла. Если он приблизительно такой, то, я думаю, что лучше вставлять каждый **offer** 
по отдельности. Если возникнет ошибка при записи какой-нибудь строки, то вставленные перед этим записи, останутся в 
таблице, чего не произойдет при множественной вставке. 
