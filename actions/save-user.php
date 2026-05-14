<?php

require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';


/*
|--------------------------------------------------------------------------
| CHECK METHOD
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    redirect('../pages/landing.php');
}


/*
|--------------------------------------------------------------------------
| GET FORM DATA
|--------------------------------------------------------------------------
*/

$name = sanitize($_POST['name'] ?? '');

$email = sanitize($_POST['email'] ?? '');

$phone = sanitize($_POST['phone'] ?? '');

$score = (int) ($_POST['score'] ?? 0);


/*
|--------------------------------------------------------------------------
| VALIDATION
|--------------------------------------------------------------------------
*/

if (
    empty($name) ||
    empty($email) ||
    empty($phone)
) {

    die('All fields are required.');
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    die('Invalid email address.');
}


/*
|--------------------------------------------------------------------------
| RESULT TYPE
|--------------------------------------------------------------------------
*/

$result_type = getResultCategory($score);

/*
|--------------------------------------------------------------------------
| CHECK EXISTING USER
|--------------------------------------------------------------------------
*/

$check_stmt = $pdo->prepare("
    SELECT id
    FROM users
    WHERE email = ?
    OR phone = ?
");

$check_stmt->execute([
    $email,
    $phone
]);

$existing_user = $check_stmt->fetch();


if ($existing_user) {

   ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Already Submitted</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#050816] text-white min-h-screen flex items-center justify-center px-5">


    <!-- Glow -->

    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">

        <div class="absolute w-72 h-72 bg-cyan-500 opacity-20 blur-3xl rounded-full top-10 left-10"></div>

        <div class="absolute w-72 h-72 bg-purple-500 opacity-20 blur-3xl rounded-full bottom-10 right-10"></div>

    </div>


    <!-- Card -->

    <div
        class="relative z-10 max-w-xl w-full bg-white/5 border border-white/10
               rounded-3xl p-10 backdrop-blur-xl shadow-2xl text-center">


        <!-- Icon -->

        <div class="text-6xl mb-6">

            ⚠️

        </div>


        <!-- Title -->

        <h1 class="text-4xl font-extrabold">

            Assessment Already Submitted

        </h1>


        <!-- Text -->

        <p class="mt-5 text-gray-300 text-lg leading-relaxed">

            It looks like this email or WhatsApp number
            has already completed the AI readiness test.

        </p>


        <!-- Button -->

        <a href="../pages/landing.php"

            class="mt-8 inline-flex items-center justify-center px-8 py-4 rounded-2xl
                   bg-gradient-to-r from-cyan-500 to-purple-600
                   hover:scale-105 transition duration-300
                   text-lg font-semibold shadow-2xl shadow-cyan-500/30">

            Back To Home

        </a>

    </div>

</body>

</html>

<?php

exit;
}


/*
|--------------------------------------------------------------------------
| SAVE USER
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    INSERT INTO users
    (
        name,
        email,
        phone,
        score,
        result_type
    )

    VALUES
    (
        ?,
        ?,
        ?,
        ?,
        ?
    )
");


$stmt->execute([
    $name,
    $email,
    $phone,
    $score,
    $result_type
]);


/*
|--------------------------------------------------------------------------
| SAVE SESSION
|--------------------------------------------------------------------------
*/

$_SESSION['user_name'] = $name;

$_SESSION['user_score'] = $score;

$_SESSION['result_type'] = $result_type;


/*
|--------------------------------------------------------------------------
| SAVE QUIZ ANSWERS JSON
|--------------------------------------------------------------------------
*/

$_SESSION['quiz_answers'] =

    $_POST['quiz_answers'] ?? '[]';


/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

redirect('../pages/full-report.php');