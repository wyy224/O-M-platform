<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="./js/echarts.min.js"></script>

</head>

<body>
<?php
//import the databse.php to use the functions
require_once './server/database.php';
session_start();
?>
    <div class="wrapper">
        <div class="top"></div>
        <div class="main">
            <div class="main-top">
                <ul>
                    <li class="active" id="overview">Overview</li>
                    <li id="selectAndEdit">Data</li>
                    <li id="analysis">Analysis</li>
                    <li id="alarm">Alarm</li>
                    <li id="setting">Setting</li>
                </ul>
                <div class="logout">
                    <a onclick="loginStatus()"><svg t="1721957044713" class="icon" viewBox="0 0 1024 1024" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" p-id="1487" width="30" height="30">
                            <path
                                d="M749.098667 157.226667A426.24 426.24 0 0 1 938.666667 512c0 235.648-191.018667 426.666667-426.666667 426.666667S85.333333 747.648 85.333333 512a426.24 426.24 0 0 1 189.226667-354.56 42.666667 42.666667 0 1 1 47.530667 70.869333 341.333333 341.333333 0 1 0 379.52-0.213333 42.666667 42.666667 0 0 1 47.488-70.869333zM512 64a42.666667 42.666667 0 0 1 42.666667 42.666667v298.666666a42.666667 42.666667 0 0 1-85.333334 0v-298.666666a42.666667 42.666667 0 0 1 42.666667-42.666667z"
                                fill="#ffffff" p-id="1488"></path>
                        </svg></a>
                </div>
            </div>
            <div class="main-center">
                <div class="left">
                    <div class="left-top">
                        <div class="little-title">
                            <p>Feature</p>
                        </div>
                        <div class="content">
                            <div class="zonglan">Overview</div>
                            <ul class="zl-list">
                                <li class="actived">Strain</li>
                                <li>vibration</li>
                                <li>noise</li>
                            </ul>
                            <ul class="zl-list">
                                <li>rotate speed</li>
                                <li>Light Vibration</li>
                            </ul>
                        </div>
                    </div>
                    <div class="left-bottom">
                        <div class="little-title">
                            <p>Channel error <br> info</p>
                        </div>
                        <div class="showlist">
                            <div id="strain" class="tongdao active">
                                <p class="yb-btn">Strain</p>
                                <div class="strain-li">
                                </div>
                            </div>
                            <div class="tongdao" id="vibration">
                                <p class="yb-btn">Vibration</p>
                                <div class="vibration-li">
                                </div>
                            </div>
                            <div class="tongdao" id="noise">
                                <p class="yb-btn">Noise</p>
                                <div class="noise-li">
                                </div>
                            </div>
                            <div class="tongdao" id="rotate">
                                <p class="yb-btn">Rotate rate</p>
                                <div class="speed-li">
                                </div>
                            </div>
                            <div class="tongdao" id="light">
                                <p class="yb-btn">Light Vibration</p>
                                <div class="light-li">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="center">
                    <div id="container"></div>
                </div>
                <div class="right">
                    <div class="right-top">
                        <div class="little-title" id="alarmTitle">
                            <p>Alarm Situation</p>
                        </div>
                        <div id="pie">

                        </div>
                    </div>
                    <div class="right-bottom">
                        <div class="little-title">
                            <p>Alarm Overview</p>
                        </div>
                        <div class="content">
                            <div class="date-picker">
                                <label for="date">Date：</label>
                                <input type="date" id="date" name="date" required class="form-control">
                                <button class="modify-button" id="Submit">Submit</button>
                                <button class="modify-button" onclick="window.location='alarm.php'">More</button>
                            </div>
                            <div class="show-info" id="showInfo">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="./js/three.min.js"></script>
<script type="module">
    import { OBJLoader } from './js/OBJLoader.js';
    import { OrbitControls } from './js/OrbitControls.js';
    document.addEventListener('DOMContentLoaded', (event) => {
        const container = document.getElementById('container');

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 80;

        const renderer = new THREE.WebGLRenderer({
            alpha: true
        });
        container.appendChild(renderer.domElement);

        function resizeRendererToDisplaySize(renderer) {
            const canvas = renderer.domElement;
            const width = container.clientWidth;
            const height = container.clientHeight;
            // Set the width and height of the canvas, where the width and height are the width and height of the container elements
            if (canvas.width !== width || canvas.height !== height) {
                renderer.setSize(width, height, false); // 第三个参数为false，表示不需要调整WebGL画布的视口大小
            }

            // Update the projection matrix of the camera to accommodate the new dimensions (if the camera is a perspective camera)
            if (camera instanceof THREE.PerspectiveCamera) {
                camera.aspect = width / height;
                camera.updateProjectionMatrix();
            }
        }

        // First call to set size
        resizeRendererToDisplaySize(renderer);

        // Add event listeners for window size changes
        window.addEventListener('resize', function () {
            resizeRendererToDisplaySize(renderer);
        });
        // Adding Light
        const directionLight = new THREE.DirectionalLight(0xffffff, 0.5);
        directionLight.position.set(1, 1, 1).normalize();
        scene.add(directionLight);
        var model;

        //Load the OBJ model
        const loader = new OBJLoader();
        loader.load('js/model.obj', function (object) {
            object.position.set(0, -50, 0);
            model = object;
            scene.add(object);
            animate();
        }, undefined, function (error) {
            console.error('An error happend', error)
        });
        const controls = new OrbitControls(camera, renderer.domElement);

        function animate() {
            requestAnimationFrame(animate);

            // update OrbitControls
            controls.update();

            // Render Scene
            renderer.render(scene, camera);
        }
        animate();

    })

</script>
<script src="js/common.js"></script>

<script src="js/index.js"></script>