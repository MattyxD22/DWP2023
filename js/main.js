$(document).ready(function () {
  const url_user = "../controllers/UserController.php";
  const url_post = "../controllers/PostController.php";
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

  $(document).on("click", ".categoryRow", function (e) {
    e.stopPropagation();
    e.preventDefault();

    const checkbox = $(this).find(".categoryCheckbox");

    if ($(checkbox).prop("checked") == true) {
      $(checkbox).prop("checked", false);
    } else {
      $(checkbox).prop("checked", true);
    }
  });

  $(document).on("click", ".header_title_row", function () {
    const data = {
      action: "homepage",
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

  $(document).on("click", ".createNewPost_btn", function () {
    const container = $(this).closest(".newPost_container");

    const title = container.find(".newPost_Title").val();
    const description = container.find(".newPost_Textarea").val();
    let categories = [];

    let formData = new FormData();

    let images = [];

    container.find(".categoryRow").each(function () {
      if ($(this).find(".categoryCheckbox").prop("checked") == true) {
        categories.push({ categoryID: $(this).data("id") });
      }
    });

    const data = {
      action: "createPost",
      title: title,
      description: description,
      categories: categories,
    };

    // formData.append("data", data);

    // const input = document.getElementById("file_input");

    // $(input.files).each(function () {
    //   console.log($(this)[0]);
    //   formData.append("file", $(this)[0], $(this)[0].name);
    // });

    // console.log(formData);

    // $.ajax({
    //   url: "url_post",
    //   data: formData,
    //   type: "POST",
    //   contentType: false, // NEEDED, DON'T OMIT THIS
    //   processData: false, // NEEDED, DON'T OMIT THIS
    // }).done(function (data) {
    //   console.log(data);
    // });

    $.ajax({
      url: "url_post",
      data: data,
      type: "POST",
    }).done(function (data) {
      console.log(data);
    });
  });

  $(document).on("click", ".categoryContainer", function () {
    if ($(this).hasClass("open")) {
      $(this).removeClass("open");
    } else {
      $(this).addClass("open");
    }
  });

  // Profile
    $(document).on("click", ".profile_btn", function () {
    const data = {
      action: "profile",
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

  document.addEventListener("DOMContentLoaded", function() {
    fetch("controllers/UserController.php?action=fetchFollowers", {
        method: "GET"
    })
    .then(response => response.text())
    .then(data => {
      console.log("123");
        document.getElementById("followerCount").innerText = data;
    })
    .catch(error => console.error('There was an error:', error));
});

});
