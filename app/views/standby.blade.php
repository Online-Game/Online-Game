@extends('application')

@section('title')
Standby only HANICAM
@stop

@section('content')
    <div>

    <div>
        <svg width="1500" height="1500" viewBox="0 0 1500 1500">
            <defs>
                <polygon points="0,25 43,0 86,25 86,75 43,100 0,75" id="hex-polygon1"/>
            </defs>
            <g transform="translate(0,0)">
                <?php
                $xlength = 15;
                $ylength = 7;
                for($i = 0; $i < $ylength; $i++){
                for($j = 0; $j < $xlength - $i; $j++){
                ?>
                <use x="{{ $j*86+$i*43+5 }}" y="{{ $i*75+5 }}"
                     xlink:href="#hex-polygon1" fill="white" id="{{$i.'in'.$j}}"
                     stroke="black" stroke-width="2" stroke-linejoin="round"></use>
                    <text x="{{ $j*86+$i*43+33 }}" y="{{ $i*75+65 }}" class="{{$i.'in'.$j}}" font-size="30">
                    </text>
                <?php }} ?>

            </g>
        </svg>
    </div>

    </div>

@stop

@section('script')
    <script type="text/javascript">
        $(function() {
            var myLocation;
            var loadingLocation = 0;
            var loadingOrders = ['1in6', '1in7',  '2in7', '3in6', '3in5', '2in5'];
            var matching = 'マッチング中';
            var matchingStartloc = '5in2';
            var cansel = '×';
            var canselStartLoc = '2in6';
            function nextLocation() {
                loadingLocation++;
                if (loadingLocation >= loadingOrders.length) {
                    loadingLocation = 0;
                }
            }
            function setWord(word, startLoc, fontSize, className) {
                fontSize = fontSize || 30;
                className = className || word;

                var location = startLoc.slice(0, startLoc.length - 1);
                for (var i = 0; i < word.length; i++) {
                    $('.' + location + (i + Number(startLoc.substr(startLoc.length - 1)))).text(word[i]).attr('font-size', fontSize);
                }
            }

            setWord(matching, matchingStartloc);
            setWord(cansel, canselStartLoc, 45);

            setInterval(function () {
                $('#' + loadingOrders[loadingLocation]).attr('fill', 'none');
                nextLocation();
                $('#' + loadingOrders[loadingLocation]).attr('fill', 'blue');
            }, 50);
        });
    </script>
@stop