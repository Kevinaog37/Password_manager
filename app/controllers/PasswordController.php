<?php
include("app/models/PasswordModel.php");

class PasswordController
{
    public function index()
    {
        require_once __DIR__ . '/../views/dashboardView.php';
    }

    public function create()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['user'][0]['id'])) {
                $user = $_SESSION['user'][0]['id'];
                $password_name = $_POST['password_name'];
//                $password = $this->encriptionAES($_POST['password']);
                $password = $this->encrypt_decrypt("encrypt", $_POST['password']);
                $password_description = $_POST['description'];

                $pass = new PasswordModel();
                $info['resultado'] = $pass->createPassword($user, $password_name, $password, $password_description);
                if ($info['resultado']) {
                    $info['respuesta'] = 1;
                    echo json_encode($info);
                } else {
                    echo json_encode($pass->getError());
                }
            } else {
                echo json_encode(array('error' => 'Debes iniciar sesión.'));
            }
        }
    }

    public function delete()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['user'][0]['id'])) {
                $id = $_POST['password_id'];

                $pass = new PasswordModel();
                $info['resultado'] = $pass->deletePasswordById($id);
                if ($info['resultado']) {
                    $info['respuesta'] = 1;
                    echo json_encode($info);
                } else {
                    echo json_encode($pass->getError());
                }
            } else {
                echo json_encode(array('error' => 'Debes iniciar sesión.'));
            }
        }
    }

    public function update()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['user'][0]['id'])) {
                $id = $_POST['password_id'];
                $password_name = $_POST['password_name'];
                //$password = $this->encriptionAES($_POST['password']);
                $password = $this->encrypt_decrypt("encrypt", $_POST['password']);
                $password_description = $_POST['password_description'];
                //$password_description = $_POST['description'];

                $pass = new PasswordModel();
                $info['resultado'] = $pass->updatePassword($id, $password_name, $password, $password_description);
                if ($info['resultado']) {
                    $info['respuesta'] = 1;
                    echo json_encode($info);
                } else {
                    echo json_encode($pass->getError());
                }
            } else {
                echo json_encode(array('error' => 'Debes iniciar sesión.'));
            }
        }
    }

    public function encriptionAES($text){
        $key ="2a8c74e9051bc7d7c8fcfd79b01506d4b3931bb93e65fda65b95f9e3b587a618";
        // Generar un IV (vector de inicialización) aleatorio de 16 bytes
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        
        // Asegurarse de que el IV tenga exactamente 16 bytes
        if (strlen($iv) < 16) {
            $iv = str_pad($iv, 16, "\0");
        }
        
        // Cifrar el texto con AES-256-CBC
        $ciphertext = openssl_encrypt($text, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        
        // Combinar el IV con el ciphertext para poder descifrarlo luego
        $ciphertext_with_iv = base64_encode($iv . $ciphertext);
        
        return $ciphertext_with_iv;
    }

    public function desencriptionAES($text) {
        $key ="2a8c74e9051bc7d7c8fcfd79b01506d4b3931bb93e65fda65b95f9e3b587a618";
        // Decodificar el texto cifrado desde base64
        $ciphertext_with_iv = base64_decode($text);
        
        // Obtener el IV de los primeros 16 bytes
        $iv_length = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($ciphertext_with_iv, 0, $iv_length);
        
        // Obtener el ciphertext (el resto de los datos)
        $ciphertext = substr($ciphertext_with_iv, $iv_length);
        
        // Descifrar el texto con AES-256-CBC
        $plaintext = openssl_decrypt($ciphertext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        
        return $plaintext;
    }

    function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'sadgjakgdkjafkj';
        $secret_iv = 'This is my secret iv';

        $key = hash('sha256', $secret_key);
        
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
    
    
    public function passwordsList()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();
            $password = new PasswordModel();
            $password_list = $password->getAllByUser($_SESSION['user'][0]['id']);
        ?>

            <?php if (count($password_list) == 0) { ?>
                <div class="alert alert-warning">No tienes contraseñas guardadas.</div>
            <?php } else { ?>
                <?php foreach ($password_list as $passwords) { ?>
                    <div class="alert alert-light row justify-content-center align-items-center">
                        <div class="col-2 d-flex align-items-center">
                            <span><input id="name-input<?php echo $passwords['id']; ?>" type="text" class="form-control" disabled value="<?php echo $passwords['name']; ?>"></span>
                        </div>
                        <div class="col-4">
                            <span><input id="password-input<?php echo $passwords['id']; ?>" type="password" class="form-control" disabled value="<?php echo $passwords['password']; ?>"></span>
                        </div>
                        <div class="col-3">
                            <span><textarea id="description-input<?php echo $passwords['id']; ?>" class="form-control" placeholder="Description" disabled><?php echo $passwords['description']; ?></textarea></span>
                        </div>
                        <div class="col-1 d-flex justify-content-center align-items-center fs-5">
                            <span class="mdi mdi-eye-off-outline cursor-pointer password-sight" data-id="<?php echo $passwords['id']; ?>" data-tipo="1"></span>
                        </div>

                        <div class="col-1 d-flex justify-content-center align-items-center fs-5">
                            <span id="password-modify<?php echo $passwords['id']; ?>" class="mdi mdi-pencil cursor-pointer password-modify" data-id="<?php echo $passwords['id']; ?>"></span>
                            <span id="password-check<?php echo $passwords['id']; ?>" class="mdi mdi-check-bold  cursor-pointer password-check toHide" data-id="<?php echo $passwords['id']; ?>"></span>
                            &nbsp;&nbsp;
                            <span id="password-cancel<?php echo $passwords['id']; ?>" class="mdi mdi-cancel cursor-pointer password-cancel toHide " data-id="<?php echo $passwords['id']; ?>"></span>
                        </div>

                        <div class="col-1 d-flex justify-content-center align-items-center fs-5">
                            <span class="mdi mdi-close-outline cursor-pointer password-delete" data-id="<?php echo $passwords['id']; ?>"></span>
                        </div>
                    </div>
        <?php
                }
            }
        }
    }
}
