$(document).ready(function () {
  const url_user = "../controllers/UserController.php";
  const url_sidebar = "../controllers/sidebarController.php";

  $(document).on("click", ".feed_item", function () {
    let id = $(this).data("id");
    console.log("Opening post withID: ", id);
  });

  $(document).on("click", ".bi-hand-thumbs-up-fill", function (e) {
    e.stopPropagation();
    e.preventDefault();
    let id = $(this).data("id");
    console.log("liked post with ID: ", id);
  });

  $(document).on("click", ".bi-hand-thumbs-down-fill", function (e) {
    e.stopPropagation();
    e.preventDefault();
    let id = $(this).data("id");
    console.log("disliked post with ID: ", id);
  });

  $(document).on("click", ".logout_btn", function () {
    let userID = 1;

    const data = {
      action: "logout",
      userID: userID,
    };

    $.ajax({
      url: url_user,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log("request sent and data returned", data);
    });
  });

  $(document).on("click", ".createPost_btn", function () {
    const data = {
      action: "newPost",
    };

    $.ajax({
      url: url_sidebar,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log($(".state_col"));
      $(".state_col").empty();
      $(".state_col").append(data);
    });
  });

  $(document).on("click", ".row_category", function () {
    const checkbox = $(this).find(".category_checkbox");

    if ($(checkbox).prop("checked") == true) {
      $(checkbox).prop("checked", false);
    } else {
      $(checkbox).prop("checked", true);
    }
  });


  $(document).on('click','.header_title_row', function() {
    
      const data = {
        action: 'homepage'
      }

      
    $.ajax({
      url: url_sidebar,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log($(".state_col"));
      $(".state_col").empty();
      $(".state_col").append(data);
    });

  })

  $(document).on("click", ".createNewPost_btn", function () {
    const container = $(this).closest(".newPost_container");

    const title = container.find(".title_input").val();
  });
});
