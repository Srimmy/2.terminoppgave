# Terminoppgave Vg2 //  Utvikles helt til sommer


**Prosjektet:** Lage en web applikasjon der man kan dele bilder og spille spill. Nettstedet skal kunne åpnes ved å skrive inn en ip addresse på Kuben.It nettet. På nettleseren skal du kunne logge på en bruker der passordet blir kryptert i databasen. På nettsiden skal du kunne sende melinger til de du vil og se på de nyeste bildene som blir lagt ut.

**Må ha for å sette opp:**
* Mysql
* Php 
* phpmyadmin
* apache2

**Anbefaler å laste ned xampp fordi da lastes alt ned på likt: https://www.apachefriends.org/download.html**

**Sette opp på xampp:**
*Extract alle filene i zip mappen i 'C:\xampp\htdocs\dashboard'
*Åpne opp xampp og kjør apache2 og mysql
*Trykk 'admin' inni action kolonnen i mysql raden
*Dette burde ta deg til en nettside, her trykker du 'sql' i navigasjonsmenyen.
*Skriv inn 'CREATE DATABASE users;' og trykk 'go' nede høyre hjørne.
*Klipp all infirmasjonen i 'users.sql' filen og lim det inn det i den samme 'sql' tabben som i stad og trykk go.
**I noen versioner av mysql må man skrive inn "use users;" før du kopierer og limer inn.**
*For å åpne prosjektet kan du nå skrive 'localhost/2.terminoppgave-main' i skrivefeltet på nettleseren din, merk deg at dette må være URL skrive feltet.


**Kryssliste for prosjekt**
* ~~Lage en web applikasjon med brukerinnlogging der man kan dele bilder og spille spill~~
* ~~Brukerinnloggingen er kryptert~~
* Man skal kunne kommunisere (instagram private messages)
* ~~Kunne se profiler~~
* Legge til websocket slik at siden ikke må refreshes
* ~~Passe på at databasen er sikret~~
* sikre porter og ssh i ufw (kommandoer er skrevet i oppdrag: system sikring)
* fjerne root fra mysql og virtuelle maskiner
* ~~legge til lik og kommentar funksjon~~
* ~~lagt til måte å legge ut bilder på slik at det blir lagret på samme maskin som apache2~~
* legge til ticketing system for brukerstøtte siden applikasjonen foreløpig mangler slike funksjoner
* legge til epost slik at jeg kan automatisere en "glemt passord".
* se gjennom lover og regler: personvern, gdpr (hva skjer hvis nettsiden blir medium for terrorister?)
* flere ideer er skrevet i login/STUCK.txt
