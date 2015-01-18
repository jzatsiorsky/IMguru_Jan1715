/**
 * scripts.js
 *
 * Computer Science 50
 * Final Project - imGuru
 * Tim McNamara, Will Mendez, James Zatsiorsky
 *
 * Global JavaScript, if any.
 */

// load all the games for a sport and house
function gamestable(loc, parameters) {
        var games = $.getJSON("search_games.php", parameters);
        games.fail( function() {
            alert("Failed to access database");
        });
		games.done( function(data) {
			// no articles received
	    if (parameters.sport == "all")
	    {
	        if (data.length == 0)
		    {
			    var msg = "<h3><strong>" + parameters.house + " has no upcoming games! Be sure to check back soon!</h3>";
			    loc.innerHTML = msg;
		    }
		    else
		    {
		        var gamedata = "<table class = 'table table-striped'><caption><h3>Upcoming games for <strong>" + parameters.house + "</strong></h3></caption>";
			    gamedata += "<tr><th>Sport</th><th>Opponent</th><th>Date</th><th>Time</th>";
			    gamedata += "<th>Location</th><th>More Info</th></tr>";
			    // for loop through each message
			    for (var i = 0, length = data.length; i < length; i++)
			    {
			        var opponent;
			        if (data[i].team1 == parameters.house) {
			            opponent = data[i].team2;
			        }
			        else {
			            opponent = data[i].team1;
			        }
			        gamedata += "<tr><td>" + data[i].sport + "</td>";
			        gamedata += "<td>" + opponent + "</td><td>" + data[i].date + "</td><td>" + data[i].time;
			        gamedata += "</td><td>" + data[i].location + "</td><td><a href='game_page.php?gameid=";
			        gamedata += data[i].gameid + "'>Click here</a></td></tr>";
			    }
			    gamedata += "</table>";
			    loc.innerHTML = gamedata;
		    }
		}
	    else
		{
			if (data.length == 0)
			{
				var msg = "<h3><strong>" + house + " has no upcoming games for this sport!</h3>";
				loc.innerHTML = msg;
			}
			else
			{
			    var gamedata = "<table class = 'table table-striped'><caption><h3>Upcoming " + data[0].sport + " games for <strong>" + parameters.house + "</strong></h3></caption>";
				gamedata += "<tr><th>Opponent</th><th>Date</th><th>Time</th><th>Location</th><th>More Info</th></tr>"
				// for loop through each message
				for (var i = 0, length = data.length; i < length; i++)
				{
				    var opponent;
				    if (data[i].team1 == parameters.house) {
				        opponent = data[i].team2;
				    }
				    else if (data[i].team2 == parameters.house) {
				        opponent = data[i].team1;
				    }
				    gamedata += "<tr><td>" + opponent + "</td><td>" + data[i].date + "</td><td>" + data[i].time;
				    gamedata += "</td><td>" + data[i].location + "</td><td><a href='game_page.php?gameid=";
				    gamedata += data[i].gameid + "'>Click here</a></td></tr>";
				}
				gamedata += "</table>";
				loc.innerHTML = gamedata;
			}
        }
    });
}
    
       
			

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
            icon: sports,
            animation: google.maps.Animation.DROP,
        });
}
// add a roster to a game page
function loadroster(roster, parameters) {
    var players = $.getJSON("search_rosters.php", parameters)
    players.fail(function() {
        alert("Database connection failed");
    });
    players.done(function(data) {
        // no articles received
        var rosterdata;
        if (data.length == 0)
        {
	        rosterdata = "<h3>Be the first from your house to sign up!</h3>";
	        
        }
        else
        {
            var rosterdata = "<h3>People from " + parameters.house + " attending this game.</h3>"
            rosterdata += "<table class='table table-striped'><tr><th>Name</th><th>E-mail</th></tr>";
	        // for loop through each player
	        for (var i = 0, length = data.length; i < length; i++)
	        {
		        rosterdata += "<tr><td>" + data[i].name + "</td><td>" + data[i].email + "</td></tr>";
	        }
	        rosterdata += "</table>";
        }
        roster.innerHTML = rosterdata;
        var buttontext = "";
        if (parameters.attending == 1)
        {
            buttontext += "I can no longer attend this game";
        }
        else
        {
            buttontext += "I want to play in this game";
        }
        document.getElementById("roster_update").innerHTML = buttontext;
    });
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
        success: function() {}
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

