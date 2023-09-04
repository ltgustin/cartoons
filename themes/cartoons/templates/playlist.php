<?php 
$homeId = get_option('page_on_front');
$songs = get_field('playlist',$homeId);

if(!empty($songs)) :

    $count = 0;

    $songs_array = array(
        'tracks' => array(),
        'urls'   => array()
    );

    foreach ($songs as $key => $song) {
        if(!empty($song)) :
            array_push($songs_array['tracks'],$song['title']);
            array_push($songs_array['urls'],$song['url']);
        $count++; endif;
    }

    echo '<div id="app-cover">';
        echo '<div id="player">';
            echo '<div id="player-track">';
                echo '<div id="track-name"></div>';
            echo '</div>';
            echo '<div id="player-content">';
                echo '<div id="player-controls">';
                    if($count > 1) :
                        echo '<div class="button" id="play-previous">';
                            echo '<i class="icon-play-prev"></i>';
                        echo '</div>'; // prev
                    endif;

                    echo '<div class="button" id="play-pause-button">';
                        echo '<i class="icon-play"></i>';
                    echo '</div>'; // play

                    if($count > 1) :
                        echo '<div class="button" id="play-next">';
                            echo '<i class="icon-play-next"></i>';
                        echo '</div>'; // next
                    endif;
                echo '</div>'; // player controls
            echo '</div>'; // player content
        echo '</div>'; // player
    echo '</div>'; // app cover
?>

<script>
//https://codepen.io/TaxiNews/pen/BaaZEYr
jQuery(function($){
    // PLAYLIST
    var playerWrap = $('#player'),
        playerTrack = $("#player-track"), 
        trackName = $('#track-name'), 
        playPauseButton = $("#play-pause-button"), 
        i = playPauseButton.find('i'), 
        bTime, nTime = 0, 
        buffInterval = null, 
        tFlag = false, 
        trackNames = [<?php echo '"'.implode('","', $songs_array['tracks']).'"' ?>],
        trackUrl = [<?php echo '"'.implode('","', $songs_array['urls']).'"' ?>],
        playPreviousTrackButton = $('#play-previous'), 
        playNextTrackButton = $('#play-next'), 
        currIndex = -1;

    function playPause() {
        setTimeout(function() {
            if(audio.paused) {
                playerTrack.addClass('active');
                checkBuffering();
                i.attr('class','icon-pause');
                audio.play();
            } else {
                playerTrack.removeClass('active');
                clearInterval(buffInterval);
                i.attr('class','icon-play');
                audio.pause();
            }
        },300);
    }

    function checkBuffering() {
        clearInterval(buffInterval);
        buffInterval = setInterval(function() { 
            if( (nTime == 0) || (bTime - nTime) > 1000  )
                playerWrap.addClass('buffering');
            else
                playerWrap.removeClass('buffering');

            bTime = new Date();
            bTime = bTime.getTime();

        },100);
    }

    function selectTrack(flag) {
        if( flag == 0 || flag == 1 )
            ++currIndex;
        else
            --currIndex;

        if( (currIndex > -1) && (currIndex < trackNames.length) ) {
            if( flag == 0 ) {
                i.attr('class','fa icon-play');
            } else {
                i.attr('class','fa icon-pause');
            }

            currTrackName = trackNames[currIndex];

            audio.src = trackUrl[currIndex];
            
            nTime = 0;
            bTime = new Date();
            bTime = bTime.getTime();

            if(flag != 0) {
                audio.play();
                playerTrack.addClass('active');
            
                clearInterval(buffInterval);
                checkBuffering();
            }

            trackName.text(currTrackName);
        } else {
            if( flag == 0 || flag == 1 ) {
                --currIndex;
            } else {
                ++currIndex;
            }
        }
    }

    function initPlayer() {   
        audio = new Audio();

        selectTrack(0);
        
        audio.loop = true;
        
        playPauseButton.on('click',playPause);

        playPreviousTrackButton.on('click',function(){ selectTrack(-1);} );
        playNextTrackButton.on('click',function(){ selectTrack(1);});
    }
        
    initPlayer();
});
</script>
<?php endif;