function test(){

// salvataggio di tutte le variabili in input
var name = document.getElementById("inputName").value;
var surname = document.getElementById("inputSurname").value;
var age = document.getElementById("inputAge").value;
var gender = document.getElementById("inputGender").value;
var notes = document.getElementById("inputNotes").value;

var name_reg_exp = /^([a-zA-Z])+$/;
var age_reg_exp = /^([0-9])+$/;
//var email_reg_exp = /@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;


// controllo di completamento

if ((name == "") || (name == "undefined")) {
    alert("Il campo Nome è obbligatorio.");
    document.getElementById("inputName").value = "";
    document.getElementById("inputName").focus();
    return false;
}
else if(!name_reg_exp.test(name))
{
    alert("Il nome non puó contenere numeri o simboli");
    document.getElementById("inputName").value = "";
}
/*
else if ((surname == "") || (surname == "undefined")) {
    alert("Il campo cognome è obbligatorio.");
    document.getElementById("inputSurname").focus();
    return false;
}

else if(!name_reg_exp.test(surname))
{
    alert("Il cognome non puó contenere numeri o simboli");
    document.getElementById("inputSurname").value = "";
}

else if ((age == "") || (age == "undefined")) {
    alert("Il campo eta' è obbligatorio.");
    document.getElementById("inputAge").focus();
    return false;
}

else if ((gender == "") || (gender == "undefined")) {
    alert("Il campo genere è obbligatorio.");
    document.getElementById("inputGender").focus();
    return false;
}
 

//validazione degli input
*/
return true;


}

function redirect(){
	//check the url for test type
	let params = new URLSearchParams(location.search);
	if(test()){
		if(params.get('test')=="freq")
			location.href="soundSettings.php?test=freq"; //if the test type is the frequency test it is added to the sound setting url
		else if(params.get('test')=="dur")
			location.href="soundSettings.php?test=dur"; //if the test type is the duration test it is added to the sound setting url
		else
			location.href="soundSettings.php?test=amp"; //if the test type is the amplitude test it is added to the sound setting url
    }
}
