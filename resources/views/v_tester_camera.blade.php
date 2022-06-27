<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengantar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }

        #camera,
        #camera--view,
        #camera--sensor,
        #camera--output {
            position: fixed;
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        #camera--view,
        #camera--sensor,
        #camera--output {
            transform: scaleX(-1);
            filter: FlipH;
        }

        #camera--trigger {
            width: 160px;
            background-color: black;
            color: white;
            font-size: 16px;
            border-radius: 30px;
            border: none;
            padding: 15px 20px;
            text-align: center;
            box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2);
            position: fixed;
            bottom: 30px;
            left: calc(50% - 100px);
        }

        #submit {
            width: 80px;
            background-color: white;
            color: black;
            font-size: 12px;
            border-radius: 30px;
            border: none;
            padding: 15px 20px;
            text-align: center;
            box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2);
            position: fixed;
            bottom: 30px;
            left: calc(90% - 80px);
        }



        .taken {
            height: 100px !important;
            width: 100px !important;
            /* margin: 50px; */
            transition: all 0.5s ease-in;
            border: solid 3px white;
            box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2);
            top: 20px;
            right: 20px;
            z-index: 3;
        }

        #frame {
            position: fixed;
            height: 80% !important;
            width: 80% !important;
            margin: 50px;
            /* transition: all 0.5s ease-in; */
            border: solid 3px white;
            box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2);
            /* top: 0;
            right: 0;
            left: 0;
            bottom: 0; */
            z-index: 2;
        }

        /* #overlay {
            position: fixed;
            display: block;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 20;
            bottom: 0;
            border: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2;
            cursor: pointer;
        } */
    </style>
</head>

<body>
    <div id="frame"></div>

    <main id="camera">
        <div id="border">
            <!-- Camera sensor -->
            <canvas id="camera--sensor"></canvas>
            <!-- Camera view -->
            <video id="camera--view" autoplay playsinline></video>
            <!-- Camera output -->
            <img src="//:0" alt="" id="camera--output">
            <!-- Camera trigger -->
            <button id="camera--trigger">Take a picture</button>
            <button class="btn btn-sm" id="submit" type="submit">Submit</button>
        </div>
    </main>

    {{-- <video id="video" width="1280" height="720" autoplay></video>
    <button id="start-camera">Start Camera</button>
    <canvas id="canvas" width="1280" height="720"></canvas>
    <button id="click-photo">Click Photo</button>
    <script type="text/javascript">
        let camera_button = document.querySelector("#start-camera");
        let video = document.querySelector("#video");
        let click_button = document.querySelector("#click-photo");
        let canvas = document.querySelector("#canvas");

        camera_button.addEventListener('click', async function() {
            let stream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: false
            });
            video.srcObject = stream;
        });

        click_button.addEventListener('click', function() {
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            let image_data_url = canvas.toDataURL('image/jpeg');

            // data url of the image
            console.log(image_data_url);
        });
    </script> --}}

    <script type="text/javascript">
        //Set constraints for the video stream
        var constraints = {
            video: {
                facingMode: "user",
                // exact: 'environment'
                width: {
                    ideal: 4096
                },
                height: {
                    ideal: 2160
                }
            },
            audio: false
        };
        // Define constants
        const cameraView = document.querySelector("#camera--view"),
            cameraOutput = document.querySelector("#camera--output"),
            cameraSensor = document.querySelector("#camera--sensor"),
            cameraTrigger = document.querySelector("#camera--trigger")
        let cameraSrc;
        // Access the device camera and stream to cameraView
        function cameraStart() {
            navigator.mediaDevices
                .getUserMedia(constraints)
                .then(function(stream) {
                    track = stream.getTracks()[0];
                    cameraView.srcObject = stream;
                })
                .catch(function(error) {
                    console.error("Oops. Something is broken.", error);
                });
        }
        // Take a picture when cameraTrigger is tapped
        cameraTrigger.onclick = function() {
            cameraSensor.width = cameraView.videoWidth;
            cameraSensor.height = cameraView.videoHeight;
            cameraSensor.getContext("2d").drawImage(cameraView, 0, 0);
            cameraOutput.src = cameraSensor.toDataURL("image/png");
            cameraOutput.classList.add("taken");
            cameraSrc = cameraSensor.toDataURL("image/png");


            console.log(cameraSrc);

            // actual width & height of the camera video
            let stream_width = cameraSensor.width;
            let stream_height = cameraSensor.height;

            console.log('Width: ' + stream_width + 'px');
            console.log('Height: ' + stream_height + 'px');
        };

        // Start the video stream when the window loads
        window.addEventListener("load", cameraStart, false);

        $('button#submit').click(function() {
            if (cameraSrc) {
                let fData = new FormData();
                fData.append('_token', "<?= csrf_token() ?>");
                fData.append('image', cameraSrc);
                $.ajax({
                    method: 'POST',
                    url: "<?= Request::root() . '/register/send' ?>",
                    data: fData,
                    processData: false,
                    contentType: false,
                    error: function() {
                        alert('Terjadi Kesalahan')
                    },
                    success: function(res) {
                        // console.log(res);
                        window.location = "/foto"
                    }
                });
            }
        });
    </script>

</body>

</html>
