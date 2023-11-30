
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('assets/js/face-api.js') }}"></script>
    <title>Face Verification</title>
    <style>
        /* Add CSS styles as needed */

        .container{
            position: relative;
        }
        video {
    max-width: 75%;
    height: auto;
    display: block;
    margin: 0 auto;
    border-radius: 10%;
    position: relative;
    left: 20px;
}

button {
    background-color: red;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    cursor: pointer;
    position: absolute; /* Mengubah menjadi absolute agar berdasarkan container */
    filter: brightness(80%);
    top: 540%; /* Sesuaikan posisi top sesuai kebutuhan */
    left: 53%; /* Sesuaikan posisi left sesuai kebutuhan */
    transform: translate(-50%, -50%); /* Agar posisi ditengah-tengah container */
    z-index: 9999;
}





        button:hover {
            filter: brightness(100%);
        }
    </style>
</head>

<body>
    <div class="container">
        <center>
            <h1>Face Verification</h1>
        </center>
        <br>
        <img id="image1" style="max-width: 300px;" alt="Captured Image" hidden>
        <img id="image2" style="max-width: 300px;" alt="User's Face Image" hidden>
        <button id="verifyButton" onclick="verifyFaces()">Verify</button>
        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
        <img id="backButton" src="" alt="kembali" onclick="goToLoginPage()">
        <script>
            document.addEventListener('DOMContentLoaded', async () => {
                await faceapi.nets.tinyFaceDetector.loadFromUri('/assets/models');
                await faceapi.nets.faceLandmark68Net.loadFromUri('/assets/models');
                await faceapi.nets.faceRecognitionNet.loadFromUri('/assets/models');

                const image1 = document.getElementById('image1');
                const image2 = document.getElementById('image2');
                const verifyButton = document.getElementById('verifyButton');

                const video = document.createElement('video');
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
                document.body.appendChild(video);
                await video.play();

                let capturedImage = null;

                verifyButton.addEventListener('click', async () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const context = canvas.getContext('2d');
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    capturedImage = canvas.toDataURL('image/jpeg');
                    image1.src = capturedImage;

                    // Load the user's face image from the server
                    const userFaceImageUrl = '/user/face-image'; // Adjust the URL accordingly
                    const response = await fetch(userFaceImageUrl);
                    const userFaceImageBlob = await response.blob();
                    const userFaceImage = URL.createObjectURL(userFaceImageBlob);
                    image2.src = userFaceImage;

                    // Perform face verification
                    verifyFaces(capturedImage, userFaceImage);
                });
            });

            async function verifyFaces(capturedImageUrl, userFaceImageUrl) {
                const capturedImage = await faceapi.fetchImage(capturedImageUrl);
                const userFaceImage = await faceapi.fetchImage(userFaceImageUrl);

                const detections1 = await faceapi.detectAllFaces(capturedImage, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptors();
                const detections2 = await faceapi.detectAllFaces(userFaceImage, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptors();

                if (detections1.length > 0 && detections2.length > 0) {
                    const faceMatcher = new faceapi.FaceMatcher(detections1, 0.6);
                    const bestMatch = faceMatcher.findBestMatch(detections2[0].descriptor);

                    const similarityPercentage = (1 - bestMatch.distance) * 100;
                    console.log(`Face Similarity: ${similarityPercentage.toFixed(2)}%`);

                    // Handle the result as needed
                    if (similarityPercentage > 51) {
                        alert('Face verification successful. Redirecting to home...');
                        window.location.href = '/home'; // Redirect to home page
                    } else {
                        alert('Face verification failed. Face similarity is less than 51%.');
                    }
                } else {
                    alert('Faces not detected in one or both images.');
                }
            }
            function goToLoginPage() {
                window.location.href = '/'; // Redirect to login page
            }
        </script>
    </div>


</body>

</html>

