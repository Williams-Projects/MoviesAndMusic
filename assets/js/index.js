// Add this script to your existing JavaScript file or create a new one

document.getElementById("searchButton").addEventListener("click", openSearchMenu);

function openSearchMenu() {
  document.getElementById("searchMenu").style.display = "block";
}

function closeSearchMenu() {
  document.getElementById("searchMenu").style.display = "none";
}

function Search() {
  var searchInput = document.querySelector('.search-menu input').value;

  // Perform an AJAX request or any suitable method to check if the movie exists
  // If the movie exists, open a popup with the movie details
  // You may replace the below line with your own logic to check movie existence

  // For demonstration purposes, assume the movie exists
  var movieExists = true;

  if (movieExists) {
    // Open a popup with the movie details
    openMoviePopup(searchInput);
  } else {
    // If the movie doesn't exist, you can handle it accordingly (e.g., show an error message)
    alert('Movie not found.');
  }
}

function openMoviePopup(movieTitle) {
  // Here, you can customize the behavior to show a popup with the movie details
  // You may use a modal, lightbox, or any other method to display the movie information
  // For now, let's just open the movie.php page with the selected movie title as a parameter
  window.location.href = 'movies.php?title=' + encodeURIComponent(movieTitle);
}
