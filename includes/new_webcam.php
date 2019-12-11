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
            <button id="capture">Capture</button>
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

        <!-- enter javascript. we need it to activate the camera and take pictures -->
        <script>
            const video = document.getElementById('video'); // to access and manipulate the video streaming space.
            const canvas = document.getElementById('canvas'); // || ||
            const capture = document.getElementById('capture');
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
            // init();

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
            context.drawImage(video, 0, 0, 500, 500);});

        </script>
    </div>
    <div class="view_prev_pics"></div>
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>