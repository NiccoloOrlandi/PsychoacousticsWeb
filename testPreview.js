var context = new AudioContext();

// minimum initial variation
var varFreq = freq;					// frequency of the variable
var stdFreq = freq;					// frequency of the standard

var startingDelta = delta;

var stdDur = dur;					// duration of the standard
var varDur = dur;					// duration of the variable

var stdAmp = amp;					// intensity of the standard
var varAmp = amp;				// intensity of the variable

switch (type) {
    case "amplitude":
        varAmp = amp + startingDelta;
        break;
    case "frequency":
        varFreq = freq + startingDelta;
        break;
    case "duration":
        varDur = dur + startingDelta;
}

var stdMod = mod;                   // onset and offset duration of ramp of the standard
var varMod = mod;                   // onset and offset duration of ramp of the variable

var swap = -1;						// position of variable sound

//funzione per generare il primo suono
function playVar(time) {
    var volume1 = context.createGain();		//volume
    volume1.gain.setValueAtTime(0, context.currentTime + time); //imposto volume iniziale a 0
    volume1.connect(context.destination);	//collego all'uscita audio
    volume1.gain.setTargetAtTime((10 ** (parseInt(varAmp) / 20)), context.currentTime + time, varMod / 1000);   //implemento onset ramp
    volume1.gain.setTargetAtTime(0, context.currentTime + time + (varDur / 1000) - 3 * (varMod / 1000), varMod / 1000); //implemento offset ramp (l'espressione "3 * (Mod/1000)" serve a garantire un raggiungimento del target del 95% circa, guardare documentazione di setTargetAtTime, in particolare la tabella del timecostant)

    oscillator = context.createOscillator();//Creiamo il primo oscillatore
    oscillator.connect(volume1);			//Colleghiamo l'oscillatore al
    oscillator.frequency.value = varFreq;	//frequency
    oscillator.type = "sine";				// tipo di onda

    oscillator.start(context.currentTime + time);		//Facciamo partire l'oscillatore
    oscillator.stop(context.currentTime + time + (varDur / 1000));//Fermiamo l'oscillatore dopo 1 secondo
}

//funzione per generare il secondo suono
function playStd(time) {
    var volume2 = context.createGain();		//volume
    volume2.gain.setValueAtTime(0, context.currentTime + time);	//imposto volume iniziale a 0
    volume2.connect(context.destination);	//collego all'uscita audio
    volume2.gain.setTargetAtTime((10 ** (parseInt(stdAmp) / 20)), context.currentTime + time, stdMod / 1000);   //implemento onset ramp
    volume2.gain.setTargetAtTime(0, context.currentTime + time + (stdDur / 1000) - 3 * (stdMod / 1000), stdMod / 1000); //implemento offset ramp (l'espressione "3 * (Mod/1000)" serve a garantire un raggiungimento del target del 95% circa, guardare documentazione di setTargetAtTime, in particolare la tabella del timecostant)

    oscillator = context.createOscillator();//Creiamo il secondo oscillatore
    oscillator.connect(volume2);			//Colleghiamo l'oscillatore al
    oscillator.frequency.value = stdFreq;	//frequency
    oscillator.type = "sine";				//tipo di onda

    oscillator.start(context.currentTime + time);		//Facciamo partire l'oscillatore
    oscillator.stop(context.currentTime + time + (stdDur / 1000));//Fermiamo l'oscillatore dopo 1 secondo
}

//funzione per randomizzare l'output
function random() {
    for (var j = 1; j <= nAFC; j++)
        document.getElementById("button" + j).disabled = true;
    document.getElementById("playTest").disabled = true;
    document.getElementById("alert").style.visibility = "hidden";

    var rand = Math.floor(Math.random() * nAFC);// the variable sound will be the rand-th sound played

    for (var j = 0; j < nAFC; j++) {
        if (j == rand)
            playVar((j * (dur / 1000)) + j * (ISI / 1000));
        else
            playStd((j * (dur / 1000)) + j * (ISI / 1000));
    }

    swap = rand + 1;

    //after playing the sound, the response buttons are reactivated
    oscillator.onended = () => { //quando l'oscillatore sta suonando il programma non si ferma, quindi serve questo per riattivare i pulsanti solo quando finisce
        for (var j = 1; j <= nAFC; j++)
            document.getElementById("button" + j).disabled = false;
        document.getElementById("playTest").disabled = false;
    }
}

function select(button) {
    for (var j = 1; j <= nAFC; j++)
        document.getElementById("button" + j).disabled = true;
    let element = document.getElementById("alert")
    if (button == swap) {
        element.style.visibility = "visible";
        element.innerText = "Correct!"
        element.classList.remove("alert-danger");
        element.classList.add("alert-success");
    } else {
        element.style.visibility = "visible";
        element.innerText = "Wrong!"
        element.classList.remove("alert-success");
        element.classList.add("alert-danger");
    }
}