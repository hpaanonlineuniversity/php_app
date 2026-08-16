<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/User.php';

class AuthController extends Controller {

    // Login Form ပြသခြင်း (GET /auth/login)
    public function login() {
        // Login ဝင်ပြီးသား ဖြစ်ပါက Dashboard သို့ ပို့မည်
        if (isset($_SESSION['user_id'])) {
            header('Location: /user/index');
            exit;
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $this->view('auth/login');
    }

    // Login စစ်ဆေးခြင်း (POST /auth/authenticate)
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // CSRF Check
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("CSRF Validation Failed!");
            }

            $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Email နှင့် Password ဖြည့်သွင်းပါ။";
                header('Location: /auth/login');
                exit;
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            // User ရှိမရှိနှင့် Password မှန်မမှန် စစ်ဆေးခြင်း
            if ($user && password_verify($password, $user['password'])) {
                
                // Session Fixation Attack ကို ကာကွယ်ရန် Session ID အသစ်ပြောင်းခြင်း
                session_regenerate_id(true);

                // Session ထဲတွင် User Data သိမ်းဆည်းခြင်း
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_name']  = $user['name'];
                $_SESSION['user_email'] = $user['email'];

                unset($_SESSION['csrf_token']);
                unset($_SESSION['error']);

                header('Location: /user/index');
                exit;
            } else {
                $_SESSION['error'] = "Email သို့မဟုတ် Password မှားယွင်းနေပါသည်။";
                header('Location: /auth/login');
                exit;
            }
        }
    }

    // Logout လုပ်ခြင်း (GET/POST /auth/logout)
    public function logout() {
        // Session များကို ဖျက်ဆီးခြင်း
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header('Location: /auth/login');
        exit;
    }
}
