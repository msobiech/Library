import {fetchAll} from "./inventory.js";
import {manageCookie} from "./main.js";
const showAlert = document.getElementById("show-alert");

const tableId = document.getElementById('main-view-table');
const tbody = tableId.getElementsByTagName('tbody')[0];
const returnForm = document.getElementById("return-book-form");
const returnModal = new bootstrap.Modal(document.getElementById("return-book-modal"));

tbody.addEventListener("click", async (e) => {
    if (e.target && e.target.matches("a.returnBookLink")) {

        e.preventDefault();
        let id = e.target.getAttribute("id");
        let login = manageCookie.getCookie("login");

        //document.getElementById("rent-book-author").value = 'Nieznany';
        //pobranie danych booku i artysty
        const bookData = await fetch(`route/routes.php?book&id=${id}&login=${login}`, {
            method: "GET",
        });
        const response = await bookData.json();

        //document.getElementById("return-book-id").value = response.id;
        document.getElementById("return-book-title").value = response.title;
        document.getElementById("return-book-author").value = response.name;
        document.getElementById("return-book-min-date").value = response.rent_start;
        document.getElementById("return-book-max-date").value = response.rent_end;
        document.getElementById("return-rent-id").value = response.rent_id;
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



returnForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    if(returnForm.checkValidity() === false){
        e.preventDefault();
        e.stopPropagation();
        returnForm.classList.add("was-validated");
        return false;
    } else {
        const formData = new FormData(returnForm);
        formData.append("book", "return");
        let user = manageCookie.getCookie("login");
        let rent_id = document.getElementById("return-rent-id").value;
        //let book_id = document.getElementById("id").value;
        formData.append("login", user);
        formData.append("rent-id", rent_id);
        //formData.append("book-id", book_id);
        let date = new Date();
        formData.append("return_date" , formatDate(date));
        const data = await fetch("route/routes.php", {
            method: "POST",
            body: formData,
        });
        showAlert.innerHTML = await data.text();
        returnForm.reset();
        returnForm.classList.remove("was-validated");
        returnModal.hide();
        fetchAll();
    }
});