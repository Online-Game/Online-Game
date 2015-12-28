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
                    <text x="{{ $j*86+$i*43+33 }}" y="{{ $i*75+65 }}" id="{{'text'.$i.'in'.$j}}" font-size="30"></text>
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
            var title = 'HONEYCOMB';
            var titleLocation = '2in2';
            var start = 'START';
            var startLocation = '4in3';

            function setWord(word, startLoc, fontSize) {
                fontSize = fontSize || 30;
                var location = startLoc.slice(0, startLoc.length - 1);
                for (var i = 0; i < word.length; i++) {
                    $('#'+ location + (i + Number(startLoc.substr(startLoc.length - 1)))).attr('class',word);
                    $('#text' + location + (i + Number(startLoc.substr(startLoc.length - 1)))).text(word[i]).attr('font-size', fontSize).attr('class',word);
                }
            }

            setWord(title, titleLocation, 45);
            setWord(start, startLocation, 45);

            $('use').hover(
                    function() {
                        $('#' + myLocation).attr("stroke-width","2");
                        $(this).attr("stroke-width","7");
                        myLocation = $(this).attr("id");
                        $('#' + myLocation).attr("stroke-width", "7");
                    }
            );
            $('.'+start).hover(
                    function() {
                        $('use'+'.'+start).attr("fill","blue");
                    },
                    function(){
                        $('use'+'.'+start).attr("fill","white");
                    }
            ).click(
                    function() {
                        $('.'+title).text('').removeClass(title);
                        $('.'+start).attr('fill','white').text('').removeClass(start).unbind("mouseenter").unbind("mouseleave").unbind("click");
                        $('use').hover(
                                function() {
                                    $('#' + myLocation).attr("stroke-width","2");
                                    $(this).attr("stroke-width","7");
                                    myLocation = $(this).attr("id");
                                    $('#' + myLocation).attr("stroke-width", "7");
                                }
                        );

                        var url = "http://192.168.33.11:12345";
                        var socket = io.connect(url);
                        socket.on('connect', function() {
                            var loadingLocation = 0;
                            var loadingOrders = ['1in6', '1in7', '2in7', '3in6', '3in5', '2in5'];
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

                            setWord(matching, matchingStartloc);
                            setWord(cansel, canselStartLoc, 45);

                            var loadingColor = setInterval(function () {
                                $('#' + loadingOrders[loadingLocation]).attr('fill', 'none');
                                nextLocation();
                                $('#' + loadingOrders[loadingLocation]).attr('fill', 'blue');
                            }, 50);

                            socket.emit('standby');
                            socket.on('join', function(id){
                                socket.emit('join', id);
                            });
                            socket.on('battle',function(){
                                $('.'+matching).text('').removeClass(matching);
                                $('.'+cansel).text('').removeClass(cansel);
                                clearInterval(loadingColor);
                                $('use').click(function() {
                                    $(this).attr("fill","blue");
                                    socket.emit('attack', $(this).attr("id"));
                                });
                                socket.on('enemy-attack', function(data){
                                    $('#'+data.attack).attr("fill","red");
                                });
                            });
                        })
                    }
            );
        });
    </script>
@stop