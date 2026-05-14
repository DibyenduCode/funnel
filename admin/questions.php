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
| DELETE QUESTION
|--------------------------------------------------------------------------
*/

if (isset($_GET['delete'])) {

    $delete_id = (int) $_GET['delete'];


    /*
    |--------------------------------------------------------------------------
    | DELETE OPTIONS FIRST
    |--------------------------------------------------------------------------
    */

    $delete_options = $pdo->prepare("
        DELETE FROM options
        WHERE question_id = ?
    ");

    $delete_options->execute([$delete_id]);


    /*
    |--------------------------------------------------------------------------
    | DELETE QUESTION
    |--------------------------------------------------------------------------
    */

    $delete_question = $pdo->prepare("
        DELETE FROM questions
        WHERE id = ?
    ");

    $delete_question->execute([$delete_id]);


    header('Location: questions.php');

    exit;
}


/*
|--------------------------------------------------------------------------
| ADD QUESTION
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $question_en = trim($_POST['question_en']);

    $question_bn = trim($_POST['question_bn']);


    /*
    |--------------------------------------------------------------------------
    | INSERT QUESTION
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO questions
        (
            question_en,
            question_bn
        )

        VALUES
        (
            ?,
            ?
        )
    ");

    $stmt->execute([
        $question_en,
        $question_bn
    ]);


    $question_id = $pdo->lastInsertId();


    /*
    |--------------------------------------------------------------------------
    | INSERT OPTIONS
    |--------------------------------------------------------------------------
    */

    for ($i = 1; $i <= 4; $i++) {

        $option_en = trim($_POST['option_en_' . $i]);

        $option_bn = trim($_POST['option_bn_' . $i]);

        $score = (int) $_POST['score_' . $i];


        $option_stmt = $pdo->prepare("
            INSERT INTO options
            (
                question_id,
                option_en,
                option_bn,
                score
            )

            VALUES
            (
                ?,
                ?,
                ?,
                ?
            )
        ");


        $option_stmt->execute([
            $question_id,
            $option_en,
            $option_bn,
            $score
        ]);
    }


    header('Location: questions.php');

    exit;
}


/*
|--------------------------------------------------------------------------
| GET QUESTIONS
|--------------------------------------------------------------------------
*/

$questions_stmt = $pdo->query("
    SELECT *
    FROM questions
    ORDER BY id DESC
");

$questions = $questions_stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Question Management</title>

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


            <!-- Logo -->

            <div>

                <h1 class="text-3xl font-extrabold">

                    🧠 Question Management

                </h1>

                <p class="text-gray-400 mt-1">

                    Manage your AI quiz questions and options

                </p>

            </div>


            <!-- Actions -->

            <div class="flex gap-3 flex-wrap">


                <a href="dashboard.php"

                    class="px-5 py-3 rounded-2xl
                           bg-white/10 hover:bg-white/20 transition">

                    Dashboard

                </a>


                <a href="logout.php"

                    class="px-5 py-3 rounded-2xl
                           bg-red-500/20 hover:bg-red-500/30
                           border border-red-400/20 transition">

                    Logout

                </a>

            </div>

        </div>

    </div>


    <!-- Main -->

    <div class="relative z-10 max-w-7xl mx-auto px-5 py-10">


        <!-- Add Question Card -->

        <div
            class="bg-white/5 border border-white/10
                   rounded-3xl p-8 backdrop-blur-xl shadow-2xl">


            <!-- Heading -->

            <div class="mb-8">

                <h2 class="text-3xl font-bold">

                    ➕ Add New Question

                </h2>

                <p class="mt-2 text-gray-400">

                    Add bilingual questions with scoring options.

                </p>

            </div>


            <!-- Form -->

            <form method="POST" class="space-y-6">


                <!-- Question English -->

                <div>

                    <label class="block mb-3 text-gray-300 font-semibold">

                        Question (English)

                    </label>

                    <textarea
                        name="question_en"
                        required

                        rows="3"

                        class="w-full px-5 py-4 rounded-2xl
                               bg-white/5 border border-white/10
                               focus:border-cyan-400 focus:outline-none
                               text-white resize-none"></textarea>

                </div>


                <!-- Question Bengali -->

                <div>

                    <label class="block mb-3 text-gray-300 font-semibold">

                        Question (Bengali)

                    </label>

                    <textarea
                        name="question_bn"
                        required

                        rows="3"

                        class="w-full px-5 py-4 rounded-2xl
                               bg-white/5 border border-white/10
                               focus:border-cyan-400 focus:outline-none
                               text-white resize-none"></textarea>

                </div>


                <!-- Options -->

                <div class="space-y-5">


                    <h3 class="text-2xl font-bold text-cyan-300">

                        Options & Scores

                    </h3>


                    <?php for ($i = 1; $i <= 4; $i++): ?>


                        <div
                            class="grid lg:grid-cols-12 gap-4
                                   bg-white/5 border border-white/10
                                   rounded-2xl p-5">


                            <!-- Option Number -->

                            <div class="lg:col-span-1 flex items-center">

                                <div
                                    class="w-10 h-10 rounded-full
                                           bg-cyan-500/20 border border-cyan-400/20
                                           flex items-center justify-center
                                           text-cyan-300 font-bold">

                                    <?php echo $i; ?>

                                </div>

                            </div>


                            <!-- English -->

                            <div class="lg:col-span-5">

                                <label class="block mb-2 text-sm text-gray-400">

                                    English Option

                                </label>

                                <input
                                    type="text"
                                    name="option_en_<?php echo $i; ?>"
                                    required

                                    class="w-full px-5 py-4 rounded-2xl
                                           bg-white/5 border border-white/10
                                           focus:border-cyan-400 focus:outline-none
                                           text-white">

                            </div>


                            <!-- Bengali -->

                            <div class="lg:col-span-5">

                                <label class="block mb-2 text-sm text-gray-400">

                                    Bengali Option

                                </label>

                                <input
                                    type="text"
                                    name="option_bn_<?php echo $i; ?>"
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
                                    name="score_<?php echo $i; ?>"
                                    required

                                    class="w-full px-4 py-4 rounded-2xl
                                           bg-white/5 border border-white/10
                                           focus:border-cyan-400 focus:outline-none
                                           text-white">

                            </div>

                        </div>


                    <?php endfor; ?>


                </div>


                <!-- Submit -->

                <button
                    type="submit"

                    class="w-full py-5 rounded-2xl
                           bg-gradient-to-r from-cyan-500 to-purple-600
                           hover:scale-[1.01] transition duration-300
                           text-lg font-semibold shadow-2xl shadow-cyan-500/30">

                    🚀 Add Question

                </button>

            </form>

        </div>


        <!-- Existing Questions -->

        <div class="mt-12">


            <!-- Header -->

            <div class="flex items-center justify-between mb-8">


                <div>

                    <h2 class="text-3xl font-bold">

                        📚 Existing Questions

                    </h2>

                    <p class="mt-2 text-gray-400">

                        Edit or delete quiz questions.

                    </p>

                </div>


                <div
                    class="px-5 py-3 rounded-2xl
                           bg-white/5 border border-white/10">

                    Total:
                    <span class="text-cyan-300 font-bold">

                        <?php echo count($questions); ?>

                    </span>

                </div>

            </div>


            <!-- Question List -->

            <div class="space-y-8">


                <?php foreach ($questions as $index => $question): ?>


                    <div
                        class="bg-white/5 border border-white/10
                               rounded-3xl p-8 backdrop-blur-xl shadow-xl">


                        <!-- Top -->

                        <div
                            class="flex flex-col lg:flex-row
                                   justify-between gap-6">


                            <!-- Question -->

                            <div class="flex-1">


                                <div
                                    class="inline-flex items-center px-4 py-2 rounded-full
                                           bg-cyan-500/20 border border-cyan-400/20
                                           text-cyan-300 text-sm font-semibold">

                                    Question #<?php echo $index + 1; ?>
                                </div>


                                <h3 class="mt-5 text-2xl font-bold leading-relaxed">

                                    <?php echo htmlspecialchars($question['question_en']); ?>

                                </h3>


                                <p class="mt-3 text-gray-400 text-lg leading-relaxed">

                                    <?php echo htmlspecialchars($question['question_bn']); ?>

                                </p>

                            </div>


                            <!-- Actions -->

                            <div class="flex gap-3 h-fit flex-wrap">


                                <!-- Edit -->

                                <a
                                    href="edit-question.php?id=<?php echo $question['id']; ?>"

                                    class="px-5 py-3 rounded-2xl
                                           bg-cyan-500/20 hover:bg-cyan-500/30
                                           border border-cyan-400/20 transition">

                                    ✏ Edit

                                </a>


                                <!-- Delete -->

                                <a
                                    href="?delete=<?php echo $question['id']; ?>"

                                    onclick="return confirm('Delete this question?')"

                                    class="px-5 py-3 rounded-2xl
                                           bg-red-500/20 hover:bg-red-500/30
                                           border border-red-400/20 transition">

                                    🗑 Delete

                                </a>

                            </div>

                        </div>


                        <!-- Options -->

                        <div class="mt-8 grid md:grid-cols-2 gap-5">


                            <?php

                            $options_stmt = $pdo->prepare("
                                SELECT *
                                FROM options
                                WHERE question_id = ?
                            ");

                            $options_stmt->execute([$question['id']]);

                            $options = $options_stmt->fetchAll(PDO::FETCH_ASSOC);

                            ?>


                            <?php foreach ($options as $option): ?>


                                <div
                                    class="bg-white/5 border border-white/10
                                           rounded-2xl p-5">


                                    <!-- EN -->

                                    <div class="flex justify-between gap-4">

                                        <p class="font-semibold leading-relaxed">

                                            <?php echo htmlspecialchars($option['option_en']); ?>

                                        </p>


                                        <div
                                            class="px-3 py-2 rounded-xl
                                                   bg-cyan-500/20 border border-cyan-400/20
                                                   text-cyan-300 font-bold h-fit">

                                            <?php echo $option['score']; ?>

                                        </div>

                                    </div>


                                    <!-- BN -->

                                    <p class="mt-3 text-gray-400">

                                        <?php echo htmlspecialchars($option['option_bn']); ?>

                                    </p>

                                </div>


                            <?php endforeach; ?>


                        </div>

                    </div>


                <?php endforeach; ?>


            </div>

        </div>

    </div>

</body>

</html>