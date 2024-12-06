var passwordCreateModal;
$(document).ready(function () {
    passwordList();

    passwordCreateModal = new bootstrap.Modal(document.getElementById('passwordCreateModal'), {});
    $("#btn_passwordCreate").click(function () {
        passwordCreateModal.show();
    });

    $("#form_passwordCreate").submit(function (e) {
        e.preventDefault();
        passwordCreate();
    });

    $("body").on("click", ".password-delete", function (e) {
        e.preventDefault();
        id = $(this).attr('data-id');
        passwordDelete(id);
    });

    $("body").on("click", ".password-sight", function (e) {
        e.preventDefault();
        tipo = $(this).attr('data-tipo');
        id = $(this).attr('data-id');
        if(tipo == 1){
            //Muestra la información
            $(this).removeClass("mdi-eye-off-outline");
            $(this).addClass("mdi-eye-outline");
            $(this).attr('data-tipo',"2");
            $("#password-input"+id).attr('type', 'text');
        }else{
            //Oculta la información
            $(this).removeClass("mdi-eye-outline");
            $(this).addClass("mdi-eye-off-outline");
            $(this).attr('data-tipo',"1");
            $("#password-input"+id).attr('type', 'password');
        }
    });

    $("body").on("click", ".password-modify", function (e) {
        e.preventDefault();
        id = $(this).attr('data-id');
        $(this).addClass('toHide');
        $("#password-check"+id).removeClass("toHide");
        $("#password-cancel"+id).removeClass("toHide");
        $("#password-input"+id).removeAttr('disabled');
        $("#name-input"+id).removeAttr('disabled');
        $("#description-input"+id).removeAttr('disabled');
    });
    
    $("body").on("click", ".password-cancel, .password-check", function (e) {
        e.preventDefault();
        id = $(this).attr('data-id');
        $(this).addClass('toHide');
        $("#password-check"+id).addClass("toHide");
        $("#password-cancel"+id).addClass("toHide");
        $("#password-modify"+id).removeClass("toHide");
        $("#password-input"+id).attr('disabled','disabled');
        $("#name-input"+id).attr('disabled','disabled');
        $("#description-input"+id).attr('disabled','disabled');
    });

    $("body").on("click", ".password-check", function (e) {
        id = $(this).attr('data-id');
        password_name = $('#name-input'+id).val();
        password_input = $('#password-input'+id).val();
        password_description = $('#description-input'+id).val();
        
        passwordUpdate(id, password_name, password_input, password_description);
    })
});

function passwordList() {
 
    $.ajax({
        url: "../Password/passwordsList",  // URL a la que hacer la petición
        type: "POST",  // Método HTTP
        data: {
        },
        success: function (data) {
            $("#password_list").html(data);
        },
        error: function (e1, e2, e3) {
            // Manejamos errores
            console.log(e1);
            console.log(e2);
            console.log(e3);
        }
    })
}

function passwordCreate() {
    password_name = $("#password_name_create").val();
    password = $("#password_create").val();
    description = $("#password_description_create").val();

    $.ajax({
        url: "../Password/Create",  // URL a la que hacer la petición
        type: "POST",  // Método HTTP
        dataType: 'json',
        data: {
            password_name,
            password,
            description
        },
        success: function (data) {
            if (data.respuesta == "1") {
                passwordCreateModal.hide();
                passwordList();
            }
        },
        error: function (e1, e2, e3) {
            // Manejamos errores
            console.log(e1);
            console.log(e2);
            console.log(e3);

        }
    })

}

function passwordDelete(id) {
 
    $.ajax({
        url: "../Password/Delete",  // URL a la que hacer la petición
        type: "POST",  // Método HTTP
        dataType: 'json',
        data: {
            password_id: id
        },
        success: function (data) {
            if (data.respuesta == "1") {
                passwordCreateModal.hide();
                passwordList();
            }
        },
        error: function (e1, e2, e3) {
            // Manejamos errores
            console.log(e1);
            console.log(e2);
            console.log(e3);

        }
    })
}

function passwordUpdate(id, password_name, password, password_description) {
 
    $.ajax({
        url: "../Password/Update",  // URL a la que hacer la petición
        type: "POST",  // Método HTTP
        dataType: 'json',
        data: {
            password_id: id, 
            password_name, 
            password,
            password_description
        },
        success: function (data) {
            if (data.respuesta == "1") {
                passwordCreateModal.hide();
                passwordList();
            }
        },
        error: function (e1, e2, e3) {
            // Manejamos errores
            console.log(e1);
            console.log(e2);
            console.log(e3);

        }
    })
}