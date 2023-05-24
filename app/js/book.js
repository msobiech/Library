import {fetchAll} from "./inventory.js";
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

addForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    if(addForm.checkValidity() === false){
        e.preventDefault();
        e.stopPropagation();
        addForm.classList.add("was-validated");
        return false;
    } else {
        const formData = new FormData(addForm);
        formData.append("book", 1);
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