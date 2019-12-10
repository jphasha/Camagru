<?php

require_once '../core/initialise.php';

$user = new User();

if ($user->isLoggedIn())
{
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camera</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header class="header">
    </header>

    <!-- stream video via webcam -->
    <div class="video-wrap">
        <video src="" id="video" playsinline autoplay></video>
    </div>

    <!-- Trigger canvas web API -->
    <div class="controller">
        <button id="snap">Capture</button>
    </div>

    <!-- stickers -->
    <p>stickers</p>
    <div class="sticker_field">

        <!-- flame -->
        <button id="sticker_1">
            <img src="../stickers/sticker1.png" alt="flame emoji" id="flame_emoji" style="height: 80px; width: 80px;">
        </button>

        <!-- bandaid -->
        <button id="sticker_2">
            <img src="../stickers/sticker2.png" alt="bandaid" id="bandaid_emoji" style="height: 80px; width: 80px;">
        </button>

        <!-- cool -->
        <button id="sticker_3">
            <img src="../stickers/sticker3.png" alt="cool" id="cool_emoji" style="height: 80px; width: 80px;">
        </button>

        <!-- instagram png -->
        <button id="sticker_4">
            <img src="../stickers/sticker4.png" alt="instagram_emoji" id="instagram_emoji" style="height: 80px; width: 80px;">
        </button>
    </div>

    <!-- image saving -->
    <form action="upload.php" method="post">
        <input type="hidden" id="img_enc" name="image_encrypt"> <!-- nvm i'm getting something here -->
        <input type="submit" id="" name="" value="save image">
    </form>

    <!-- webcam video snapshot -->
    <canvas id="canvas" width="500" height="500"></canvas>

    <script>
        'use strict';
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const errorMsgElement = document.getElementById('spanError');
        const costraints = {
            // audio: true,
            video: {
                width: 500,
                height: 500
            }
        };
        // access webcam
        async function init() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia(costraints);
                handleSuccess(stream);
            } catch (e) {
                errorMsgElement.innerHTML = `navigator.getUserMedia.error:${e.toString()}`;
            }
        }
        // success
        function handleSuccess(stream) {
            window.stream = stream;
            video.srcObject = stream;
        }
        // load init
        init();

        // Draw image
        var context = canvas.getContext('2d');

        snap.addEventListener("click", function() {
            context.drawImage(video, 0, 0, 500, 500);

          /*  document.getElementById("img_enc").value = canvas.toDataURL("images/png");*/
            save();
        });

        // stickers
        document.getElementById("sticker_1").addEventListener("click", function()
        {
            document.getElementById("img_enc").value = "sticker1.png";
        });
        document.getElementById("sticker_2").addEventListener("click", function()
        {
            document.getElementById("img_enc").value = "sticker2.png";
        });
        document.getElementById("sticker_3").addEventListener("click", function()
        {
            document.getElementById("img_enc").value = "sticker3.png";
        });
        document.getElementById("sticker_4").addEventListener("click", function()
        {
            document.getElementById("img_enc").value = "sticker4.png";
        });
        function save()
        {
            var canv_img = canvas.toDataURL("images/png");
            var http = new XMLHttpRequest();
            http.onreadystatechange = function()
            {
                if (this.OnreadyState == 4 && this.status == 200)
                {
                    // hang on.
                }
            }
            http.open('POST', 'save_img.php', true);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.send("image_url="+canv_img+"&sticker="+document.getElementById("img_enc").value);
        }
    </script>
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>

</html>

<?php
}

else
{
    Redirect::to('../index.php');
}
?>