function clearFormData() {
  // Get the form
  var form = document.getElementById("modifyUserForm");

  // Clear all input fields in the form
  for (var i = 0; i < form.elements.length; i++) {
    if (
      form.elements[i].type == "text" ||
      form.elements[i].type == "password" ||
      form.elements[i].type == "email"
    ) {
      form.elements[i].value = "";
    }
  }
}
