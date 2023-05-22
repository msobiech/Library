//Main View
const tableId = document.getElementById('main-view-table');
const tbody = tableId.getElementsByTagName('tbody')[0];

const fetchAll = async () => {
    let login = getCookie("login");
    const data = await fetch(`route/routes.php?inventory&login=${login}`, {
        method: "GET",
    });
    tbody.innerHTML = await data.text();
};

const searchModal = new bootstrap.Modal(document.getElementById("search-modal"));
const searchForm = document.getElementById("search-form");
const showAlert = document.getElementById("show-alert");

const addForm = document.getElementById("add-book-form");
const addModal = new bootstrap.Modal(document.getElementById("add-book-modal"));

searchForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    if (searchForm.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        searchForm.classList.add("was-validated");
        return false;
    } else {
        document.getElementById("search-btn").value = "Czekaj...";
        const book = document.getElementById("search-book").value;
        const author = document.getElementById("search-author").value;
        const isbn = document.getElementById("search-isbn").value;
        if (isEmpty(book) && isEmpty(author) && isEmpty(isbn)) {
            await fetchAll();
            showAlert.innerHTML = "";
        } else {
            const formData = new FormData(searchForm);
            formData.append("inwentarz", "2");
            formData.append("login", getCookie("login"));
            const data = await fetch("route/routes.php", {
                method: "POST",
                body: formData,
            });
            tbody.innerHTML = await data.text();
            let kryteria = "Kryteria wyszukiwania [ ";
            if (!isEmpty(book)) {
                kryteria = kryteria +  "Tytuł: " + book +" ";
            }
            if (!isEmpty(author)) {
                kryteria = kryteria +  "Autor: " + author + " ";
            }
            if (!isEmpty(isbn)) {
                kryteria = kryteria +  "ISBN: " + isbn;
            }
            kryteria = kryteria +"]";
            showAlert.innerHTML = showMessage("success", kryteria, "fetchInwentarz()");
        }
        document.getElementById("search-btn").value = "Szukaj";
        searchForm.reset();
        searchForm.classList.remove("was-validated");
        searchModal.hide();
    }
});

addForm.addEventListener("submit", async (e) => {
   e.preventDefault();
   if(addForm.checkValidity() === false){
       e.preventDefault();
       e.stopPropagation();
       addForm.classList.add("was-validated");
       return false;
   } else {
       const formData = new FormData(addForm);
       const data = await fetch("route/routes.php", {
           method: "POST",
           body: formData,
       });
       //formData.append("login", getCookie("login")); //nie wiem co to robi, ale jest bo bylo wyzej
       //console.log(formData);
       addForm.reset();
       addForm.classList.remove("was-validated");
       //console.log("dodano ksiazke");
       showAlert.innerHTML = showMessage("success", "Dodano książkę");
   }

});

function isEmpty(str) {
    return (!str || str.length === 0 );
}

function showMessage(type, message, action) {
    return '<div class="alert alert-'  + type + ' alert-dismissible fade show" role="alert">' +
        '<strong>' + message + '</strong></div>';
}

/**     Get a cookie's value

 *  @param  name  string  Cookie's name.
 *  @return value of the Cookie.
 */
function getCookie(name) {
    var coname = name + "=";
    var co = document.cookie.split(';');
    for (var i = 0; i < co.length; i++) {
        var c = co[i];
        c = c.replace(/^\s+/, '');
        if (c.indexOf(coname) == 0) return c.substring(coname.length, c.length);
    }
    return null;
}

export {fetchAll};