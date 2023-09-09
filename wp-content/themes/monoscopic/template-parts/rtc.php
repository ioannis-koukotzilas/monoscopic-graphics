<div id="threejs-container" style="width: 100%; height: 100vh;"></div>

<div id="controls">
    <button id="playVideo">Play</button>
    <button id="pauseVideo">Pause</button>
    <button id="startRecording">Start Recording</button>
    <button id="stopRecording">Stop Recording</button>
    <a id="downloadLink" style="display:none;">Download</a>

    <!-- User input for custom text -->
    <input type="text" id="customText" placeholder="Enter your text">
    <button id="updateText">Update Text</button>
</div>

<!-- Hidden canvas for text rendering -->
<canvas id="textCanvas" style="display:none;" width="1080" height="1920"></canvas>

<audio id="audioElement" src="http://localhost/bdl-graphics/wp-content/themes/monoscopic/src/assets/video/SEEKERSINTERNATIONAL - RunComeTest.mp3" style="display: none;"></audio>