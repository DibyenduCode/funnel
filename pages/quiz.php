<?php

require_once '../includes/config.php';
require_once '../includes/db.php';


/*
|--------------------------------------------------------------------------
| GET QUESTIONS
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("SELECT * FROM questions ORDER BY id ASC");

$stmt->execute();

$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_questions = count($questions);

?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AI Quiz</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#050816] text-white min-h-screen overflow-x-hidden">


    <!-- Background -->

    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">

        <div class="absolute w-72 h-72 bg-cyan-500 opacity-20 blur-3xl rounded-full top-10 left-10"></div>

        <div class="absolute w-72 h-72 bg-purple-500 opacity-20 blur-3xl rounded-full bottom-10 right-10"></div>

    </div>


    <!-- Main -->

    <div class="relative z-10 max-w-2xl mx-auto px-5 py-10">


        <!-- Progress -->

        <div class="mb-8">

            <div class="flex justify-between mb-2 text-sm text-gray-300">

                <span>Progress</span>

                <span id="progress-text">1 / <?php echo $total_questions; ?></span>

            </div>

            <div class="w-full h-3 bg-white/10 rounded-full overflow-hidden">

                <div id="progress-bar"
                    class="h-full bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full transition-all duration-500"
                    style="width: 20%;"></div>

            </div>

        </div>


        <!-- Quiz Card -->

        <div id="quiz-card"
            class="bg-white/5 border border-white/10 backdrop-blur-xl rounded-3xl p-6 shadow-2xl">


            <?php foreach ($questions as $index => $question): ?>


                <?php

                $question_text = $_SESSION['lang'] == 'bn'
                    ? $question['question_bn']
                    : $question['question_en'];

                ?>


                <div class="question-slide <?php echo $index == 0 ? '' : 'hidden'; ?>"
                    data-question="<?php echo $index + 1; ?>">

                    <!-- Question -->

                    <h2 class="text-2xl md:text-3xl font-bold leading-relaxed">

                        <?php echo $question_text; ?>

                    </h2>


                    <!-- Options -->

                    <div class="mt-8 space-y-4">


                        <?php

                        $option_stmt = $pdo->prepare("
                            SELECT * FROM options
                            WHERE question_id = ?
                        ");

                        $option_stmt->execute([$question['id']]);

                        $options = $option_stmt->fetchAll(PDO::FETCH_ASSOC);

                        ?>


                        <?php foreach ($options as $option): ?>


                            <?php

                            $option_text = $_SESSION['lang'] == 'bn'
                                ? $option['option_bn']
                                : $option['option_en'];

                            ?>


                            <button
                                class="option-btn w-full text-left px-5 py-4 rounded-2xl
                                       bg-white/5 hover:bg-cyan-500/20 border border-white/10
                                       hover:border-cyan-400 transition duration-300"

                                data-score="<?php echo $option['score']; ?>">

                                <?php echo $option_text; ?>

                            </button>


                        <?php endforeach; ?>


                    </div>

                </div>


            <?php endforeach; ?>


        </div>

    </div>


<script>

    let currentQuestion = 0;

    let totalQuestions = <?php echo $total_questions; ?>;


    /*
    |--------------------------------------------------------------------------
    | STORE ANSWERS
    |--------------------------------------------------------------------------
    */

    let answers = [];

    let answerData = [];


    /*
    |--------------------------------------------------------------------------
    | ELEMENTS
    |--------------------------------------------------------------------------
    */

    const questionSlides =
        document.querySelectorAll('.question-slide');

    const progressBar =
        document.getElementById('progress-bar');

    const progressText =
        document.getElementById('progress-text');



    /*
    |--------------------------------------------------------------------------
    | OPTION CLICK
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.option-btn').forEach(button => {

        button.addEventListener('click', function() {


            /*
            |--------------------------------------------------------------------------
            | PREVENT MULTIPLE CLICKS
            |--------------------------------------------------------------------------
            */

            if (this.classList.contains('selected')) {

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | DISABLE ALL OPTIONS
            |--------------------------------------------------------------------------
            */

            questionSlides[currentQuestion]
                .querySelectorAll('.option-btn')
                .forEach(btn => {

                    btn.disabled = true;

                    btn.classList.remove(
                        'bg-cyan-500/20',
                        'border-cyan-400'
                    );
                });


            /*
            |--------------------------------------------------------------------------
            | SELECT STYLE
            |--------------------------------------------------------------------------
            */

            this.classList.add(
                'selected',
                'bg-cyan-500/20',
                'border-cyan-400'
            );


            /*
            |--------------------------------------------------------------------------
            | GET SCORE
            |--------------------------------------------------------------------------
            */

            let score = parseInt(this.dataset.score);


            /*
            |--------------------------------------------------------------------------
            | SAVE SCORE
            |--------------------------------------------------------------------------
            */

            answers[currentQuestion] = score;


            /*
            |--------------------------------------------------------------------------
            | SAVE FULL ANSWER DATA
            |--------------------------------------------------------------------------
            */

            const questionText =
                questionSlides[currentQuestion]
                .querySelector('h2')
                .innerText;

            const answerText =
                this.innerText.trim();


            answerData.push({

                question: questionText,

                answer: answerText,

                point: score

            });


            /*
            |--------------------------------------------------------------------------
            | SMALL DELAY
            |--------------------------------------------------------------------------
            */

            setTimeout(() => {


                /*
                |--------------------------------------------------------------------------
                | HIDE CURRENT
                |--------------------------------------------------------------------------
                */

                questionSlides[currentQuestion]
                    .classList.add('hidden');


                currentQuestion++;


                /*
                |--------------------------------------------------------------------------
                | NEXT QUESTION
                |--------------------------------------------------------------------------
                */

                if (currentQuestion < totalQuestions) {

                    questionSlides[currentQuestion]
                        .classList.remove('hidden');


                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE PROGRESS
                    |--------------------------------------------------------------------------
                    */

                    let progress =
                        ((currentQuestion + 1) / totalQuestions) * 100;

                    progressBar.style.width =
                        progress + '%';

                    progressText.innerText =
                        `${currentQuestion + 1} / ${totalQuestions}`;

                } else {


                    /*
                    |--------------------------------------------------------------------------
                    | FINAL SCORE
                    |--------------------------------------------------------------------------
                    */

                    let finalScore =
                        answers.reduce((a, b) => a + b, 0);


                    /*
                    |--------------------------------------------------------------------------
                    | SAVE FINAL SCORE
                    |--------------------------------------------------------------------------
                    */

                    sessionStorage.setItem(
                        'quiz_score',
                        finalScore
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | SAVE ANSWER JSON
                    |--------------------------------------------------------------------------
                    */

                    sessionStorage.setItem(
                        'quiz_answers',
                        JSON.stringify(answerData)
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | REDIRECT
                    |--------------------------------------------------------------------------
                    */

                    window.location.href = 'result';

                }

            }, 300);

        });

    });

</script>
    

</body>

</html>