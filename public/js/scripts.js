/**
 * scripts.js
 *
 * Computer Science 50
 * Final Project - imGuru
 * Tim McNamara, James Zatsiorsky
 *
 * Global JavaScript.
 */

// load all the games for a sport and house
function gamestable(loc, parameters) {
    var games = $.getJSON("search_games.php", parameters);
    games.done( function(data) {
        if (data.length == 0)
        {
            // player account
            if (parameters.hasOwnProperty('house'))
            {
                var msg = "<h3>" + parameters.house + " has no upcoming games! Be sure to check back soon!</h3>";
            }
            // referee account
            else
            {
                var msg = "<h3>No upcoming games.</h3>";
            }
            loc.innerHTML = msg;
        }
        else
        {
            // player account
            if (parameters.hasOwnProperty('house'))
            {
                var gamedata = "<caption><h4>Click on a game for more info.<br>Right click a game to change your attendance status.</h4></caption>";
                gamedata += "<thead><tr><th>Sport</th><th>Opponent</th><th>Date</th><th>Time</th>";
                gamedata += "<th>Location</th><th>Attending?</th></tr></thead><tbody>";
                // for loop through each message
                for (var i = 0, length = data.length; i < length; i++)
                {

                    gamedata += "<tr class='home' value = " + data[i].gameid + " att = " + data[i].attending;
                    gamedata += " url='/game_page.php?gameid=" + data[i].gameid + "'><td>" + data[i].sport + "</td>";
                    gamedata += "<td>" + data[i].opponent + "</td><td>" + data[i].date + "</td><td>" + data[i].time;
                    gamedata += "</td><td>" + data[i].location + "</td><td>" + data[i].attending + "</td></tr>";
                }
                gamedata += "</tbody><tfoot><tr><th>Sport</th><th>Opponent</th><th>Date</th><th>Time</th>";
                gamedata += "<th>Location</th><th>Attending?</th></tr></tfoot>";
            }
            // referee account
            else
            {
                var gamedata = "<caption><h4>Click on a game for more info.<br>Right click a game to change your attendance status.</h4></caption>";
                gamedata += "<thead><tr><th>Sport</th><th>Team 1</th><th>Team 2</th><th>Date</th><th>Time</th>";
                gamedata += "<th>Location</th><th>Attending?</th></tr></thead><tbody>";
                // for loop through each message
                for (var i = 0, length = data.length; i < length; i++)
                {
                    gamedata += "<tr class='home' value = " + data[i].gameid + " att = " + data[i].attending;
                    gamedata += " url='/game_page.php?gameid=" + data[i].gameid + "'><td>" + data[i].sport + "</td>";
                    gamedata += "<td>" + data[i].team1 + "</td><td>" + data[i].team2 + "</td><td>" + data[i].date + "</td><td>" + data[i].time;
                    gamedata += "</td><td>" + data[i].location + "</td><td>" + data[i].attending + "</td></tr>";
                }
                gamedata += "</tbody><tfoot><tr><th>Sport</th><th>Opponent</th><th>Date</th><th>Time</th>";
                gamedata += "<th>Location</th><th>Attending?</th></tr></tfoot>";

            }
            loc.innerHTML = gamedata;
        }
    })
};  

// google maps api
function addgooglemap(loc, mapinfo) {
        var sports = 'img/player.png';
        var mapOptions = {
            center: new google.maps.LatLng(mapinfo.lat, mapinfo.long),
            zoom: 17,
            mapTypeId: google.maps.MapTypeId.ROADMAP
            };
        var map = new google.maps.Map(loc, mapOptions);
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(mapinfo.lat, mapinfo.long),
            map: map,
            animation: google.maps.Animation.DROP,
        });
}

