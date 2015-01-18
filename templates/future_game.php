<?php include 'navigation.php';?>
<head>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="/js/scripts.js"></script>
</head>
<div class = "shieldbox">
    <figure class = "shieldleft">
        <figcaption><h1><?php print($gameinfo['team1']); ?> </h1></figcaption>
        <img src = "img/<?php print(htmlspecialchars(strtolower($gameinfo['team1']))); ?>_shield.jpg" alt = "team 1 logo" height = "120" width = "90">
    </figure>
    <div class = "shieldcenter">
        <h2>vs.</vs>
    </div>
    <figure class = "shieldright">
        <figcaption><h1><?php print($gameinfo['team2']); ?></h1></figcaption>
        <img src = "img/<?php print(htmlspecialchars(strtolower($gameinfo['team2']))); ?>_shield.jpg" alt = "team 2 logo" height = "120" width = "90">
    </figure>
</div>
<div class = "row">
</div>
<div class = "row">
    <div class = "col-md-5 col-md-offset-1">
        <table class = "table table-striped">
            <caption><h3>Game Information</h3></caption>
            <tr>
                <td><strong>Sport</strong></td>
                <td><?php print($gameinfo["sport"]);?></td>
            </tr>
            <tr>
                <td><strong>Date</strong></td>
                <td><?php $date = date_create($gameinfo["date"]);
                 print(date_format($date, 'F d, Y'));?></td>
            </tr>
            <tr>
                <td><strong>Time</strong></td>
                <td><?php $time = date_create($gameinfo["time"]);
                $timepretty = print(date_format($time, 'g:i A'));?></td>
            </tr>
            <tr>
                <td id = "location"><strong>Location</strong></td>
                <td><?php print($gameinfo["location"]);?></td>
            </tr>
        </table>
        <div id = "roster">
        </div>
        <button id = "roster_update" class = "form-control"></button>
        <! Email team if captain >
        <?php if($_SESSION["captain"] == 1 && $roster == true): ?>
        <div id="emailbox">
            <h3>Email your team announcements about this game</h3>
            <textarea class="form-control" rows="8" style="resize:none; width:100%;text-align:left;" id="emailmsg"></textarea>
            <button class ="form-control" id="captainemail">Email your team</button>
        </div>
        <?php endif ?>
    </div>
    <div  class = "col-md-5">
        <div id = "map-canvas" style="height:300px";>
        </div>
        <div id = "location-details">
            <table class = "table table-striped">
            <caption><h3><?php print($location["fullname"]); ?></h3></caption>
            <tr><td><strong>Street Address</strong></td>
            <td><?php print($location["address"]); ?></td></tr>
            <tr><td><strong>Location Details</strong></td>
            <?php if (empty($gameinfo["details"])): ?>
           	 	<td>No details posted.</td></tr>
        	<?php else: ?>	
            	<td><?php print($gameinfo["details"]); ?></td></tr>
        	<?php endif ?>
            </table>
        </div>
    </div>
</div>
<!-- <h1> Trash talk </h1> -->
<form>


<?php if ($_SESSION["ref"] == 2): ?>

    
    


    <!-- View past posts -->
    <div id="posts_container">
        <h3>Past smack.</h3>
        <div id="past_posts">
        </div>
    </div>

    <!-- Create a post -->
    <h3> Talk some smack.</h3>
    <div class="chat">
        <fieldset>
            <div class="form-group">
               <textarea class="form-control" rows="3" style="resize:none; width:100%;text-align:left;" name="message" id="msg"></textarea>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-default" id="createpost">Create Post</button>
            </div>
        </fieldset>
    </div>
    
    
    

<?php //else: ?>
    <div style="width: 600px; margin: 0 auto 0 auto;">
        <!- View past posts>
        <h3>Past smack.</h3>
        <div id="past_posts">
        </div>
    </div>
<?php endif ?>
</form>
<script>
    var parameters_trashtalk = {
        gameid: <?php echo $gameinfo["gameid"]; ?>,
        house1: '<?php echo $gameinfo["team1"]; ?>',
        house2: '<?php echo $gameinfo["team2"]; ?>'
    };
    var mapinfo = {
        lat: <?php echo $location['latitude']; ?>,
        long: <?php echo $location['longitude']; ?>
        };
</script>
<?php if ($_SESSION["ref"] == 0): ?>
<script>
        var parameters_roster = {
            gameid: <?php echo $gameinfo["gameid"]; ?>,
            house: '<?php echo $_SESSION["house"]; ?>',
            captain: <?php echo $_SESSION["captain"]?>,
            attending : <?php echo $attending; ?>
        };
</script>
<?php else: ?>
<script>
        var parameters_roster = {
        gameid: <?php echo $gameinfo["gameid"]; ?>,
        attending : <?php echo $attending; ?>
        };
</script>
<?php endif ?>
<script>
    $(document).ready( function () {
        addgooglemap(document.getElementById('map-canvas'), mapinfo);
        loadroster(document.getElementById('roster'), parameters_roster);
        loadtrashtalk(parameters_trashtalk);
        $('#roster_update').click( function () {
            rosterupdate(parameters_roster);
        });
        $('#createpost').click( function() {
            var gameid = <?php echo $gameinfo["gameid"]; ?>;
            createPost(gameid);
            loadtrashtalk(parameters_trashtalk);
        })
        $(document).on('click', "button.like", function() {
            var messageid = $(this).attr('value'); // get the messageid from the clicked button
            // add a like to the database with given messageid
            var ajax = $.ajax({
                type: "POST",
                url: "add_like_trash.php/",
                data: {  messageid: messageid }
            });

        });
        $("#captainemail").click( function () {
            var message = $('#emailmsg').val();
            var data = {
                message: message,
                gameid: parameters_roster.gameid,
                house: parameters_roster.house
            }
            $.ajax({
                type: "POST",
                url: "game_email.php/",
                data: {
                    message: message,
                    gameid: parameters_roster.gameid,
                    house: parameters_roster.house
                }
            });
            $("#emailbox").html("<h3>Your team should recieve your email shortly.</h3>");
        });
    });
    setInterval( function() {
        loadtrashtalk(parameters_trashtalk);
    }, 5000);
</script>