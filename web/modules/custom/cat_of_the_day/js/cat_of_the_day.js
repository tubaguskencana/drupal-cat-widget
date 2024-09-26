(function ($, Drupal, once) {
    Drupal.behaviors.catOfTheDayVoting = {
      attach: function (context) {
        // Apply once to the elements in the context.
        $(once('cat-of-the-day', '#vote-up', context)).click(function () {
          var catImage = $('#cat-image').attr('src');
          $.ajax({
            url: '/cat-of-the-day/vote',
            type: 'GET',
            data: { cat_image: catImage, vote_type: 'up' },
            success: function (response) {
              alert('Vote Up! New count: ' + response.votes_up);
            },
            error: function () {
              alert('Error submitting vote.');
            }
          });
        });
  
        $(once('cat-of-the-day', '#vote-down', context)).click(function () {
            var catImage = $('#cat-image').attr('src');
            $.ajax({
                url: '/cat-of-the-day/vote',
                type: 'GET',
                data: { cat_image: catImage, vote_type: 'down' },
                success: function (response) {
                  alert('Vote Down! New count: ' + response.votes_down);
                },
                error: function () {
                  alert('Error submitting vote.');
                }
              });
          });
      }
    };
  })(jQuery, Drupal, once);
  