var stimulusData = "";
var info = "";
var csvString;

function playSound(time, freq, amp, dur, onRamp, offRamp, isStandard = true) { // funzione per generare suoni
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
            if (t < onRamp) {
                rampArr[i] = (1 + Math.sin((t * Math.PI / onRamp) - (Math.PI / 2))) / 2;    // onset ramp
            } else if (t > dur - offRamp) {
                rampArr[i] = (1 + Math.sin(((t - (dur - offRamp)) * Math.PI / offRamp) + (Math.PI / 2))) / 2; // offset ramp
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
    if (isStandard)
        stimulusData += "Standard stimulus\n" + source.buffer.getChannelData(0).join(",") + "\n";
    else
        stimulusData += "Variable stimulus\n" + source.buffer.getChannelData(0).join(",") + "\n";
}

function playNoise(time, amp, dur, onRamp, offRamp, isStandard = true) { // funzione per generare rumori
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
            if (t < onRamp) {
                rampArr[i] = (1 + Math.sin((t * Math.PI / onRamp) - (Math.PI / 2))) / 2;    // onset ramp
            } else if (t > dur - offRamp) {
                rampArr[i] = (1 + Math.sin(((t - (dur - offRamp)) * Math.PI / offRamp) + (Math.PI / 2))) / 2; // offset ramp
            } else {
                rampArr[i] = 1; // central zone
            }
            nowBuffering[i] = ((10 ** (parseInt(amp) / 20)) * (Math.random() * 2 - 1)) * rampArr[i];
        }
    }
    source = context.createBufferSource();  // creo sorgente
    source.buffer = soundBuffer;    // collego i buffer
    source.connect(vol);    // connetto la sorgente al volume
    source.start(context.currentTime + time);   // riproduco il suono
    source.stop(context.currentTime + time + dur);  // fermo il suono
    if (isStandard)
        stimulusData += "Standard stimulus\n" + source.buffer.getChannelData(0).join(",") + "\n";
    else
        stimulusData += "Variable stimulus\n" + source.buffer.getChannelData(0).join(",") + "\n";
}

