var context = new AudioContext();

// minimum initial variation
var varFreq = freq;					// frequency of the variable
var stdFreq = freq;					// frequency of the standard

var startingDelta = delta;

dur /= 1000;                        // cambio unità di misura in secondi
var stdDur = dur;					// duration of the standard
var varDur = dur;					// duration of the variable

var stdAmp = amp;					// intensity of the standard
var varAmp = amp;				    // intensity of the variable

ramp /= 1000;                        // cambio unità di misura in secondi
var stdRamp = ramp;                   // onset and offset duration of ramp of the standard
var varRamp = ramp;                   // onset and offset duration of ramp of the variable

switch (type) {
    case "amplitude":
        varAmp = amp + startingDelta;
        break;
    case "frequency":
        varFreq = freq + startingDelta;
        break;
    case "duration":
        varDur = dur + (startingDelta / 1000);
        break;
    case "nduration":
        varDur = dur + (startingDelta / 1000);
        break;
    case "gap":
        delta = (startingDelta / 1000);
        break;
}

var swap = -1;						// position of variable sound

var betweenRampDur = 0.01           // durata rampa nel gap

function playSound(time, freq, amp, dur, ramp) { // funzione per generare suoni
    var vol = context.createGain(); // creo volume
    vol.gain.value = 1;
    vol.connect(context.destination);   // collego volume all'uscita audio

    var channels = 1;  // numero canali di uscita
    var frameCount = context.sampleRate * dur;   // imposto una duarata massima del suono di n secondi
    var soundBuffer = context.createBuffer(channels, frameCount, context.sampleRate);     // creo un nuovo buffer
    let rampArr = [];
    for (let channel = 0; channel < channels; channel++) {  // riempio il buffer con il suono
        let nowBuffering = soundBuffer.getChannelData(channel);
        for (let i = 0; i < frameCount; i++) {
            t = i / context.sampleRate;
            if (t < ramp) {
                rampArr[i] = (1 + Math.sin((t * Math.PI / ramp) - (Math.PI / 2))) / 2;    // onset ramp
            } else if (t > dur - ramp) {
                rampArr[i] = (1 + Math.sin(((t - (dur - ramp)) * Math.PI / ramp) + (Math.PI / 2))) / 2; // offset ramp
            } else {
                rampArr[i] = 1; // central zone
            }
            nowBuffering[i] = ((10 ** (parseInt(amp) / 20)) * Math.sin(2 * Math.PI * freq * t)) * rampArr[i];   // t = i / context.sampleRate
        }
    }
    source = context.createBufferSource();  // creo sorgente
    source.buffer = soundBuffer;    // collego i buffer
    source.connect(vol);    // connetto la sorgente al volume
    source.start(context.currentTime + time);   // riproduco il suono
    source.stop(context.currentTime + time + dur);  // fermo il suono
}

function playNoise(time, amp, dur, ramp) { // funzione per generare suoni
    var vol = context.createGain(); // creo volume
    vol.gain.value = 1;
    vol.connect(context.destination);   // collego volume all'uscita audio

    var channels = 1;  // numero canali di uscita
    var frameCount = context.sampleRate * dur;   // imposto una duarata massima del suono di n secondi
    var soundBuffer = context.createBuffer(channels, frameCount, context.sampleRate);     // creo un nuovo buffer
    let rampArr = [];
    for (let channel = 0; channel < channels; channel++) {  // riempio il buffer con il suono
        let nowBuffering = soundBuffer.getChannelData(channel);
        for (let i = 0; i < frameCount; i++) {
            t = i / context.sampleRate;
            if (t < ramp) {
                rampArr[i] = (1 + Math.sin((t * Math.PI / ramp) - (Math.PI / 2))) / 2;    // onset ramp
            } else if (t > dur - ramp) {
                rampArr[i] = (1 + Math.sin(((t - (dur - ramp)) * Math.PI / ramp) + (Math.PI / 2))) / 2; // offset ramp
            } else {
                rampArr[i] = 1; // central zone
            }
            nowBuffering[i] = ((10 ** (parseInt(amp) / 20)) * (Math.random() * 2 - 1)) * rampArr[i];   // t = i / context.sampleRate
        }
    }
    source = context.createBufferSource();  // creo sorgente
    source.buffer = soundBuffer;    // collego i buffer
    source.connect(vol);    // connetto la sorgente al volume
    source.start(context.currentTime + time);   // riproduco il suono
    source.stop(context.currentTime + time + dur);  // fermo il suono
}

