<?php include 'navigation.php';?>
<form>
	
	<h1> <?= $teams[0]["team1"] ?> vs. <?= $teams[0]["team2"] ?> Trash Talk </h1>
	<div class="trash-create">
		<!- Create a post>
		<h3> Talk some smack.</h3>
		<div class="chat">
			<fieldset>
				<div class="form-group">
				   <textarea class="form-control" rows="2" style="resize:none; width:85%;text-align:left;" name="message" id="msg"></textarea>
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-default" id="create" onclick="createPost();">Create Post</button>
				</div>
			</fieldset>
		</div>
	</div>

	<div class="trash-posts">
		<!- View past posts>
		<h3>Past smack.</h3>
		<div id="past_posts">
		</div>
	</div>
</form>

<!-- Javascript -->
<script>
	// reload the content every 5 seconds
	setInterval(function()
	{ 
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
					document.getElementById('past_posts').innerHTML += "<div class='post'><p class='postp'>" + data[i].name + " of " + data[i].house + " said: <span class='like_num'>" + data[i].likes + points + "</span><button type='button' class='btn btn-default like' aria-label='Left Align' value=" + data[i].messageid + "><span class='glyphicon glyphicon-thumbs-up'></span> +1</button></p><p class = 'post_message'>" + data[i].message + "</p><p class='postp'>" + data[i].date_time + "</p></div><hr class='post_break'>";
				}
			}
		});
	}, 5000);//time in milliseconds 

</script>

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
				document.getElementById('past_posts').innerHTML += "<div class='post'><p class='postp'>" + data[i].name + " of " + data[i].house + " said: <span class='like_num'>" + data[i].likes + points + "</span><button type='button' class='btn btn-default like' aria-label='Left Align' value=" + data[i].messageid + "><span class='glyphicon glyphicon-thumbs-up'></span> +1</button></p><p class = 'post_message'>" + data[i].message + "</p><p class='postp'>" + data[i].date_time + "</p></div><hr class='post_break'>";
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
				document.getElementById('past_posts').innerHTML += "<div class='post'><p class='postp'>" + data[i].name + " of " + data[i].house + " said: <span class='like_num'>" + data[i].likes + points + "</span><button type='button' class='btn btn-default like' aria-label='Left Align' value=" + data[i].messageid + "><span class='glyphicon glyphicon-thumbs-up'></span> +1</button></p><p class = 'post_message'>" + data[i].message + "</p><p class='postp'>" + data[i].date_time + "</p></div><hr class='post_break'>";
			}
		
		});
	});
};

$(document).on('click', "button.like", function() {
	var messageid = $(this).attr('value'); // get the messageid from the clicked button
	// add a like to the database with given messageid
	var ajax = $.ajax({
		type: "POST",
		url: "add_like_trash.php/",
		data: {  messageid: messageid }
	})
	.done(function() {
		// get the total number of likes
		var parameters = {
			gameid: <?php echo $teams[0]["gameid"]; ?>
		};
		var messages = $.getJSON("search_trash.php", parameters)
		messages.done(function(data) {
			var length = data.length;
			document.getElementById('past_posts').innerHTML = ""; // reset posts
			for (var i = length-1; i >= 0; i--)
			{
				if (data[i].likes == 1)
					var points = " point";	
				else
					var points = " points";
				document.getElementById('past_posts').innerHTML += "<div class='post'><p class='postp'>" + data[i].name + " of " + data[i].house + " said: <span class='like_num'>" + data[i].likes + points + "</span><button type='button' class='btn btn-default like' aria-label='Left Align' value=" + data[i].messageid + "><span class='glyphicon glyphicon-thumbs-up'></span> +1</button></p><p class = 'post_message'>" + data[i].message + "</p><p class='postp'>" + data[i].date_time + "</p></div><hr class='post_break'>";
			}
		});
		

	});
});
</script>