function playGapNoise(time, amp, dur, onRamp, offRamp, gap, isStandard = true) { // funzione per generare suoni
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
            if (t < onRamp) {
                rampArr[i] = (1 + Math.sin((t * Math.PI / onRamp) - (Math.PI / 2))) / 2;    // onset ramp
            } else if (t >= onRamp && t < ((dur / 2) - (gap / 2))) {
                rampArr[i] = 1; // first central zone
            } else if (t >= ((dur / 2) - (gap / 2)) && t < ((dur / 2) - (gap / 2) + betweenRampDur) && t < (dur / 2)) {
                rampArr[i] = (1 + Math.sin(((t - ((dur / 2) - (gap / 2))) * Math.PI / betweenRampDur) + (Math.PI / 2))) / 2; // offset ramp gap
            } else if (t >= ((dur / 2) - (gap / 2) + betweenRampDur) && t < ((dur / 2) + (gap / 2) - betweenRampDur)) {
                rampArr[i] = 0; // central zone in gap
            } else if (t >= ((dur / 2) + (gap / 2) - betweenRampDur) && t < (dur / 2) + (gap / 2)) {
                rampArr[i] = (1 + Math.sin(((t - ((dur / 2) + (gap / 2) - betweenRampDur)) * Math.PI / betweenRampDur) - (Math.PI / 2))) / 2; // onset ramp gap
            } else if (t >= (dur / 2) + (gap / 2) && t < dur - offRamp) {
                rampArr[i] = 1; // second central zone
            } else if (t >= dur - offRamp) {
                rampArr[i] = (1 + Math.sin(((t - (dur - offRamp)) * Math.PI / offRamp) + (Math.PI / 2))) / 2; // offset ramp
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
    if (isStandard)
        stimulusData += "Standard stimulus\n" + source.buffer.getChannelData(0).join(",") + "\n";
    else
        stimulusData += "Variable stimulus\n" + source.buffer.getChannelData(0).join(",") + "\n";
}

function playModulatedNoise(time, carAmp, carDur, modAmp, modFreq, modPhase, onRamp, offRamp, isStandard = true) { // funzione per generare rumori
    console.log(modAmp);
    console.log()

    var vol = context.createGain(); // creo volume
    vol.gain.value = 1;
    vol.connect(context.destination);   // collego volume all'uscita audio

    let channels = 1;
    var frameCount = context.sampleRate * carDur;
    let noiseBuffer = context.createBuffer(channels, frameCount, context.sampleRate);
    for (let channel = 0; channel < channels; channel++) {
        let master = noiseBuffer.getChannelData(channel);
        let carrier = [];
        let modulator = [];
        let ramp = [];
        for (let i = 0; i < frameCount; i++) {
            t = i / context.sampleRate;
            if (t < onRamp) {
                ramp[i] = (1 + Math.sin((t * Math.PI / onRamp) - (Math.PI / 2))) / 2;
            } else if (t > carDur - offRamp) {
                ramp[i] = (1 + Math.sin(((t - (carDur - offRamp)) * Math.PI / offRamp) + (Math.PI / 2))) / 2;
            } else {
                ramp[i] = 1;
            }
            carrier[i] = carAmp * (Math.random() * 2 - 1);
            modulator[i] = modAmp * Math.sin(i * 2 * Math.PI * modFreq / context.sampleRate + modPhase); // t = i / sampleRate
            master[i] = (((carAmp / (carAmp + modAmp)) + (modulator[i] / (carAmp + modAmp))) * carrier[i]) * ramp[i];
        }
    }
    source = context.createBufferSource();  // creo sorgente
    source.buffer = noiseBuffer;    // collego i buffer
    source.connect(vol);    // connetto la sorgente al volume
    source.start(context.currentTime + time);   // riproduco il suono
    source.stop(context.currentTime + time + carDur);  // fermo il suono
    if (isStandard)
        stimulusData += "Standard stimulus\n" + source.buffer.getChannelData(0).join(",") + "\n";
    else
        stimulusData += "Variable stimulus\n" + source.buffer.getChannelData(0).join(",") + "\n";
}

function downloadData(type) {
    if (type == "amp" || type == "freq" || type == "dur")
        info = "frequency of standard stimulus," + stdFreq + ",frequency of variable stimulus," + varFreq + "\n" +
            "amplitude of standard stimulus," + stdAmp + ",amplitude of variable stimulus," + varAmp + "\n" +
            "duration of standard stimulus," + stdDur + ",duration of variable stimulus," + varDur + "\n" +
            "onset ramp," + onRamp + ",offset ramp," + offRamp + "\n" +
            "current factor," + currentFactor + "\n";
    else if (type == "ndur")
        info = "amplitude of standard stimulus," + stdAmp + ",amplitude of variable stimulus," + varAmp + "\n" +
            "duration of standard stimulus," + stdDur + ",duration of variable stimulus," + varDur + "\n" +
            "onset ramp," + onRamp + ",offset ramp," + offRamp + "\n" +
            "current factor," + currentFactor + "\n";
    else if (type == "gap")
        info = "amplitude of standard stimulus," + stdAmp + ",amplitude of variable stimulus," + varAmp + "\n" +
            "duration of standard stimulus," + stdDur + ",duration of variable stimulus," + varDur + "\n" +
            "onset ramp," + onRamp + ",offset ramp," + offRamp + "\n" +
            "current factor," + currentFactor + ",gap," + delta + "\n";
    else if (type == "nmod")
        info = "amplitude of standard stimulus," + carAmpDb + ",duration of standard stimulus," + carDur + "\n" +
            "amplitude of carrier (variable stimulus)," + carAmpDb + ",duration of carrier (variable stimulus)," + carDur +
            ",amplitude of modulator (variable stimulus)," + modAmpDb + ",frequency of modulator (variable stimulus)," + modFreq + ",phase of modulator (variable stimulus)," + modPhase + "\n" +
            "onset ramp," + onRamp + ",offset ramp," + offRamp + "\n" +
            "current factor," + currentFactor + "\n";
    else
        info = "errore";
    csvString = info + stimulusData + "\n\n\n";
    let csvContent = "data:text/csv;charset=utf-8," + csvString;
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "my_data.csv");
    document.body.appendChild(link);
    link.click();
}