"use strict";

var form = document.comment;

form.review_content.addEventListener("keyup", function () {
    var length = this.value.length;
    document.querySelector("#areaLetters").innerHTML = String(500 - length);
});

/**
 *
 * Display data to selector.
 *
 * @param selector
 * @param data
 *
 */

function reload(selector, data) {
    document.querySelector(selector).innerHTML += data;
    return false;
}

/**
 *
 * Clearing form after success request.
 *
 * @param form
 */

function clearForm(form) {
    console.log(form);
    for (var i = 0; i < form.elements.length; i++){
        form.elements[i].value = "";
    }
    document.querySelector(".file_upload>div").innerHTML = "Вы можете прекрепить картинку";
}

/**
 *
 * Forming and sending request
 *
 */

form.addEventListener('submit', function (ev) {
        var output = document.getElementById('response'),
            data = new FormData(form);
        var request = new XMLHttpRequest();
        request.open("POST", "db_record.php", true);
        request.onload = function () {
            if (request.status == 200) {
                output.className = "access";
                output.innerHTML = "Сообщение отправлено успешно!";
                reload(".content", request.response);
                clearForm(form);
                grecaptcha.reset();
            } else {
                output.className = "error";
                output.innerHTML = request.response + "<br \/>";
            }
        };
        request.send(data);
        ev.preventDefault();
}, false);

/**
 *
 * Display error message in element.
 *
 * @param element
 * @param errorMessage
 */

function showError(element, errorMessage){
    element.className += 'error';
    var msgElem = document.createElement('div');
    msgElem.className = "errorMsg";
    msgElem.innerHTML = errorMessage;
    element.appendChild(msgElem);
}

/**
 *
 * Clearing error message in element.
 *
 * @param element
 */

function resetError(element){
    element.className -= "error";
    if ((element.lastChild) && (element.lastChild.className == "errorMsg")){
        element.removeChild(element.lastChild);
    }
}

/**
 *
 * Validation for inputs.
 *
 */

form.image.onfocus = function () {
    if (this.value) {
        document.querySelector(".file_upload>div").innerHTML = this.value;
    }
};
form.user_name.onblur = function () {
    if ( !((1 < this.value.length) && (this.value.length < 19)) ) {
        showError(this.parentNode, "Имя должно содержать от 2 до 18 символов!");
    }
};

form.user_name.onfocus = function () {
    resetError(this.parentNode)
};

form.review_tittle.onblur = function () {
    if ( !((4 < this.value.length) && (this.value.length < 51)) ) {
        showError(this.parentNode, "Тема должна содержать от 5 до 50 символов!");
    }
};

form.review_tittle.onfocus = function () {
    resetError(this.parentNode)
};

form.review_content.onblur = function () {
    if (this.value.length > 500){
        showError(this.parentNode, "Удивительно, как у тебя это получилось?")
    }
};
