<?php

require_once '../includes/config.php';
require_once '../includes/functions.php';


/*
|--------------------------------------------------------------------------
| CHECK SESSION
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['user_score'])) {

    redirect('landing');
}


/*
|--------------------------------------------------------------------------
| USER DATA
|--------------------------------------------------------------------------
*/

$name = $_SESSION['user_name'];

$score = $_SESSION['user_score'];

$result_type = $_SESSION['result_type'];

$quiz_answers = $_SESSION['quiz_answers'] ?? '[]';


/*
|--------------------------------------------------------------------------
| CALCULATE PERCENTAGE
|--------------------------------------------------------------------------
*/

$total_questions = 13;

$max_score = $total_questions * 4;

$percentage = round(($score / $max_score) * 100);


/*
|--------------------------------------------------------------------------
| OPENAI AI REPORT
|--------------------------------------------------------------------------
*/

$prompt = "

User Name: {$name}

AI Score: {$percentage}%

Result Type: {$result_type}

Question & Answers JSON:

{$quiz_answers}

Analyze the user's:

- AI adaptability
- future mindset
- fear of change
- AI opportunity awareness
- learning mindset
- survivability in AI era

Generate:
- emotional
- personalized
- beginner friendly
- motivational
- realistic
- marketing focused report

Mention:
- future opportunity
- importance of AI skills
- AI adaptability
- encouragement to learn AI automation

Maximum 120 words.

Plain text only.

";

$data = [

    "model" => "gpt-4.1-mini",

    "messages" => [

        [
            "role" => "system",
            "content" =>
                "You are an AI future career coach."
        ],

        [
            "role" => "user",
            "content" => $prompt
        ]

    ],

    "temperature" => 0.8

];


$ch = curl_init();

curl_setopt(
    $ch,
    CURLOPT_URL,
    "https://api.openai.com/v1/chat/completions"
);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [

    "Content-Type: application/json",

    "Authorization: Bearer " . OPENAI_API_KEY

]);

curl_setopt(
    $ch,
    CURLOPT_POSTFIELDS,
    json_encode($data)
);

$response = curl_exec($ch);

curl_close($ch);

$responseData =
    json_decode($response, true);

$ai_report =
    $responseData['choices'][0]['message']['content']
    ?? "AI report unavailable right now.";

