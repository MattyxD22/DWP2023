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

  $(document).on("click", ".createPost_btn", function () {
    const data = {
      action: "newPost",
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
        categories.push($(this).data("id"));
      }
    });

    const data = {
      action: "createPost",
      title: title,
      description: description,
      categories: categories,
    };

    formData.append("action", "createPost");
    formData.append("title", title);
    formData.append("description", description);
    formData.append("categories", categories);

    const input = document.getElementById("file_input");

    $(input.files).each(function () {
      // console.log($(this)[0]);
      formData.append("file", $(this)[0], $(this)[0].name);
    });

    console.log(formData);

    $.ajax({
      url: url_post,
      data: formData,
      dataType: "JSON",
      type: "POST",
      contentType: false, // NEEDED, DON'T OMIT THIS
      processData: false, // NEEDED, DON'T OMIT THIS
    }).done(function (data) {
      console.log(data);
    });

    // $.ajax({
    //   url: url_post,
    //   type: "POST",
    //   data: data,
    // }).done(function (data) {
    //   console.log(data);
    // });
  });

  $(document).on("click", ".mainBG", function (e) {
    if (!$(e.target).closest(".categoryDropdownContainer")) {
      alert("!");
      $(".categoryContainer").removeClass("open");
    }
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
      $(".state_col").empty();
      $(".state_col").append(data);
    });
  });

  $(document).on("click", ".category_item", function () {
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
      $(".state_col").empty();
      $(".state_col").append(data);
    });
  });

  $(document).on("click", ".profile_item", function () {
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

  $(document).on("click", ".reply_comment_container", function () {
    $(this).toggleClass("open");
  });

  $(document).on("click", ".reply_to_comment_container", function (e) {
    e.stopPropagation();
    e.preventDefault();
  });

  $(document).on("click", ".close_popup", function (e) {
    e.stopPropagation();
    e.preventDefault();

    $(this).closest(".reply_comment_container").removeClass("open");
  });

  $(document).on("click", ".submit_reply", function () {
    const container = $(this).closest(".reply_to_comment_container");

    let reply = container.find(".std_input").val();
    let commentID = $(this).data("id");

    const data = {
      action: "createComment",
      comment: reply,
      postID: commentID,
    };

    $.ajax({
      url: url_post,
      type: "POST",
      data: data,
    }).done(function (data) {
      container.find(".std_input").val("");
      container.closest(".reply_comment_container").removeClass("open");
    });
  });

  $(document).on("click", ".like_post", function (e) {
    e.stopPropagation();
    e.preventDefault();

    let elem = $(this); // put the event element into a variable, to be able to access it in the ajax request
    let action = "addLike";
    let postID = $(this).data("id");

    // Check if the post has been liked by the user
    if ($(elem).hasClass("liked")) {
      action = "removeLike";
    }

    const data = {
      action: action,
      postID: postID,
    };

    $.ajax({
      url: url_user,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log(data);
      if ($(elem).hasClass("liked")) {
        // prepare data obj for removinf the like
        // remove "like" class so icon wont be red
        $(elem).removeClass("like");
      } else {
        // add "like" class to icon will be red
        $(elem).addClass("like");
      }
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

  $(document).on("click", ".followUnfollowBtn", function (e) {
    e.stopPropagation();
    e.preventDefault();

    const userID = $(this).data("userid");

    const data = {
      action: "followUser",
      userID: userID
    }

    $.ajax({
      url: url_user,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log(data);
    });
  });

  $(document).on("click", ".reply_comment_container", function () {
    $(this).toggleClass("open");
  });

  $(document).on("click", ".reply_to_comment_container", function (e) {
    e.stopPropagation();
    e.preventDefault();
  });

  $(document).on("click", ".close_popup", function (e) {
    e.stopPropagation();
    e.preventDefault();

    $(this).closest(".reply_comment_container").removeClass("open");
  });

  $(document).on("click", ".submit_reply", function () {
    const container = $(this).closest(".reply_to_comment_container");

    let reply = container.find(".std_input").val();
    let commentID = $(this).data("id");

    const data = {
      action: "createComment",
      comment: reply,
      postID: commentID,
    };

    $.ajax({
      url: url_post,
      type: "POST",
      data: data,
    }).done(function (data) {
      container.find(".std_input").val("");
      container.closest(".reply_comment_container").removeClass("open");
    });
  });

  $(document).on("click", ".like_post", function (e) {
    e.stopPropagation();
    e.preventDefault();

    let elem = $(this); // put the event element into a variable, to be able to access it in the ajax request
    let action = "addLike";
    let postID = $(this).data("id");

    // Check if the post has been liked by the user
    if ($(elem).hasClass("liked")) {
      action = "removeLike";
    }

    const data = {
      action: action,
      postID: postID,
    };

    console.log(data);

    $.ajax({
      url: url_post,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log(data);

      // // Check if the post has been liked by the user
      // if ($(elem).hasClass("liked")) {
      //   // prepare data obj for removinf the like
      //   // remove "like" class so icon wont be red
      //   $(elem).removeClass("like");
      // } else {
      //   // add "like" class to icon will be red
      //   $(elem).addClass("like");
      // }
    });
  });
  $(document).on("click", ".dislike_post", function (e) {
    e.stopPropagation();
    e.preventDefault();

    let elem = $(this); // put the event element into a variable, to be able to access it in the ajax request
    let action = "addDislike";
    let postID = $(this).data("id");

    // Check if the post has been liked by the user
    if ($(elem).hasClass("liked")) {
      action = "removeLike";
    }

    const data = {
      action: action,
      postID: postID,
    };

    console.log(data);

    $.ajax({
      url: url_post,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log(data);

      // // Check if the post has been liked by the user
      // if ($(elem).hasClass("liked")) {
      //   // prepare data obj for removinf the like
      //   // remove "like" class so icon wont be red
      //   $(elem).removeClass("like");
      // } else {
      //   // add "like" class to icon will be red
      //   $(elem).addClass("like");
      // }
    });
  });

  $(document).on("click", ".tab_elem", function () {
    const type = $(this).data("type");
    const container = $(this).closest(".profile_page");
    $(this).siblings().removeClass("selected");
    $(this).addClass("selected");
    container.find(".profile_content").removeClass("selected");
    container
      .find('.profile_content[data-type="' + type + '"]')
      .addClass("selected");
  });
});
