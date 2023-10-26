$(document).ready(function () {
  let url_user = "http://localhost/DWP2023/contronllers/UserController.php";

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
      // Do what you want in case of success
    });
  });
});
