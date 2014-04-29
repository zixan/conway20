<!DOCTYPE html>
<html lang="en">
  	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="An implementation of Conway's Game of Life.">
    <meta name="author" content="ZM">

    <title>Conway20</title>
    <link href="conway.css" rel="stylesheet">
    <link href="inner.css" rel="stylesheet">
  	</head>
  	<body>
    <div class="container">
    <div class="jumbotron header">
        conway20 <span>a game of life implementation</span>
    </div>
    <div class="jumbotron game">
	<br />
    <form class="form-inline" role="form" action="index.php" method="post">

   	<div class="form-group" style="display:block; margin-bottom:4px;">
 
	<textarea class="form-control" rows="4" style="width:230px" name="pos">
<?php
$default = <<<EOF
......oo.
.o..o.oo.
.oo...oo.
.o.o..ooo																																											
EOF;
$w = isset( $_POST["w"] ) ? $_POST["w"] : 10;
$h = isset( $_POST["h"] ) ? $_POST["h"] : 10;
$g = isset( $_POST["g"] ) ? $_POST["g"] : 1;
$pos = isset( $_POST["pos"] ) ? $_POST["pos"] : $default;

print $pos; 
?>
		</textarea>

   		</div>

  		<div class="form-group">
    	<label class="sr-only" for="width">width</label>
    	<input type="text" class="form-control" id="width" name="w" placeholder="width" value="<?php print $w; ?>">
  		</div>

  		<div class="form-group">
    	<label class="sr-only" for="height">height</label>
    	<input type="text" class="form-control" id="height" name="h" placeholder="height" value="<?php print $h; ?>">
  		</div>

  		<div class="form-group">
    	<label class="sr-only" for="g">g</label>
    	<input type="text" class="form-control" id="g" name="g" placeholder="g" value="<?php print $g; ?>">
  		</div>
	  	<button type="submit" class="btn btn-default">GO</button>
	</form>

<br />

<p>Generations :: 0</p>
	<table align="center">
<?php
	require_once("game_of_life.php");	
	$conway20 = new game_of_life( new state( $pos, $w, $h ) );
	print $conway20->display();
?>
	</table>

<p>Generations :: <?php print $g; ?></p>
	<table align="center">
<?php

$conway20->step($g);
print $conway20->display();
?>
        </table>
<br />
      </div>


      <div class="footer">
        <p>crafted with &#9829; by zeeshan mughal</p>
      </div>

    </div> 

  </body>
</html>
