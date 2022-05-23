//contesto e dichiarazione variabili da cambiare durante il test, probabilmente andranno tolte molte variabili globali da qui una volta terminato l'algoritmo
var context= new AudioContext();

// minimum initial variation
var varFreq = freq;	// frequency of the variable 
var stdFreq = freq;					// frequency of the standard
var startingDelta = delta;

var stdDur = dur/1000;				// duration of the standard 
var varDur = dur/1000;				// duration of the variable 

var stdAmp = amp;					// intensity of the variable
var varAmp = amp+delta;				// intensity of the standard 

var swap =-1;						// position of variable sound			
var correctAnsw = 0;				// number of correct answers

var currentFactor = factor;			// first or second factor, depending on the number of reversals

// array and variables for data storage
var history = [];				// will have the answers ('1' if right, '0' if wrong)
var reversalsPositions = [];	// will have the position of the i-th reversal in the history array 
var i = 0;						// next index of the array
var countRev = 0;				// count of reversals 
var results = [[], [], [], [], [], [], [], []];		// block, trial, delta, variable value, variable position, pressed button, correct answer?, reversals
var score = 0					// final score
var positiveStrike = -1;		// -1 = unsetted, 0 = negative strike, 1 = positive strike
var currentBlock = 1;			// current testing block
var result = "";				// final results that will be saved on the db

var timestamp = 0;				// timestamp of the starting of the test
var pressedButton;

//funzione per generare il primo suono
function playVar(time){
	var volume1 = context.createGain();		//volume
	volume1.gain.value = (10**(parseInt(varAmp)/20));			// do una valore al guadagno
	volume1.connect(context.destination);	//collego all'uscita audio

	oscillator = context.createOscillator();//Creiamo il primo oscillatore
	oscillator.connect(volume1);			//Colleghiamo l'oscillatore al
	oscillator.frequency.value = varFreq;	//frequency
	oscillator.type = "sine";				// tipo di onda
	
	oscillator.start(context.currentTime + time);		//Facciamo partire l'oscillatore
	oscillator.stop(context.currentTime + time + (dur/1000));//Fermiamo l'oscillatore dopo 1 secondo
}

//funzione per generare il secondo suono
function playStd(time){
	var volume2 = context.createGain();		//volume
	volume2.gain.value = (10**(parseInt(stdAmp)/20))			//do una valore al guadagno
	volume2.connect(context.destination);	//collego all'uscita audio

	oscillator = context.createOscillator();//Creiamo il secondo oscillatore
	oscillator.connect(volume2);			//Colleghiamo l'oscillatore al
	oscillator.frequency.value = stdFreq;	//frequency
	oscillator.type = "sine";				//tipo di onda

	oscillator.start(context.currentTime + time);		//Facciamo partire l'oscillatore
	oscillator.stop(context.currentTime + time + (dur/1000));//Fermiamo l'oscillatore dopo 1 secondo
}

