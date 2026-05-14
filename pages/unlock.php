<?php

require_once '../includes/config.php';

$score = isset($_GET['score']) ? (int) $_GET['score'] : 0;

?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Unlock Full Report</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#050816] text-white min-h-screen overflow-x-hidden">


    <!-- Glow -->

    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">

        <div class="absolute w-72 h-72 bg-cyan-500 opacity-20 blur-3xl rounded-full top-10 left-10"></div>

        <div class="absolute w-72 h-72 bg-purple-500 opacity-20 blur-3xl rounded-full bottom-10 right-10"></div>

    </div>


    <!-- Main -->

    <div class="relative z-10 flex justify-center items-center min-h-screen px-5 py-10">


        <!-- Card -->

        <div
            class="w-full max-w-2xl bg-white/5 border border-white/10
                   rounded-3xl p-8 backdrop-blur-xl shadow-2xl">


            <!-- Heading -->

            <div class="text-center">

                <h1 class="text-4xl font-extrabold">

                    🔓 Unlock Full AI Report

                </h1>

                <p class="mt-4 text-gray-300">

                    Get your personalized AI career analysis and roadmap.

                </p>

            </div>


            <!-- Form -->

            <form
                id="unlockForm"
                action="<?php echo SITE_URL; ?>/actions/save-user.php"
                method="POST"
                class="mt-10 space-y-6">


                <!-- Hidden Score -->

                <input
                    type="hidden"
                    name="score"
                    value="<?php echo $score; ?>">


                <!-- Name -->

                <div>

                    <label class="block mb-2 text-gray-300">

                        Full Name

                    </label>

                    <input
                        type="text"
                        name="name"
                        required

                        class="w-full px-5 py-4 rounded-2xl
                               bg-white/5 border border-white/10
                               focus:border-cyan-400 focus:outline-none
                               text-white">

                </div>


                <!-- Email -->

                <div>

                    <label class="block mb-2 text-gray-300">

                        Gmail Address

                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        required

                        class="w-full px-5 py-4 rounded-2xl
                               bg-white/5 border border-white/10
                               focus:border-cyan-400 focus:outline-none
                               text-white">

                    <p id="emailError"
                        class="text-red-400 text-sm mt-2 hidden">

                        Please enter a valid Gmail address.

                    </p>

                </div>


                <!-- WhatsApp -->

                <div>

                    <label class="block mb-2 text-gray-300">

                        WhatsApp Number

                    </label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        required
                        maxlength="10"

                        class="w-full px-5 py-4 rounded-2xl
                               bg-white/5 border border-white/10
                               focus:border-cyan-400 focus:outline-none
                               text-white">

                    <p id="phoneError"
                        class="text-red-400 text-sm mt-2 hidden">

                        Please enter a valid 10-digit number.

                    </p>

                </div>


                <!-- Submit -->

                <button
                    type="submit"

                    class="w-full py-4 rounded-2xl
                           bg-gradient-to-r from-cyan-500 to-purple-600
                           hover:scale-[1.02] transition duration-300
                           text-lg font-semibold shadow-2xl shadow-cyan-500/30">

                    Unlock My Full Report

                </button>


            </form>


            <!-- Footer -->

            <p class="mt-6 text-center text-gray-500 text-sm">

                We respect your privacy. No spam.

            </p>


        </div>

    </div>



    <script>

        const form = document.getElementById('unlockForm');

        const email = document.getElementById('email');

        const phone = document.getElementById('phone');

        const emailError = document.getElementById('emailError');

        const phoneError = document.getElementById('phoneError');



        /*
        |--------------------------------------------------------------------------
        | ONLY NUMBER IN PHONE
        |--------------------------------------------------------------------------
        */

        phone.addEventListener('input', function() {

            this.value = this.value.replace(/\D/g, '');

        });



        /*
        |--------------------------------------------------------------------------
        | FORM VALIDATION
        |--------------------------------------------------------------------------
        */

        form.addEventListener('submit', function(e) {

            let valid = true;


            // Gmail validation

            if (!email.value.endsWith('@gmail.com')) {

                emailError.classList.remove('hidden');

                valid = false;

            } else {

                emailError.classList.add('hidden');

            }


            // Phone validation

            if (phone.value.length !== 10) {

                phoneError.classList.remove('hidden');

                valid = false;

            } else {

                phoneError.classList.add('hidden');

            }


            // Stop submit

            if (!valid) {

                e.preventDefault();

            }

        });

    </script>

</body>

</html>