var plus = ""; //modify the redirection url if needed

// invio valori client-client
function send_value() {
	var amplitude = document.getElementById('amplitude').value;
	localStorage.setItem('amplitude', amplitude);
	document.location.href = plus+"test.html";
	
	var frequency = document.getElementById('frequency').value;
	localStorage.setItem('frequency', frequency);
	document.location.href = plus+"test.html";
	
	var duration = document.getElementById('duration').value;
	localStorage.setItem('duration', duration);
	document.location.href = plus+"test.html";

	var factor = document.getElementById('factor').value;
	localStorage.setItem('factor', factor);
	document.location.href = plus+"test.html";

	var reversals = document.getElementById('reversals').value;
	localStorage.setItem('reversals', reversals);
	document.location.href = plus+"test.html";

	var level = document.getElementById('level').value;
	localStorage.setItem('level', level);
	document.location.href = plus+"test.html";
}

// test controllo inserimento
function test(){
	//Elenco campi da controllare 
	var amp = document.getElementById("amplitude").value;
	var freq = document.getElementById("frequency").value;
	var dur = document.getElementById("duration").value;
	var phase = document.getElementById("phase").value;
	var numBlocks = document.getElementById("blocks").value;
	var startLevel = document.getElementById("level").value;
	var nafc = document.getElementById("nAFC").value;
	var fact = document.getElementById("factor").value;
	var rev = document.getElementById("reversals").value;
	var revTh = document.getElementById("reversalsTh").value;

	var sound_irreg_exp = /^([a-zA-Z])+$/;

	// controlli su amplitude
	if ((amp == "") || (amp == "undefined")) {
		alert("Il campo Amplitude è obbligatorio.");
		document.getElementById("amplitude").value = "";
		document.getElementById("amplitude").focus();
		return false;
	}
	/*else if ((amp <0) || (amp > 1)) {
		alert("Il valore del campo Amplitude deve essere compreso tra 0 e 1 ");
		document.getElementById("amplitude").value = "";
		document.getElementById("amplitude").focus();
		return false;
	}*/
	else if(sound_irreg_exp.test(amp)){
		alert("Il campo Amplitude puó contenere solo numeri");
		document.getElementById("amplitude").value = "";
		document.getElementById("amplitude").focus();
		return false;
	}
	
	//Controlli su frequency
	if ((freq == "") || (freq == "undefined")) {
		alert("Il campo Frequency è obbligatorio.");
		document.getElementById("frequency").value = "";
		document.getElementById("frequency").focus();
		return false;
	}
	else if (freq <0){
		alert("Il valore del campo Frequency deve essere maggiore di 0 ");
		document.getElementById("frequency").value = "";
		document.getElementById("frequency").focus();
		return false;
	}
	/*else if(!sound_reg_exp.test(freq)){
		alert("Il campo Frequency puó contenere solo numeri");
		document.getElementById("amplitude").value = "";
		document.getElementById("amplitude").focus();
		return false;
	}*/
	
	//Controlli su duration
	if ((dur == "") || (dur == "undefined")) {
		alert("Il campo Duration è obbligatorio.");
		document.getElementById("duration").value = "";
		document.getElementById("duration").focus();
		return false;
	}
	else if (dur <0){
		alert("Il valore del campo Duration deve essere maggiore di 0 ");
		document.getElementById("duration").value = "";
		document.getElementById("duration").focus();
		return false;
	}
	/*else if(!sound_reg_exp.test(dur)){
	
		alert("Il campo Frequency puó contenere solo numeri");
		document.getElementById("duration").value = "";
		document.getElementById("duration").focus();
		return false;
	}*/
	
	//controlli su phase
	if ((phase == "") || (phase == "undefined")) {
		alert("Il campo Phase è obbligatorio.");
		document.getElementById("phase").value = "";
		document.getElementById("phase").focus();
		return false;
	}
	else if (phase <0){
		alert("Il valore del campo Phase deve essere maggiore di 0 ");
		document.getElementById("phase").value = "";
		document.getElementById("phase").focus();
		return false;
	}
	/*else if(!sound_reg_exp.test(dur)){
	
		alert("Il campo Frequency puó contenere solo numeri");
		document.getElementById("duration").value = "";
		document.getElementById("duration").focus();
		return false;

	}*/
	
	//controlli su number of blocks
	if ((numBlocks == "") || (numBlocks == "undefined")) {
		alert("Il campo Number of Blocks è obbligatorio.");
		document.getElementById("blocks").value = "";
		document.getElementById("blocks").focus();
		return false;
	}
	else if (numBlocks <0){
		alert("Il valore del campo Number of Blocks deve essere maggiore di 0 ");
		document.getElementById("blocks").value = "";
		document.getElementById("blocks").focus();
		return false;
	}
	/*else if(!sound_reg_exp.test(dur)){
		alert("Il campo Frequency puó contenere solo numeri");
		document.getElementById("duration").value = "";
		document.getElementById("duration").focus();
		return false;
	}*/
	
	//controlli su starting level
	if ((startLevel == "") || (startLevel == "undefined")) {
		alert("Il campo Starting level è obbligatorio.");
		document.getElementById("level").value = "";
		document.getElementById("level").focus();
		return false;
	}
	else if (startLevel <0){
		alert("Il valore del campo Starting level deve essere maggiore di 0 ");
		document.getElementById("level").value = "";
		document.getElementById("level").focus();
		return false;
	}
	/*
	else if(!sound_reg_exp.test(dur)){
		alert("Il campo Frequency puó contenere solo numeri");
		document.getElementById("duration").value = "";
		document.getElementById("duration").focus();
		return false;
	}*/
	
	//controlli su nAFC
	if ((nafc == "") || (nafc == "undefined")) {
		alert("Il campo nAFC è obbligatorio.");
		document.getElementById("nAFC").value = "";
		document.getElementById("nAFC").focus();
		return false;
	}
	else if (nafc <0){
		alert("Il valore del campo nAFC deve essere maggiore di 0 ");
		document.getElementById("nAFC").value = "";
		document.getElementById("nAFC").focus();
		return false;
	}
	/*else if(!sound_reg_exp.test(dur)){
		alert("Il campo Frequency puó contenere solo numeri");
		document.getElementById("duration").value = "";
		document.getElementById("duration").focus();
		return false;
	}*/
	
	//controlli sul factor
	if ((fact == "") || (fact == "undefined")) {
		alert("Il campo Factor è obbligatorio.");
		document.getElementById("factor").value = "";
		document.getElementById("factor").focus();
		return false;
	}
	//TODO: impostare i valori minimi e massimi adatti
	else if ((fact < 1) || (fact > 10) || isNaN(+fact)){
		alert("Il valore del campo Factor deve essere un numero tra 1 e 10");
		document.getElementById("factor").value = "";
		document.getElementById("factor").focus();
		return false;
	}
	/*else if(!sound_reg_exp.test(dur)){
		alert("Il campo Frequency puó contenere solo numeri");
		document.getElementById("duration").value = "";
		document.getElementById("duration").focus();
		return false;
	}*/
	
	//controlli su starting rev
	if ((rev == "") || (rev == "undefined")) {
		alert("Il campo Reversals è obbligatorio.");
		document.getElementById("reversals").value = "";
		document.getElementById("reversals").focus();
		return false;
	}
	else if (rev <0){
		alert("Il valore del campo Reversals deve essere maggiore di 0 ");
		document.getElementById("reversals").value = "";
		document.getElementById("reversals").focus();
		return false;
	}
	/*else if(!sound_reg_exp.test(dur)){
		alert("Il campo Frequency puó contenere solo numeri");
		document.getElementById("duration").value = "";
		document.getElementById("duration").focus();
		return false;
	}*/
	
	//controlli su revTh
	if ((revTh == "") || (revTh == "undefined")) {
		alert("Il campo Reversals Threshold è obbligatorio.");
		document.getElementById("reversalsTh").value = "";
		document.getElementById("reversalsTh").focus();
		return false;
	}
	else if (revTh <0){
		alert("Il valore del campo Reversals Threshold deve essere maggiore di 0 ");
		document.getElementById("reversalsTh").value = "";
		document.getElementById("reversalsTh").focus();
		return false;
	}
	/*else if(!sound_reg_exp.test(dur)){
		alert("Il campo Frequency puó contenere solo numeri");
		document.getElementById("duration").value = "";
		document.getElementById("duration").focus();
		return false;
	}*/
	return true;    
}

// redirect
function redirect(){
	//finds the type of test in the url
	let params = new URLSearchParams(location.search);
	
	if(params.get('test')=="freq")
		plus = "freq"; //if the type of test is the frequency test, adds it to the href urls
	else if (params.get('test')=="dur")
		plus = "dur"; //if the type of test is the duration test, adds it to the href urls
	if(test()){
		send_value();
		location.href=plus+"test.html";
	}
}