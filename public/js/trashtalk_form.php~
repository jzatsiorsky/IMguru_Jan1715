<script>
// on the page's load, load all messages
$( document ).ready(function() {
	var parameters = {
    	gameid: <?php echo $teams[0]["gameid"]; ?>
		};
	var messages = $.getJSON("search_trash.php", parameters)
	messages.done(function(data) {
		var length = data.length;
		// no articles received
		if (length == 0)
		{
			document.getElementById('past_posts').innerHTML = "<h3>No trash talk yet! Be the first.</h3>";
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
				document.getElementById('past_posts').innerHTML += "<div class='post'><p class='postp'>" + data[i].name + " said: <span class='like_num'>" + data[i].likes + points + "</span><button type='button' class='btn btn-default like' aria-label='Left Align' value=" + data[i].messageid + "><span class='glyphicon glyphicon-thumbs-up'></span> +1</button></p><p class = 'post_message'>" + data[i].message + "</p><p class='postp'>" + data[i].date_time + "</p></div><hr class='post_break'>";
			}
		}
	});
});


// do the following when the form is submitted
function createPost() {
	var gameid = <?php echo $teams[0]["gameid"]; ?>;
	var message = document.getElementById("msg").value;
	if (message == "")
		return false;
	document.getElementById("msg").value = ""; // reset the text field
	$.ajax({
		type: "POST",
		url: "trashtalk.php/",
		data: {  message: message, gameid: gameid }
	})
	.done(function() {
	// now get the data to display it
		var parameters = {
	    	gameid: <?php echo $teams[0]["gameid"]; ?>
		};
		var messages = $.getJSON("search_trash.php", parameters)
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
				document.getElementById('past_posts').innerHTML += "<div class='post'><p class='postp'>" + data[i].name + " said: <span class='like_num'>" + data[i].likes + points + "</span><button type='button' class='btn btn-default like' aria-label='Left Align' value=" + data[i].messageid + "><span class='glyphicon glyphicon-thumbs-up'></span> +1</button></p><p class = 'post_message'>" + data[i].message + "</p><p class='postp'>" + data[i].date_time + "</p></div><hr class='post_break'>";
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
				document.getElementById('past_posts').innerHTML += "<div class='post'><p class='postp'>" + data[i].name + " said: <span class='like_num'>" + data[i].likes + points + "</span><button type='button' class='btn btn-default like' aria-label='Left Align' value=" + data[i].messageid + "><span class='glyphicon glyphicon-thumbs-up'></span> +1</button></p><p class = 'post_message'>" + data[i].message + "</p><p class='postp'>" + data[i].date_time + "</p></div><hr class='post_break'>";
			}
		});
		

	});
});
</script>

