@extends('application')

@section('title')
HANICAM
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
                <?php }} ?>

            </g>
        </svg>
    </div>

    </div>

@stop

@section('script')
    <script type="text/javascript">
        var url = "http://192.168.33.11:1234";
//        var socket = io.connect(url);

        var myLocation;
//        socket.on('connect', function(){
            $('use').hover(
                    function() {
                        $('#' + myLocation).attr("stroke-width","2");
                        $(this).attr("stroke-width","7");
                        myLocation = $(this).attr("id");
                        $('#' + myLocation).attr("stroke-width", "7");
//                        socket.emit('location', myLocation);
                    }
            ).click(
                    function() {
                        $(this).attr("fill","blue");
//                        socket.emit('attack', $(this).attr("id"));
                    }
            );
//        });
    </script>
@stop