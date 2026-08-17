<?php

// Session Security Configuration များ သတ်မှတ်ခြင်း
session_set_cookie_params([
    'lifetime' => 0,                      // Browser ပိတ်လိုက်ပါက Session ကုန်ဆုံးမည်
    'path'     => '/',                    // Domain တစ်ခုလုံးတွင် သုံးနိုင်မည်
    'domain'   => '',                     // Current Domain ကို အလိုအလျောက် သုံးမည်
    'secure'   => true,                   // HTTPS Connection မှသာ Cookie ပို့မည်
    'httponly' => true,                   // JavaScript (XSS) မှ Cookie ဖတ်၍ မရအောင် တားဆီးမည်
    'samesite' => 'Lax'                   // CSRF Attack များကို ကာကွယ်ရန် သတ်မှတ်မည် (Lax သို့မဟုတ် Strict)
]);

session_start(); //CSRF Token နှင့် Error Message များ အသုံးပြုနိုင်ရန်

require_once __DIR__ . '/../core/App.php';

$app = new App();
