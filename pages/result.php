<?php

require_once '../includes/config.php';
require_once '../includes/functions.php';


/*
|--------------------------------------------------------------------------
| GET SCORE
|--------------------------------------------------------------------------
*/

$score = 0;

if (isset($_GET['score'])) {

    $score = (int) $_GET['score'];

} else {

    ?>

    <script>

        let score = sessionStorage.getItem('quiz_score') || 0;

        window.location.href = "result?score=" + score;

    </script>

    <?php

    exit;
}


/*
|--------------------------------------------------------------------------
| RESULT
|--------------------------------------------------------------------------
*/

$result_type = getResultCategory($score);

$analysis = getPersonalAnalysis($score);

?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AI Result</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#050816] text-white min-h-screen overflow-x-hidden">


    <!-- Background Glow -->

    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">

        <div class="absolute w-72 h-72 bg-cyan-500 opacity-20 blur-3xl rounded-full top-10 left-10"></div>

        <div class="absolute w-72 h-72 bg-purple-500 opacity-20 blur-3xl rounded-full bottom-10 right-10"></div>

    </div>


    <!-- Main -->

    <div class="relative z-10 max-w-3xl mx-auto px-5 py-10">


        <!-- Result Card -->

        <div class="bg-white/5 border border-white/10 rounded-3xl p-8 backdrop-blur-xl shadow-2xl">


            <!-- Heading -->

            <div class="text-center">

                <h1 class="text-4xl font-extrabold">

                    🤖 Your AI Readiness Score

                </h1>

                <p class="text-gray-400 mt-4">

                    Discover how prepared you are for the AI-powered future.

                </p>

            </div>


            <!-- Score Circle -->

            <div class="mt-10 flex justify-center">

                <div
                    class="w-48 h-48 rounded-full border-[10px]
                           border-cyan-400 flex items-center justify-center
                           bg-cyan-500/10 shadow-2xl shadow-cyan-500/20">

                    <div class="text-center">

                        <?php

$max_score = 52;

$percentage = round(($score / $max_score) * 100);

?>

<h2 class="text-5xl font-extrabold">

    <?php echo $percentage; ?>%

</h2>

<p class="text-gray-300 mt-2">

    <?php echo $score; ?> / <?php echo $max_score; ?>

</p>

                    </div>

                </div>

            </div>


            <!-- Result Type -->

            <div class="mt-8 text-center">

                <h2 class="text-3xl font-bold text-cyan-300">

                    <?php echo $result_type; ?>

                </h2>

                <p class="mt-4 text-gray-300 text-lg leading-relaxed">

                    <?php echo $analysis; ?>

                </p>

            </div>


            <!-- Locked Full Report -->

            <div
                class="mt-12 bg-white/5 border border-white/10 rounded-3xl p-6 relative overflow-hidden">


                <!-- Blur Layer -->

                <div class="absolute inset-0 backdrop-blur-md bg-black/40 z-10"></div>


                <!-- Fake Content -->

                <div class="space-y-5">

                    <div class="p-5 rounded-2xl bg-white/5">

                        🔒 AI Career Risk Analysis

                    </div>

                    <div class="p-5 rounded-2xl bg-white/5">

                        🔒 Best AI Skill To Learn

                    </div>

                    <div class="p-5 rounded-2xl bg-white/5">

                        🔒 AI Growth Roadmap

                    </div>

                    <div class="p-5 rounded-2xl bg-white/5">

                        🔒 Future Career Recommendation

                    </div>

                </div>


                <!-- Unlock Overlay -->

                <div
                    class="absolute inset-0 z-20 flex flex-col justify-center items-center text-center px-6">

                    <h3 class="text-3xl font-bold">

                        🔓 Unlock Your Full AI Report

                    </h3>

                    <p class="mt-4 text-gray-300 max-w-xl">

                        Get your complete AI career analysis, future risk score,
                        skill roadmap, and personalized recommendations.

                    </p>


                    <!-- CTA -->

                    <a href="unlock?score=<?php echo $score; ?>"
                        class="mt-8 px-8 py-4 rounded-2xl
                               bg-gradient-to-r from-cyan-500 to-purple-600
                               hover:scale-105 transition duration-300
                               text-lg font-semibold shadow-2xl shadow-cyan-500/30">

                        Unlock Full Report

                    </a>

                </div>

            </div>


            <!-- Footer Text -->

            <div class="mt-10 text-center">

                <p class="text-gray-500 text-sm">

                    AI is changing careers faster than ever.
                    Stay ahead before it’s too late.

                </p>

            </div>


        </div>

    </div>

</body>

</html>