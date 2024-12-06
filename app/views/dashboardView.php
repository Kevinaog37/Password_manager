<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$password = new PasswordModel();
$password_list = $password->getAllByUser($_SESSION['user'][0]['id']);

echo "<pre>";
//var_dump($password_list);   
echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "public/templates/header.php"; ?>
    <script src="../public/js/password.js"></script>
</head>

<body>
    <main>
        <div id="contenedor" class="container d-flex justify-content-center">
            <div id="password_list_card" class="card border-primary mb-5 mt-5">
                <div class="card-header text-center text-primary d-flex justify-content-center align-items-center fs-5">
                    <span class="fs-3">My passwords</span>
                    <span class="ms-4"><button id="btn_passwordCreate" class="btn btn-primary btn-sm">New pass</button></span>
                </div>
                <div id="password_list" class="card-body">
                    
                </div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="passwordCreateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mb-5">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="form_passwordCreate">
                        <div class="mb-3">
                            <label for="password_name_create" class="form-label">Name</label>
                            <input type="text" class="form-control" id="password_name_create" placeholder="Type name or title">
                        </div>

                        <div class="mb-3">
                            <label for="password_create" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password_create" placeholder="Type password">
                        </div>

                        <div class="mb-3">
                            <label for="password_description_create" class="form-label">Description</label>
                            <textarea id="password_description_create" class="form-control" placeholder="Type additional information"></textarea>
                        </div>

                        <div class="mb-3">
                            <button id="btn_passwordSave" class="btn btn-primary form-control">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>