import {fetchAll} from "./inventory.js";
import {manageCookie} from "./main.js";

const showAlert = document.getElementById("show-alert");

const addForm = document.getElementById("add-book-form");
const addModal = new bootstrap.Modal(document.getElementById("add-book-modal"));


//Zbudowanie slownika dostepnych gatunkow.

const categoriesSelectBody = document.getElementById("categories-dict-select");
const addModalC = document.getElementById("add-book-modal");
addModalC.addEventListener('shown.bs.modal', async function () {
    const data = await fetch("route/routes.php?category", {
        method: "GET",
    });
    categoriesSelectBody.innerHTML = await data.text();

})

//zbudowanie slownika do wyszukiwania dostepnych gatunkow

const categoriesSearchBody = document.getElementById("search-categories-dict");
const searchModal = document.getElementById("search-modal");

searchModal.addEventListener('shown.bs.modal', async function(){
    const data = await fetch("route/routes.php?category", {
        method: "GET",
    });
    categoriesSearchBody.innerHTML = await data.text();
    categoriesSearchBody.innerHTML = '<option value="-1">Brak kategorii</option>' + await categoriesSearchBody.innerHTML;
})

addForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    if(addForm.checkValidity() === false){
        e.preventDefault();
        e.stopPropagation();
        addForm.classList.add("was-validated");
        return false;
    } else {
        let user = manageCookie.getCookie("login");

        const formData = new FormData(addForm);
        formData.append("book", "add");
        formData.append("login", user);

        const data = await fetch("route/routes.php", {
            method: "POST",
            body: formData,
        });
        //formData.append("login", getCookie("login")); //nie wiem co to robi, ale jest bo bylo wyzej
        //console.log(formData);
        showAlert.innerHTML = await data.text();
        addForm.reset();
        addForm.classList.remove("was-validated");
        addModal.hide();
        fetchAll();
    }
});