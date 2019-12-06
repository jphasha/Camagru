<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camera</title>
</head>

<body>

    <!-- stream video via webcam -->
    <div class="video-wrap">
        <video src="" id="video" playsinline autoplay></video>
    </div>

    <!-- Trigger canvas web API -->
    <div class="controller">
        <button id="snap">Capture</button>
    </div>

    <!-- webcam video snapshot -->
    <canvas id="canvas" width="640" height="480"></canvas>

    <script>
        'use strict';
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const errorMsgElement = document.getElementById('spanError');
        const costraints = {
            audio: true,
            video: {
                width: 1280,
                height: 720
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
            context.drawImage(video, 0, 0, 640, 480);
        })
    </script>
</body>

</html>