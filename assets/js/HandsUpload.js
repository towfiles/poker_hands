let uploadHandsObj = document.getElementById("upload-hands");
let handsDialogObj = document.getElementById("hands-dialog");
let uploadStatusObj = document.getElementById("upload-status");
let calPlayer1Object= document.getElementById("cal-player1");
let winsCountObj = document.getElementById("wins-count");
const mimeTypes = [ 'text/plain' ];
const maxFileSize = 2*1024*1024;

 function validateFile(file){
    if(mimeTypes.indexOf(file.type) === -1) {
        alert('Error : Incorrect file type');
        return false;
    }
    if(file.size > maxFileSize) {
        alert('Error : Exceeded size 2MB');
        return false;
    }

    return true
}

function sendHandsToServer(file){
    let data = new FormData();
    let request = new XMLHttpRequest();

    data.append('file', file);
    request.responseType = 'json';
    request.open('post', '/upload-hands');
    request.send(data);
    request.onreadystatechange = function(){
        if(request.readyState === 4 && request.status === 200) {
            uploadStatusObj.innerHTML = `Upload successful: file name is ${request.response.data.fileName} `;
            calPlayer1Object.style.display = "inline";

        }
    }
}

uploadHandsObj.addEventListener("click", () => {
    handsDialogObj.click();
});

handsDialogObj.addEventListener("change", function(){
    let file = this.files[0];

    if(validateFile(file)) {
        this.value = null;
        uploadStatusObj.innerHTML = "Uploading";
        sendHandsToServer(file);

    }

});

calPlayer1Object.addEventListener("click", () => {
    let request = new XMLHttpRequest();
    request.responseType = 'json';
    request.open('get', '/player1-wins');
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState === 4 && request.status === 200) {
            winsCountObj.innerHTML = ` Player 1 made ${request.response.data.wins}`;
            console.log(request.response);
        }
    }
});