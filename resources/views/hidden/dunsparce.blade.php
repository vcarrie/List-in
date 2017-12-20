
@extends('template.master')

@section('title', 'Dunsparce')

@section('main')
    <style>
        #container {
            position: relative;
        }
        .timer {
            font-size: 24px;
            color: blue;
        }
        #animation {
            position: absolute;
            left: 900px;
        }
        #animation1 {
            position: absolute;
            left: 900px;
        }
        #animation2 {
            position: absolute;
            left: 900px;
        }
    </style>
    <script>

        function myMove() {
            var elem = document.getElementById("animation");
            var elem1 = document.getElementById("animation1");
            var elem2 = document.getElementById("animation2");
            var pos = 900;
            var pos1 = 900;
            var pos2 = 900;
            var id = setInterval(frame, 10);

            function frame() {
                if (pos < 0) {
                    elem.style.left = 900 + 'px';
                    pos = 900;
                } else {
                    pos -= 3;
                    elem.style.left = pos + 'px';
                }
                if (pos1 < 0) {
                    elem1.style.left = 900 + 'px';
                    pos1 = 900;
                } else {
                    pos1 -= 2;
                    elem1.style.left = pos1 + 'px';
                }
                if (pos2 < 0) {
                    elem2.style.left = 900 + 'px';
                    pos2 = 900;
                } else {
                    pos2 -= 1;
                    elem2.style.left = pos2 + 'px';
                }
            }
        }
        var seconds_left = 4;
        function timer() {
            var interval = setInterval(function() {
                document.getElementById('timer_div').innerHTML = --seconds_left;

                if (seconds_left <= 0)
                {
                    document.getElementById('timer_div').innerHTML = "Gooooo!";
                    clearInterval(interval);
                    myMove()
                }
            }, 1000);
        }


    </script>

<div class="col-md-6 col-md-offset-2" id="container" style="margin-top: 8%;">
    <button onclick="timer();">Let's Race!</button><div id="timer_div" class="timer">Hold on!</div>
    <div id="animation">
        <img src="https://eternia.fr/public/media/pokedex/pgl/206.png" alt="">
    </div>
    <div id="animation1">
        <img src="https://eternia.fr/public/media/pokedex/pgl/206.png" alt="">
    </div>
    <div id="animation2">
        <img src="https://eternia.fr/public/media/pokedex/pgl/206.png" alt="">
    </div>



</div>

@endsection
