
 //Prendo i dati condivisi nella cache , dovrá essere sostituita con una ricezione dei dati dal server
 
    var amp =  localStorage.getItem('amplitude');                   // amplitude from the previous form
  //document.getElementById('output').innerHTML = amp;

    var freq =  localStorage.getItem('frequency');                  // frequency from the previous form
  
    var dur =  localStorage.getItem('duration');                    // duration from the previous form
  
    var delta = localStorage.getItem('level');                      // delta from the previous form

    var stdFactor =  localStorage.getItem('factor');                // factor from the previous form
 
    var reversals =  localStorage.getItem('reversals');             // reversals from the previous form
  
   
   

//contesto e dichiarazione variabili da cambiare durante il test, probabilmente andranno tolte molte variabili globali da qui una volta terminato l'algoritmo
var context= new AudioContext();

                  // minimum initial variation 

var varFreq = freq;                                                  // frequency of the variable 

var stdFreq = freq;                                                  // frequency of the standard 

var stdDur = dur/1000;                                               // duration of the standard 

var varDur = dur/1000;                                               // duration of the variable 

var intStd = parseInt(amp);                                                    // intensity of the variable in dB

var intVar = parseInt(amp) + parseInt(delta);                                            // intensity of the standard in dB

var swap =-1;                                                        // initial value of swap

var factor = stdFactor;                                              // factor setted as the std Factor

alert(intStd)
alert(intVar)

// array and variables for data storage

const history = [];                                                  // history of the test

var i = 0;                                                           // next index of the array

var countRev = 0;                                                    // count of reversals 

//funzione per generare il primo suono
function playVar(time){

    //volume
    var volume1 = context.createGain();
    // do una valore al guadagno
    volume1.gain.value = (10**(parseInt(intVar)/20)/10); 
    //collego all'uscita audio
    volume1.connect(context.destination);

    //Creiamo il primo oscillatore
    oscillator = context.createOscillator();
    //Colleghiamo l'oscillatore al
    oscillator.connect(volume1);
    //frequency
    oscillator.frequency.value = varFreq;
    // tipo di onda 
    oscillator.type = "sine"; 
    //Facciamo partire l'oscillatore
    oscillator.start(context.currentTime+time);
    //Fermiamo l'oscillatore dopo 3 secondi
    oscillator.stop(context.currentTime + time + 1);

}
//funzione per generare il secondo suono
function playStd(time){

    var volume2 = context.createGain();         
    // do una valore al guadagno
    volume2.gain.value = (10**(parseInt(intStd)/20)/10);
    //collego all'uscita audio
    volume2.connect(context.destination);

    //Creiamo il primo oscillatore
    oscillator = context.createOscillator();
    //Colleghiamo l'oscillatore al
    oscillator.connect(volume2);
    //frequency
    oscillator.frequency.value = stdFreq;
    // tipo di onda 
    oscillator.type = "sine"; 
    //Facciamo partire l'oscillatore
    oscillator.start(context.currentTime+time);
    //Fermiamo l'oscillatore dopo 3 secondi
    oscillator.stop(context.currentTime + time + 1);

}

//funzione per randomizzare l'output
function random(){

    var num = Math.floor(Math.random() *2);             // this random decides if the variable sound will be reproduced as the first or second heared sound
    
    if(num==0){

        playStd(0);                                     // first play the std sound
        playVar(2);                                     // then play the variable sound
        swap = 1;                                       // save that we swapped the order of the two                        
    }
    else{

       playVar(0);                                      // first play the variable sound
       playStd(2);                                      // then play the std sound
       swap = 0;                                        // save that we did not swapped the order of the two
    }  

    //after playing the sound, the response buttons are reactivated
	oscillator.onended = () => { //quando l'oscillatore sta suonando il programma non si ferma, quindi serve questo per riattivare i pulsanti solo quando finisce
		document.getElementById("first").disabled = false;
		document.getElementById("second").disabled = false;
	}


}


//SimpleUpdDown functions 

function selectFirst(){

    

    if(swap==0)
    {
        delta = intVar - intStd;                                     // calculate the difference between the amplitude of the two sounds
        intVar = intVar - parseInt(delta)/parseInt(factor);                               // sub the half of the delta so that you can never reach the intStd
        history[i] = 1;                                                 
        if((i>0)&&(history[i]!=history[i-1]))
        {
            countRev++;
        }

        if(countRev == reversals) 
            alert("il test é finito");
        i++;
        alert(countRev)
    }
    else
    {
        delta = intVar- intStd;
        intVar = intVar + parseInt(delta)/parseInt(factor); 
        history[i] = 0;
        if((i>0)&&(history[i]!=history[i-1]))
        {
            countRev++;
        }
        
        if(countRev == reversals) 
            alert("il test é finito");
        i++;
        alert(countRev)
    }
    alert(intVar);


}   

function selectSecond(){

    
    if(swap==0)
    {
        
        delta = intVar - intStd;
        intVar = intVar - parseInt(delta)/parseInt(factor);
        history[i] = 0;
        if((i>0)&&(history[i]!=history[i-1]))
        {
            countRev++;
        }
        
        if(countRev == reversals) 
            alert("il test é finito");
        i++;
        alert(countRev)
    }
    else
    { 
        delta = intVar- intStd;
        intVar = intVar - parseInt(delta)/parseInt(factor);
        history[i] =1;
        if((i>0)&&(history[i]!=history[i-1]))
        {
            countRev++;
        }

        if(countRev == reversals) 
            alert("il test é finito");
        i++;
        alert(countRev)
    }
    alert(intVar);
    

}

//funzione per iniziare
function start(){
	document.getElementById("StartingWindow").style.display="none"; //rendo invisibile la finestra iniziale
	document.getElementById("PlayForm").style.display="inherit"; //rendo visibile l'interfaccia del test
	random(); //comincia il test
}

