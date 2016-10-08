const API = 'http://172.16.3.51:4321/api';
const PING_INTERVAL = 1000;

var state = {
    uid: null,
    finishTime: null,
    gameOn: false,
    stateInterval: null,
    timerInterval: null
};

$(document).ready(
    function () {
        state.finishTime = Date.now() + 4000;
        $('.join').on('click', function () {
            console.log('thing');
            switchView('wait');
            joinGame();
            updateScoreboard();
        });

        $('.betting').submit(function (e) {

            var num = $('.number-input').val();
            bet(num);
            e.preventDefault();
            console.log(e, num);
        });



    }
);

function gameStarted(maxNum) {
    state.gameOn = true;
    state.updateInterval = setInterval(function () {
        console.log('ping');
    }, PING_INTERVAL);

    state.timerInterval = makeTimer();

    switchView('game');
}

function gameStop() {
    clearInterval(state.updateInterval);
    clearInterval(state.timerInterval);
}

function joinGame() {
    var url = API + '/join';
    $.get(url, function (f) {
        console.log(f);
        if (!f) {
            throw Error('bad response');
        }

        state.uid = f;
    }, 'json').fail(function (e) {
        console.log(e);
    });
}
function updateRound() {
    var url = API + '/round';
    $.get(url, function (f) {
        if(f.isStarted) {
            if(!state.gameOn) {
                gameStarted(f.maxNum);

            }
            $('.range-max').text(maxNum);
            $('.number-input').val(0);
            state.finishTime = f.time;
        } else {
            switchView('wait');
        }
        state.uid = f;
    }, 'json').fail(function (e) {
        console.log(e);
    });
}

function updateGame() {
    var url = API + '/join';
    $.get(url, function (f) {
        console.log(f);
    });
}
function updateScoreboard() {
    var url = API + '/players';
    $.get(url, function (f) {
        makeScoreBoard(f);
    }, 'json');
}


function bet(number) {
    var url = API + '/bet';
    $.post(url, {uid: state.uid, bet: number}, function () {
        console.log('bet success');
    }).fail(function (e) {
        console.log(e);
    });
}


/**
 *
 * @param view
 */
function switchView(view) {
    $('body')
        .removeClass('show-lobby show-game show-wait')
        .addClass('show-' + view);
}

function makeScoreBoard(scores) {
    let container = $('.scoreboard').html('');
    for (var i = 0, l = scores.length; i < l; i++) {
        let score = scores[i];
        container.append(
            addToScoreBoard(score.uid, score.score)
        );
    }
}

function addToScoreBoard(id, score) {
    var e = $('<div/>');

    if (state.uid == id) {
        e.addClass('current');
    }

    $('<span/>').text(id + ' : ' + score).appendTo(e);
    return e;
}

function makeTimer() {

    return setInterval(function () {

        var diff = state.finishTime - Date.now();

        if(diff < 0) {
            state.finishTime = Date.now() + 5000;
        } else {
        }

        $('.time').text( Math.max(0, Math.floor(diff/100)/10) + 's');

    }, 200);

}