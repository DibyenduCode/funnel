<?php

require_once '../includes/config.php';

?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AI Readiness Test</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#050816] text-white overflow-x-hidden">


    <!-- Background Glow -->

    <div class="fixed inset-0 overflow-hidden z-0">

        <div class="absolute w-[400px] h-[400px] bg-cyan-500/20 blur-[120px] rounded-full -top-32 -left-32"></div>

        <div class="absolute w-[400px] h-[400px] bg-purple-500/20 blur-[120px] rounded-full -bottom-32 -right-32"></div>

    </div>


    <!-- Language Switch -->

    <div class="fixed top-5 right-5 z-50 flex gap-2">

        <a href="?lang=en"
            class="px-4 py-2 rounded-xl
                   bg-white/10 hover:bg-white/20
                   transition backdrop-blur-xl
                   border border-white/10 text-sm">

            <?php echo $lang['english']; ?>

        </a>

        <a href="?lang=bn"
            class="px-4 py-2 rounded-xl
                   bg-white/10 hover:bg-white/20
                   transition backdrop-blur-xl
                   border border-white/10 text-sm">

            <?php echo $lang['bengali']; ?>

        </a>

    </div>


    <!-- HERO -->

    <section class="relative z-10 min-h-screen flex items-center">


        <div class="max-w-7xl mx-auto px-5 py-24 w-full">


            <div class="grid lg:grid-cols-2 gap-16 items-center">


                <!-- LEFT -->

                <div class="flex flex-col items-center lg:items-start text-center lg:text-left">


                    <!-- Badge -->

                    <div
                        class="inline-flex items-center gap-3
                               px-5 py-3 rounded-full
                               border border-cyan-400/20
                               bg-cyan-500/10 text-cyan-300
                               text-sm font-semibold">

                        <?php echo $lang['badge_text']; ?>

                    </div>


                    <!-- Title -->

                    <h1
                        class="mt-8 text-4xl sm:text-5xl md:text-6xl
                               font-black leading-tight max-w-4xl">

                        <?php echo $lang['hero_title']; ?>

                    </h1>


                    <!-- Subtitle -->

                    <p
                        class="mt-6 text-lg md:text-xl text-gray-300
                               leading-relaxed max-w-2xl">

                        <?php echo $lang['hero_subtitle']; ?>

                    </p>


                    <!-- Features -->

                    <div class="mt-10 space-y-5 w-full max-w-2xl">


                        <!-- Feature -->

                        <div
                            class="flex items-start gap-4 text-left
                                   bg-white/5 border border-white/10
                                   rounded-2xl p-5 backdrop-blur-xl">


                            <div
                                class="min-w-[42px] w-10 h-10 rounded-2xl
                                       bg-cyan-500/20 border border-cyan-400/20
                                       flex items-center justify-center
                                       text-cyan-300 font-bold">

                                ✓

                            </div>


                            <div>

                                <h3 class="text-lg md:text-xl font-bold">

                                    <?php echo $lang['feature_1']; ?>

                                </h3>

                            </div>

                        </div>



                        <!-- Feature -->

                        <div
                            class="flex items-start gap-4 text-left
                                   bg-white/5 border border-white/10
                                   rounded-2xl p-5 backdrop-blur-xl">


                            <div
                                class="min-w-[42px] w-10 h-10 rounded-2xl
                                       bg-cyan-500/20 border border-cyan-400/20
                                       flex items-center justify-center
                                       text-cyan-300 font-bold">

                                ✓

                            </div>


                            <div>

                                <h3 class="text-lg md:text-xl font-bold">

                                    <?php echo $lang['feature_2']; ?>

                                </h3>

                            </div>

                        </div>



                        <!-- Feature -->

                        <div
                            class="flex items-start gap-4 text-left
                                   bg-white/5 border border-white/10
                                   rounded-2xl p-5 backdrop-blur-xl">


                            <div
                                class="min-w-[42px] w-10 h-10 rounded-2xl
                                       bg-cyan-500/20 border border-cyan-400/20
                                       flex items-center justify-center
                                       text-cyan-300 font-bold">

                                ✓

                            </div>


                            <div>

                                <h3 class="text-lg md:text-xl font-bold">

                                    <?php echo $lang['feature_3']; ?>

                                </h3>

                            </div>

                        </div>

                    </div>


                    <!-- CTA -->

                    <div
                        class="mt-12 flex flex-col sm:flex-row
                               items-center justify-center lg:justify-start
                               gap-5 w-full">


                        <!-- Button -->

                        <a href="quiz"

                            class="w-full sm:w-auto
                                   text-center
                                   px-10 py-5 rounded-2xl
                                   bg-gradient-to-r from-cyan-500 to-purple-600
                                   hover:scale-105 transition duration-300
                                   text-lg font-bold shadow-2xl shadow-cyan-500/30">

                            🚀 <?php echo $lang['start_quiz']; ?>

                        </a>


                        <!-- Time -->

                        <div
                            class="w-full sm:w-auto
                                   px-8 py-5 rounded-2xl
                                   bg-white/5 border border-white/10
                                   text-lg font-semibold text-center">

                            <?php echo $lang['time_text']; ?>

                        </div>

                    </div>


                    <!-- Footer -->

                    <p class="mt-6 text-gray-500 text-sm md:text-base">

                        <?php echo $lang['footer_text']; ?>

                    </p>

                </div>


                <!-- RIGHT -->

                <div class="relative mt-10 lg:mt-0">


                    <!-- Main Card -->

                    <div
                        class="relative overflow-hidden
                               rounded-[35px]
                               border border-white/10
                               bg-gradient-to-br from-[#0B1023] via-[#111827] to-[#1E1B4B]
                               p-6 md:p-10 shadow-2xl">


                        <!-- Glow -->

                        <div
                            class="absolute w-72 h-72 bg-cyan-500/20 blur-3xl rounded-full -top-20 -left-20"></div>

                        <div
                            class="absolute w-72 h-72 bg-purple-500/20 blur-3xl rounded-full -bottom-20 -right-20"></div>


                        <!-- Content -->

                        <div class="relative z-10">


                            <!-- Top -->

                            <div class="flex items-center justify-between gap-4">


                                <div
                                    class="inline-flex items-center gap-3
                                           px-4 py-3 rounded-full
                                           bg-white/10 border border-white/10">


                                    <div
                                        class="w-3 h-3 rounded-full bg-cyan-400"></div>

                                    <span class="font-semibold tracking-wide text-sm">

                                        AI READINESS TEST

                                    </span>

                                </div>


                                <div
                                    class="w-14 h-14 rounded-full
                                           bg-gradient-to-br from-cyan-400 to-purple-500
                                           flex items-center justify-center
                                           text-2xl shadow-2xl">

                                    🤖

                                </div>

                            </div>


                            <!-- Score -->

                            <div class="mt-12">


                                <div class="flex items-end gap-3">


                                    <h2
                                        class="text-7xl md:text-9xl
                                               font-black text-cyan-300">

                                        82%

                                    </h2>


                                    <div
                                        class="pb-4 text-xl md:text-2xl
                                               font-bold text-white/80">

                                        <?php echo $lang['score_label']; ?>

                                    </div>

                                </div>


                                <!-- Result -->

                                <div
                                    class="mt-6 inline-flex items-center
                                           px-5 py-3 rounded-2xl
                                           bg-cyan-500/20 border border-cyan-400/20
                                           text-cyan-300 text-lg md:text-xl font-bold">

                                    <?php echo $lang['result_label']; ?>

                                </div>


                                <!-- Quote -->

                                <p
                                    class="mt-8 text-xl md:text-2xl
                                           leading-relaxed
                                           text-gray-200 font-medium">

                                    <?php echo $lang['quote']; ?>

                                </p>


                                <!-- Footer -->

                                <div
                                    class="mt-12 flex items-center justify-between gap-5">


                                    <div>

                                        <p
                                            class="text-gray-400 text-xs uppercase tracking-widest">

                                            <?php echo $lang['tested_today']; ?>

                                        </p>

                                        <h3 class="mt-2 text-xl md:text-2xl font-bold">

                                            <?php echo $lang['tested_people']; ?>

                                        </h3>

                                    </div>


                                    <div
                                        class="px-4 py-3 rounded-2xl
                                               bg-white/10 border border-white/10
                                               text-sm md:text-lg font-bold">

                                        <?php echo $lang['future_ready']; ?>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- Floating Card -->

                    <div
                        class="hidden md:block absolute -bottom-8 -left-8
                               bg-white/5 border border-white/10
                               backdrop-blur-xl rounded-3xl p-5">


                        <div class="text-4xl font-black text-cyan-300">

                            92%

                        </div>

                        <p class="mt-2 text-gray-300">

                            <?php echo $lang['floating_1']; ?>

                        </p>

                    </div>


                    <!-- Floating Card -->

                    <div
                        class="hidden md:block absolute -top-8 -right-8
                               bg-white/5 border border-white/10
                               backdrop-blur-xl rounded-3xl p-5">


                        <div class="text-4xl font-black text-purple-300">

                            2 Min

                        </div>

                        <p class="mt-2 text-gray-300">

                            <?php echo $lang['floating_2']; ?>

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

    

<!-- SOCIAL PROOF -->

<section class="relative z-10 py-20">


    <div class="max-w-7xl mx-auto px-5">


        <!-- Heading -->

        <div class="text-center">

            <h2 class="text-4xl md:text-5xl font-black">

                <?php echo $lang['social_title']; ?>

            </h2>

            <p class="mt-6 text-xl text-gray-400 max-w-3xl mx-auto">

                <?php echo $lang['social_subtitle']; ?>

            </p>

        </div>


        <!-- Stats -->

        <div class="mt-16 grid grid-cols-2 lg:grid-cols-4 gap-6">


            <!-- Stat -->

            <div
                class="bg-white/5 border border-white/10
                       rounded-3xl p-8 text-center backdrop-blur-xl">


                <div class="text-5xl font-black text-cyan-300">

                    12K+

                </div>

                <p class="mt-4 text-gray-400">

                    <?php echo $lang['stat_1']; ?>

                </p>

            </div>



            <!-- Stat -->

            <div
                class="bg-white/5 border border-white/10
                       rounded-3xl p-8 text-center backdrop-blur-xl">


                <div class="text-5xl font-black text-purple-300">

                    92%

                </div>

                <p class="mt-4 text-gray-400">

                    <?php echo $lang['stat_2']; ?>

                </p>

            </div>



            <!-- Stat -->

            <div
                class="bg-white/5 border border-white/10
                       rounded-3xl p-8 text-center backdrop-blur-xl">


                <div class="text-5xl font-black text-cyan-300">

                    2 Min

                </div>

                <p class="mt-4 text-gray-400">

                    <?php echo $lang['stat_3']; ?>

                </p>

            </div>



            <!-- Stat -->

            <div
                class="bg-white/5 border border-white/10
                       rounded-3xl p-8 text-center backdrop-blur-xl">


                <div class="text-5xl font-black text-purple-300">

                    Free

                </div>

                <p class="mt-4 text-gray-400">

                    <?php echo $lang['stat_4']; ?>

                </p>

            </div>

        </div>

    </div>

</section>



<!-- WHY TAKE TEST -->

<section class="relative z-10 py-20">


    <div class="max-w-7xl mx-auto px-5">


        <!-- Heading -->

        <div class="text-center">

            <h2 class="text-4xl md:text-5xl font-black">

                <?php echo $lang['why_title']; ?>

            </h2>

        </div>


        <!-- Cards -->

        <div class="mt-16 grid lg:grid-cols-3 gap-8">


            <!-- Card -->

            <div
                class="bg-white/5 border border-white/10
                       rounded-[35px] p-8 backdrop-blur-xl">


                <div class="text-6xl">

                    😨

                </div>


                <h3 class="mt-6 text-2xl font-bold">

                    <?php echo $lang['why_card_1_title']; ?>

                </h3>


                <p class="mt-5 text-gray-400 leading-relaxed">

                    <?php echo $lang['why_card_1_text']; ?>

                </p>

            </div>



            <!-- Card -->

            <div
                class="bg-white/5 border border-white/10
                       rounded-[35px] p-8 backdrop-blur-xl">


                <div class="text-6xl">

                    🚀

                </div>


                <h3 class="mt-6 text-2xl font-bold">

                    <?php echo $lang['why_card_2_title']; ?>

                </h3>


                <p class="mt-5 text-gray-400 leading-relaxed">

                    <?php echo $lang['why_card_2_text']; ?>

                </p>

            </div>



            <!-- Card -->

            <div
                class="bg-white/5 border border-white/10
                       rounded-[35px] p-8 backdrop-blur-xl">


                <div class="text-6xl">

                    🤖

                </div>


                <h3 class="mt-6 text-2xl font-bold">

                    <?php echo $lang['why_card_3_title']; ?>

                </h3>


                <p class="mt-5 text-gray-400 leading-relaxed">

                    <?php echo $lang['why_card_3_text']; ?>

                </p>

            </div>

        </div>

    </div>

</section>



<!-- FINAL CTA -->

<section class="relative z-10 py-24">


    <div class="max-w-5xl mx-auto px-5 text-center">


        <div
            class="relative overflow-hidden
                   rounded-[40px]
                   border border-white/10
                   bg-gradient-to-br from-[#0B1023] via-[#111827] to-[#1E1B4B]
                   p-10 md:p-16 shadow-2xl">


            <!-- Glow -->

            <div
                class="absolute w-96 h-96 bg-cyan-500/20 blur-3xl rounded-full -top-32 -left-32"></div>

            <div
                class="absolute w-96 h-96 bg-purple-500/20 blur-3xl rounded-full -bottom-32 -right-32"></div>


            <!-- Content -->

            <div class="relative z-10">


                <h2
                    class="text-4xl md:text-6xl
                           font-black leading-tight">

                    <?php echo $lang['final_title']; ?>

                </h2>


                <p
                    class="mt-8 text-xl text-gray-300
                           leading-relaxed max-w-3xl mx-auto">

                    <?php echo $lang['final_subtitle']; ?>

                </p>


                <!-- CTA -->

                <div class="mt-12">


                    <a href="quiz"

                        class="inline-flex items-center justify-center
                               px-12 py-6 rounded-3xl
                               bg-gradient-to-r from-cyan-500 to-purple-600
                               hover:scale-105 transition duration-300
                               text-2xl font-black shadow-2xl shadow-cyan-500/30">

                        <?php echo $lang['final_button']; ?>

                    </a>

                </div>


                <p class="mt-6 text-gray-500">

                    <?php echo $lang['final_footer']; ?>

                </p>

            </div>

        </div>

    </div>

</section>


</body>

</html>