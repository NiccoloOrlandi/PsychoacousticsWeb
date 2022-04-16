
//Prendo i dati condivisi nella cache , dovrá essere sostituita con una ricezione dei dati dal server 
var amp = localStorage.getItem('amplitude');		// amplitude from the previous form
var freq = localStorage.getItem('frequency'); 		// frequency from the previous form
var dur = localStorage.getItem('duration'); 		// duration from the previous form
var delta = localStorage.getItem('level');			// delta from the previous form
var stdFactor = localStorage.getItem('factor'); 	// factor from the previous form
var reversals = localStorage.getItem('reversals');	// reversals from the previous form
var algorithm = localStorage.getItem('algorithm');	//algorithm from the previous form

//contesto e dichiarazione variabili da cambiare durante il test, probabilmente andranno tolte molte variabili globali da qui una volta terminato l'algoritmo
var context= new AudioContext();

// minimum initial variation
var varFreq = parseInt(freq) + parseInt(delta);	// frequency of the variable 
var stdFreq = parseInt(freq);					// frequency of the standard
 
var stdDur = dur/1000;					// duration of the standard 
var varDur = dur/1000;					// duration of the variable 

var intStd = parseFloat(amp);		// intensity of the variable
var intVar = parseFloat(amp);		// intensity of the standard 

var swap =-1;							// initial value of swap
var factor = stdFactor;				
var correctAnsw = 0;	   

// array and variables for data storage
const history = [];
var i = 0;					// next index of the array
var countRev = 0;			// count of reversals 

//funzione per generare il primo suono
function playVar(time){
	var volume1 = context.createGain();		//volume
	volume1.gain.value = (10**(parseInt(intVar)/20)/10);			// do una valore al guadagno
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
	volume2.gain.value = (10**(parseInt(intStd)/20)/10)			//do una valore al guadagno
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
		case 'FourDownOneUp':
			nDOWNoneUP(4, button);
			break;
		default:
			nDOWNoneUP(1, button);
			break;
	}
	
	if((i>0)&&(history[i]!=history[i-1]))
			countRev++;

	if(countRev == reversals){
		alert("il test é finito");
		location.href="index.html";
	}
	
	i++;
	
	// disable the response buttons until the new sounds are heared
	document.getElementById("first").disabled = true;
	document.getElementById("second").disabled = true;
	
	random();
}

//funzione per implementare l'algoritmo nD1U
function nDOWNoneUP(n, button){
	delta = varFreq-stdFreq;
	
	if((button == 1 && swap == 0) || (button == 2 && swap == 1)){ //correct answer
		history[i] = 0;
		correctAnsw += 1;
		if(correctAnsw == n){ //if there are n consegutive correct answers
			varFreq = varFreq - (delta/parseInt(factor));
			correctAnsw = 0;
		}
		
	}else{ //wrong answer
		varFreq = varFreq + (delta/parseInt(factor));
		history[i] = 1;
		correctAnsw = 0;
	}
}

//funzione per iniziare
function start(){
	document.getElementById("StartingWindow").style.display="none"; //rendo invisibile la finestra iniziale
	document.getElementById("PlayForm").style.display="inherit"; //rendo visibile l'interfaccia del test
	random(); //comincia il test
}
