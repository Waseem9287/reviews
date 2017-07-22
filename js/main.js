"use strict";

var form = document.comment;

function reload(selector, data) {
    document.querySelector(selector).innerHTML += data;
    return false;
}

function clearForm(form) {
    console.log(form);
    for (var i = 0; i < form.elements.length; i++){
        form.elements[i].value = "";
    }
}

form.addEventListener('submit', function (ev) {
        var output = document.getElementById('answer'),
            data = new FormData(form);
        var request = new XMLHttpRequest();
        request.open("POST", "db_record.php", true);
        request.onload = function () {
            if (request.status == 200) {
                output.innerHTML = "Сообщение отправлено успешно!";
                reload(".content", request.response);
                clearForm(form);
            } else {
                output.innerHTML = request.response + "<br \/>";
            }
        };
        request.send(data);
        ev.preventDefault();
}, false);

// Validation on Front for inputs

function showError(element, errorMessage){

    element.className += 'error';
    var msgElem = document.createElement('div');
    msgElem.className = "errorMsg";
    msgElem.innerHTML = errorMessage;
    element.appendChild(msgElem);

}

function resetError(element){
    element.className = "";
    if ((element.lastChild) && (element.lastChild.className == "errorMsg")){
        element.removeChild(element.lastChild);
    }
}

document.comment.user_name.onblur = function () {
    if ( !((2 < this.value.length) && (this.value.length < 19)) ) {
        showError(this.parentNode, "Имя должно содержать от 2 до 18 символов!");
    }
};

document.comment.user_name.onfocus = function () {
    resetError(this.parentNode)
};

document.comment.review_tittle.onblur = function () {
    if ( !((4 < this.value.length) && (this.value.length < 51)) ) {
        showError(this.parentNode, "Тема должна содержать от 5 до 50 символов!");
    }
};

document.comment.review_tittle.onfocus = function () {
    resetError(this.parentNode)
};

document.comment.review_content.onblur = function () {
    if (this.value.length > 500){
        showError(this.parentNode, "Удивительно, как у тебя это получилось?")
    }
};

document.comment.review_content.onfocus = function () {
    resetError(this.parentNode)
};