function playGapNoise(time, amp, dur, ramp, gap) { // funzione per generare suoni
    console.log(delta);
    var vol = context.createGain(); // creo volume
    vol.gain.value = 1;
    vol.connect(context.destination);   // collego volume all'uscita audio

    var channels = 1;  // numero canali di uscita
    var frameCount = context.sampleRate * dur;   // imposto una duarata massima del suono di n secondi
    var soundBuffer = context.createBuffer(channels, frameCount, context.sampleRate);     // creo un nuovo buffer
    let rampArr = [];
    for (let channel = 0; channel < channels; channel++) {  // riempio il buffer con il suono
        let nowBuffering = soundBuffer.getChannelData(channel);
        for (let i = 0; i < frameCount; i++) {
            t = i / context.sampleRate;
            if (t < ramp) {
                rampArr[i] = (1 + Math.sin((t * Math.PI / ramp) - (Math.PI / 2))) / 2;    // onset ramp
            } else if (t >= ramp && t < ((dur / 2) - (gap / 2))) {
                rampArr[i] = 1; // first central zone
            } else if (t >= ((dur / 2) - (gap / 2)) && t < ((dur / 2) - (gap / 2) + betweenRampDur) && t < (dur / 2)) {
                rampArr[i] = (1 + Math.sin(((t - ((dur / 2) - (gap / 2))) * Math.PI / betweenRampDur) + (Math.PI / 2))) / 2; // offset ramp gap
            } else if (t >= ((dur / 2) - (gap / 2) + betweenRampDur) && t < ((dur / 2) + (gap / 2) - betweenRampDur)) {
                rampArr[i] = 0; // central zone in gap
            } else if (t >= ((dur / 2) + (gap / 2) - betweenRampDur) && t < (dur / 2) + (gap / 2)) {
                rampArr[i] = (1 + Math.sin(((t - ((dur / 2) + (gap / 2) - betweenRampDur)) * Math.PI / betweenRampDur) - (Math.PI / 2))) / 2; // onset ramp gap
            } else if (t >= (dur / 2) + (gap / 2) && t < dur - ramp) {
                rampArr[i] = 1; // second central zone
            } else if (t >= dur - ramp) {
                rampArr[i] = (1 + Math.sin(((t - (dur - ramp)) * Math.PI / ramp) + (Math.PI / 2))) / 2; // offset ramp
            } else {
                console.log("errore");
            }
            nowBuffering[i] = ((10 ** (parseInt(amp) / 20)) * (Math.random() * 2 - 1)) * rampArr[i];   // t = i / context.sampleRate
        }
    }
    source = context.createBufferSource();  // creo sorgente
    source.buffer = soundBuffer;    // collego i buffer
    source.connect(vol);    // connetto la sorgente al volume
    source.start(context.currentTime + time);   // riproduco il suono
    source.stop(context.currentTime + time + dur);  // fermo il suono
}

//funzione per randomizzare l'output
function random() {
    for (var j = 1; j <= nAFC; j++)
        document.getElementById("button" + j).disabled = true;
    document.getElementById("playTest").disabled = true;
    document.getElementById("alert").style.visibility = "hidden";

    var rand = Math.floor(Math.random() * nAFC); // the variable sound will be the rand-th sound played

    for (var j = 0; j < nAFC; j++) {
        if (type == "amplitude" || type == "frequency") {
            if (j == rand)
                playSound((j * varDur) + j * (ISI / 1000), varFreq, varAmp, varDur, varRamp);
            else
                playSound((j * stdDur) + j * (ISI / 1000), stdFreq, stdAmp, stdDur, stdRamp);
        } else if (type == "duration") {
            if (j == rand)
                playSound((j * stdDur) + j * (ISI / 1000), varFreq, varAmp, varDur, varRamp);
            else if (j < rand)
                playSound((j * stdDur) + j * (ISI / 1000), stdFreq, stdAmp, stdDur, stdRamp);
            else if (j > rand)
                playSound(((j - 1) * stdDur) + varDur + j * (ISI / 1000), stdFreq, stdAmp, stdDur, stdRamp);
        } else if (type == "gap") {
            if (j == rand)
                playGapNoise((j * varDur) + j * (ISI / 1000), varAmp, varDur, varRamp, delta);
            else
                playNoise((j * stdDur) + j * (ISI / 1000), stdAmp, stdDur, stdRamp);
        } else if (type == "nduration") {
            if (j == rand)
                playNoise((j * stdDur) + j * (ISI / 1000), varAmp, varDur, varRamp);
            else if (j < rand)
                playNoise((j * stdDur) + j * (ISI / 1000), stdAmp, stdDur, stdRamp);
            else if (j > rand)
                playNoise(((j - 1) * stdDur) + varDur + j * (ISI / 1000), stdAmp, stdDur, stdRamp);
        }
    }

    swap = rand + 1;

    //after playing the sound, the response buttons are reactivated
    source.onended = () => { //quando l'oscillatore sta suonando il programma non si ferma, quindi serve questo per riattivare i pulsanti solo quando finisce
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