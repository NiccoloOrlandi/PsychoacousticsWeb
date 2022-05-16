//contesto e dichiarazione variabili da cambiare durante il test, probabilmente andranno tolte molte variabili globali da qui una volta terminato l'algoritmo
var context= new AudioContext();

// minimum initial variation
var varFreq = parseInt(freq) + parseInt(delta);	// frequency of the variable 
var stdFreq = parseInt(freq);					// frequency of the standard
 
var stdDur = dur/1000;				// duration of the standard 
var varDur = dur/1000;				// duration of the variable 

var intStd = parseFloat(amp);		// intensity of the variable
var intVar = parseFloat(amp);		// intensity of the standard 

var swap =-1;						// initial value of swap			
var correctAnsw = 0;				// number of correct answers

var currentFactor = factor;			// first or second factor, depending on the number of reversals

// array and variables for data storage
const history = [];				// will have the answers ('1' if right, '0' if wrong)
var reversalsPositions = [];	// will have the position of the i-th reversal in the history array 
var i = 0;						// next index of the array
var countRev = 0;				// count of reversals 
var results = [[], [], [], [], [], [], [], []];		// block, trial, delta, variable value, variable position, pressed button, correct answer?, reversals
var score = 0					// final score
var positiveStrike = -1;		// -1 = unsetted, 0 = negative strike, 1 = positive strike

var timestamp = 0;				// timestamp of the starting of the test
var pressedButton;
//funzione per generare il primo suono
function playVar(time){
	var volume1 = context.createGain();		//volume
	volume1.gain.value = (10**(parseInt(intVar)/20));			// do una valore al guadagno
	volume1.connect(context.destination);	//collego all'uscita audio

	oscillator = context.createOscillator();//Creiamo il primo oscillatore
	oscillator.connect(volume1);			//Colleghiamo l'oscillatore al
	oscillator.frequency.value = varFreq;	//frequency
	oscillator.type = "sine";				// tipo di onda
	
	oscillator.start(context.currentTime + time);		//Facciamo partire l'oscillatore
	oscillator.stop(context.currentTime + time + 1);//Fermiamo l'oscillatore dopo 1 secondo
}

//funzione per generare il secondo suono
function playStd(time){
	var volume2 = context.createGain();		//volume
	volume2.gain.value = (10**(parseInt(intStd)/20))			//do una valore al guadagno
	volume2.connect(context.destination);	//collego all'uscita audio

	oscillator = context.createOscillator();//Creiamo il secondo oscillatore
	oscillator.connect(volume2);			//Colleghiamo l'oscillatore al
	oscillator.frequency.value = stdFreq;	//frequency
	oscillator.type = "sine";				//tipo di onda

	oscillator.start(context.currentTime + time);		//Facciamo partire l'oscillatore
	oscillator.stop(context.currentTime + time + 1);//Fermiamo l'oscillatore dopo 1 secondo
}

//funzione per randomizzare l'output
function random(){
	var rand = Math.floor(Math.random() *2);// this random decides if the variable sound will be reproduced as the first or second heared sound
	rand = 1;
	if(rand==0){//first played: Standard sound
		playStd(0);
		playVar(2);
		swap = 1;
	}
	else{//first played: Variable sound
		playVar(0);
		playStd(2);
		swap = 0;
	}  
	
	//after playing the sound, the response buttons are reactivated
	oscillator.onended = () => { //quando l'oscillatore sta suonando il programma non si ferma, quindi serve questo per riattivare i pulsanti solo quando finisce
		document.getElementById("first").disabled = false;
		document.getElementById("second").disabled = false;
	}
}

