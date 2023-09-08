function loginWithTwitter() {
  // Make an API call to your server
  $.ajax({
    url: 'login_with_twitter.php',
    type: 'GET',
    success: function(response) {
      // Redirect the user to the Twitter authorization page
      window.location.href = response.redirect_url;
    },
    error: function(error) {
      console.log(error);
    }
  });
}