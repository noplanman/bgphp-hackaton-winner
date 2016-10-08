const API = 'http://172.16.3.51:4321';

var state = {
    uid : null
};

$(document).ready(
    function () {
        $('.join').on('click', function () {
            console.log('thing');
            joinGame();
            switchView('game');
            updateScoreboard();
        });
    }
);

function joinGame() {
    var url = API + '/join';
    $.get(url, function (f) {
        console.log(f);
        if (!f.id) {
            throw Error('bad response');
        }

        state.uid = f.id;
    }, 'json').fail(function (e) {
        alert('Error ' + e)
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
    for(var i = 0, l = scores.length; i < l; i++) {
        let score = scores[i];
        container.append(
            addToScoreBoard(score.uid, score.score)
        );
    }
}

function addToScoreBoard(id, score) {
    var e = $('<div/>');

    if(state.uid == id) {
        e.addClass('current');
    }

    $('<span/>').text(id + ' : ' + score).appendTo(e);
    return e;
}
