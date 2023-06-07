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


searchForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    if (searchForm.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        searchForm.classList.add("was-validated");
        return false;
    } else {
        document.getElementById("search-btn").value = "Czekaj...";
        let login = getCookie("login");
        const book = document.getElementById("search-book").value;
        const author_name = document.getElementById("search-author-name").value;
        const author_surname = document.getElementById("search-author-surname").value;
        const category = document.getElementById("search-categories-dict").value;
        const isbn = document.getElementById("search-isbn").value;
        const sort = document.getElementById("search-sort-dict").value;
        if (isEmpty(book) && isEmpty(author_name) && isEmpty(category) && isEmpty(isbn) && isEmpty(author_surname) && isEmpty(sort)) {
            await fetchAll();
            showAlert.innerHTML = showMessage("danger", "Proszę wypełnić conajmniej jedno pole!");
            console.log("Pusty formularz!");
        } else {
            let kryteria = "Kryteria wyszukiwania [ ";
            let params = "";
            if (!isEmpty(book)) {
                kryteria = kryteria +  "Tytuł: " + book +" ";
                params = params + '&title=' + book;
            }
            if (!isEmpty(author_name)) {
                kryteria = kryteria +  "Imię autora: " + author_name + " ";
                params = params + '&author_name=' + author_name;
            }
            if(!isEmpty(author_surname)){
                kryteria = kryteria + "Nazwisko autora: " + author_surname + " ";
                params = params + '&author_surname=' + author_surname;
            }
            if (!isEmpty(isbn)) {
                kryteria = kryteria +  "ISBN: " + isbn;
                params = params + '&isbn=' + isbn;
            }
            if(!isEmpty(category) && category != "-1"){
                kryteria = kryteria + "Gatunek: " + category;
                params = params + '&category_id=' + category;
            }
            if(!isEmpty(sort) && sort !="-1"){
                const sort_label = document.getElementById("search-sort-dict-option-"+sort).text;
                kryteria = kryteria + "Sortowanie: " + sort_label;
                params = params + '&sort_type=' + sort;
            }
            kryteria = kryteria +"]";
            console.log(params);
            console.log(category);
            console.log(typeof(category));
            const searched_result = await fetch(`route/routes.php?inventory&login=${login}`+params, {
                method: "GET",
            });
            tbody.innerHTML = await searched_result.text();
            console.log("pytanie wykonane")
            showAlert.innerHTML = showMessage("success", kryteria);
        }
        document.getElementById("search-btn").value = "Szukaj";
        searchForm.reset();
        searchForm.classList.remove("was-validated");
        searchModal.hide();
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