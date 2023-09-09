document.addEventListener('DOMContentLoaded', (event) => {

  const containerWidth = 1080;
  const containerHeight = 1920;

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(75, containerWidth / containerHeight, 0.1, 1000);
  const renderer = new THREE.WebGLRenderer();
  renderer.setSize(containerWidth, containerHeight);
  document.getElementById('threejs-container').appendChild(renderer.domElement);

  // Create video element and texture
  const video = document.createElement('video');
  video.src = "http://localhost/bdl-graphics/wp-content/themes/monoscopic/src/assets/video/SP_Pro_Promo.mp4";
  video.load();

  const videoTexture = new THREE.VideoTexture(video);
  videoTexture.minFilter = THREE.LinearFilter;
  videoTexture.magFilter = THREE.LinearFilter;
  videoTexture.format = THREE.RGBFormat;

  const geometry = new THREE.PlaneGeometry(2, 2);

  // Add video to a mesh and the mesh to the scene
  const videoMaterial = new THREE.MeshBasicMaterial({ map: videoTexture });
  const videoMesh = new THREE.Mesh(geometry, videoMaterial);
  scene.add(videoMesh);

  // Function to draw text on 2D canvas
  function drawTextToCanvas(text) {
    const canvas = document.getElementById('textCanvas');
    const ctx = canvas.getContext('2d');

    // Clear previous text
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Set text style
    ctx.font = '48px Arial';
    ctx.fillStyle = 'red';
    ctx.textAlign = 'center';
    ctx.fillText(text, canvas.width / 2, canvas.height / 2);
  }

  const textTexture = new THREE.CanvasTexture(document.getElementById('textCanvas'));
  const textMaterial = new THREE.MeshBasicMaterial({ map: textTexture, transparent: true });
  const textMesh = new THREE.Mesh(geometry, textMaterial);
  scene.add(textMesh);

  const audioElement = document.getElementById('audioElement');

  // Video & Audio controls
  document.getElementById('playVideo').addEventListener('click', () => {
    video.play();
    audioElement.play();
  });

  document.getElementById('pauseVideo').addEventListener('click', () => {
    video.pause();
    audioElement.pause();
  });

  // Update Text functionality
  document.getElementById('updateText').addEventListener('click', () => {
    const customText = document.getElementById('customText').value;
    drawTextToCanvas(customText);
    textTexture.needsUpdate = true;
  });

  // Recording functionality
  let mediaRecorder;
  let recordedChunks = [];
  const startRecording = document.getElementById('startRecording');
  const stopRecording = document.getElementById('stopRecording');
  const downloadLink = document.getElementById('downloadLink');

  startRecording.addEventListener('click', () => {
    const videoStream = renderer.domElement.captureStream ? renderer.domElement.captureStream() : renderer.domElement.mozCaptureStream();
    const audioStream = audioElement.captureStream ? audioElement.captureStream() : audioElement.mozCaptureStream();

    const combinedStream = new MediaStream([...videoStream.getVideoTracks(), ...audioStream.getAudioTracks()]);

    mediaRecorder = new MediaRecorder(combinedStream);

    mediaRecorder.ondataavailable = event => {
      if (event.data.size > 0) recordedChunks.push(event.data);
    };
    mediaRecorder.onstop = () => {
      const blob = new Blob(recordedChunks, { type: 'video/webm' });
      const url = URL.createObjectURL(blob);
      downloadLink.href = url;
      downloadLink.download = 'recorded-video.webm';
      downloadLink.style.display = 'block';
    };
    mediaRecorder.start();
  });


  stopRecording.addEventListener('click', () => {
    if (mediaRecorder) mediaRecorder.stop();
  });

  video.addEventListener('loadedmetadata', function () {
    // Get video dimensions
    const videoWidth = video.videoWidth;
    const videoHeight = video.videoHeight;

    // Calculate video and container aspect ratios
    const videoAspectRatio = videoWidth / videoHeight;
    const containerAspectRatio = containerWidth / containerHeight;

    let planeWidth, planeHeight;

    // Depending on the video's aspect ratio, fit the video inside the container
    if (videoAspectRatio > containerAspectRatio) {
      // Video is wider
      planeWidth = 2;
      planeHeight = 2 / videoAspectRatio;
    } else {
      // Video is taller
      planeHeight = 2;
      planeWidth = 2 * videoAspectRatio;
    }

    videoMesh.scale.set(planeWidth, planeHeight, 1);
  });

  // Render function
  function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
  }
  animate();

  video.muted = true;

  camera.position.z = 1;
});
