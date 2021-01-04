// Checkbox to show/hide password input
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

// Clear file upload button
function clearFileUpload() {
    let browseBtn = document.getElementById('browse');
    let clearBtn = document.getElementById('clear');

    browseBtn.value = '';
}