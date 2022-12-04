window.onload = function() {
    //check if it's been less than a week since the user last logged in
    if (localStorage.getItem('user')!=null) {
        let userData = localStorage.getItem('user').split(" ");
        if (Date.now()-userData[1]>6.048e8) {
            localStorage.removeItem('user');
        }
        else {
            window.location.href = "finalapp.html";
        }
    }

    //setting up switching between login/signup screens
    document.getElementById("showSignUp").addEventListener("click", function() {
        document.getElementById("login").hidden = true;
        document.getElementById("signup").hidden = false;
    } );

    document.getElementById("showLogin").addEventListener("click", function() {
        document.getElementById("signup").hidden = true;
        document.getElementById("login").hidden = false;
    } );

    //giving forms their listeners
    document.getElementById("loginForm").addEventListener("submit", loginListener);
    document.getElementById("signupForm").addEventListener("submit", signUpListener);
}


/* Give server sign up request */
function signUpListener(e) {
    e.preventDefault();

    fetch(
        "./php/final_ProcessSignUp.php",
        {
            method: "POST",
            body: new FormData(this)
        }
    ).then(response => {
        response.json().then(result =>{
                processServerResponse(result);
            } )
        } )
}


/* Give server login request */
function loginListener(e) {
    e.preventDefault();

    fetch(
        "./php/final_ProcessLogin.php",
        {
            //options
            method: "POST",
            body: new FormData(this)
        }
    ).then(response => {
        response.json().then(result =>{
                processServerResponse(result);
            } )
        } )
}


/* Logic for hanlding server responses */
function processServerResponse(response) {
    //don't want to stack error messages on the page
    let existingErrors = document.querySelectorAll(".error");
    for (errorMsg of existingErrors) {
        errorMsg.remove();
    }
    
    //do different things based on error type
    switch(response["type"]) {
        case 0:
            delete response["type"];
            toMainPage(response);
            break;
        case 1:
            delete response["type"];
            handleUserErrors(response);
            break;
        case 2:
            delete response["type"];
            alert(response["sql"]);
            break;
        default:
            alert("something broke");
    }
}


/* Handle user errors */
function handleUserErrors(errors) {
    //error id to message reference
    let errorsToMessages = ["Please enter a value", "Invalid email format", "Email already exists",
        "Email not found", "Incorrect password"];

    for (key in errors) {
        let errorLabel = document.createElement("label");
        errorLabel.textContent = errorsToMessages[errors[key]];
        errorLabel.htmlFor = key;
        errorLabel.className = "error";

        let lineBreak = document.createElement("br");
        lineBreak.className = "error";

        document.getElementById(key).insertAdjacentElement("afterend", lineBreak);
        lineBreak.insertAdjacentElement("afterend",errorLabel);
    }
}


/* Goes to main page if everything worked out */
function toMainPage(results) {
    //remembers user's ID and time of login
    localStorage.setItem('user',results['id']+" "+Date.now());

    //goes to main page
    window.location.href = "finalapp.html";
}