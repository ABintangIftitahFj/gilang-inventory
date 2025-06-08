<?php
// fix-barcode-issues.php - Diagnostic tool to test camera access and permissions

header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Diagnostic Tool</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #2563eb;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        button {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #1d4ed8;
        }
        video {
            width: 100%;
            max-height: 400px;
            background: #000;
            margin-bottom: 10px;
            border-radius: 8px;
        }
        code {
            display: block;
            background: #f5f5f5;
            padding: 8px;
            border-radius: 4px;
            overflow-x: auto;
            margin-bottom: 10px;
        }
        .result {
            margin-top: 10px;
            padding: 8px;
            border-radius: 4px;
        }
        .success {
            background-color: #d1fae5;
            color: #047857;
        }
        .error {
            background-color: #fee2e2;
            color: #b91c1c;
        }
    </style>
</head>
<body>
    <h1>Camera Diagnostic Tool</h1>
    <div class="card">
        <h2>1. Camera Access Test</h2>
        <p>This will test if your browser can access your camera.</p>
        <video id="testVideo" autoplay playsinline></video>
        <button id="testCameraBtn">Test Camera</button>
        <div id="cameraResult" class="result"></div>
    </div>

    <div class="card">
        <h2>2. Available Cameras</h2>
        <p>This will list all available camera devices on your system.</p>
        <button id="listCamerasBtn">List Cameras</button>
        <div id="camerasList" class="result"></div>
    </div>

    <div class="card">
        <h2>3. Environment Information</h2>
        <div id="userAgentInfo"></div>
    </div>

    <div class="card">
        <h2>Troubleshooting Instructions</h2>
        <ol>
            <li>Make sure you've granted camera permissions to this website</li>
            <li>Try using a different browser (Chrome is recommended)</li>
            <li>On mobile, make sure the app has camera permissions</li>
            <li>If using iOS, make sure you're using Safari</li>
            <li>Try clearing browser cache and cookies</li>
            <li>Ensure your camera is not being used by another application</li>
        </ol>
    </div>

    <script>
        document.getElementById('userAgentInfo').innerHTML = `
            <p><strong>Browser:</strong> ${navigator.userAgent}</p>
            <p><strong>Platform:</strong> ${navigator.platform}</p>
            <p><strong>Secure Context:</strong> ${window.isSecureContext ? 'Yes' : 'No'}</p>
        `;

        document.getElementById('testCameraBtn').addEventListener('click', async function() {
            const video = document.getElementById('testVideo');
            const resultDiv = document.getElementById('cameraResult');
            
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment',
                        width: { ideal: 1280 },
                        height: { ideal: 720 } 
                    } 
                });
                
                video.srcObject = stream;
                resultDiv.textContent = '✅ Camera access successful!';
                resultDiv.className = 'result success';
                
                // Display video settings
                const videoTrack = stream.getVideoTracks()[0];
                const settings = videoTrack.getSettings();
                
                setTimeout(() => {
                    resultDiv.innerHTML = `
                        ✅ Camera access successful!<br>
                        <strong>Camera:</strong> ${videoTrack.label}<br>
                        <strong>Resolution:</strong> ${settings.width}x${settings.height}<br>
                        <strong>Frame Rate:</strong> ${settings.frameRate}
                    `;
                }, 1000);
                
            } catch (error) {
                resultDiv.textContent = `❌ Camera access failed: ${error.message}`;
                resultDiv.className = 'result error';
                console.error('Error accessing camera:', error);
            }
        });

        document.getElementById('listCamerasBtn').addEventListener('click', async function() {
            const camerasListDiv = document.getElementById('camerasList');
            camerasListDiv.textContent = 'Fetching cameras...';
            
            try {
                // Need to request permissions first
                await navigator.mediaDevices.getUserMedia({ video: true });
                
                const devices = await navigator.mediaDevices.enumerateDevices();
                const videoDevices = devices.filter(device => device.kind === 'videoinput');
                
                if (videoDevices.length === 0) {
                    camerasListDiv.textContent = 'No video devices found.';
                    camerasListDiv.className = 'result error';
                    return;
                }
                
                camerasListDiv.innerHTML = `<p>Found ${videoDevices.length} camera(s):</p>`;
                videoDevices.forEach((device, index) => {
                    camerasListDiv.innerHTML += `
                        <p><strong>Camera ${index + 1}:</strong> ${device.label || 'Unnamed camera'}</p>
                    `;
                });
                camerasListDiv.className = 'result success';
                
            } catch (error) {
                camerasListDiv.textContent = `❌ Error listing cameras: ${error.message}`;
                camerasListDiv.className = 'result error';
                console.error('Error listing cameras:', error);
            }
        });
    </script>
</body>
</html>
