var curBackground = localStorage.getItem("background");
if(curBackground == null){
    localStorage.setItem("background", 1);
    curBackground = localStorage.getItem("background");
}

document.body.style.backgroundImage = "linear-gradient(rgba(0, 0, 0, 0.821),rgba(0,0,0,0.8)),url(../css/Background"+curBackground+".jpg)";