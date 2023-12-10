  <!-- @WillFourTwenty -->
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <link rel="shortcut icon" type="image/png" href="https://cdn.discordapp.com/avatars/568922304898400270/d93e4deee8e2e56a60f85521e1b489bc.png?size=1024"/>
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

          .container > div {
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

              // SQL query to fetch movie information from the database
              $sql = "SELECT moviepic, title, mainlink, server1, server2, server3 FROM movies";
              $result = $conn->query($sql);

              // Display movie covers with 120x120 size and spacing in rows of 10
  if ($result->num_rows > 0) {
    $count = 0;
    echo '<div style="width: 100%;">'; // Container with fixed width
    while($row = $result->fetch_assoc()) {
        if ($count % 1000000000000000000000000 === 0 && $count !== 0) {
            echo '</div><div style="width: 100%; clear: both; margin-bottom: 1inch;"></div>'; // Add spacing between rows
        }
        echo '<div style="float: left; margin-right: 1inch;">'; // Add spacing between movie covers
        echo '<img src="/assets/moviepics/' . $row['moviepic'] . '" alt="Movie Cover" style="width: 140px; height: 140px;" onclick="showPlayer(\'' . $row['mainlink'] . '\', \'' . $row['server1'] . '\', \'' . $row['server2'] . '\', \'' . $row['server3'] . '\')">';
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
              <iframe id="movieIframe" width="100%" height="360" frameborder="0" allowfullscreen></iframe>
              <button id="server1Button" onclick="updateIframe(server1Link)">Server 1</button>
              <button id="server2Button" onclick="updateIframe(server2Link)">Server 2</button>
              <button id="server3Button" onclick="updateIframe(server3Link)">Server 3</button>
          </div>
      </div>
  
      <script> 
         function _0x5251(){var _0x5ee875=['2305jelHFC','3792512ggjxzC','3340000lDvCNz','flex','src','1326xbjWMW','none','getElementById','playerContainer','222910oGeTHI','block','style','playerOverlay','1830960PYrEoQ','7evkfWA','21381GAZuCX','1574476IaFzbb','display','movieIframe','50vcYmxo'];_0x5251=function(){return _0x5ee875;};return _0x5251();}(function(_0x460d92,_0x3c5d25){var _0x525743=_0x5110,_0x3e34c2=_0x460d92();while(!![]){try{var _0x14edbc=parseInt(_0x525743(0x1f4))/0x1+-parseInt(_0x525743(0x1fe))/0x2*(-parseInt(_0x525743(0x1fa))/0x3)+-parseInt(_0x525743(0x1fb))/0x4+-parseInt(_0x525743(0x1eb))/0x5*(parseInt(_0x525743(0x1f0))/0x6)+parseInt(_0x525743(0x1f9))/0x7*(parseInt(_0x525743(0x1ec))/0x8)+parseInt(_0x525743(0x1f8))/0x9+-parseInt(_0x525743(0x1ed))/0xa;if(_0x14edbc===_0x3c5d25)break;else _0x3e34c2['push'](_0x3e34c2['shift']());}catch(_0x22f64d){_0x3e34c2['push'](_0x3e34c2['shift']());}}}(_0x5251,0x3cd01));var server1Link,server2Link,server3Link;function showPlayer(_0x1c5d9c,_0x3667e8,_0x32373d,_0x585370){var _0x49dd20=_0x5110;document[_0x49dd20(0x1f2)](_0x49dd20(0x1fd))[_0x49dd20(0x1ef)]=_0x1c5d9c,server1Link=_0x3667e8,server2Link=_0x32373d,server3Link=_0x585370,document[_0x49dd20(0x1f2)](_0x49dd20(0x1f7))[_0x49dd20(0x1f6)][_0x49dd20(0x1fc)]=_0x49dd20(0x1ee),document['getElementById'](_0x49dd20(0x1f3))[_0x49dd20(0x1f6)]['display']=_0x49dd20(0x1f5);}function closePlayer(){var _0x19e238=_0x5110;document[_0x19e238(0x1f2)](_0x19e238(0x1f7))[_0x19e238(0x1f6)][_0x19e238(0x1fc)]=_0x19e238(0x1f1),document[_0x19e238(0x1f2)](_0x19e238(0x1f3))[_0x19e238(0x1f6)][_0x19e238(0x1fc)]='none';}function _0x5110(_0x39a6a8,_0x16e6b0){var _0x525114=_0x5251();return _0x5110=function(_0x5110fa,_0x2871a3){_0x5110fa=_0x5110fa-0x1eb;var _0x59a844=_0x525114[_0x5110fa];return _0x59a844;},_0x5110(_0x39a6a8,_0x16e6b0);}function updateIframe(_0x4307c4){var _0x40795b=_0x5110;document[_0x40795b(0x1f2)](_0x40795b(0x1fd))['src']=_0x4307c4;}
      </script>
  </body>
  </html>
  <!-- @WillFourTwenty -->