<!- Include navigation bar>
<?php include 'navigation.php';?>
<h1 style="margin:0 0 20px 0;"> Change e-mail. </h1>
<form action="change_email.php" method="post">
    <fieldset>
		<div class="boxed">
		    <div class="form-group">
		        <input class="form-control" name="new_email1" placeholder="New E-mail" />
		    </div>
		    <div class ="form-group">
		        <input class ="form-control" name="new_email2" placeholder="Repeat New E-mail" />
		    </div>
		    <div class="form-group">
		        <button type="submit" class="btn btn-default">Reset E-mail</button>
		    </div>
		</div>
    </fieldset>
</form>
<div>
    or <a href="index.php">go back</a> 
</div>
