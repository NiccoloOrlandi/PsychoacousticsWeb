function changeColor(){
    var bottone = document.getElementById("test-button")
    bottone.style.backgroundColor = '#80000F';
    bottone.style.color= 'fff';
    bottone.style.borderColor = '#000';
}

function leave(){
    var bottone = document.getElementById('test-button')
    bottone.style.backgroundColor = '#8B0000';
    bottone.style.color= 'fff';
    bottone.style.borderColor = '#000';
}

function copy(id){
	navigator.clipboard.writeText(document.getElementById(id).innerHTML);
	alert('copied to clipboard');
}