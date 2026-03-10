function accuracyBarSetting(accuracy){ 
    var bar = document.getElementById("accuracy_bar"); 
    bar.style.width = accuracy+"%"; 
} 
 
var modal = document.getElementById("modal"); 
 
window.onclick = function(event) { 
    if(event.target == modal) { 
      modal.style.display = "none"; 
    } 
}