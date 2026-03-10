var background = document.getElementById("background_selection");
var left = document.getElementById("left");
var right = document.getElementById("right");
var submit = document.getElementById("submit");

var curBackground = localStorage.getItem("background");
if(curBackground == null){
    localStorage.setItem("background", 1);
    curBackground = localStorage.getItem("background");
}

window.onload = function(){
    background.style.backgroundImage = "url(../css/background"+curBackground+".jpg)";
}

function change(index){
    background.style.backgroundImage = "url(../css/background"+index+".jpg)";
    document.body.style.backgroundImage = "linear-gradient(rgba(0, 0, 0, 0.821),rgba(0,0,0,0.8)),url(../css/Background"+index+".jpg)";
};

left.onclick = function(){
    if(curBackground == 1){
        curBackground = 3;
    }
    else{
       curBackground--; 
    }
    change(curBackground);
};

right.onclick = function(){
    if(curBackground == 3){
        curBackground = 1;
    }
    else{
       curBackground++; 
    }
    change(curBackground);
};

submit.onclick = function(){
    localStorage.setItem("background", curBackground);
};