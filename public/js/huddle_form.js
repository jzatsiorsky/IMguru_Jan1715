
// reload the content every 5 seconds
setInterval(function()
{ 
	var select = document.getElementById("thr class='post_break'eads");
	var sport = select.options[select.selectedIndex].value; // contains sport value to search database with
    var parameters = {
	    	sport: sport
	};
	var messages = $.getJSON("search_sports.php", parameters)
	messages.done(function(data) {
		var length = data.length;
		if (length == 0)
		{
			document.getElementById('past_posts').innerHTML = "<h3>No posts made on this topic yet. Be the first!</h3>";
		}
		else
		{
			// add message to html if there are already messages there
			document.getElementById('past_posts').innerHTML = ""; // reset the HTML in the div
			// for loop thr class='post_break'ough each message
			for (var i = length-1; i >= 0; i--)
			{
				if (data[i].likes == 1)
					var points = " point";	
				else
					var points = " points";
				printPost(data[i], points);
			}
		}
	});
}, 5000);//time in milliseconds 

	
function printPost(data, points) {
	// resize the photo
	var photo = data.photo;
	var smallPic = photo.split("200x200")[0];
    smallPic += "50x50/";
	var userid = $("#past_posts").attr('userid');
	if (data.userid != userid) {
		document.getElementById('past_posts').innerHTML += 
												"<div class='post_date' style='clear:both'>" + data.date_time + "</div>" + 
												"<div class='post-left'>" + 
													"<table>" +
														"<tr>" +
															"<td width='20%;'>" +
															"<table><tr><td><img src='" + smallPic + "' style='border-radius: 25px;' /></td></tr><tr><td>" +
																"<div class='postp-left'>" + 
																	data.name +
																"</div>" +
															"</td></tr></table></td>" + 
															"<td>" +
																"<div class='post_text_left'>" +
																	"<span class='post_text_left'>" +
																		 	data.message + 
																	"</span>" +
																"</div>" +
															"</td>" +
														"</tr>" +
													"</table>" + 
												"</div>";
	}
	else {
		document.getElementById('past_posts').innerHTML += 
												"<div class='post_date' style='clear:both;'>" + data.date_time + "</div>" + 
												"<div class='post-right'>" + 
													"<table style='float:right;'>" +
														"<tr>" +
															"<td>" + 
																"<div class='post_text_right'>" +
																	"<span class='post_text_right'>" +
																		 	data.message + 
																	"</span>" +
																"</div>" +
															"</td>" +
															"<td style='width:40px; height:40px;'>" +
															"<table><tr><td><img src='" + smallPic + "' style='border-radius: 25px;' /></td></tr><tr><td>" +
																"<div class='postp-right'>" + 
																	"You" +
																"</div>" +
															"</td></tr></table></td>" + 
														"</tr>" +
													"</table>" + 
												"</div>";
	}
// + "<span class='like_num'>" + data.likes + points + "</span><button type='button' class='btn btn-default like' aria-label='Left Align' value=" + data.messageid + "><span class='glyphicon glyphicon-thumbs-up'></span> +1</button>" + 
}

// on the page's load, show the general chat
$( document ).ready(function() {
	document.getElementById('past_posts').innerHTML = "<br><br><img src='/img/ajax-loader.gif'>";
	var parameters = {
    	sport: "general"
		};
	var messages = $.getJSON("search_sports.php", parameters)

	messages.done(function(data) {
		var length = data.length;
		// no articles received
		if (length == 0)
		{
			document.getElementById('past_posts').innerHTML = "<h3>No posts made on this topic yet. Be the first!</h3>";
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
				printPost(data[i], points);
			}
		}
	});
});
// show posts based on selection from dropdown menu
document.getElementById("thr class='post_break'eads").onchange = function () {
	document.getElementById('past_posts').innerHTML = "<br><br><img src='/img/ajax-loader.gif'>";
	var select = document.getElementById("thr class='post_break'eads");
	var sport = select.options[select.selectedIndex].value; // contains sport value to search database with
	var parameters = {
    	sport: sport
	};
	var messages = $.getJSON("search_sports.php", parameters)
	messages.done(function(data) {
		var length = data.length;
		// no articles received
		if (length == 0)
		{
			document.getElementById('past_posts').innerHTML = "<h3>No posts made on this topic yet. Be the first!</h3>";
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
				printPost(data[i], points);
			}
		}
	});
};

// do the following when the form is submitted
function createPost() {
	var sport = document.getElementById("thr class='post_break'eads").value;
	var message = document.getElementById("msg").value;
	if (message == "")
		return false;
	document.getElementById("msg").value = ""; // reset the text field
	$.ajax({
		type: "POST",
		url: "huddle.php/",
		data: {  message: message, sport: sport }
	})
	.done(function() {
	// now get the data to display it
		var parameters = {
	    	sport: sport
		};
		var messages = $.getJSON("search_sports.php", parameters)
		messages.done(function(data) {
			var length = data.length;
			// add message to html if there are already messages there
			document.getElementById('past_posts').innerHTML = ""; // reset the HTML in the div
			// for loop thr class='post_break'ough each message
			for (var i = length-1; i >= 0; i--)
			{
				if (data[i].likes == 1)
					var points = " point";	
				else
					var points = " points";
				printPost(data[i], points);
			}
		
		});
	});
};

$(document).on('click', "button.like", function() {
	var messageid = $(this).attr('value'); // get the messageid from the clicked button

	// add a like to the database with given messageid
	var ajax = $.ajax({
		type: "POST",
		url: "add_like.php/",
		data: {  messageid: messageid }
	})
	.done(function() {
		// get the total number of likes
		var sport = document.getElementById("thr class='post_break'eads").value;
		var parameters = {
			sport: sport
		};
		var messages = $.getJSON("search_sports.php", parameters)
		messages.done(function(data) {
			var length = data.length;
			document.getElementById('past_posts').innerHTML = ""; // reset posts
			for (var i = length-1; i >= 0; i--)
			{
				if (data[i].likes == 1)
					var points = " point";	
				else
					var points = " points";
				printPost(data[i], points);
			}
		});
		

	});
});




