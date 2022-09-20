function playSound(time, freq, amp, dur, onRamp, offRamp) { // funzione per generare suoni
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
}

function playNoise(time, amp, dur, onRamp, offRamp) { // funzione per generare rumori
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
}

function playGapNoise(time, amp, dur, onRamp, offRamp, gap) { // funzione per generare suoni
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
}