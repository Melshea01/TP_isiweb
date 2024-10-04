function setUpEventListener(){
  connexion();
  var c = document.getElementById("Connexion");
  var i = document.getElementById("Inscription");
  c.addEventListener("click", connexion);
  i.addEventListener("click", inscription);
}


function inscription(){
  var co = document.getElementsByClassName("connexion");
  for(var i = 0; i < co.length; i++){
    co[i].style.display = 'none';
  }
  var ins = document.getElementsByClassName("inscription");
  for(var i = 0; i < ins.length; i++){
    ins[i].style.display = 'block';
  }
}



function connexion(){
  var ins = document.getElementsByClassName("inscription");
  for(var i = 0; i < ins.length; i++){
    ins[i].style.display = 'none';
  }
  var co = document.getElementsByClassName("connexion");
  for(var i = 0; i < co.length; i++){
    co[i].style.display = 'block';
  }
}


window.addEventListener("load", setUpEventListener);
