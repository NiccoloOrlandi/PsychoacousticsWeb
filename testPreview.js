var context = new AudioContext();

// minimum initial variation
var varFreq = freq;					// frequency of the variable
var stdFreq = freq;					// frequency of the standard

var startingDelta = delta;

var stdDur = dur;					// duration of the standard
var varDur = dur;					// duration of the variable

var stdAmp = amp;					// intensity of the standard
var varAmp = amp;				    // intensity of the variable

switch (type) {
    case "amplitude":
        varAmp = amp + startingDelta;
        break;
    case "frequency":
        varFreq = freq + startingDelta;
        break;
    case "duration":
        varDur = dur + startingDelta;
        break;
}

var stdMod = mod;                   // onset and offset duration of ramp of the standard
var varMod = mod;                   // onset and offset duration of ramp of the variable

var swap = -1;						// position of variable sound

var maxDur = 15;                    // durata massima rumore
var betweenRampDur = 0.03           // durata rampa nel gap

var channels = 2;   // durata massima rumore
var frameCount = context.sampleRate * maxDur;   // durata rampa nel gap
var myArrayBuffer = context.createBuffer(channels, frameCount, context.sampleRate); // numero canali di uscita
for (let channel = 0; channel < channels; channel++) {  // imposto una duarata massima del rumore di n (15) secondi
    let nowBuffering = myArrayBuffer.getChannelData(channel);
    for (let i = 0; i < frameCount; i++) {
        nowBuffering[i] = Math.random() * 2 - 1;
    }
}

//funzione per generare il primo suono
function playVarSound(time) {
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
    oscillator.stop(context.currentTime + time + (varDur / 1000));  //Fermiamo l'oscillatore dopo dur secondi
}

//funzione per generare il secondo suono
function playStdSound(time) {
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
    oscillator.stop(context.currentTime + time + (stdDur / 1000));//Fermiamo l'oscillatore dopo dur secondi
}

//funzione per generare il primo suono
function playVarNoise(time) {
    let start1 = 0;                                             // punto di partenza della prima metà del rumore
    let end1 = ((varDur / 1000) / 2) - ((delta / 1000) / 2);    // punto di stop della prima metà del rumore
    let start2 = ((varDur / 1000) / 2) + ((delta / 1000) / 2);  // punto di partenza della seconda metà del rumore
    let end2 = varDur / 1000;                                   // punto di stop della seconda metà del rumore

    var volume1 = context.createGain(); // creo volume
    volume1.gain.setValueAtTime(0, context.currentTime);    // imposto volume iniziale a 0
    volume1.connect(context.destination);   // connetto il volume all'uscita
    volume1.gain.setTargetAtTime((10 ** (parseInt(amp) / 20)), context.currentTime + time + start1, mod / 1000);    // eseguo rampa onset iniziale (inizia da start1 e dura mod ms)
    volume1.gain.setTargetAtTime(0, context.currentTime + time + end1 - 3 * (betweenRampDur / 1000), betweenRampDur);   // eseguo rampa offset del gap (inizia a end1 e dura betweenRampDur s)
    volume1.gain.setTargetAtTime((10 ** (parseInt(amp) / 20)), context.currentTime + time + start2, betweenRampDur);  // eseguo rampa onset del gap (inizia a start2 e dura betweenRampDur s)
    volume1.gain.setTargetAtTime(0, context.currentTime + time + end2 - 3 * (mod / 1000), mod / 1000);  // eseguo rampa offset finale (inizia da end2 e dura mod ms)

    source = context.createBufferSource();  // creo sorgente
    source.buffer = myArrayBuffer;  // collego i buffer
    source.connect(volume1);    // connetto la sorgente al volume
    source.start(context.currentTime + time + start1);  // riproduco il rumore
    source.stop(context.currentTime + time + end2); // fermo il rumore
}

//funzione per generare il secondo suono
function playStdNoise(time) {
    var volume2 = context.createGain(); // creo volume
    volume2.gain.setValueAtTime(0, context.currentTime);    // imposto volume iniziale a 0
    volume2.connect(context.destination);   // connetto il volume all'uscita
    volume2.gain.setTargetAtTime((10 ** (parseInt(amp) / 20)), context.currentTime + time, stdMod / 1000);  // eseguo rampa onset iniziale
    volume2.gain.setTargetAtTime(0, context.currentTime + time + (stdDur / 1000) - 3 * (stdMod / 1000), mod / 1000);    // eseguo rampa offset finale

    source = context.createBufferSource();  // creo sorgente
    source.buffer = myArrayBuffer;  // collego i buffer
    source.connect(volume2);    // connetto la sorgente al volume
    source.start(context.currentTime + time);   // riproduco il rumore
    source.stop(context.currentTime + time + (stdDur / 1000));  // fermo il rumore
}


//funzione per randomizzare l'output
function random() {
    for (var j = 1; j <= nAFC; j++)
        document.getElementById("button" + j).disabled = true;
    document.getElementById("playTest").disabled = true;
    document.getElementById("alert").style.visibility = "hidden";

    var rand = Math.floor(Math.random() * nAFC);// the variable sound will be the rand-th sound played

    for (var j = 0; j < nAFC; j++) {
        if (type == "amplitude" || type == "frequency") {
            if (j == rand) {
                playVarSound((j * (dur / 1000)) + j * (ISI / 1000));
            } else {
                playStdSound((j * (dur / 1000)) + j * (ISI / 1000));
            }
        } else if (type == "duration") {
            if (j == rand)
                playVarSound((j * (stdDur / 1000)) + j * (ISI / 1000));
            else if (j < rand)
                playStdSound((j * (stdDur / 1000)) + j * (ISI / 1000));
            else if (j > rand)
                playStdSound(((j - 1) * (stdDur / 1000)) + (varDur / 1000) + j * (ISI / 1000));
        } else if (type == "gap") {
            if (j == rand)
                playVarNoise((j * (dur / 1000)) + j * (ISI / 1000));
            else
                playStdNoise((j * (dur / 1000)) + j * (ISI / 1000));
        }
    }

    swap = rand + 1;

    //after playing the sound, the response buttons are reactivated
    if (type != "gap") {
        oscillator.onended = () => { //quando l'oscillatore sta suonando il programma non si ferma, quindi serve questo per riattivare i pulsanti solo quando finisce
            for (var j = 1; j <= nAFC; j++)
                document.getElementById("button" + j).disabled = false;
            document.getElementById("playTest").disabled = false;
        }
    } else {
        source.onended = () => { //quando l'oscillatore sta suonando il programma non si ferma, quindi serve questo per riattivare i pulsanti solo quando finisce
            for (var j = 1; j <= nAFC; j++)
                document.getElementById("button" + j).disabled = false;
            document.getElementById("playTest").disabled = false;
        }
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