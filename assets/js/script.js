document.addEventListener("DOMContentLoaded", function () {
  console.log("loader");

  const links = document.querySelectorAll(".delete");

  links.forEach((element) => {
    // console.log(element);
    element.addEventListener("click", function (e) {
      if (!confirm("Are You Sure?")) {
        e.preventDefault();
      }
    });
  });
});
