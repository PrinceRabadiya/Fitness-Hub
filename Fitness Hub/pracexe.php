<?php
    include("db.php");
    session_start();
    if (!isset($_SESSION["email"])) {
        header("location:./login/login.php");
    }
    $id=$_GET["id"];
    $select="SELECT * FROM exercises WHERE _courseid='$id'";
    $result=mysqli_query($conn,$select);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="pracexe.css">
    <script src="https://kit.fontawesome.com/a319ab9648.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="left">
            <div id="image-description"></div>
            <div id="timer-container">
                <div id="timer">30</div>
                <svg id="svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                    <circle id="timer-ring" cx="50" cy="50" r="40" />
                </svg>
            </div>
            <div class="btngrops">
            <button id="pauseButton">Pause</button>
            <button id="skipButton" onclick="skipexe();"><i class="fa-solid fa-forward" style="color: #ffffff;"></i></button>
            </div>
        </div>
        <div class="right">
            <div id="image-container">
                <img id="image" src="">
                <div id="message"></div>
            </div>
        </div>
    </div>

    <script>
                var images = [
                    <?php
                        while($row=mysqli_fetch_assoc($result)){
                            echo "    {
                                src: '$row[exercises_video]',
                                alt: 'Image 1',
                                title: 'Title 1',
                                description: '$row[exercises_name]'
                            },";
                        }
                        ?>
            ];
        // var images = [{
        //         src: "../img/debug2.gif",
        //         alt: "Image 1",
        //         title: "Title 1",
        //         description: "deadbug exercise"
        //     },
        //     {
        //         src: "../img/leg raise.gif",
        //         alt: "Image 2",
        //         title: "Title 2",
        //         description: "leg raise exercise "
        //     },
        //     {
        //         src: "../img/spiderman pushups.gif",
        //         alt: "Image 3",
        //         title: "Title 3",
        //         description: "Spiderman pushup exercise "
        //     },
        //     {
        //         src: "../img/cobra2.gif",
        //         alt: "Image 3",
        //         title: "Title 3",
        //         description: "cobra exercise "
        //     }
        // ];


        var currentIndex = -1;
        var timerElement = document.getElementById("timer");
        var imageElement = document.getElementById("image");
        var descriptionElement = document.getElementById("image-description");
        var messageElement = document.getElementById("message");
        var pauseButton = document.getElementById("pauseButton");
        var timerInterval;
        var isPaused = false;
        var isBreakTime = false;
        var remainingTime = 30;

        function startTimer() {
            updateTimerDisplay(remainingTime);

            timerInterval = setInterval(function() {
                remainingTime--;
                updateTimerDisplay(remainingTime);
                if (remainingTime === 0) {
                    clearInterval(timerInterval);
                    if (isBreakTime) {
                        isBreakTime = false;
                        messageElement.textContent = "";
                        changeImage();
                        showImageAndDescription();
                        remainingTime = 30;
                        startTimer();
                    } else {
                        isBreakTime = true;
                        messageElement.textContent = "TAKE A 30 SEC BREAK";
                        hideImageAndDescription();
                        remainingTime = 30;
                        startTimer();
                    }
                }
            }, 1000);
        }

        function updateTimerDisplay(time) {
            timerElement.textContent = time;
            var dashOffset = (251.2 * (30 - time)) / 30;
            document.getElementById("timer-ring").style.strokeDashoffset = dashOffset;
        }

        function changeImage() {
            currentIndex++;
            if (currentIndex >= images.length) {
                currentIndex = 0;
                breaktimer();
            }

            var currentImage = images[currentIndex];
            imageElement.src = currentImage.src;
            imageElement.alt = currentImage.alt;
            imageElement.title = currentImage.title;
            descriptionElement.textContent = currentImage.description;
        }

        function breaktimer(){
            window.open('complete.php<?php echo "?id=$id"; ?>','_self');
        }

        function skipexe(){
            clearInterval(timerInterval);
                    if (isBreakTime) {
                        isBreakTime = false;
                        messageElement.textContent = "";
                        changeImage();
                        showImageAndDescription();
                        remainingTime = 30;
                        startTimer();
                    } else {
                        isBreakTime = true;
                        messageElement.textContent = "TAKE A 30 SEC BREAK";
                        hideImageAndDescription();
                        remainingTime = 30;
                        startTimer();
                    }
        }

        function hideImageAndDescription() {
            imageElement.style.display = "none";
            descriptionElement.style.display = "none";
        }

        function showImageAndDescription() {
            imageElement.style.display = "block";
            descriptionElement.style.display = "block";
        }

        pauseButton.addEventListener("click", function() {
            if (isPaused) {
                isPaused = false;
                pauseButton.textContent = "Pause";
                startTimer();
            } else {
                isPaused = true;
                pauseButton.textContent = "Resume";
                clearInterval(timerInterval);
            }
        });

        startTimer();
        changeImage();
    </script>
</body>

</html>

