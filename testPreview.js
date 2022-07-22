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
        break;
}

var stdMod = mod;                   // onset and offset duration of ramp of the standard
var varMod = mod;                   // onset and offset duration of ramp of the variable

var swap = -1;						// position of variable sound

var channels = 2;
var frameCount = context.sampleRate * 10;
var myArrayBuffer = context.createBuffer(channels, frameCount, context.sampleRate);
for (let channel = 0; channel < channels; channel++) {
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
    oscillator.stop(context.currentTime + time + (varDur / 1000));//Fermiamo l'oscillatore dopo 1 secondo
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
    oscillator.stop(context.currentTime + time + (stdDur / 1000));//Fermiamo l'oscillatore dopo 1 secondo
}

//funzione per generare il primo suono
function playVarNoise(time) {
    let start1 = 0;
    let end1 = ((varDur / 1000) / 2) - ((delta / 1000) / 2);
    let start2 = ((varDur / 1000) / 2) + ((delta / 1000) / 2);
    let end2 = varDur / 1000;

    var volume1 = context.createGain();
    volume1.gain.setValueAtTime(0, context.currentTime);
    volume1.connect(context.destination);
    volume1.gain.setTargetAtTime((10 ** (parseInt(amp) / 20)), context.currentTime + time + start1, mod / 1000);
    volume1.gain.setTargetAtTime(0, context.currentTime + time + end1 - 3 * (0.03 / 1000), 0.03);
    volume1.gain.setTargetAtTime((10 ** (parseInt(amp) / 20)), context.currentTime + time + start2, 0.03);
    volume1.gain.setTargetAtTime(0, context.currentTime + time + end2 - 3 * (mod / 1000), mod / 1000);


    source = context.createBufferSource();
    source.buffer = myArrayBuffer;
    source.connect(volume1);

    source.start(context.currentTime + time + start1);
    source.stop(context.currentTime + time + end2);
}

//funzione per generare il secondo suono
function playStdNoise(time) {
    var volume2 = context.createGain();
    volume2.gain.setValueAtTime(0, context.currentTime);
    volume2.connect(context.destination);

    volume2.gain.setTargetAtTime((10 ** (parseInt(amp) / 20)), context.currentTime + time, stdMod / 1000);

    volume2.gain.setTargetAtTime(0, context.currentTime + time + (stdDur / 1000) - 3 * (stdMod / 1000), mod / 1000);

    source = context.createBufferSource();
    source.buffer = myArrayBuffer;
    source.connect(volume2);
    source.start(context.currentTime + time);
    source.stop(context.currentTime + time + (stdDur / 1000));
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
            if (type != "gap")
                playVarSound((j * (dur / 1000)) + j * (ISI / 1000));
            else
                playVarNoise((j * (dur / 1000)) + j * (ISI / 1000));
        else if (type != "gap")
            playStdSound((j * (dur / 1000)) + j * (ISI / 1000));
        else
            playStdNoise((j * (dur / 1000)) + j * (ISI / 1000));
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