<!-- @WillFourTwenty -->
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="image/png"
        href="https://cdn.discordapp.com/avatars/568922304898400270/d93e4deee8e2e56a60f85521e1b489bc.png?size=1024" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmNest</title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .container>div {
            width: 40px;
            margin: 5px;
            text-align: center;
        }

        .container img {
            width: 40px;
            height: 40px;
            cursor: pointer;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .player-container {
            display: none;
            background-color: black;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            position: relative;
        }

        .close-button {
            position: absolute;
            color: red;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .player-container button {
            margin: 10px;
            padding: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .lyrics-container {
            text-align: center;
            margin-top: 20px;
            white-space: pre-line; /* Preserve line breaks */ 
            color: white;
        }

        .lyrics-container a {
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
    <div class="container">
        <ul class="header">
            <li class="head1" onclick="window.location.href='index';">HOME</li>
            <li class="head2" onclick="window.location.href='movies';">MOVIES</li>
            <li class="head3" onclick="window.location.href='songs';">SONGS</li>
            <li class="head4" onclick="window.location.href='request';">REQUEST</li>
        </ul>
    </div>

    <div class="container">
        <?php
        // Database connection information
        $host = "localhost";
        $username = "root";
        $password = ""; // Add your database password here
        $database = "filmnest";

        // Create connection
        $conn = new mysqli($host, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to fetch song information from the database
        $sql = "SELECT cover, cover2, linktosong, linktovideo, lyrics FROM songs";
        $result = $conn->query($sql);

        // Display song covers with 140x140 size and spacing in rows
        if ($result->num_rows > 0) {
            $count = 0;
            echo '<div style="width: 100%;">'; // Container with fixed width
            while ($row = $result->fetch_assoc()) {
                if ($count % 10 === 0 && $count !== 0) {
                    echo '</div><div style="width: 100%; clear: both; margin-bottom: 1inch;"></div>'; // Add spacing between rows
                }
                echo '<div style="float: left; margin-right: 1inch;">'; // Add spacing between song covers
                echo '<img src="/assets/covers/' . $row['cover'] . '.jpg" alt="Song Cover" style="width: 140px; height: 140px;" onclick="showPlayer(\'' . $row['linktosong'] . '\', \'' . $row['cover'] . '.jpg\', \'' . $row['cover2'] . '.gif\', \'' . addslashes($row['lyrics']) . '\', \'' . $row['linktovideo'] . '\')">';
                echo '</div>';
                $count++;
            }
            echo '</div>'; // Close the container
        } else {
            echo "0 results";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>

    <div id="playerOverlay" class="overlay">
        <div id="playerContainer" class="player-container">
            <span class="close-button" onclick="closePlayer()">&times;</span> 
            <audio id="audioPlayer" controls style="width: 100%;" hidden></audio>
            <video id="videoPlayer" controls style="width: 100%;" hidden></video>

            <div class="lyrics-container" id="lyricsContainer"></div>

            <button onclick="playSong()">Song</button>
            <button onclick="playVideo()">Video</button>
        </div>
    </div>

    <script>
    var songLink, songCover, songCover2, isAudio = true, lyrics;

    function showPlayer(_0x1c5d9c, _0x3667e8, _0x585370, _0x2a7b5c) {
        songLink = _0x1c5d9c;
        songCover = _0x3667e8;
        songCover2 = _0x585370;
        lyrics = _0x2a7b5c;
        document.getElementById('playerOverlay').style.display = 'flex';
        document.getElementById('playerContainer').style.display = 'block';

        // Display cover photo on the page
        var coverImage = document.getElementById('coverImage');
        coverImage.src = '/assets/animatedcovers/' + songCover;
        coverImage.style.display = 'block';

        displayLyrics();
    }

    function closePlayer() {
        document.getElementById('playerOverlay').style.display = 'none';
        document.getElementById('playerContainer').style.display = 'none';
        document.getElementById('audioPlayer').pause();
        document.getElementById('videoPlayer').pause();

        // Hide cover photo on player close
        document.getElementById('coverImage').style.display = 'none';
    }

    function playSong() {
        isAudio = true;
        document.getElementById('audioPlayer').src = '/assets/songs/' + songLink + '.mp3';
        document.getElementById('audioPlayer').hidden = false;
        document.getElementById('videoPlayer').hidden = true;
        document.getElementById('audioPlayer').play();
        displayLyrics();
    }

    function playVideo() {
        isAudio = false;
        document.getElementById('videoPlayer').src = '/assets/songvideos/' + songLink + '.mp4';
        document.getElementById('audioPlayer').hidden = true;
        document.getElementById('videoPlayer').hidden = false;
        document.getElementById('videoPlayer').play();
        document.getElementById('lyricsContainer').innerText = '';
    }

    function displayLyrics() {
    var lyricsContainer = document.getElementById('lyricsContainer');
    lyricsContainer.innerHTML = '';

    if (lyrics !== null && lyrics !== '') {
        lyrics = lyrics.replace(/<br>/g, '\n'); // Convert <br> to newline
        lyrics = lyrics.replace(/\n/g, '<br>'); // Convert newline to <br>
        lyricsContainer.innerHTML = lyrics;
    } else {
        var noLyricsLink = document.createElement('a');
        noLyricsLink.innerText = 'No lyrics for this song 😟';
        noLyricsLink.href = 'request.php';
        lyricsContainer.appendChild(noLyricsLink);
    }
}


    document.getElementById('audioPlayer').addEventListener('ended', function () {
        if (isAudio) {
            closePlayer();
        }
    });
</script>

</body>

</html>
<!-- @WillFourTwenty -->
