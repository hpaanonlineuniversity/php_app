<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/User.php';

class UserController extends Controller {

    public function __construct() {
        // Login မဝင်ထားပါက Login Page သို့ ပြန်ညွှန်းခြင်း
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
    }

    // User List ပြသခြင်း
    public function index() {
        $userModel = new User();
        $users = $userModel->getAllUsers();
        $this->view('users/index', ['users' => $users]);
    }

    // Form ပြသခြင်း (GET Request)
    public function create() {
        // CSRF Token တည်ဆောက်ခြင်း
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $this->view('users/create');
    }

    // Edit Form ပြသခြင်း (GET /user/edit/1)
    public function edit($id = null) {
        if (!$id) {
            header('Location: /user/index');
            exit;
        }

        $userModel = new User();
        $user = $userModel->getUserById($id);

        if (!$user) {
            die("User မတွေ့ရှိပါ။");
        }

        // CSRF Token ဖန်တီးခြင်း
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $this->view('users/edit', ['user' => $user]);
    }

    // Update Data သိမ်းဆည်းခြင်း (POST /user/update/1)
    public function update($id = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            
            // CSRF Check
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("CSRF Validation Failed!");
            }

            $name  = trim($_POST['name'] ?? '');
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
            $pass  = $_POST['password'] ?? '';

            if (empty($name) || empty($email)) {
                die("Name နှင့် Email ဖြည့်သွင်းရန် လိုအပ်ပါသည်။");
            }

            $userModel = new User();
            $success = $userModel->update($id, [
                'name'     => $name,
                'email'    => $email,
                'password' => $pass
            ]);

            if ($success) {

                header('Location: /user/index');
                exit;
            } else {
                echo "Update ပြုလုပ်ခြင်း မအောင်မြင်ပါ။";
            }
        }
    }


    // Form Data သိမ်းဆည်းခြင်း (POST Request)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // CSRF Token စစ်ဆေးခြင်း
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("CSRF Validation Failed!");
            }

            // Input Validation & Sanitization
            $name  = trim($_POST['name'] ?? '');
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
            $pass  = $_POST['password'] ?? '';

            if (empty($name) || empty($email) || empty($pass)) {
                die("ကျေးဇူးပြု၍ အချက်အလက်များ အပြည့်အစုံ ဖြည့်သွင်းပါ။");
            }

            // Model မှတစ်ဆင့် DB သို့ ထည့်သွင်းခြင်း
            $userModel = new User();
            $success = $userModel->create([
                'name'     => $name,
                'email'    => $email,
                'password' => $pass
            ]);

            if ($success) {
 
                header('Location: /user/index');
                exit;
            } else {
                echo "User ထည့်သွင်းခြင်း မအောင်မြင်ပါ။";
            }
        }
    }

    // Delete Process (POST /user/delete/1)
    public function delete($id = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            
            // CSRF Check
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("CSRF Validation Failed!");
            }

            $userModel = new User();
            
            // User ရှိမရှိ အရင် စစ်ဆေးခြင်း
            $user = $userModel->getUserById($id);
            if (!$user) {
                die("ဖျက်လိုသော User မတွေ့ရှိပါ။");
            }

            // DB မှ ဖျက်ထုတ်ခြင်း
            $success = $userModel->delete($id);

            if ($success) {
                header('Location: /user/index');
                exit;
            } else {
                echo "User ဖျက်ထုတ်ခြင်း မအောင်မြင်ပါ။";
            }
        } else {
            // GET Request ဖြင့် လာပါက တိုက်ရိုက် ငြင်းပယ်ခြင်း
            die("Invalid Request Method.");
        }
    }

}
