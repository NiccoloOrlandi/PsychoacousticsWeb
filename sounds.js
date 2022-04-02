
 //Prendo i dati condivisi nella cache , dovrá essere sostituita con una ricezione dei dati dal server
 
    var amp =  localStorage.getItem('amplitude'); 
  //document.getElementById('output').innerHTML = amp;

    var freq =  localStorage.getItem('frequency'); 
  

    var dur =  localStorage.getItem('duration'); 
  
    var delta = localStorage.getItem('level');

    var stdFactor =  localStorage.getItem('factor'); 
 
    var reversals =  localStorage.getItem('reversals'); 
  
   
   

//contesto e dichiarazione variabili da cambiare durante il test, probabilmente andranno tolte molte variabili globali da qui una volta terminato l'algoritmo
var context= new AudioContext();

                  // minimum initial variation 

var varFreq = freq;                           // frequency of the variable 

var stdFreq = freq;                           // frequency of the standard 

var stdDur = dur/1000;                        // duration of the standard 

var varDur = dur/1000;                        // duration of the variable 

var intStd = 10**(amp/20);                    // intensity of the variable

var intVar = 10**((-parseInt(amp)+parseInt(delta))/20);  // intensity of the standard 

var swap =-1;                                 // initial value of swap


var factor = stdFactor;                       

// array and variables for data storage

const history = [];

var i = 0;                                    // next index of the array

var countRev = 0;                             // count of reversals 

//funzione per generare il primo suono
function playVar(time){

    //volume
    var volume1 = context.createGain();
    // do una valore al guadagno
    volume1.gain.value = intVar;
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
    volume2.gain.value = intStd;
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

        playStd(0);
        playVar(2);
        swap = 1;

        console.log(swap);   
    }
    else{

       playVar(0);
       playStd(2);
       swap = 0;
    }  

    alert(intStd)
    alert(intVar)
}


//funzioni per implementare l'algoritmo SimpleUpDown
function selectFirst(){

    
    if(swap==0)
    {
        intVar = intVar - 10**(-parseInt(delta)*parseInt(factor)/20);
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
    else
    {
        intVar = intVar + 10**(-parseInt(delta)*parseInt(factor)/20);
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


/*
    selector = 1;
    if((swap==0)&&(intVar>=intStd)&&(selector ==1)){

        intVar=intVar + delta*factor
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
    else if((swap==1)&&(intVar<intStd)&&(selector == 1)){

        intVar=intVar*factor
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
    else if((swap==1)&&(intVar>=intStd)&&(selector == 1)){
        
        intStd=intStd/factor
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
    else if((swap==0)&&(intVar<intStd)&&(selector == 1)){
        
        intVar=intVar/factor
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
   
*/
}   

function selectSecond(){

    if(swap==0)
    {
        
        intVar =intVar + 10**(-parseInt(delta)*parseInt(factor)/20);
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
        intVar =intVar - 10**(-parseInt(delta)*parseInt(factor)/20);
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


/*      
    selector = 2;
    if((swap ==0)&&(intVar<intStd)&&(selector == 2)){

        intVar=intVar*factor
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
    else if((swap==1)&&(intVar>=intStd)&&(selector == 2)) {
        
        intStd=intStd*factor 
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
    else if((swap==1)&&(intVar<intStd)&&(selector == 2)){

        intVar=intVar/factor
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
    else if((swap==0)&&(intVar>=intStd)&&(selector == 2)){
        
        intStd=intStd/factor
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

*/  
}

