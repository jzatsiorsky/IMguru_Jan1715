<form>
	<?php include 'navigation.php';?>
	<p>
		Welcome to The Huddle. Here, you can post to your house and fellow teammates. What are you waiting for?
	</p>
	<div class="form-group" style="clear:both;">
		<span>See posts for:</span>
		<select class="form-control" name="sport" id="threads">
			<option value = "general"> <?= htmlspecialchars($_SESSION["house"]) ?> - General</option>
			<option value = "football"> <?= htmlspecialchars($_SESSION["house"]) ?> - Flag football</option>
			<option value = "frisbee"> <?= htmlspecialchars($_SESSION["house"]) ?> - Ultimate frisbee</option>
			<option value = "tennis"> <?= htmlspecialchars($_SESSION["house"]) ?> - Tennis</option>
			<option value = "squash"> <?= htmlspecialchars($_SESSION["house"]) ?> - Squash</option>
			<option value = "basketball"> <?= htmlspecialchars($_SESSION["house"]) ?> - Basketball</option>
			<option value = "soccer"> <?= htmlspecialchars($_SESSION["house"]) ?> - Soccer</option>
		</select>
	</div>

	<div class = "divider">
		<div class="fixed">
			<!- Create a post>
			<h3 class="message_title">Create a post.</h3>
			<div class="chat">
				<fieldset>
					<div class="form-group">
					   <textarea class="form-control" rows="3" style="resize:none; width:85%;text-align:left;" name="message" id="msg"></textarea>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-default" disabled id="create" onclick="createPost();">Create Post</button>
					</div>
				</fieldset>
			</div>
		</div>
		<div class="flexed">
			<!- View past posts>
			<h3 class="message_title">Past posts.</h3>
			<div id="past_posts">
				<h3>Select a thread!</h3>
			</div>
		</div>
	</div>

</form>
<script>


	// on the page's load, show the general chat
	$( document ).ready(function() {
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
				// for loop through each message
				for (var i = length-1; i >= 0; i--)
				{
					document.getElementById('past_posts').innerHTML += "<div class='post'><p class='postp'>" + data[i].name + " said: <span class='like_num'>" + data[i].likes + " points</span> <button type='button' class='btn btn-default like' aria-label='Left Align' value=" + data[i].messageid + "><span class='glyphicon glyphicon-thumbs-up'></span> +1</button></p><p class = 'post_message'>" + data[i].message + "</p><p class='postp'>" + data[i].date_time + "</p></div>";
				}
			}
		});
	};






	// show posts based on selection from dropdown menu
	document.getElementById("threads").onchange = function () {
		var select = document.getElementById("threads");
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
				// for loop through each message
				for (var i = length-1; i >= 0; i--)
				{
					document.getElementById('past_posts').innerHTML += "<div class='post'><p class='postp'>" + data[i].name + " said: <span class='like_num'>" + data[i].likes + " points</span> <button type='button' class='btn btn-default like' aria-label='Left Align' value=" + data[i].messageid + "><span class='glyphicon glyphicon-thumbs-up'></span> +1</button></p><p class = 'post_message'>" + data[i].message + "</p><p class='postp'>" + data[i].date_time + "</p></div>";
				}
			}
		});
	};
	
	// do the following when the form is submitted
	function createPost() {
		var sport = document.getElementById("threads").value;
		var message = document.getElementById("msg").value;
		if (message == "")
			return false;
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
				// for loop through each message
				for (var i = length-1; i >= 0; i--)
				{
					document.getElementById('past_posts').innerHTML += "<div class='post'><p class='postp'>" + data[i].name + " said: <span class='like_num'>" + data[i].likes + " points</span><button type='button' class='btn btn-default like' aria-label='Left Align' value=" + data[i].messageid + "><span class='glyphicon glyphicon-thumbs-up'></span> +1</button></p><p class = 'post_message'>" + data[i].message + "</p><p class='postp'>" + data[i].date_time + "</p></div>";
				}
			document.getElementById("msg").value = ""; // reset the text field
			});
		});
	};

	$(document).on('click', "button.like", function() {
		var messageid = $(this).attr('value'); // get the messageid from the clicked button
		// add a like to the database with given messageid
		$.ajax({
  			type: "POST",
  			url: "add_like.php/",
  			data: {  messageid: messageid }
		})
		.done(function() {
			// get the total number of likes
			var sport = document.getElementById("threads").value;
			var parameters = {
		    	sport: sport
			};
			var messages = $.getJSON("search_sports.php", parameters)
			messages.done(function(data) {
				var length = data.length;
				document.getElementById('past_posts').innerHTML = ""; // reset posts
				for (var i = length-1; i >= 0; i--)
				{
					document.getElementById('past_posts').innerHTML += "<div class='post'><p class='postp'>" + data[i].name + " said: <span class='like_num'>" + data[i].likes + " points</span><button type='button' class='btn btn-default like' aria-label='Left Align' value=" + data[i].messageid + "><span class='glyphicon glyphicon-thumbs-up'></span> +1</button></p><p class = 'post_message'>" + data[i].message + "</p><p class='postp'>" + data[i].date_time + "</p></div>";
				}
			});

		});
	});


</script>







