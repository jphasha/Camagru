<?php

require_once '../core/initialise.php';

$user = new User();

if (!$user->isLoggedIn())
{
    Redirect::to('../index.php');
}

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
    <div class="camera_section">

        <!-- space where to stream video via webcam -->
        <div class="video-wrap">
            <video src="" id="video" playsinline autoplay></video>
        </div>

        <!-- strike a pose -->
        <div class="controller">
            <button id="capture" name="capture">Capture</button>
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

        <!-- there is that canvas -->
        <canvas id="canvas" width="500" height="500"></canvas>

        <!-- image saving -->
        <form action="../classes/Upload.php" method="post">
            <input type="hidden" id="img_enc" name="image_encrypt">
            <input type="submit" id="image_saver" name="image_saver" value="save image">
        </form>

        <!-- enter javascript. we need it to activate the camera and take pictures -->
        <script>
            const video = document.getElementById('video'); // to ac cess and manipulate the video streaming space.

            const sticker1 = document.getElementById('sticker_1');
            const sticker2 = document.getElementById('sticker_2');
            const sticker3 = document.getElementById('sticker_3');
            const sticker4 = document.getElementById('sticker_4');

            const canvas = document.getElementById('canvas');

            const capture = document.getElementById('capture');

            const flame_emoji = document.getElementById('flame_emoji');
            const bandaid_emoji = document.getElementById('bandaid_emoji');
            const cool_emoji = document.getElementById('cool_emoji');
            const instagram_emoji = document.getElementById('instagram_emoji');

            var image_saver = document.getElementById('image_saver');

            const errorMsgElement = document.getElementById('spanError'); // in case of errors we may encounter when trying to access webcam
            const costraints = {
            video: {
                width: 500,
                height: 500
                }
            }; // streaming properties

            // a function to access the webcam
            async function init() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia(costraints);
                    handleSuccess(stream);
                }
                catch (e) {
                    errorMsgElement.innerHTML = `navigator.getUserMedia.error:${e.toString()}`;
                }
            }

            // what to do upon successful video access
            function handleSuccess(stream) {
                window.stream = stream;
                video.srcObject = stream;
            }

            // now to activate that webcam
            init();

            // draw on the canvas
            var context = canvas.getContext('2d'); // set the canvas drawing method to "2d" (getContext('2d'))

            // a function that draws the captured image to / on the canvas
            // function draw_image()
            // {
            //     context.drawImage(video, 0, 0, 500, 500); // using the getContext drawing method, draw an image of 500*500 beginning at (0,0) axis.
            // }

            // // now what to do when the capture button is pressed.
            // capture.addEventListener("click", draw_image()); // in the event that click is true. apply function draw_image()

            capture.addEventListener("click", function() {
                context.drawImage(video, 0, 0, 500, 500);
            });

            sticker1.addEventListener("click", function() {
                context.drawImage(flame_emoji, 0, 0, 100, 100);
            });

            sticker2.addEventListener("click", function() {
                context.drawImage(bandaid_emoji, 400, 0, 100, 100);
            });

            sticker3.addEventListener("click", function() {
                context.drawImage(cool_emoji, 0, 400, 100, 100);
            });

            sticker4.addEventListener("click", function() {
                context.drawImage(instagram_emoji, 400, 400, 100, 100);
            });

            image_saver.addEventListener("click", function() {
                image = canvas.toDataURL("images/png");
                document.getElementById("img_enc").value = image;
            })
        </script>
    </div>
    <div class="view_prev_pics"></div>
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>