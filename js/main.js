$(document).ready(function () {
  const url_user = "../controllers/UserController.php";
  const url_post = "../controllers/PostController.php";
  const url_sidebar = "../controllers/sidebarController.php";
  const url_admin = "../controllers/AdminController.php";

  $(document).on("click", ".btn_categories", function () {
    const data = {
      action: "category",
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

  $(document).on("click", ".login_btn", function () {
    const container = $(this).closest(".login_container");

    const user = container.find(".input_user").val();
    const pass = container.find(".input_password").val();

    const data = {
      action: "login",
      user: user,
      password: pass,
    };

    console.log(data);

    $.ajax({
      url: url_user,
      type: "POST",
      data: data,
    }).done(async function (data) {
      console.log(data);
      //window.location = "http://localhost/DWP2023/views/feed.php";
      $(".mainBG").empty();
      $(".mainBG").append(data);
      //console.log("logging in.... ", data.view);
    });
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
      console.log($(".mainBG"));
      $(".mainBG").empty();
      $(".mainBG").append(data);
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
      url: url_post,
      type: "POST",
      data: data,
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

  $(document).on("click", ".feed_item", function () {
    const postID = $(this).data("id");

    const data = {
      action: "openPost",
      postID: postID,
    };

    $.ajax({
      url: url_post,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log(data);
      $(".state_col").empty();
      $(".state_col").append(data);
    });
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
      $(".state_col").empty();
      $(".state_col").append(data);
    });
  });
  
  // Admin
  $(document).on("click", ".admin_btn", function () {
    const data = {
      action: "admin",
    };

    $.ajax({
      url: url_sidebar,
      type: "POST",
      data: data,
    }).done(function (data) {
      $(".state_col").empty();
      $(".state_col").append(data);
    });
  });

  $(document).on("click", ".submit_comment", function () {
    const container = $(this).closest(".postComment_Container");
    const comment = container.find(".comment_textArea").val();
    const id = $(this).data("id");

    const data = {
      action: "createComment",
      comment: comment,
      postID: id,
    };

    $.ajax({
      url: url_post,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log(data);
    });
  });

  // log out
  $(document).on("click", ".logout_btn", function () {
    const data = {
      action: "logout",
    };

    $.ajax({
      url: url_user,
      type: "POST",
      data: data,
    }).done(function (data) {
      $(".state_col").empty();
      $(".state_col").append(data);
    });
  });

  $(document).on("click", ".open_profile_event", function (e) {
    e.stopPropagation();
    e.preventDefault();

    const userID = $(this).data("userid");

    const data = {
      action: "fromPost",
      userID: userID
    }

    $.ajax({
      url: url_user,
      type: "POST",
      data: data,
    }).done(function (data) {
      $(".state_col").empty();
      $(".state_col").append(data);
    });

    // alert("cliked on user profile: " + userID);
  });

    $(document).on("click", ".updateUserBtn", function () {
    const container = $(this).closest(".updateUserContainer");

    const user = container.find(".selectedUserToUpdate").val();
    const userBan = container.find(".selectedUserBanStatus").is(':checked');
    const userNewEmail = container.find(".newEmail").val();
    const userNewPassword = container.find(".newPassword").val();

    const data = {
      action: "updateUser",
      user: user,
      userBan: userBan,
      userNewEmail: userNewEmail,
      userNewPassword: userNewPassword
    };

    $.ajax({
      url: url_admin,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log(data);
    });
  });
});
