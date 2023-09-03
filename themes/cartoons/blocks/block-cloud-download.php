<?php 
$image = block_value('image');
$title = block_value('title') ? block_value('title') : 'Cloud Download';
$text = block_value('text');

echo '<div class="block cloud-download-wrap wide">';
    echo '<div class="download-left">';
        if($image) echo '<img src="'.wp_get_attachment_image_src($image,'full')[0].'" alt="" />';
        echo '<div class="inner">';
            echo '<h1>'.esc_html($title).'</h1>';
            if($text) echo '<p>'.esc_html($text).'</p>';

            echo '<form id="download-form" method="post" name="download-form">';

                echo '<div class="field number">';
                    echo '<label for="number">Asset ID#</label>';
                    echo '<input type="text" name="theid" id="theid" placeholder="1234" pattern="\d{1,4}" maxlength="4" />';
                echo '</div>'; // field

                echo '<button class="btn"><span>Get Cartoon Asset</span></button>';

                echo '<div class="throw_error"></div>';
            echo '</form>';

        echo '</div>'; // inner

        echo '<div class="download-wrap"><a class="btn download" id="download-cloud" download="cartoons.jpg"><span>Download</span><svg width="25.4" height="21" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" style="enable-background:new 0 0 25.4 21" viewBox="0 0 25.4 21"><path d="M17.7 15.1c.4.4.4 1 0 1.4l-4.2 4.2c-.1.1-.2.2-.3.2-.2.1-.3.1-.4.1s-.3 0-.4-.1c-.1-.1-.2-.1-.3-.2l-4.2-4.2c-.4-.4-.4-1 0-1.4s1-.4 1.4 0l2.5 2.5v-7.1c0-.6.4-1 1-1s1 .4 1 1v7.1l2.5-2.5c.4-.4 1-.4 1.4 0zM24.2 9c-1.2-1.7-3.1-2.7-5.1-2.7h-.6C16.9 1.7 12-1 7.2.3 2.2 1.6-.9 6.7.4 11.8c.4 1.4 1.1 2.8 2.1 3.9.4.4 1 .5 1.4.1.4-.4.5-1 .1-1.4-.8-.9-1.3-1.9-1.6-3.1-1-4 1.4-8 5.3-9 4-1 8 1.4 9 5.3.1.4.5.8 1 .8H19c1.4 0 2.7.7 3.5 1.8 1.4 1.9.9 4.6-1 5.9-.5.3-.6.9-.2 1.4.2.3.5.4.8.4.2 0 .4-.1.6-.2 1.4-1 2.3-2.4 2.6-4.1s-.1-3.2-1.1-4.6z" href="javascript:canvas.toDataURL("image/jpeg");"/></svg></a></div>';
    echo '</div>'; // left

    echo '<div id="canvas-wrap"><canvas height=1000px width=1000px id="download-canvas" class="download-canvas"></canvas></div>';
echo '</div>';
?>

<script>
    jQuery(function($){
        let canvas = document.getElementById('download-canvas');
        canvas.height = canvas.width * 1;

        $('#download-form').submit(function(event) {
            event.preventDefault();
            // let canvas = document.querySelector('canvas');

            $('.throw_error').empty();

            let formID = $('input[name=theid]').val();
            const regExp = /^0[0-9].*$/;
            const osKey = bloginfo.xapi;
            const osContract = bloginfo.xcontract;
            if(formID === '') {
                $('.throw_error').fadeIn(1000).html('ID cannot be blank');
            } else if(regExp.test(formID) == true) {
                $('.throw_error').fadeIn(1000).html('Remove the 0 at the beginning');
            } else if(formID > 7774) {
                $('.throw_error').fadeIn(1000).html('Choose an ID between 1 and 7774');
            } else {
                $('#canvas-wrap').addClass('loading');
                
                const options = {
                  method: 'GET',
                  headers: {accept: 'application/json', 'X-API-KEY': osKey}
                };

                fetch('https://api.opensea.io/v2/chain/ethereum/contract/'+osContract+'/nfts/'+formID, options)
                  .then(response => response.json())
                  .then(response => {
                    let image_temp = response.nft.image_url;
                    let image_resized = image_temp.replace('w=500', 'w=1000');


                    canvas = document.getElementById('download-canvas');
                    let context = canvas.getContext('2d');

                    let x = 0, y = 0, IMG_WIDTH = 1000, IMG_HEIGHT = 1000;

                    let fetchImage = (source) => {
                      x = 0;
                      y = 0;
                      return new Promise(resolve => {
                        let image = new Image();
                        image.src = source;
                        image.onload = () => {
                          context.globalAlpha = 1;
                          context.drawImage(image, x, y, IMG_WIDTH, IMG_HEIGHT);
                          resolve();
                        }  
                        image.setAttribute('crossorigin', 'anonymous')
                      });
                    }

                    fetchImage(image_resized);

                    setTimeout(() => {
                        $('#canvas-wrap').removeClass('loading');
                        $('.download-wrap').addClass('show');
                    }, 2000);
 
                  })
                  .catch(err => {
                        $('.throw_error').empty();
                        $('.throw_error').fadeIn(1000).html('Error occured, please try again.');
                  });

            }

        }); // end submit

        let downloadLink = document.getElementById('download-cloud');
        function download() {
            var dt = canvas.toDataURL('image/jpeg');
            this.href = dt;
        };
        downloadLink.addEventListener('click', download, false);
    });
</script>