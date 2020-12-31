
function showPass() {
    let pass = document.getElementById("password");
    let box = document.getElementById("show-pw");


    if (box.checked == true) {
        pass.type = 'text';
    }
    else {
        pass.type = 'password';
    }
}

