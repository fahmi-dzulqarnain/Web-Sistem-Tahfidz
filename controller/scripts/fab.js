const fab = document.querySelector(".fab");

function fabClick() {
  if (fab.classList.contains("active")) {
    fab.classList.remove("active");
  } else {
    fab.classList.add("active");
  }
}
