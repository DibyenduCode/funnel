<?php

require_once '../includes/config.php';


/*
|--------------------------------------------------------------------------
| ALREADY LOGGED IN
|--------------------------------------------------------------------------
*/

if (isset($_SESSION['admin_logged_in'])) {

    header('Location: dashboard.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| LOGIN SUBMIT
|--------------------------------------------------------------------------
*/

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email'] ?? '');

    $password = trim($_POST['password'] ?? '');


    if (
        $email == ADMIN_EMAIL &&
        $password == ADMIN_PASSWORD
    ) {

        $_SESSION['admin_logged_in'] = true;

        header('Location: dashboard.php');

        exit;

    } else {

        $error = 'Invalid login credentials.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login</title>

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
        class="relative z-10 w-full max-w-md bg-white/5 border border-white/10
               rounded-3xl p-8 backdrop-blur-xl shadow-2xl">


        <!-- Heading -->

        <div class="text-center">

            <h1 class="text-4xl font-extrabold">

                🔐 Admin Login

            </h1>

            <p class="mt-4 text-gray-300">

                Access AI Quiz Dashboard

            </p>

        </div>


        <!-- Error -->

        <?php if ($error): ?>

            <div
                class="mt-6 bg-red-500/20 border border-red-400/30
                       text-red-300 px-4 py-3 rounded-2xl">

                <?php echo $error; ?>

            </div>

        <?php endif; ?>


        <!-- Form -->

        <form method="POST" class="mt-8 space-y-6">


            <!-- Email -->

            <div>

                <label class="block mb-2 text-gray-300">

                    Admin Email

                </label>

                <input
                    type="email"
                    name="email"
                    required

                    class="w-full px-5 py-4 rounded-2xl
                           bg-white/5 border border-white/10
                           focus:border-cyan-400 focus:outline-none
                           text-white">

            </div>


            <!-- Password -->

            <div>

                <label class="block mb-2 text-gray-300">

                    Password

                </label>

                <input
                    type="password"
                    name="password"
                    required

                    class="w-full px-5 py-4 rounded-2xl
                           bg-white/5 border border-white/10
                           focus:border-cyan-400 focus:outline-none
                           text-white">

            </div>


            <!-- Submit -->

            <button
                type="submit"

                class="w-full py-4 rounded-2xl
                       bg-gradient-to-r from-cyan-500 to-purple-600
                       hover:scale-[1.02] transition duration-300
                       text-lg font-semibold shadow-2xl shadow-cyan-500/30">

                Login

            </button>

        </form>

    </div>

</body>

</html>