?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AI Future Survival Report</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">


    <style>

        *{
            font-family: 'Inter', sans-serif;
        }

        body{

            background:
            radial-gradient(circle at top left,#102347 0%,transparent 35%),
            radial-gradient(circle at bottom right,#1d1038 0%,transparent 35%),
            #050816;
        }

        .glass{

            background: rgba(255,255,255,0.05);

            backdrop-filter: blur(18px);

            border: 1px solid rgba(255,255,255,0.08);
        }

        .gradient-text{

            background: linear-gradient(to right,#67e8f9,#a78bfa);

            -webkit-background-clip: text;

            -webkit-text-fill-color: transparent;
        }

    </style>

</head>

<body class="text-white min-h-screen overflow-x-hidden">


<!-- BACKGROUND -->

<div class="fixed inset-0 overflow-hidden z-0">

    <div class="absolute top-0 left-0 w-[300px] h-[300px] bg-cyan-500/20 rounded-full blur-[100px]"></div>

    <div class="absolute bottom-0 right-0 w-[300px] h-[300px] bg-purple-500/20 rounded-full blur-[100px]"></div>

</div>



<!-- MAIN -->

<div class="relative z-10 max-w-5xl mx-auto px-4 py-8">


    <!-- HERO -->

    <div class="text-center">


        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-500/10 border border-red-500/20 text-red-300 text-xs font-black uppercase tracking-[3px]">

            ⚠️ AI FUTURE ANALYSIS

        </div>


        <h1 class="mt-5 text-4xl md:text-6xl font-black leading-tight">

            Your AI Future

            <span class="gradient-text">

                Survival Report

            </span>

        </h1>


        <p class="mt-5 text-base md:text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed">

            Discover how prepared you are
            for the AI revolution.

        </p>

    </div>





    <!-- MAIN GRID -->

    <div class="mt-10 grid lg:grid-cols-2 gap-6">


        <!-- LEFT -->

        <div class="glass rounded-[28px] p-5 md:p-7">


            <!-- SCORE -->

            <div class="text-center">


                <p class="uppercase tracking-[4px] text-xs text-gray-400">

                    AI SURVIVAL SCORE

                </p>


                <h2 class="mt-3 text-7xl md:text-8xl font-black text-cyan-300">

                    <?php echo $percentage; ?>%

                </h2>


                <div class="mt-4 inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 text-cyan-300 text-lg md:text-xl font-black text-center">

                    <?php echo htmlspecialchars($result_type); ?>

                </div>

            </div>



            <!-- ALERT -->

            <div class="mt-6 p-5 rounded-3xl bg-red-500/10 border border-red-500/20">


                <h3 class="text-lg font-black text-red-300">

                    ⚠️ Reality Check

                </h3>


                <p class="mt-3 text-gray-200 leading-relaxed text-sm md:text-base">

                    AI is changing jobs rapidly.
                    People who learn AI skills early may gain massive future opportunities.

                </p>

            </div>



            <!-- STATS -->

            <div class="mt-5 grid grid-cols-2 gap-4">


                <div class="glass rounded-2xl p-4 text-center">

                    <h3 class="text-3xl font-black text-cyan-300">

                        <?php echo $score; ?>

                    </h3>

                    <p class="mt-2 text-gray-400 text-sm">

                        Raw Score

                    </p>

                </div>


                <div class="glass rounded-2xl p-4 text-center">

                    <h3 class="text-3xl font-black text-cyan-300">

                        13

                    </h3>

                    <p class="mt-2 text-gray-400 text-sm">

                        Questions

                    </p>

                </div>

            </div>



            <!-- CTA -->

            <div class="mt-5 p-5 rounded-3xl bg-gradient-to-r from-green-500/10 to-cyan-500/10 border border-green-400/20">


                <h3 class="text-lg font-black">

                    🚀 Join Free AI Community

                </h3>


                <p class="mt-3 text-gray-300 leading-relaxed text-sm md:text-base">

                    Learn ChatGPT, AI automation,
                    prompting and future-ready skills FREE.

                </p>


                <a href="https://chat.whatsapp.com/CkuySalzbPjFUTJqJtNcvL"
                   target="_blank"
                   class="mt-5 inline-flex items-center justify-center w-full px-6 py-4 rounded-2xl bg-green-500 hover:bg-green-600 transition duration-300 text-base font-bold">

                    👥 Join WhatsApp Community

                </a>

            </div>

        </div>




        <!-- RIGHT -->

        <div class="glass rounded-[28px] p-5 md:p-7">


            <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-cyan-500/10 border border-cyan-400/20 text-cyan-300 text-sm font-bold">

                🤖 Personalized AI Report

            </div>


            <div class="mt-5 p-5 rounded-3xl bg-gradient-to-br from-cyan-500/10 to-purple-500/10 border border-white/10">


                <p class="text-base md:text-lg leading-[2] text-gray-100">

                    <?php echo nl2br(htmlspecialchars($ai_report)); ?>

                </p>

            </div>



            <!-- INSIGHTS -->

            <div class="mt-5 grid gap-4">


                <div class="glass rounded-2xl p-5">

                    <h3 class="text-lg font-black text-cyan-300">

                        ⚡ AI Skills = Future Skills

                    </h3>

                    <p class="mt-2 text-gray-300 leading-relaxed text-sm md:text-base">

                        AI productivity is becoming more valuable than traditional degrees.

                    </p>

                </div>



                <div class="glass rounded-2xl p-5">

                    <h3 class="text-lg font-black text-cyan-300">

                        🚀 Early Learners Win

                    </h3>

                    <p class="mt-2 text-gray-300 leading-relaxed text-sm md:text-base">

                        People who start learning AI now may dominate future opportunities.

                    </p>

                </div>

            </div>

        </div>

    </div>





    <!-- SHARE SECTION -->

    <div class="mt-16">


        <div class="text-center">

            <h2 class="text-3xl md:text-5xl font-black leading-tight">

                🚀 Share Your AI Score

            </h2>

            <p class="mt-4 text-base md:text-lg text-gray-400 max-w-xl mx-auto">

                Challenge your friends and compare AI readiness.

            </p>

        </div>



        <!-- VIRAL CARD -->

        <div class="mt-10 flex justify-center">


            <div

                id="shareCard"

                class="relative overflow-hidden
                       w-full max-w-[340px]
                       rounded-[28px]
                       border border-cyan-500/20
                       bg-[#071120]
                       shadow-2xl">


                <!-- BG -->

                <div class="absolute inset-0">


                    <div
                        class="absolute -top-16 -left-16
                               w-40 h-40
                               bg-cyan-500/20
                               rounded-full blur-3xl">
                    </div>


                    <div
                        class="absolute -bottom-16 -right-16
                               w-40 h-40
                               bg-purple-500/20
                               rounded-full blur-3xl">
                    </div>

                </div>



                <!-- CONTENT -->

                <div class="relative z-10 p-4">


                    <!-- TOP -->

                    <div class="flex items-center justify-between gap-2">


                        <div
                            class="px-3 py-1 rounded-full
                                   bg-red-500/10
                                   border border-red-500/20
                                   text-red-300
                                   text-[8px]
                                   font-black
                                   uppercase tracking-[2px]">

                            AI ANALYSIS

                        </div>


                        <div
                            class="px-3 py-1 rounded-full
                                   bg-white/5
                                   border border-white/10
                                   text-gray-300
                                   text-[8px]
                                   font-bold">

                            🔥 Viral Test

                        </div>

                    </div>



                    <!-- HOOK -->

                    <div class="mt-4 text-center">


                        <h2
                            class="text-lg leading-tight
                                   font-black text-white">

                            ⚠️ Most People
                            Are Not Ready
                            For AI Future

                        </h2>

                    </div>



                    <!-- PROFILE -->

                    <div class="mt-4 flex justify-center">


                        <div
                            class="w-14 h-14 rounded-2xl
                                   bg-cyan-500/15
                                   border border-cyan-400/20
                                   flex items-center justify-center
                                   text-2xl">

                            👤

                        </div>

                    </div>



                    <!-- NAME -->

                    <div class="mt-3 text-center">


                        <h3
                            class="text-lg
                                   font-black text-white
                                   break-words leading-tight">

                            <?php echo htmlspecialchars($name); ?>

                        </h3>


                        <p
                            class="mt-1 text-[9px]
                                   uppercase tracking-[3px]
                                   text-gray-400">

                            AI Survival Score

                        </p>

                    </div>



                    <!-- SCORE -->

                    <div class="mt-4 text-center">


                        <h1
                            class="text-5xl md:text-6xl
                                   leading-none
                                   font-black
                                   text-cyan-300">

                            <?php echo $percentage; ?>%

                        </h1>


                        <div
                            class="mt-2 inline-flex
                                   items-center justify-center
                                   px-4 py-1.5 rounded-xl
                                   bg-cyan-500/15
                                   border border-cyan-400/20
                                   text-cyan-300
                                   text-xs font-black">

                            <?php echo htmlspecialchars($result_type); ?>

                        </div>

                    </div>

                    <!-- PROGRESS -->

                    <div class="mt-4">


                        <div
                            class="flex justify-between
                                   text-[9px]
                                   text-gray-400 mb-2">

                            <span>AI Adaptability</span>

                            <span><?php echo $percentage; ?>%</span>

                        </div>


                        <div
                            class="w-full h-2.5 rounded-full
                                   bg-white/10 overflow-hidden">


                            <div

                                class="h-full rounded-full
                                       bg-gradient-to-r
                                       from-cyan-400 to-blue-500"

                                style="width: <?php echo $percentage; ?>%;">

                            </div>

                        </div>

                    </div>



                    <!-- CTA -->

                    <div
                        class="mt-4 p-3 rounded-2xl
                               bg-red-500/10
                               border border-red-500/20
                               text-center">


                        <p
                            class="text-xs
                                   font-bold
                                   text-red-200
                                   leading-relaxed">

                            🚀 Take the test now and
                            compare your AI survival score
                            with your friends.

                        </p>

                    </div>



                    



                    <!-- FOOTER -->

                    <div class="mt-4 text-center">


                        <p
                            class="text-xs font-bold
                                   text-white leading-relaxed">

                            🔥 Are YOU Ready For AI?

                        </p>


                        <p
                            class="mt-2 text-[9px]
                                   uppercase tracking-[3px]
                                   text-gray-500">

                            TAKE THE TEST

                        </p>


                        <h3
                            class="mt-1 text-xs
                                   font-black text-cyan-300
                                   break-all">

                            <?php echo SITE_URL; ?>

                        </h3>

                    </div>

                </div>

            </div>

        </div>



        <!-- DOWNLOAD BUTTON -->

        <div class="mt-8 flex justify-center">


            <button
                onclick="downloadCard(event)"

                class="w-full max-w-sm
                       px-6 py-4 rounded-2xl
                       bg-gradient-to-r
                       from-cyan-500 to-purple-600
                       hover:scale-[1.02]
                       transition duration-300
                       text-base font-bold
                       shadow-2xl shadow-cyan-500/30">

                📥 Download Score Card

            </button>

        </div>

    </div>

</div>





<!-- html2canvas -->

<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>


<script>

async function downloadCard(event) {

    const button = event.target;

    const originalText = button.innerHTML;

    button.innerHTML = '⏳ Generating...';

    button.disabled = true;

    try {

        const card =
            document.getElementById('shareCard');

        if (!card) {

            alert('Card not found');

            return;
        }

        await document.fonts.ready;

        await new Promise(resolve =>
            setTimeout(resolve, 500)
        );

        const canvas = await html2canvas(card, {

            scale: 2,

            useCORS: true,

            allowTaint: true,

            backgroundColor: '#071120',

            logging: false

        });

        const image =
            canvas.toDataURL('image/png');

        const link =
            document.createElement('a');

        link.href = image;

        link.download =
            'ai-survival-score.png';

        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);

        button.innerHTML = '✅ Downloaded';

        setTimeout(() => {

            button.innerHTML = originalText;

            button.disabled = false;

        }, 2000);

    }

    catch (error) {

        console.error(error);

        alert('Failed to generate image');

        button.innerHTML = originalText;

        button.disabled = false;

    }

}

</script>

</body>

</html>