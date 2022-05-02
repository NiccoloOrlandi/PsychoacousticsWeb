# Wep app per dipartimento di psicologia UniPd
attualmente in sviluppo il primo test 


	--     APPUNTI     --

DEADLINES E TO-DO:

- test amp e freq
	- rivedere amp iniziale												da fare
	- inserire doppio factor											fatto (per freq)		
		- fattore <factor> usato per i primi <reversals> reversals						fatto (per freq)
		- fattore <second factor> usato per i successivi <second reversals> reversals				fatto (per freq)
		- totale reversals = <reversals> + <second reversals>							fatto (per freq)
		- reversals da salvare nel db = <revelsals threshold>							fatto (per freq)
	- limiti factor: il primo maggiore del secondo, il secondo maggiore di uno					fatto
		- 2 e sqrt(2) come placeholder       									fatto        

- test durata + 2d1u
	- rivedere distanza tra i due suoni nel test sulla durata							da fare

- db (login) 30/04/2022
 	- revisionare schema er 											fatto
    	- implementare         												fatto
    	- riempire         												fatto
	- cambiare l'identificativo di test: usare fk_guest + un seriale (n-esimo test di un certo guest) 		fatto 
	- età in guest deve essere sostituita con data di nascita (solo quando creiamo account?)	  		non serve 
	- feedback se checkbox spuntata 
	- dati salvati solo se spunto la checkbox "save results"
	- aggiungere email al db 									  		va bene
	- inviamo solo gli ultimi reversals oppure tutti e poi ci pensano gli analisti 			  		a seconda di rev threshold
	- salvataggio di blocco, trial, delta, posizioneVariabile, tastoPremuto, rispostaCorretta, reversal (in questo ordine)
	
- poi php entro 30/04/2022
	- quando un utente si registra va creato un nuovo account (e va controllato che l'username non esista già)   	fatto
		- controlli js sugli input (required data + sql injections)						da fare 
	- passaggio dati in sicurezza (demographicData, soundSettings, tipo di test)				     	fatto (per ora non problema lato client)
	- richiedere al professore una spiegazione specifica su cosa dovrá fare chi ha l'account ( invita gli altri in che modo e cosa ne facciamo dei dati)
	
	- salvataggio dei dati dei guest che hanno creato un account						     	fatto
	 
	- informativa sulla privacy?									  		per ora non serve
	- quando registri va creato anche un guest, quindi vanno chieste tutte le info				     	fatto
	- quando un utente registrato fa un test va aggiunto il risultato del test e va collegato al guest dell'utente	fatto 			
	- quando un guest non registrato fa un test va creato il guest e va aggiunto il risultato del test e va collegato al guest da fare
	- quando un utente accede va controllato che esista e va creata una sessione (così se fa test vengono collegati al suo account) fatto
			
- captcha	entro 15/05/2022
	- inserire controllo login o sign in per non mettere il nome 							fatto
	- captcha livello v2 o v3											da fare dopo aver parlato con tecnici
	- come oscurare i dati di php username e psw									non serve
	- scrivi su file e i file php leggono il file	
	- conferma password (non ancora messa prima bisogna iscriversi e forse va introdotta la email ma va chiesto al prof)
	- implementare sturuttura a tre livelli
	- creare la pagina per i risultati immediati del test								fatto
		- implementare download dati come CSV
	- creare pagina per lo storico dei test

- plus se riusciamo entro il 10/06/2022
	- Vedere se si puó modificare la fase del suono
	- Funzione (esponenziale fino a 1?) che permette di non avere brutte sensazioni a inizio e fine suono 
	- Predisporre presenza di rumori di sottofondo 
	- Predisporre piú di due suoni alla volta ( un suono viene ripetuto piú volte e l'altro una volta sola )
	- Diagramma architetturale del sistema
	- Recupero dati utente e psw ( difficile serve mailing list, quando ci si registra bisogna inserire email )
	- predisporre funzionamento delle altre metriche
	
	- suoni suonabili componibili
	- problema del click iniziale
	
- grafica entro il 10/06/2022
	- alert di errore di inerimento dati (migliorare)
	- index.html:le funzioni che cambiano il colore potrebbero essere sostituite con del css
	- index.html:la funzione "onclick" delle card può essere sostituita dall'href (è un tag link <a>) e col css si può evitare che esca sottolineato

- documentazione entro il 10/06/2022
	- documento dei requisiti
	- tesi

- domande tecnici:
	- non funziona forticlient
	- come cambiare la landing page, ora quando entro nel sito vengo portato all'albero delle cartelle
	- come inviare i file 
	- é possibile fare in modo che le modifiche che faccio nella repository github vengano fatte anche sul server?
	- dati per recapchta : email futuro proprietario, nome dominio, non posso farlo ora perché servono questi dati e un collegamento https
	
