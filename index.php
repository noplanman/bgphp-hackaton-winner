<!doctype html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        .wait, .game, .lobby {
            display: none;
        }
        .show-lobby .lobby {
            display: block;
        }
        .show-wait .wait {
            display: block;
        }
        .show-game .game {
            display: block;
        }
    </style>
</head>
<body class="show-lobby">
<h1>The numbers game!</h1>
<span>Let the best win! #bgphp #rlz!</span>
<div class="lobby">
<button class="join">Join the adventure!!!</button>
</div>
<div class="wait">
    <h2>Waiting for players</h2>
    <img src="http://8tj6yjstus44zgya1unqg0il.wpengine.netdna-cdn.com/wp-content/uploads/2015/06/Forever-alone-400x400.png">

</div>
<div class="game">
    <h2>Game on!</h2>
    <span class="range">0 - <span class="range-max"></span></span>
    <form>
        <input title="number" class="number-input" type="number" />
        <input type="submit" class="number-submit" value="Bet!!!"/>
    </form>
    <span class="time"></span>
</div>
<script async src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="/index.js"></script>
</body>
</html>