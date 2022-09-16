//contesto e dichiarazione variabili da cambiare durante il test, probabilmente andranno tolte molte variabili globali da qui una volta terminato l'algoritmo
var context = new AudioContext();

// minimum initial variation
var varFreq = freq + delta;			// frequency of the variable 
var stdFreq = freq;					// frequency of the standard
var startingDelta = delta;

dur /= 1000;                        // cambio unità di misura in secondi
var stdDur = dur;					// duration of the standard
var varDur = dur;					// duration of the variable

var stdAmp = amp;					// intensity of the standard
var varAmp = amp;					// intensity of the variable

ramp /= 1000;                        // cambio unità di misura in secondi
var stdRamp = ramp;                  // onset and offset duration of ramp of the standard
var varRamp = ramp;                  // onset and offset duration of ramp of the variable

var swap = -1;						// position of variable sound
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
var result = "";				// final results that will be saved on the db

var timestamp = 0;				// timestamp of the starting of the test
var pressedButton;

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

//funzione per randomizzare l'output
function random() {
    var rand = Math.floor(Math.random() * nAFC);// the variable sound will be the rand-th sound played
    for (var j = 0; j < nAFC; j++) {
        if (j == rand)
            playSound((j * varDur) + j * (ISI / 1000), varFreq, varAmp, varDur, varRamp);
        else
            playSound((j * stdDur) + j * (ISI / 1000), stdFreq, stdAmp, stdDur, stdRamp);
    }

    swap = rand + 1;

    //after playing the sound, the response buttons are reactivated
    source.onended = () => { //quando l'oscillatore sta suonando il programma non si ferma, quindi serve questo per riattivare i pulsanti solo quando finisce
        for (var j = 1; j <= nAFC; j++)
            document.getElementById("button" + j).disabled = false;
    }
}

function saveResults() {
    //save new data
    results[0][i] = currentBlock;				// block
    results[1][i] = i + 1;						// trial
    results[2][i] = parseFloat(parseInt((varFreq - stdFreq) * 1000) / 1000); 	// approximated delta
    results[3][i] = parseFloat(parseInt(varFreq * 1000) / 1000);			// approximated variable value
    results[4][i] = swap;						// variable position
    results[5][i] = pressedButton; 				// pressed button
    results[6][i] = pressedButton == swap ? 1 : 0;	// is the answer correct? 1->yes, 0->no
}

//funzione per implementare l'algoritmo SimpleUpDown
function select(button) {
    pressedButton = button;
    saveResults();

    switch (algorithm) {
        case 'SimpleUpDown':
            nDOWNoneUP(1);
            break;
        case 'TwoDownOneUp':
            nDOWNoneUP(2);
            break;
        case 'ThreeDownOneUp':
            nDOWNoneUP(3);
            break;
        default:
            nDOWNoneUP(2);
            break;
    }

    results[7][i] = countRev; // reversals counter is updated in nDOWNoneUP() function and saved after it

    //increment counter
    i++;

    //use the second factor from now
    if (countRev == reversals)
        currentFactor = secondFactor;

    //end of the test
    if (countRev == reversals + secondReversals) {
        //format datas as a csv file
        //format: block;trials;delta;variableValue;variablePosition;button;correct;reversals;";
        for (var j = 0; j < i; j++) {
            result += results[0][j] + ";" + results[1][j] + ";" + results[2][j] + ";" + results[3][j] + ";"
            result += results[4][j] + ";" + results[5][j] + ";" + results[6][j] + ";" + results[7][j] + ",";
        }

        //calculate score
        for (var j = countRev - reversalThreshold; j < countRev; j++) {
            deltaBefore = results[2][reversalsPositions[j] - 1]; //delta before the reversal
            deltaAfter = results[2][reversalsPositions[j]]; //delta after the reversal
            score += (deltaBefore + deltaAfter) / 2; //average delta of the reversal
        }
        score /= reversalThreshold; //average deltas of every reversal
        score = parseFloat(parseInt(score * 100) / 100); //approximate to 2 decimal digits

        //format description as a csv file
        //prima tutti i nomi, poi tutti i dati
        var description = "&amp=" + amp + "&freq=" + freq + "&dur=" + dur + "&ramp=" + ramp +/*"&phase="+phase+*/"&blocks=" + blocks + "&delta=" + startingDelta + "&nAFC=" + nAFC + "&ISI=" + ISI + "&ITI=" + ITI;
        description += "&fact=" + factor + "&secFact=" + secondFactor + "&rev=" + reversals + "&secRev=" + secondReversals + "&threshold=" + reversalThreshold + "&alg=" + algorithm + "&sampleRate=" + context.sampleRate;

        //pass the datas to the php file
        location.href = "php/saveData.php?result=" + result + "&timestamp=" + timestamp + "&type=freq" + description + "&currentBlock=" + currentBlock + "&score=" + score + "&saveSettings=" + saveSettings;
    }
    //if the test is not ended
    else {

        // disable the response buttons until the new sounds are heared
        for (var j = 1; j <= nAFC; j++)
            document.getElementById("button" + j).disabled = true;

        //randomize and play the next sounds
        window.setTimeout("random()", ITI); //next sounds after interTrialInterval ms
    }
}

document.addEventListener('keypress', function keypress(event) {
    if (!document.getElementById("button1").disabled) {
        if ((event.code >= 'Digit1' && event.code <= 'Digit' + nAFC) || (event.code >= 'Numpad1' && event.code <= 'Numpad' + nAFC)) {
            select(event.key)
            console.log('You pressed ' + event.key + ' button');
        }
    }
});

//funzione per implementare l'algoritmo nD1U
function nDOWNoneUP(n) {
    delta = varFreq - stdFreq;

    if (pressedButton == swap) { //correct answer
        history[i] = 1;
        correctAnsw += 1;
        if (correctAnsw == n) { //if there are n consegutive correct answers
            varFreq = stdFreq + (delta / currentFactor);
            correctAnsw = 0;
            if (positiveStrike == 0) {
                //there was a reversal
                reversalsPositions[countRev] = i - (n - 1);//save the position of that reversal
                countRev++;
            }
            positiveStrike = 1;
        }
        if (feedback) {
            document.getElementById("correct").style.display = "inherit";
            document.getElementById("wrong").style.display = "none";
            window.setTimeout("timer()", 500);
        }

    } else { //wrong answer
        history[i] = 0;
        correctAnsw = 0;
        varFreq = stdFreq + (delta * currentFactor);

        if (positiveStrike == 1) {
            //there was a reversal
            reversalsPositions[countRev] = i;//save the position of that reversal
            countRev++;
        }
        positiveStrike = 0;

        if (feedback) {
            document.getElementById("correct").style.display = "none";
            document.getElementById("wrong").style.display = "inherit";
            window.setTimeout("timer()", 500);

        }
    }
}

//starting function
function start() {
    document.getElementById("StartingWindow").style.display = "none"; //starting window becomes invisible
    document.getElementById("PlayForm").style.display = "inherit"; //test interface becomes visible

    // take the timestamp when the test starts
    var currentdate = new Date();
    timestamp = currentdate.getFullYear() + "-" + (currentdate.getMonth() + 1) + "-" + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();

    window.setTimeout("random()", ITI); //test starts after interTrialInterval ms
}

function timer() {
    document.getElementById("wrong").style.display = "none";
    document.getElementById("correct").style.display = "none";
}
