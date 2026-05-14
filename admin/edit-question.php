<?php

require_once '../includes/config.php';
require_once '../includes/db.php';


/*
|--------------------------------------------------------------------------
| AUTH CHECK
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['admin_logged_in'])) {

    header('Location: login.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| GET ID
|--------------------------------------------------------------------------
*/

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {

    header('Location: questions.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| GET QUESTION
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM questions
    WHERE id = ?
");

$stmt->execute([$id]);

$question = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$question) {

    header('Location: questions.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| GET OPTIONS
|--------------------------------------------------------------------------
*/

$options_stmt = $pdo->prepare("
    SELECT *
    FROM options
    WHERE question_id = ?
    ORDER BY id ASC
");

$options_stmt->execute([$id]);

$options = $options_stmt->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| UPDATE QUESTION
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $question_en = trim($_POST['question_en']);

    $question_bn = trim($_POST['question_bn']);


    /*
    |--------------------------------------------------------------------------
    | UPDATE QUESTION
    |--------------------------------------------------------------------------
    */

    $update_stmt = $pdo->prepare("
        UPDATE questions

        SET
            question_en = ?,
            question_bn = ?

        WHERE id = ?
    ");

    $update_stmt->execute([
        $question_en,
        $question_bn,
        $id
    ]);


    /*
    |--------------------------------------------------------------------------
    | UPDATE OPTIONS
    |--------------------------------------------------------------------------
    */

    foreach ($options as $option) {

        $option_en = trim($_POST['option_en'][$option['id']]);

        $option_bn = trim($_POST['option_bn'][$option['id']]);

        $score = (int) $_POST['score'][$option['id']];


        $option_update = $pdo->prepare("
            UPDATE options

            SET
                option_en = ?,
                option_bn = ?,
                score = ?

            WHERE id = ?
        ");

        $option_update->execute([
            $option_en,
            $option_bn,
            $score,
            $option['id']
        ]);
    }


    header('Location: questions.php');

    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Question</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#050816] text-white min-h-screen overflow-x-hidden">


    <!-- Glow -->

    <div class="fixed inset-0 overflow-hidden z-0">

        <div class="absolute w-96 h-96 bg-cyan-500 opacity-10 blur-3xl rounded-full top-0 left-0"></div>

        <div class="absolute w-96 h-96 bg-purple-500 opacity-10 blur-3xl rounded-full bottom-0 right-0"></div>

    </div>


    <!-- Topbar -->

    <div
        class="sticky top-0 z-50 border-b border-white/10
               bg-black/30 backdrop-blur-xl">


        <div
            class="max-w-7xl mx-auto px-5 py-4 flex items-center justify-between">


            <!-- Left -->

            <div>

                <h1 class="text-3xl font-extrabold">

                    ✏ Edit Question

                </h1>

                <p class="text-gray-400 mt-1">

                    Update question, options and scoring

                </p>

            </div>


            <!-- Right -->

            <div class="flex gap-3">


                <a href="questions.php"

                    class="px-5 py-3 rounded-2xl
                           bg-white/10 hover:bg-white/20 transition">

                    Questions

                </a>


                <a href="dashboard.php"

                    class="px-5 py-3 rounded-2xl
                           bg-cyan-500/20 hover:bg-cyan-500/30
                           border border-cyan-400/20 transition">

                    Dashboard

                </a>

            </div>

        </div>

    </div>


    <!-- Main -->

    <div class="relative z-10 max-w-7xl mx-auto px-5 py-10">


        <!-- Main Card -->

        <div
            class="bg-white/5 border border-white/10
                   rounded-3xl p-8 backdrop-blur-xl shadow-2xl">


            <!-- Header -->

            <div class="mb-8">

                <div
                    class="inline-flex items-center px-4 py-2 rounded-full
                           bg-cyan-500/20 border border-cyan-400/20
                           text-cyan-300 text-sm font-semibold">

                    Editing Question
                </div>


                <h2 class="mt-5 text-3xl font-bold">

                    Update Quiz Content

                </h2>

            </div>


            <!-- Form -->

            <form method="POST" class="space-y-6">


                <!-- Question EN -->

                <div>

                    <label class="block mb-3 text-gray-300 font-semibold">

                        Question (English)

                    </label>

                    <textarea
                        name="question_en"
                        rows="3"
                        required

                        class="w-full px-5 py-4 rounded-2xl
                               bg-white/5 border border-white/10
                               focus:border-cyan-400 focus:outline-none
                               text-white resize-none"><?php echo htmlspecialchars($question['question_en']); ?></textarea>

                </div>


                <!-- Question BN -->

                <div>

                    <label class="block mb-3 text-gray-300 font-semibold">

                        Question (Bengali)

                    </label>

                    <textarea
                        name="question_bn"
                        rows="3"
                        required

                        class="w-full px-5 py-4 rounded-2xl
                               bg-white/5 border border-white/10
                               focus:border-cyan-400 focus:outline-none
                               text-white resize-none"><?php echo htmlspecialchars($question['question_bn']); ?></textarea>

                </div>


                <!-- Options -->

                <div class="space-y-5">


                    <h3 class="text-2xl font-bold text-cyan-300">

                        Options & Scores

                    </h3>


                    <?php foreach ($options as $index => $option): ?>


                        <div
                            class="grid lg:grid-cols-12 gap-4
                                   bg-white/5 border border-white/10
                                   rounded-2xl p-5">


                            <!-- Number -->

                            <div class="lg:col-span-1 flex items-center">

                                <div
                                    class="w-10 h-10 rounded-full
                                           bg-cyan-500/20 border border-cyan-400/20
                                           flex items-center justify-center
                                           text-cyan-300 font-bold">

                                    <?php echo $index + 1; ?>

                                </div>

                            </div>


                            <!-- EN -->

                            <div class="lg:col-span-5">

                                <label class="block mb-2 text-sm text-gray-400">

                                    English Option

                                </label>

                                <input
                                    type="text"
                                    name="option_en[<?php echo $option['id']; ?>]"
                                    value="<?php echo htmlspecialchars($option['option_en']); ?>"
                                    required

                                    class="w-full px-5 py-4 rounded-2xl
                                           bg-white/5 border border-white/10
                                           focus:border-cyan-400 focus:outline-none
                                           text-white">

                            </div>


                            <!-- BN -->

                            <div class="lg:col-span-5">

                                <label class="block mb-2 text-sm text-gray-400">

                                    Bengali Option

                                </label>

                                <input
                                    type="text"
                                    name="option_bn[<?php echo $option['id']; ?>]"
                                    value="<?php echo htmlspecialchars($option['option_bn']); ?>"
                                    required

                                    class="w-full px-5 py-4 rounded-2xl
                                           bg-white/5 border border-white/10
                                           focus:border-cyan-400 focus:outline-none
                                           text-white">

                            </div>


                            <!-- Score -->

                            <div class="lg:col-span-1">

                                <label class="block mb-2 text-sm text-gray-400">

                                    Score

                                </label>

                                <input
                                    type="number"
                                    name="score[<?php echo $option['id']; ?>]"
                                    value="<?php echo $option['score']; ?>"
                                    required

                                    class="w-full px-4 py-4 rounded-2xl
                                           bg-white/5 border border-white/10
                                           focus:border-cyan-400 focus:outline-none
                                           text-white">

                            </div>

                        </div>


                    <?php endforeach; ?>


                </div>


                <!-- Submit -->

                <button
                    type="submit"

                    class="w-full py-5 rounded-2xl
                           bg-gradient-to-r from-cyan-500 to-purple-600
                           hover:scale-[1.01] transition duration-300
                           text-lg font-semibold shadow-2xl shadow-cyan-500/30">

                    🚀 Update Question

                </button>

            </form>

        </div>

    </div>

</body>

</html>