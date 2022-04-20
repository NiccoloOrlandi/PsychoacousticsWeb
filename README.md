# Wep app per dipartimento di psicologia UniPd
attualmente in sviluppo il primo test 


	--     APPUNTI     --

DEADLINES E TO-DO:

- test amp e freq
	- rivedere amp iniziale
	- inserire doppio factor (sqrt(2) dopo n test) -> ?
	- limiti factor: 1-10                        -> ?

- test durata + 2d1u
	- rivedere distanza tra i due suoni nel test sulla durata

- db (login)
	- cambiare l'identificativo di test: usare fk_guest + un seriale (n-esimo test di un certo guest)
	- età in guest deve essere sostituita con data di nascita
	- feedback se checkbox spuntata
	- salvataggio dei dati dei guest che hanno creato un account
	- inviamo solo gli ultimi reversals oppure tutti e poi ci pensano gli analisti
	- conferma password (non ancora messa prima bisogna iscriversi e forse va introdotta la email ma va chiesto al prof )
	- dati salvati solo se spunto la checkbox "save results"
	- implementare col sito (php)
		- quando un utente si registra va creato un nuovo account (e va controllato che l'username non esista già)
			- informativa sulla privacy?
			- quando registri va creato anche un guest, quindi vanno chieste tutte le info
		- quando un utente registrato fa un test va aggiunto il risultato del test e va collegato al guest dell'utente
		- quando un guest non registrato fa un test va creato il guest e va aggiunto il risultato del test e va collegato al guest
		- quando un utente accede va controllato che esista e va creata una sessione (così se fa test vengono collegati al suo account)

- poi php
	- passaggio dati in sicurezza (demographicData, soundSettings, tipo di test)
	
- captcha
	- livello intermedio

- plus se riusciamo
	- Vedere se si puó modificare la fase del suono
	- Funzione (esponenziale fino a 1?) che permette di non avere brutte sensazioni a inizio e fine suono 
	- Predisporre presenza di rumori di sottofondo 
	- Predisporre piú di due suoni alla volta ( un suono viene ripetuto piú volte e l'altro una volta sola )
	- Diagramma architetturale del sistema
	- Recupero dati utente e psw ( difficile serve mailing list, quando ci si registra bisogna inserire email )
	- predisporre funzionamento delle altre metriche
	
- grafica
	- alert di errore di inerimento dati (migliorare)
	- index.html:le funzioni che cambiano il colore potrebbero essere sostituite con del css
	- index.html:la funzione "onclick" delle card può essere sostituita dall'href (è un tag link <a>) e col css si può evitare che esca sottolineato

- documentazione
	- documento dei requisiti
	- tesi
	
