import {fetchAll} from "./inventory.js";

const mainHeader = document.getElementById("main-header");

const loginModal = new bootstrap.Modal(document.getElementById("login-modal"));
const loginForm = document.getElementById("login-form");

const logoutBtn = document.getElementById("logout-btn");

const showAlert = document.getElementById("show-alert");

mainHeader.addEventListener("click", (e) => {
    showAlert.innerHTML = "";
    reload();
});

loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    if (loginForm.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        loginForm.classList.add("was-validated");
        return false;
    } else {
        const formData = new FormData(loginForm);
        formData.append("auth", "1");
        formData.append("zaloguj", "1");
        const login = document.getElementById("login").value;
        formData.append("login",login);
        formData.append("password",document.getElementById("password").value);
        const data = await fetch("route/routes.php", {
            method: "POST",
            body: formData,
        });
        const loginStatus = await data.text();
        if (loginStatus === 'true') {
            manageCookie.setCookie("login", login, 1);
            loginForm.reset();
            loginForm.classList.remove("was-validated");
            //enable menu
            document.getElementById("new-book-btn").classList.remove("d-none");
            //hide login and show logout
            document.getElementById("login-btn").classList.add("d-none");
            document.getElementById("logout-btn").classList.remove("d-none");
            loginModal.hide();
            reload();
        } else {
            alert("Nieprawidlowe dane do logowania lub uzytkownik nie istnieje");
            e.preventDefault();
            e.stopPropagation();
            loginForm.reset();
        }


    }
});

// Logout
logoutBtn.addEventListener("click", async(e) => {
    //invalidate the session/remove cookie
    //alert(manageCookie.getCookie("login"));
    manageCookie.removeCookie("login");
    //alert(manageCookie.getCookie("login"));
    //enable menu
    document.getElementById("new-book-btn").classList.add("d-none");
    //hide login and show logout
    document.getElementById("login-btn").classList.remove("d-none");
    document.getElementById("logout-btn").classList.add("d-none");
    fetchAll();
});


function reload() {
    showAlert.innerHTML = "";
    fetchAll();
}

let manageCookie;
manageCookie = {
    /*     Set a cookie's value

        *  @param  name  string  Cookie's name.
        *  @param  value string  Cookie's value.
        *  @param  days  int     Number of days for expiry.
   */
    setCookie: function (name, value, days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = "; expires=" + date.toGMTString();
        } else var expires = "";
        document.cookie = name + "=" + value + expires + "; path=/";
    },

    /**     Get a cookie's value

     *  @param  name  string  Cookie's name.
     *  @return value of the Cookie.
     */
    getCookie: function (name) {
        var coname = name + "=";
        var co = document.cookie.split(';');
        for (var i = 0; i < co.length; i++) {
            var c = co[i];
            c = c.replace(/^\s+/, '');
            if (c.indexOf(coname) == 0) return c.substring(coname.length, c.length);
        }
        return null;
    },

    /**     Removes a cookie

     *  @param  name  string  Cookie's name.
     */

    removeCookie: function (name) {
        manageCookie.setCookie(name, "", -1);
    },

    /** Returns an object with all the cookies. */

    getAll: function () {
        var splits = document.cookie.split(";");
        var cookies = {};
        for (var i = 0; i < splits.length; i++) {
            var split = splits[i].split("=");
            cookies[split[0]] = unescape(split[1]);
        }
        return cookies;
    },

    /** Removes all the cookies */

    removeAll: function () {
        var cookies = manageCookie.getAll();
        for (var key in cookies) {
            if (obj.hasOwnProperty(key)) {
                manageCookie.removeCookie();
            }
        }
    }
};

manageCookie.removeCookie("login");
fetchAll();

export {manageCookie};