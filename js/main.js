$(document).ready(function () {
  var quillEditor;
  var quillEditor2;
  var quillEditor_createPost;
  var quillEditor_editPost;
  var quillEditor_reply;

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

  $(document).on("click", ".btn_aboutUs", function () {
    const data = {
      action: "aboutUs",
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

      let comment_container = document.getElementsByClassName("createPost_RTE");
      //let comment_container = $(".state_col").find(".RTE_comment");
      //console.log("createPost_RTE");

      const toolbarOptions = [
        ["bold", "italic", "underline", "strike"], // toggled buttons
        ["blockquote", "code-block"],

        [{ header: 1 }, { header: 2 }], // custom button values
        [{ list: "ordered" }, { list: "bullet" }],
        [{ script: "sub" }, { script: "super" }], // superscript/subscript
        [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
        [{ direction: "rtl" }], // text direction

        [{ size: ["small", false, "large", "huge"] }], // custom dropdown
        [{ header: [1, 2, 3, 4, 5, 6, false] }],

        [{ color: [] }, { background: [] }], // dropdown with defaults from theme
        [{ font: [] }],
        [{ align: [] }],

        ["clean"], // remove formatting button
      ];

      //console.log("RTE_comment");

      quillEditor_createPost = new Quill(".createPost_RTE", {
        modules: {
          toolbar: toolbarOptions,
        },
        placeholder: "Give your post a Description",
        theme: "snow",
      });
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

  $(document).on("input", ".newPost_Title", function () {
    if ($(this).val != "" && $(this).val() != null) {
      $(this).css({ border: "1px solid transparent" });
    } else {
      $(this).css({ border: "1px solid #DC2626" });
    }
  });

  $(document).on("input", ".edit_post_title", function () {
    if ($(this).val != "" && $(this).val() != null) {
      $(this).css({ border: "1px solid transparent" });
    } else {
      $(this).css({ border: "1px solid #DC2626" });
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

    if (title != "" && title != null) {
      const description = quillEditor_createPost.root.innerHTML;
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

      const input = document.getElementById("file_input");

      $(input.files).each(function (index, value) {
        // console.log($(this)[0]);
        //console.log($(input.files));
        //console.log($(this)[0], $(this)[0].name);

        formData.append("file" + index, $(this)[0], $(this)[0].name);
      });

      formData.append("action", "createPost");
      formData.append("title", title);
      formData.append("description", description);
      formData.append("categories", categories);
      //console.log(formData);

      $.ajax({
        url: url_post,
        data: formData,
        //dataType: "JSON",
        type: "POST",
        contentType: false, // NEEDED, DON'T OMIT THIS
        processData: false, // NEEDED, DON'T OMIT THIS
      }).done(function (data) {
        if (data == "Filesize too big") {
          alert(
            "The filesize for one or more of the files are too big, keep it below 2mb"
          );
        } else if (data == "filetype is not allowed") {
          alert(
            "The filetype of one or more of your files that you have selected is not allowed"
          );
        } else {
          alert("Post created successfully");
        }

        //alert("Post Created successfully");
        //console.log(data);
      });
    } else {
      alert("Please give your post a title");
      container.find(".newPost_Title").css({ border: "1px solid #DC2626" });
    }
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

      let comment_container = document.getElementsByClassName("RTE_comment");
      //let comment_container = $(".state_col").find(".RTE_comment");
      console.log("RTE_comment");

      const toolbarOptions = [
        ["bold", "italic", "underline", "strike"], // toggled buttons
        ["blockquote", "code-block"],

        [{ header: 1 }, { header: 2 }], // custom button values
        [{ list: "ordered" }, { list: "bullet" }],
        [{ script: "sub" }, { script: "super" }], // superscript/subscript
        [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
        [{ direction: "rtl" }], // text direction

        [{ size: ["small", false, "large", "huge"] }], // custom dropdown
        [{ header: [1, 2, 3, 4, 5, 6, false] }],

        [{ color: [] }, { background: [] }], // dropdown with defaults from theme
        [{ font: [] }],
        [{ align: [] }],

        ["clean"], // remove formatting button
      ];

      console.log("RTE_comment");

      quillEditor = new Quill(".RTE_comment", {
        modules: {
          toolbar: toolbarOptions,
        },
        placeholder: "Write a comment...",
        theme: "snow",
      });
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

      let comment_container = document.getElementsByClassName("RTE_comment");
      //let comment_container = $(".state_col").find(".RTE_comment");
      console.log("RTE_comment");

      const toolbarOptions = [
        ["bold", "italic", "underline", "strike"], // toggled buttons
        ["blockquote", "code-block"],

        [{ header: 1 }, { header: 2 }], // custom button values
        [{ list: "ordered" }, { list: "bullet" }],
        [{ script: "sub" }, { script: "super" }], // superscript/subscript
        [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
        [{ direction: "rtl" }], // text direction

        [{ size: ["small", false, "large", "huge"] }], // custom dropdown
        [{ header: [1, 2, 3, 4, 5, 6, false] }],

        [{ color: [] }, { background: [] }], // dropdown with defaults from theme
        [{ font: [] }],
        [{ align: [] }],

        ["clean"], // remove formatting button
      ];

      console.log("RTE_comment");

      quillEditor = new Quill(".RTE_comment", {
        modules: {
          toolbar: toolbarOptions,
        },
        placeholder: "Write a comment...",
        theme: "snow",
      });
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

      const toolbarOptions = [
        ["bold", "italic", "underline", "strike"], // toggled buttons
        ["blockquote", "code-block"],

        [{ header: 1 }, { header: 2 }], // custom button values
        [{ list: "ordered" }, { list: "bullet" }],
        [{ script: "sub" }, { script: "super" }], // superscript/subscript
        [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
        [{ direction: "rtl" }], // text direction

        [{ size: ["small", false, "large", "huge"] }], // custom dropdown
        [{ header: [1, 2, 3, 4, 5, 6, false] }],

        [{ color: [] }, { background: [] }], // dropdown with defaults from theme
        [{ font: [] }],
        [{ align: [] }],

        ["clean"], // remove formatting button
      ];

      quillEditor2 = new Quill(".updateSiteDescription", {
        modules: {
          toolbar: toolbarOptions,
        },
        placeholder: "Write a comment...",
        theme: "snow",
      });
    });
  });

  $(document).on("click", ".submit_comment", function () {
    const post_container = $(this).closest(".post_Container");
    const comment = quillEditor.root.innerHTML;

    if (comment != "<p><br></p>") {
      const id = $(this).data("id");
      const orgID = 0; // only needed when creating replies, not inital comments

      const data = {
        action: "createComment",
        comment: comment,
        postID: id,
        orgID: orgID,
      };

      console.log(data);

      $.ajax({
        url: url_post,
        type: "POST",
        data: data,
      }).done(function (data) {
        //Clearing comments after successful comment creation
        post_container.find(".comment_section").remove();
        post_container.append(data);
      });
    } else {
      alert("Please write a comment");
    }
  });

  //Save site description
  $(document).on("click", ".saveSiteDescription", function () {
    const description = quillEditor2.root.innerHTML;

    const data = {
      action: "updateDescription",
      description: description,
    };

    $.ajax({
      url: url_admin,
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

    if ($(this).hasClass("open")) {
      const toolbarOptions = [
        ["bold", "italic", "underline", "strike"], // toggled buttons
        ["blockquote", "code-block"],

        [{ header: 1 }, { header: 2 }], // custom button values
        [{ list: "ordered" }, { list: "bullet" }],
        [{ script: "sub" }, { script: "super" }], // superscript/subscript
        [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
        [{ direction: "rtl" }], // text direction

        [{ size: ["small", false, "large", "huge"] }], // custom dropdown
        [{ header: [1, 2, 3, 4, 5, 6, false] }],

        [{ color: [] }, { background: [] }], // dropdown with defaults from theme
        [{ font: [] }],
        [{ align: [] }],

        ["clean"], // remove formatting button
      ];

      // use javascript instead of jquery to find the child element that should be converted to RTE
      const editor = this.querySelector(".reply_rte");

      quillEditor_reply = new Quill(editor, {
        modules: {
          toolbar: toolbarOptions,
        },
        placeholder: "Write a Comment..",
        theme: "snow",
      });
    } else {
      $(this).find(".ql-toolbar").remove();
    }
  });

  $(document).on("click", ".reply_to_comment_container", function (e) {
    e.stopPropagation();
    e.preventDefault();
  });

  $(document).on("click", ".close_popup", function (e) {
    e.stopPropagation();
    e.preventDefault();

    $(this).closest(".reply_to_comment_container").find(".ql-toolbar").remove();

    $(this).closest(".reply_comment_container").removeClass("open");
  });

  $(document).on("click", ".submit_reply", function () {
    const post_container = $(this).closest(".post_Container");
    const container = $(this).closest(".reply_to_comment_container");

    let reply = quillEditor_reply.root.innerHTML;

    if (reply != "<p><br></p>") {
      let commentID = $(this).data("id");
      let orgID = $(this).data("orgid") || 0; // Original post ID - cant remember what it does

      const data = {
        action: "createComment",
        comment: reply,
        postID: commentID,
        orgID: orgID,
      };

      $.ajax({
        url: url_post,
        type: "POST",
        data: data,
      }).done(function (data) {
        //Clearing comments after successful comment creation
        post_container.find(".comment_section").remove();
        post_container.append(data);
        //container.find(".std_input").val("");
        //container.closest(".reply_comment_container").removeClass("open");
      });
    } else {
      alert("Please write a comment before submitting");
    }
  });

  $(document).on("click", ".open_profile_event", function (e) {
    e.stopPropagation();
    e.preventDefault();

    const userID = $(this).data("userid");

    const data = {
      action: "fromPost",
      userID: userID,
    };

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

  $(document).on("click", ".user-card", function (e) {
    e.stopPropagation();
    e.preventDefault();

    const userID = $(this).data("userid");

    const data = {
      action: "fromPost",
      userID: userID,
    };

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
    let userBan = 0;

    if(container.find(".selectedUserBanStatus").prop('checked') == true){
      userBan = 1;
    }

    const userNewEmail = container.find(".newEmail").val();
    const userNewPassword = container.find(".newPassword").val();

    const input = document.getElementById("newProfileImage");

    const file = input.files[0];

    let formData = new FormData();

    formData.append("action", "updateUser");
    if (file) {
      formData.append("file", file, file.name);
    }
    formData.append("user", user ? user : '');
    formData.append("userBan", userBan);
    formData.append("userNewEmail", userNewEmail ? userNewEmail : '');
    formData.append("userNewPassword", userNewPassword ? userNewPassword : '');

    /* const data = {
      action: "updateUser",
      user: user,
      userBan: userBan,
      userNewEmail: userNewEmail,
      userNewPassword: userNewPassword,
      userNewImage: userNewImage
    }; */

    $.ajax({
      url: url_admin,
      data: formData,
      dataType: "JSON",
      type: "POST",
      contentType: false, // NEEDED, DON'T OMIT THIS
      processData: false, // NEEDED, DON'T OMIT THIS
    }).done(function (data) {
      console.log(data);
    });
  });

  $(document).on("click", ".updateContactBtn", function () {
    const container = $(this).closest(".updateContact");

    const fName = container.find(".contactInfoFirstName").val();
    const lName = container.find(".contactInfoLastName").val();
    const email = container.find(".contactInfoEmail").val();
    const phoneNumber = container.find(".contactInfoPhoneNumber").val();
    const city = container.find(".contactInfoCity").val();
    const houseNumber = container.find(".contactInfoHouseNumber").val();
    const streetName = container.find(".contactInfoStreetName").val();

    const data = {
      action: "updateContact",
      fName: fName,
      lName: lName,
      email: email,
      phoneNumber: phoneNumber,
      city: city,
      houseNumber: houseNumber,
      streetName: streetName,
    };

    $.ajax({
      url: url_admin,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log(data);
    });
  });

  //Follow/unfollow
  $(document).on("click", ".followUnfollowBtn", function (e) {
    e.stopPropagation();
    e.preventDefault();

    const userID = $(this).data("userid");

    const data = {
      action: "followUser",
      userID: userID,
    };

    $.ajax({
      url: url_user,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log(data);
    });
  });

  //Block/unblock
  $(document).on("click", ".blockUnblockButton", function (e) {
    e.stopPropagation();
    e.preventDefault();

    const userID = $(this).data("userid");

    const data = {
      action: "blockUser",
      userID: userID,
    };

    $.ajax({
      url: url_user,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log(data);
    });
  });

  $(document).on("click", ".close_popup", function (e) {
    e.stopPropagation();
    e.preventDefault();
  });

  // $(document).on("click", ".submit_reply", function () {
  //   const container = $(this).closest(".reply_to_comment_container");

  //   let reply = container.find(".std_input").val();
  //   let commentID = $(this).data("id");

  //   const data = {
  //     action: "createComment",
  //     comment: reply,
  //     postID: commentID,
  //   };

  //   $.ajax({
  //     url: url_post,
  //     type: "POST",
  //     data: data,
  //   }).done(function (data) {
  //     container.find(".std_input").val("");
  //     container.closest(".reply_comment_container").removeClass("open");
  //   });
  // });

  //Repost button
  $(document).on("click", ".repost_post", function (e) {
    e.stopPropagation();
    e.preventDefault();

    let elem = $(this);
    let postID = $(this).data("id");

    const data = {
      action: "repost",
      postID: postID,
    };

    $.ajax({
      url: url_post,
      type: "POST",
      data: data,
    }).done(function (data) {
      console.log(data);
    });
  });

  $(document).on("click", ".like_post", function (e) {
    e.stopPropagation();
    e.preventDefault();

    let elem = $(this); // put the event element into a variable, to be able to access it in the ajax request
    let container = elem.closest(".post_actions");
    let amount = container.find(".likes_amount").data("amount");
    console.log(amount);
    let action = "addLike";
    let postID = $(this).data("id");

    console.log(container);
    console.log(container.find(".action_like"));

    // Check if the post has been liked by the user
    if (container.find(".action_like").hasClass("like")) {
      action = "removeLike";
    }

    const data = {
      action: action,
      postID: postID,
    };

    console.log("!", data);

    $.ajax({
      url: url_post,
      type: "POST",
      data: data,
    }).done(function (data) {
      if ($(container).find(".action_like").hasClass("like")) {
        container.find(".action_like").removeClass("like");
        amount--;
        container.find(".likes_amount").html(amount);
      } else {
        container.find(".action_like").addClass("like");
        amount++;
        container.find(".likes_amount").html(amount);

        if ($(container).find(".action_dislike").hasClass("dislike")) {
          container.find(".action_dislike").removeClass("dislike");
          const dislikeAmount =
            container.find(".dislikes_amount").data("amount") - 1;

          container.find(".dislikes_amount").html(dislikeAmount);
          container.find(".dislikes_amount").data("amount", dislikeAmount);
        }
      }
      container.find(".likes_amount").data("amount", amount);
    });
  });

  $(document).on("click", ".dislike_post", function (e) {
    e.stopPropagation();
    e.preventDefault();

    let elem = $(this); // put the event element into a variable, to be able to access it in the ajax request
    let container = elem.closest(".post_actions");
    let amount = parseInt(container.find(".dislikes_amount").html());
    let action = "addDislike";
    let postID = $(this).data("id");

    // Check if the post has been liked by the user
    if ($(container).find(".action_dislike").hasClass("dislike")) {
      action = "removeLike";
    }

    const data = {
      action: action,
      postID: postID,
    };

    console.log("!", data);

    $.ajax({
      url: url_post,
      type: "POST",
      data: data,
    }).done(function (data) {
      if ($(container).find(".action_dislike").hasClass("dislike")) {
        container.find(".action_dislike").removeClass("dislike");
        amount--;
        container.find(".dislikes_amount").html(amount);
      } else {
        container.find(".action_dislike").addClass("dislike");
        amount++;
        container.find(".dislikes_amount").html(amount);

        if ($(container).find(".action_like").hasClass("like")) {
          container.find(".action_like").removeClass("like");
          const likeAmount = container.find(".likes_amount").data("amount") - 1;

          container.find(".likes_amount").html(likeAmount);
          container.find(".likes_amount").data("amount", likeAmount);
        }
      }
      container.find(".dislikes_amount").data("amount", amount);
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

  $(document).on("click", ".post_image_container", function () {});

  $(document).on("click", ".btn_rules", function () {
    const data = {
      action: "rules",
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

  $(document).on("click", ".delete_rule", function () {
    const row = $(this).closest(".rules_row");
    const id = $(this).data("rule");

    const data = {
      action: "removeRule",
      ruleID: id,
    };

    $.ajax({
      url: url_admin,
      type: "POST",
      data: data,
    }).done(function (data) {
      // Remove after request is completed successfully
      row.remove();
    });
  });

  $(document).on("click", ".update_rule", function () {
    const row = $(this).closest(".rules_row");
    const id = $(this).data("rule");
    const ruleText = row.find(".std_input").val();

    const data = {
      action: "updateRule",
      ruleID: id,
      ruleText: ruleText,
    };

    $.ajax({
      url: url_admin,
      type: "POST",
      data: data,
    }).done(function (data) {});
  });

  $(document).on("click", ".get_new_rule", function () {
    const container = $(this).closest(".rules_MainContainer");

    const data = {
      action: "getNewRule",
    };

    $.ajax({
      url: url_admin,
      type: "POST",
      data: data,
    }).done(function (data) {
      container.find(".rules_col").append(data);
      //Scroll to bottom after rule insert
      container
        .find(".rules_ScrollContainer")
        .scrollTop(container.find(".rules_ScrollContainer")[0].scrollHeight);
    });
  });

  $(document).on("click", ".add_rule", function () {
    const rules_container = $(this).closest(".rules_col");
    const container = $(this).closest(".rules_row");
    const ruleText = container.find(".std_input").val();

    const data = {
      action: "addNewRule",
      rule: ruleText,
    };

    $.ajax({
      url: url_admin,
      type: "POST",
      data: data,
    }).done(function (data) {
      $('.profile_content[data-type="2"]').empty();
      $('.profile_content[data-type="2"]').append(data);
    });
  });

  /**
   * Open a dialog if the user has clicked on the picture
   */
  $(document).on("click", ".feed_image_container", function (e) {
    e.stopPropagation();
    e.preventDefault();
    const container = this;
    console.log(container);

    let dialog = container.querySelector("dialog");
    $(dialog).addClass("showing");
    dialog.showModal();
  });

  /**
   * Close the dialog when clicked on the backdrop
   * If the user has clicked inside the container, dont close it
   */
  $(document).on("click", ".imgDialog", function (e) {
    e.stopPropagation();
    e.preventDefault();

    // Get the clicked element from the event-target
    const clickElem = e.target;

    // check if the clicked element is the dialog element itself
    if ($(clickElem).hasClass("imgDialog")) {
      // if true, close the dialog

      let dialog = document.querySelector("dialog");
      $(dialog).removeClass("showing");
      dialog.close();
    }
  });

  $(document).on("click", ".direction_scroll", function () {
    const direction = $(this).data("direction");
    const container = $(this).closest(".dialogContainer");
    let currentImgID = container.find(".modalImg.active").data("img");
    const images = container.find(".modalImg").length;
    //alert(images);

    switch (direction) {
      case "back":
        if (currentImgID > 1) {
          currentImgID--;
          container.find(".modalImg").removeClass("active");
          container
            .find(".modalImg[data-img=" + currentImgID + "]")
            .addClass("active");
        }
        break;

      case "forward":
        if (currentImgID < images) {
          currentImgID++;
          container.find(".modalImg").removeClass("active");
          container
            .find(".modalImg[data-img=" + currentImgID + "]")
            .addClass("active");
        }

        break;
    }

    container.find(".imgIndicator").removeClass("active");
    container
      .find('.imgIndicator[data-img="' + currentImgID + '"]')
      .addClass("active");
  });

  // $(document).on("click", ".edit_post_container", function () {
  //   $(this).toggleClass("open");
  // });

  $(document).on("click", ".edit_post", function () {
    $(this).toggleClass("active");

    const container = $(this).closest(".post_Container");

    //Unhide inputs when editing post if "Edit Post" was clicked and it has the class "active"
    if ($(this).hasClass("active")) {
      container.find(".post_title_span").addClass("hide");
      container.find(".post_description_span").addClass("hide");
      container.find(".post_comments_container").addClass("hide");
      container.find(".post_image_container").addClass("hide");

      container.find(".edit_post_title").removeClass("hide");
      container.find(".edit_post_rte").removeClass("hide");
      container.find(".btn_update_post").removeClass("hide");

      let comment_container = document.getElementsByClassName("edit_post_rte");

      const toolbarOptions = [
        ["bold", "italic", "underline", "strike"], // toggled buttons
        ["blockquote", "code-block"],

        [{ header: 1 }, { header: 2 }], // custom button values
        [{ list: "ordered" }, { list: "bullet" }],
        [{ script: "sub" }, { script: "super" }], // superscript/subscript
        [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
        [{ direction: "rtl" }], // text direction

        [{ size: ["small", false, "large", "huge"] }], // custom dropdown
        [{ header: [1, 2, 3, 4, 5, 6, false] }],

        [{ color: [] }, { background: [] }], // dropdown with defaults from theme
        [{ font: [] }],
        [{ align: [] }],

        ["clean"], // remove formatting button
      ];

      quillEditor_editPost = new Quill(".edit_post_rte", {
        modules: {
          toolbar: toolbarOptions,
        },
        placeholder: "Give your Post a Description...",
        theme: "snow",
      });
    } else {
      // Otherwise hide the inputs if it was clicked again
      container.find(".post_title_span").removeClass("hide");
      container.find(".post_description_span").removeClass("hide");
      container.find(".post_comments_container").removeClass("hide");
      container.find(".post_image_container").removeClass("hide");

      container.find(".edit_post_title").addClass("hide");
      container.find(".edit_post_rte").addClass("hide");
      container.find(".btn_update_post").addClass("hide");

      container.find(".post_content .ql-toolbar").remove();
    }
  });

  $(document).on("click", ".btn_update_post", function () {
    const container = $(this).closest(".post_Container");

    const postID = $(this).data("post");
    const title = container.find(".edit_post_title").val();

    if (title != "" && title != null) {
      const description = quillEditor_editPost.root.innerHTML;

      const data = {
        action: "updatePost",
        postID: postID,
        title: title,
        description: description,
      };

      $.ajax({
        url: url_post,
        type: "POST",
        data: data,
      }).done(function (data) {
        $(".state_col").empty();
        $(".state_col").append(data);

        let comment_container = document.getElementsByClassName("RTE_comment");
        //let comment_container = $(".state_col").find(".RTE_comment");
        console.log("RTE_comment");

        const toolbarOptions = [
          ["bold", "italic", "underline", "strike"], // toggled buttons
          ["blockquote", "code-block"],

          [{ header: 1 }, { header: 2 }], // custom button values
          [{ list: "ordered" }, { list: "bullet" }],
          [{ script: "sub" }, { script: "super" }], // superscript/subscript
          [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
          [{ direction: "rtl" }], // text direction

          [{ size: ["small", false, "large", "huge"] }], // custom dropdown
          [{ header: [1, 2, 3, 4, 5, 6, false] }],

          [{ color: [] }, { background: [] }], // dropdown with defaults from theme
          [{ font: [] }],
          [{ align: [] }],

          ["clean"], // remove formatting button
        ];

        console.log("RTE_comment");

        quillEditor = new Quill(".RTE_comment", {
          modules: {
            toolbar: toolbarOptions,
          },
          placeholder: "Write a comment...",
          theme: "snow",
        });
      });
    } else {
      alert("Please ensure that your post has a Title");
      container.find(".edit_post_title").css({ border: "1px solid #DC2626" });
    }
  });

  $(document).on("click", ".hide_post", function () {
    // The confirm method returns true if the user clicks "OK" and false if the user clicks "Cancel"
    var userConfirmed = window.confirm(
      "This will hide the post, you can still see it in your profile, but other people won't, you can always unhide the post again"
    );

    // Check the result and perform actions accordingly
    if (userConfirmed) {
      const postID = $(this).data("post");

      const data = {
        action: "hidePost",
        postID: postID,
      };

      $.ajax({
        url: url_post,
        type: "POST",
        data: data,
      }).done(function (data) {
        alert("Your post is now hidden");

        $(".state_col").empty();
        $(".state_col").append(data);
      });
    } else {
    }
  });

  $(document).on("click", ".unhide_post", function () {
    // The confirm method returns true if the user clicks "OK" and false if the user clicks "Cancel"
    var userConfirmed = window.confirm(
      "This will unhide the post, you can always hide the post again"
    );

    // Check the result and perform actions accordingly
    if (userConfirmed) {
      const postID = $(this).data("post");

      const data = {
        action: "unhidePost",
        postID: postID,
      };

      $.ajax({
        url: url_post,
        type: "POST",
        data: data,
      }).done(function (data) {
        alert("Your post is now unhidden");

        $(".state_col").empty();
        $(".state_col").append(data);

        let comment_container = document.getElementsByClassName("RTE_comment");
        //let comment_container = $(".state_col").find(".RTE_comment");
        console.log("RTE_comment");

        const toolbarOptions = [
          ["bold", "italic", "underline", "strike"], // toggled buttons
          ["blockquote", "code-block"],

          [{ header: 1 }, { header: 2 }], // custom button values
          [{ list: "ordered" }, { list: "bullet" }],
          [{ script: "sub" }, { script: "super" }], // superscript/subscript
          [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
          [{ direction: "rtl" }], // text direction

          [{ size: ["small", false, "large", "huge"] }], // custom dropdown
          [{ header: [1, 2, 3, 4, 5, 6, false] }],

          [{ color: [] }, { background: [] }], // dropdown with defaults from theme
          [{ font: [] }],
          [{ align: [] }],

          ["clean"], // remove formatting button
        ];

        console.log("RTE_comment");

        quillEditor = new Quill(".RTE_comment", {
          modules: {
            toolbar: toolbarOptions,
          },
          placeholder: "Write a comment...",
          theme: "snow",
        });
      });
    } else {
    }
  });

  $(document).on("click", ".delete_post", function () {
    // The confirm method returns true if the user clicks "OK" and false if the user clicks "Cancel"
    var userConfirmed = window.confirm(
      "This action will delete the post, it will be gone forever! Are you sure?"
    );

    // Check the result and perform actions accordingly
    if (userConfirmed) {
      const postID = $(this).data("post");

      const data = {
        action: "deletePost",
        postID: postID,
      };

      $.ajax({
        url: url_post,
        type: "POST",
        data: data,
      }).done(function (data) {
        alert("Your post is now deleted");

        $(".state_col").empty();
        $(".state_col").append(data);
      });
    } else {
    }
  });
});
