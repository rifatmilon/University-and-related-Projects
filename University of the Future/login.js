$("form").validate({
  rules: {
    fullname: {
      minlength: 3,
      maxlength: 50,
      required: true,
    },
    contactNo: {
      minlength: 11,
      maxlength: 11,
      required: true,
      numeric: true,
    },
    email: {
      required: true,
      email: true,
    },
    password: {
      required: true,
      minlength: 6,
      maxlength: 15,
    },
    rePassword: {
      required: true,
      equalTo: "#password",
    },
  },
  highlight: function (element) {
    $(element).closest(".input-group").addClass("has-error");
  },
  unhighlight: function (element) {
    $(element).closest(".input-group").removeClass("has-error");
  },
  errorElement: "span",
  errorClass: "help-block",
  errorPlacement: function (error, element) {
    if (element.parent(".input-group").length) {
      error.insertAfter(element.parent());
    } else {
      error.insertAfter(element);
    }
  },
});
