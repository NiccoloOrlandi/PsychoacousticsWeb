# Wep app per dipartimento di psicologia UniPd

glossario:
ISI: inter-stimulus interval
ITI: inter-trial interval
nAFC: number of Alternative Forced Choice

legenda:
 ✓ : fatto 
 ✗ : non da fare
 - : da fare
 ? : da chiedere

	--     TO-DO     --

- domande prof Grassi
	- la funzione downloadAll non segue molto le norme di privacy
	- gli utenti devono poter essere informati su come vengono trattati i loro dati
	- norme GDPR e utilizzo dei cookie senza consenso (rischio multa)
	
-cose da fare con i tecnici
	- psychoacousticsWEB nell'url
	- capchta, serve https
	- settare smtp per inviare le email
	- copy to clipboard di userSettings richiede https (togliere overflow:scroll dopo aver risolto)

- nuove features
	- nuove features per Mattia
		- sistemare click -> Mattia
		- test con rumore per amp e dur -> Mattia

	- nuove feature per Andrea e Niccolò
		- save settings funziona anche senza fare il test
		- feedback scelto da chi manda il link -> va aggiunto al db

	- roba facile e veloce
		? link al manuale nella home page (da aggiornare dopo le modifiche)
		- ITI (interTrialInterval) va messo nel csv

	- altro da fare il prima possibile
		- lista errori/limiti dei valori nel manuale

- migliorie per il futuro
	- modificare la fase del suono
	- suoni suonabili componibili
	- migiorare la sicurezza
		- dati di accesso al db criptati
		- controlli sui dati passati con get
		- blocco accesso alle pagine tramite copia-incolla dell'url
	- save test settings funziona anche senza finire il test (si crea un apposito test dummy nel db che serve solo a quello)
	- possibilità di cancellare i test da yourTests
	- possibilità di scaricare un singolo test da yourTests
	- possibilità di togliere i SU (chi può farlo? Gli SU stessi? Se io metto un SU poi lui può togliermi. In molti ambiti funziona così)
	- pulsante "set test" in user settings per modificare le impostazioni del test mandato con il link/invite code

- documentazione
	- Diagramma architetturale del sistema
	- guida/documentazione
	- documento dei requisiti
	- tesi
