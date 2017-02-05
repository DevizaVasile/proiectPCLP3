Creat de Deviza Vasile
Poiect la materia  Programarea Calculatoarelor si Limbaje de Programare 3
Universitatea Transilvania din Brasov
Facultatea de Inginerie Electrica si Stiinta Calculatoarelor 
Specializarea Tehnologia Informatiei , Anul 2.

Proiectul dat consta in crearea si dezvoltarea unei aplicatii pentru un client real , 
in cazul de fata este vorba despre administratia cantinei universitatii Transilvania , in 
continuare numit "Client".
Clinentul are nevoie de o solutie informatica pentru a cunoaste exact cata mancare sa prepare 
cu o zi inainte pentru a minimiza pierderile de mancare .

Pentru acest proiect am decis sa creez un website pentru studenti , unde acestia sa 
poata comanda mancarea cu o zi inainte , iar pentru client am creat 2 aplicatii Java 
prin intermediul carora Clinetul va putea vedea aceste comenzi .

Tehnologii utilizate si functiile lor in aplicatie.

Baza de date "db1"
Este scheletul aplicatiei , aici se afla datele studentilor ,
comenzile plasate de acestia , si meniul cantinei .
Sunt 4 tabele cu functii diferite .


**********************
Websiteul
Este un site web scris in PHP care permite studentilor sa se inregistreze , logheze , 
comande mancare  , si sa vizualizeze comenzile plasate  anterior.


**********************
Scriptul python "meniu_generator_1.x" are 2 functii majore , 
1. Extrage meniul de pe pagina universitaii  , salveaza meniul in format XML si HTML (meniu.xml si meniu.html).
Deoarece accesul la meniu este restrictionat pentru utilizatorii care nu au cont de tip student ( student.student@unitbv.ro )
scriptul nu poate fi testat , deci am lasat variabilele de logare neinitializate ( string gol ) .
2. Sterge toate inregistrarile din baza de date facute cu o zi inainte .


**********************
Aplicatia Java 'Manager Cantina'
Aceasta aplicatie destinata clientului permite vizualizarea comenzilor plasate de studentin in forma unei liste care afiseaza mancarea 
si cantitatea comandata .
Ex
Mancare 1 >>>>>10 portii
Mancare 2 >>>>>15 portii

Este construita pe modelul MVC  cu tehnologia JavaFX (interfata grafica) in NetBeans.

Fisierul 'src/managercantina/DbConnection.java' este clasa care face conexiunea la baza de date "db1"  cu ajutorul driverului JDBC si face interogari bazei de date 
prin intermediul unor metode statice .

Fisierul 'src/managercantina/Mancare.java' este clasa unde sunt create modele in structura MVC , un obiect de tip mancare care are un constructor si un getter.

Fisierele'src/managercantina/FXMLDocument.fxml' si 'src/managercantina/FXMLDocumnetController.java' sunt View si respectiv Controller in arhitectura MVC .
Fisierul fxml este un schelet al interfetei de tipul  mark up language care creaza butoane , liste , ferestre  iar controllerul se ocupa de partea de logica si interactiune user-aplicatie .


**********************
Aplicatia Java 'Finalizare Comenzi'
Aceasta aplicatie este destintata Clientului.
Are acelasi model arhitectural ( MVC ).
Permite onorarea comenzilor de catre personalul cantinei , introducat un id ( in cazul de fata email-ul studentului  ) pentru a vizualiza comenzile acestuia si 
ulterior modificarea statului comenzii de la plasata la ridicata .


**********************
Directii viitoare de dezvoltare 
Amplicatie in forma data este doar un prototip , pentru a putea fi implementata sunte necesare urmatoarele:
-automatizarea scriptului meniu_generator_1.x.py pentru a rula independent la o anumita ora cand o cere clientul
-criptarea datelor si asigurarea nealterarii lor prin injectii SQL in partea de plasare comenzi a aplicatiei web 
-crearea unei metode de incarcare a soldului 
-imbunatatirea interfetelor grafice 
-crearea unui sistem 'back-up'  si 'log' pentru monitorizare a tuturor proceselor
-crearea unui fisier de configurare pentru aplicatiile Java Manager Cantina si Finalizare Comenzi  in cazul migrarii bazei de date si a websiteului

 



