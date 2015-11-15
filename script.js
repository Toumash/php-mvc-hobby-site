function showNews(data) {
    var table = $('#main');
    var content = ["<h3>Informacje o spotkaniach</h3>"];
    content.push("<table class='news-table'><tr><th>Tytul</th><th>Speaker</th><th>Data</th><th>Opis</th></tr>");
    for (var i = 0; i < data.length; i++) {
        var description = data[i].description;
        if (data[i].description.length > 60) {
            description = data[i].description.substring(0, 60) + "...";
        }
        content.push("<tr><td>" + data[i].title + "</td><td>" + data[i].speaker + "</td><td>" + data[i].date + "</td><td>" + description + "</td></tr>");
    }

    content.push("</table>");

    document.getElementsByTagName('main')[0].innerHTML = content.join('');
    table.innerHTML = content.join("");
}

function showNews() {
    $.getJSON('meetings.json').done(showNews).fail(function () {
        alert('Coś poszło nie tak :C');
    });
}
function addNewsButton() {
    var menu = document.getElementById('menu');
    var newItem = document.createElement('li');
    var newButton = document.createElement('a');
    newButton.href = '#';
    newButton.appendChild(document.createTextNode('Spotkania'));
    newItem.appendChild(newButton);
    menu.appendChild(newItem);
    newButton.onclick = showNews;
}

function showDialog(title,content,isModal){
    $('main').append("<div id='dialog' title='" + title + "'>" + content + "</div>");
    $('#dialog').dialog({modal:isModal});
}
function form_validate() {
    var form = $('#contact-form');
    var subject = $('#subject',form).val();
    var email = $('#email', form).val();
    var content = $('#content',form).val();

    var emailReg = /^([\w\.]+@([\w]+\.)+[\w]{2,4})?$/;

    if(subject.length < 10){
        showDialog("Błąd","Podany tytuł jest zbyt krótki",true);
        return false;
    }
    if (!emailReg.test(email)) {
        showDialog("Błąd","podany adres email jest nieprawidłowy",true);
        return false;
    }
    if(content.length < 10){
        showDialog("Błąd","Tresć wiadomości jest zbyt krótka",true);
        return false;
    }

    showDialog("Ok","Wiadomość została przekazana. (Nie, brak serwera to brak wiadomosci : ) )");
    // aby nie zamykac dialogu : )
    return false;
}
function timerTick() {
    var diffSecs = (new Date().getTime() - startTime) / 1000;
    document.getElementById('counter').innerHTML = Math.ceil(diffSecs) + "";
    setTimeout('timerTick()', 1000);
}
var changeBackground = function (element) {
    var newColor = element.style.backgroundColor;
    document.body.style.backgroundColor = newColor;
    if (window.localStorage) {
        localStorage['background-color'] = newColor;
    }
};


startTime = new Date().getTime();
if (window.localStorage) {
    if (sessionStorage['startTime'] != null) {
        startTime = sessionStorage['startTime'];
    } else {
        sessionStorage['startTime'] = startTime;
    }
}

window.onload = function () {
    if (window.localStorage) {
        if (localStorage['background-color'] != null) {
            document.body.style.backgroundColor = localStorage['background-color'];
        }

        document.getElementsByTagName('footer')[0].innerHTML = "Zmień tło:<button onclick='changeBackground(this);' style=\"background-color: #19c589\">$</button>"
            + "<button onclick=\"changeBackground(this)\" style=\"background-color:#dddddd\">$</button>"
            + "<button onclick=\"changeBackground(this)\" style=\"background-color:#2F3036\">$</button><br/>";
    } else {
        document.getElementsByTagName('footer')[0].innerHTML = "Aby w pełni korzystać ze strony użyj lepszej przeglądarki";
    }
    if (window.sessionStorage) {
        var counterElement = document.createElement('span');
        counterElement.appendChild(document.createTextNode("Mogłeś programować już: "));
        var strong = document.createElement('strong');
        var c = document.createElement('span');
        c.id = "counter";
        strong.appendChild(c);
        strong.appendChild(document.createTextNode(' sekund'));
        counterElement.appendChild(strong);
        document.getElementsByTagName('footer')[0].appendChild(counterElement);
        timerTick();
    }
    addNewsButton();

};