//funzione per randomizzare l'output
function random(){
	var rand = Math.floor(Math.random() * nAFC);// the variable sound will be the rand-th sound played
	rand=0;
	
	for(var j=0;j<nAFC;j++){
		if(j==rand)
			playVar((j*(dur/1000)) + j);
		else
			playStd((j*(dur/1000)) + j);
	}
	
	swap = rand+1;
	
	//after playing the sound, the response buttons are reactivated
	oscillator.onended = () => { //quando l'oscillatore sta suonando il programma non si ferma, quindi serve questo per riattivare i pulsanti solo quando finisce
		for(var j=1;j<=nAFC;j++)
			document.getElementById("button"+j).disabled = false;
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
	results[0][i] = currentBlock;		// blocco --> da implementare in futuro
	results[1][i] = i+1;				// trial
	results[2][i] = varAmp-stdAmp; 	// delta
	results[3][i] = varAmp;			// variable value
	results[4][i] = swap;				// variable position
	results[5][i] = pressedButton; 		// pulsante premuto
	results[6][i] = history[i];			// correttezza risposta
	results[7][i] = countRev;			// reversals
	
	//increment counter
	i++;
	
	//use the second factor from now
	if(countRev == reversals)
		currentFactor = secondFactor;
	
	//end of the test
	if(countRev == reversals+secondReversals){
		//format datas as a csv file (only the last <reversalThreshold> reversals)
		//format: block;trials;delta;variableValue;variablePosition;button;correct;reversals;";
		for(var j = Math.min(reversalsPositions[countRev - reversalThreshold]-1,0); j < i; j++){
			result += results[0][j] + ";" + results[1][j] + ";" + results[2][j] + ";" + results[3][j] + ";"
			result += results[4][j] + ";" + results[5][j] + ";" + results[6][j] + ";" + results[7][j] + ",";
		}
			
		if(currentBlock<blocks){
			currentBlock += 1;
			
			delta = startingDelta;
			varAmp = amp + delta;
			swap =-1;						// position of variable sound			
			correctAnsw = 0;				// number of correct answers

			currentFactor = factor;			// first or second factor, depending on the number of reversals

			history = [];				// will have the answers ('1' if right, '0' if wrong)
			reversalsPositions = [];	// will have the position of the i-th reversal in the history array 
			i = 0;						// next index of the array
			countRev = 0;
			score = 0					// final score
			positiveStrike = -1;
			
			random(); 					//ricomincia il test
		}else{
			//calculate score 
			for(var j = countRev - reversalThreshold; j<countRev; j++){
				deltaBefore = results[2][reversalsPositions[j]-1]; //delta before the reversal
				deltaAfter = results[2][reversalsPositions[j]]; //delta after the reversal
				score += (deltaBefore + deltaAfter)/2; //average delta of the reversal
			}
			score /= reversalThreshold; //average deltas of every reversal
			score = parseFloat(parseInt(score*100)/100); //approximate to 2 decimal digits
			
			//format description as a csv file
			//prima tutti i nomi, poi tutti i dati
			var description = "&amp="+amp+"&freq="+freq+"&dur="+dur+/*"&phase="+phase+*/"&blocks="+blocks+"&delta="+startingDelta;
			description += "&nAFC="+nAFC+"&fact="+factor+"&secFact="+secondFactor+"&rev="+reversals+"&secRev="+secondReversals;
			description += "&threshold="+reversalThreshold+"&alg="+algorithm;
			
			alert(result);
			//pass the datas to the php file
			location.href="salvaDati.php?result="+result+"&timestamp="+timestamp+"&type=amp"+description+"&score="+score+"&saveSettings="+saveSettings;
		}
	}
	//if the test is not ended
	else{
	
		// disable the response buttons until the new sounds are heared
		for(var j=1;j<=nAFC;j++)
			document.getElementById("button"+j).disabled = true;
		
		//randomize and play the next sounds
		random();
	}
}

//funzione per implementare l'algoritmo nD1U
function nDOWNoneUP(n, button){
	delta = varAmp-stdAmp;
	pressedButton = button;
	if(button == swap){ //correct answer
		history[i] = 0;
		correctAnsw += 1;
		if(correctAnsw == n){ //if there are n consegutive correct answers
			varAmp = stdAmp + (delta/parseInt(currentFactor));
			correctAnsw = 0;
			if(positiveStrike == 0){
				//there was a reversal
				reversalsPositions[countRev] = i-(n-1);//save the position of that reversal
				countRev++;
			}
			positiveStrike = 1;
		}
		if(feedback)
			alert("Risposta corretta")
		
	}else{ //wrong answer
		varAmp = stdAmp + (delta*parseInt(currentFactor));
		history[i] = 1;
		correctAnsw = 0;
		
		if(positiveStrike == 1){
			//there was a reversal
			reversalsPositions[countRev] = i;//save the position of that reversal
			countRev++;
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