//funzione per implementare l'algoritmo SimpleUpDown
function select(button){
	switch(algorithm){
		case 'SimpleUpDown':
			nDOWNoneUP(1, button);
			break;
		case 'TwoDownOneUp':
			nDOWNoneUP(2, button);
			break;
		case 'ThreeDownOneUp':
			nDOWNoneUP(3, button);
			break;
		default:
			nDOWNoneUP(1, button);
			break;
	}
	
	//save new data
	alert(swap);
	results[0][i] = 1;					// blocco --> da implementare in futuro
	results[1][i] = i+1;				// trial
	results[2][i] = varFreq-stdFreq; 	// delta
	results[3][i] = varFreq;			// variable value
	results[4][i] = swap+1;				// variable position
	results[5][i] = pressedButton; 		// pulsante premuto
	results[6][i] = history[i]			// correttezza risposta
	results[7][i] = countRev;			// reversals
	
	//increment counter
	i++;
	
	//use the second factor from now
	if(countRev == reversals)
		currentFactor = secondFactor;
	
	//end of the test
	if(countRev == reversals+secondReversals){
		alert("il test é finito");
		
		//format datas as a csv file (only the last <reversalThreshold> reversals)
		var result = "blocks,trials,delta,variableValue,variablePosition,button,correct,reversals;";
		for(var j = Math.min(reversalsPositions[countRev - reversalThreshold]-1,0); j < i; j++){
			result += results[0][j] + "," + results[1][j] + "," + results[2][j] + "," + results[3][j] + "," + results[4][j] + "," + results[5][j] + "," + results[6][j] + "," + results[7][j] + ";";
		}
		
		//format description as a csv file
		//prima tutti i nomi, poi tutti i dati
		var description = "&amp="+amp+"&freq="+freq+"&dur="+dur+/*"&phase="+phase+*/"&blocks="+blocks+"&delta="+delta;
		description += "&nAFC="+nAFC+"&fact="+factor+"&secFact="+secondFactor+"&rev="+reversals+"&secRev="+secondReversals;
		description += "&threshold="+reversalThreshold+"&alg="+algorithm;
		
		//pass the datas to the php file
		location.href="salvaDati.php?result="+result+"&timestamp="+timestamp+"&type=freq"+description+"&score="+(score/countRev);
	}
	//if the test is not ended
	else{
	
		// disable the response buttons until the new sounds are heared
		document.getElementById("first").disabled = true;
		document.getElementById("second").disabled = true;
		
		//randomize and play the next sounds
		random();
	}
}

//funzione per implementare l'algoritmo nD1U
function nDOWNoneUP(n, button){
	delta = varFreq-stdFreq;
	pressedButton = button;
	if((button == 1 && swap == 0) || (button == 2 && swap == 1)){ //correct answer
		history[i] = 0;
		correctAnsw += 1;
		if(correctAnsw == n){ //if there are n consegutive correct answers
			varFreq = stdFreq + (delta/parseInt(currentFactor));
			correctAnsw = 0;
			if(positiveStrike == 0){
				//there was a reversal
				reversalsPositions[countRev] = i-(n-1);//save the position of that reversal
				countRev++;
				
				//calculate score
				score += (delta + (varFreq-stdFreq))/2;
			}
			positiveStrike = 1;
		}
		if(feedback)
			alert("Risposta corretta")
		
	}else{ //wrong answer
		varFreq = stdFreq + (delta*parseInt(currentFactor));
		history[i] = 1;
		correctAnsw = 0;
		
		if(positiveStrike == 1){
			//there was a reversal
			reversalsPositions[countRev] = i;//save the position of that reversal
			countRev++;
			
			//calculate score
			score += (delta + (varFreq-stdFreq))/2;
		}
		positiveStrike = 0;
		
		if(feedback)
			alert("Risposta errata")
	}
}

//funzione per iniziare
function start(){
	document.getElementById("StartingWindow").style.display="none"; //rendo invisibile la finestra iniziale
	document.getElementById("PlayForm").style.display="inherit"; //rendo visibile l'interfaccia del test
	
	// take the timestamp when the test starts
	var currentdate = new Date(); 
	timestamp = currentdate.getFullYear()+"-"+(currentdate.getMonth()+1)+"-"+currentdate.getDate()+" "+currentdate.getHours()+":"+currentdate.getMinutes()+":"+currentdate.getSeconds();
	
	random(); //comincia il test
}
