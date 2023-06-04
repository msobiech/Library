import {fetchAll} from "./inventory.js";
import {manageCookie} from "./main.js";
const showAlert = document.getElementById("show-alert");

const tableId = document.getElementById('main-view-table');
const tbody = tableId.getElementsByTagName('tbody')[0];
const rentForm = document.getElementById("rent-book-form");
const rentModal = new bootstrap.Modal(document.getElementById("rent-book-modal"));

tbody.addEventListener("click", async (e) => {
    if (e.target && e.target.matches("a.rentBookLink")) {
        e.preventDefault();

        let id = e.target.getAttribute("id");
        let login = manageCookie.getCookie("login");

        document.getElementById("rent-book-id").value = id;
        //document.getElementById("rent-book-author").value = 'Nieznany';
        //pobranie danych booku i artysty
        const bookData = await fetch(`route/routes.php?book&id=${id}&login=${login}`, {
            method: "GET",
        });
        const response = await bookData.json();

        document.getElementById("rent-book-title").value = response.title;
        document.getElementById("rent-book-author").value = response.name;
        let date = new Date();
        document.getElementById("rent-book-min-date").value = formatDate(date);
        // add a day
        date.setDate(date.getDate() + 7);
        document.getElementById("rent-book-max-date").value = formatDate(date);
    }
});

function formatDate(date) {
    const yyyy = date.getFullYear();
    let mm = date.getMonth() + 1; // Months start at 0!
    let dd = date.getDate();
    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;
    return yyyy + '-' + mm + '-' + dd;
}


rentForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    if(rentForm.checkValidity() === false){
        e.preventDefault();
        e.stopPropagation();
        rentForm.classList.add("was-validated");
        return false;
    } else {
        const formData = new FormData(rentForm);
        formData.append("book", "rent");
        let user = manageCookie.getCookie("login");
        let book_id = document.getElementById("rent-book-id").value;
        formData.append("login", user);
        formData.append("book-id", book_id);
        const data = await fetch("route/routes.php", {
            method: "POST",
            body: formData,
        });
        showAlert.innerHTML = await data.text();
        rentForm.reset();
        rentForm.classList.remove("was-validated");
        rentModal.hide();
        fetchAll();
    }
});