// add a roster to a game page
function loadroster(roster, parameters) {
    var players = $.getJSON("search_rosters.php", parameters)
    players.fail(function() {
        alert("Loading roster failed.");
    }); 
    players.done(function(data) {
        // no articles received
        var rosterdata;
        if (data.length == 0)
        {
            if (parameters.hasOwnProperty('house')) 
                rosterdata = "<h3>Be the first from your house to sign up!</h3>";
            else
                rosterdata = "<h3>Be the first referee to sign up!</h3";
        }
        else
        {
            if (parameters.hasOwnProperty('house')) 
                var rosterdata = "<h3>People from " + parameters.house + " attending this game.</h3>";
            else
                var rosterdata = "<h3>Referees attending this game.</h3>";

            rosterdata += "<table class='table table-striped'>";
            // for loop through each player
            for (var i = 0, length = data.length; i < length; i++)
            {
                if (data[i].photo != "\"\"") {
                    var smallPic = data[i].photo.split("200x200")[0];
                    smallPic += "50x50/";
                }
                else {
                    var smallPic = "http://www.ucarecdn.com/6d29ef92-786d-43be-aefd-6a80fe4d4812/-/resize/50x50/";
                }

                rosterdata += "<tr>" +
                            "<td style='vertical-align: middle;'>" + (i+1) + ".</td>" + 
                            "<td style='vertical-align: middle; font-weight: bold;'>" + data[i].name + "</td>" + 
                            "<td><img src = '" + smallPic + "' style='border-radius: 25px; float:left;'/></td>" + 
                            "</tr>";
            }
            rosterdata += "</table>";
        }
        roster.innerHTML = "";
        roster.innerHTML = rosterdata;
        var buttontext = "";
        if (parameters.attending == 1)
        {
            if (parameters.hasOwnProperty('house')) 
                buttontext += "I can no longer attend this game";
            else
                buttontext += "I can no longer referee this game";
        }
        else
        {
            if (parameters.hasOwnProperty('house')) 
                buttontext += "I want to play in this game";
            else
                buttontext += "I am refereeing this game";
        }
        document.getElementById("roster_update").innerHTML = buttontext;
    })
}

// add user to game roster
function rosterupdate(parameters) {
    $.ajax({
        data: {
            gameid: parameters.gameid,
            attending: parameters.attending
        },
        url: 'roster_update.php',
        method: 'POST',
        async: false
    });
    if (parameters.attending == 1)
    {
        parameters.attending = 0;
    }
    else
    {
        parameters.attending = 1;
    }
    loadroster(document.getElementById('roster'), parameters);
}

// load the past trash talk for a game
function loadtrashtalk(parameters) { 
    var messages = $.getJSON("search_trash.php", parameters);
    messages.done(function(data) {
        var length = data.length;
        var text = "";
        // no articles received
        if (length == 0)
        {
            text += "<h3>No trash talk yet! Be the first.</h3>";
        }
        else
        {
            document.getElementById('past_posts').innerHTML = ""; // reset the HTML in the div
            // for loop thr class='post_break'ough each message
            for (var i = length-1; i >= 0; i--)
            {
                if (data[i].likes == 1)
                    var points = " point";  
                else
                    var points = " points";
                text += "<div class='post'><p class='postp'>" + data[i].name + " of " + data[i].house;
                text += " said: <span class='like_num'>" + data[i].likes + " points";
                text += "</span><button type='button' class='btn btn-default like' aria-label='Left Align' value=";
                text += data[i].messageid + "><span class='glyphicon glyphicon-thumbs-up'></span>";
                text += "+1</button></p><p class = 'post_message'>" + data[i].message + "</p><p class='postp'>";
                text += data[i].date_time + "</p></div><hr class='post_break'>";
            }
        }
    document.getElementById('past_posts').innerHTML = text;
    });
}

// captain email team
function emailteam(parameters) {
    var message = $("#emailmsg").val();
    $.ajax({
        type: "POST",
        url: "emailteam.php/",
        data: { 
            message: message,
            gameid: parameters.gameid,
            house: parameters.house
        }
    });
}

// create a new trashtalk post
function createPost(gameid) {
    var message = document.getElementById("msg").value;
    if (message == "")
        return false;
    document.getElementById("msg").value = ""; // reset the text field
    $.ajax({
        type: "POST",
        url: "trashtalk.php/",
        data: {  message: message, gameid: gameid }
    });
};

// add a like to a trash talk
function addlike(messageid, parameters) {
    // add a like to the database with given messageid
    var ajax = $.ajax({
        type: "POST",
        url: "add_like_trash.php/",
        data: {  messageid: messageid }
    });
    ajax.done(loadtrashtalk(parameters));
}

// sign a user up for all games of a particular sport
function signUp(sport) {
    $.ajax({
        data: {
            sport : sport
        },
        url: 'sign_up_sport.php',
        method: 'POST'
    });

    document.getElementById("sign_up").innerHTML = "<p>All signed up!</p>";
}


























