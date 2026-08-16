<?php

session_start(); //CSRF Token နှင့် Error Message များ အသုံးပြုနိုင်ရန်

require_once __DIR__ . '/../core/App.php';

$app = new App();
