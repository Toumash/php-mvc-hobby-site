startTime = new Date().getTime();
if(window.localStorage) {
    if (sessionStorage['startTime'] != null) {
        startTime = sessionStorage['startTime'];
    } else {
        sessionStorage['startTime'] = startTime;
    }
}


window.onload = function() {
    if (window.localStorage) {
        if (localStorage['background-color'] != null) {
            document.body.style.backgroundColor = localStorage['background-color'];
        }

        document.getElementsByTagName('footer')[0].innerHTML = "Zmień tło:<button onclick='changeBackground(this);' style=\"background-color: #19c589\">$</button>"
            +"<button onclick=\"changeBackground(this)\" style=\"background-color:#dddddd\">$</button>"
            +"<button onclick=\"changeBackground(this)\" style=\"background-color:#2F3036\">$</button><br/>";
    }else{
        document.getElementsByTagName('footer')[0].innerHTML = "Aby w pełni korzystać ze strony użyj lepszej przeglądarki";
    }
    if(window.sessionStorage){
        var counterElement = document.createElement('span');
        counterElement.appendChild(document.createTextNode("Mogłeś programować już: "));
        var strong = document.createElement('strong');
        var c= document.createElement('span');
        c.id= "counter";
        strong.appendChild(c);
        strong.appendChild(document.createTextNode(' sekund'));
        counterElement.appendChild(strong);
        document.getElementsByTagName('footer')[0].appendChild(counterElement);
        setTimeout('getSec()',1);
    }

};

function getSec()
{
    var diffSecs = (new Date().getTime() - startTime)/1000;
    document.getElementById('counter').innerHTML = Math.ceil(diffSecs)+"";
    setTimeout('getSec()',1000);
}
var changeBackground = function(element){
    var newColor = element.style.backgroundColor;
    document.body.style.backgroundColor = newColor;
    if(window.localStorage) {
        localStorage['background-color'] = newColor;
    }
};