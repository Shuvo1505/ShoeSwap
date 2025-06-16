var gender_=localStorage.getItem("gender");
document.addEventListener("DOMContentLoaded", function() {
  // Access the element after it has been loaded
  let inputElement = document.getElementById("gender");
  if (inputElement !== null) {
    inputElement.setAttribute("value", gender_);
    
  }

});