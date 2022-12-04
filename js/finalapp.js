window.onload = function() {
    //check there's a valid user on hand
    if (localStorage.getItem('user')==null) { 
        window.location.href = "final.html";
    }

    //exercise suggestions listener
    document.getElementById("typeselector").addEventListener("change", getExercises);

    //to settings page button
    document.getElementById("toSettings").addEventListener("click", showSettings);

    //to main page button
    document.getElementById("toMain").addEventListener("click", showMain);

    //submit settings form
    document.getElementById("settingsform").addEventListener("submit", applySettings);

    //sign out button
    document.getElementById("signout").addEventListener("click", firstSignout);

    getPrefs();
}


/* Give server sign up request */
async function getExercises() {
    //removes suggestions and returns if user selects 'choose and exercise'
    if (this.value =="") {
        document.getElementById("suggestions").innerHTML = "";
        return;
    }
    
    //make a json
    let data = { type: this.value }

    //send the json
    const response = await fetch(
        "./php/final_retrieveExercises.php",
        {
            method: "POST",
            body: JSON.stringify(data)
        }
    );
    
    const result = await response.text();
    
    showExercises(result);
}


/* Show exercises on webpage */
function showExercises(exercises) {
    suggestions = document.getElementById("suggestions");
    suggestions.innerHTML = "";
    suggestions.innerHTML = "Exercises:<br>"+exercises;
}


/* Initial signout click */
function firstSignout() {
    //presents yes/no confirmation
    document.getElementById("signoutholder").innerHTML = 
        "Are you sure?<br><span class='pseudolink' id='confirmsignout'>Yes!</span> "+
        "<span class='pseudolink' id='retractsignout'>No!</span>";

    //listener to sign user out
    document.getElementById("confirmsignout").addEventListener("click", function() {
        localStorage.removeItem('user');
        window.location.href = "final.html";
    });

    //listener to revert paragraph to previous content
    document.getElementById("retractsignout").addEventListener("click", function() {
        document.getElementById("signoutholder").innerHTML = '<span class="pseudolink" id="signout">Sign Out</span>';
        document.getElementById("signout").addEventListener("click", firstSignout);
    });
}


/* Show/hide settings/app functions */
function showSettings() {
    document.getElementById("mainpage").hidden = true;
    document.getElementById("settingspage").hidden = false;
    document.getElementById("toSettings").hidden = true;
    document.getElementById("toMain").hidden = false;
}
function showMain() {
    document.getElementById("settingspage").hidden = true;
    document.getElementById("mainpage").hidden = false;
    document.getElementById("toMain").hidden = true;
    document.getElementById("toSettings").hidden = false;
}


/* Get preferences settings */
async function getPrefs() {
    //get user id
    let data = { id: localStorage.getItem('user').split(" ")[0] }

    //send it to php
    const response = await fetch(
        "./php/final_getSettings.php",
        {
            method: "POST",
            body: JSON.stringify(data)
        }
    );
    
    const result = await response.text();
    setTheme(result);
}


/* Apply settings function */
async function applySettings(e) {
    e.preventDefault();

    //get user id
    let data = new FormData(this);
    data.append("id", localStorage.getItem('user').split(" ")[0]);

    //send it to php
    const response = await fetch(
        "./php/final_setSettings.php",
        {
            method: "POST",
            body: data
        }
    );
    
    const result = await response.text();
    setTheme(result);
}


/* Set theme function */
function setTheme(themeID) {
    let themes = ["light","dark","gray","pink"];
    document.getElementById("themeStylesheet").href = "css/themes/"+themes[themeID]+".css";
}