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
| EXPORT CSV
|--------------------------------------------------------------------------
*/

if (isset($_GET['export'])) {

    $from_date = $_GET['from_date'] ?? '';

    $to_date = $_GET['to_date'] ?? '';

    $min_score = $_GET['min_score'] ?? '';

    $max_score = $_GET['max_score'] ?? '';


    /*
    |--------------------------------------------------------------------------
    | QUERY
    |--------------------------------------------------------------------------
    */

    $query = "
        SELECT *
        FROM users
        WHERE 1=1
    ";

    $params = [];


    /*
    |--------------------------------------------------------------------------
    | DATE FILTER
    |--------------------------------------------------------------------------
    */

    if (!empty($from_date)) {

        $query .= " AND DATE(created_at) >= ? ";

        $params[] = $from_date;
    }


    if (!empty($to_date)) {

        $query .= " AND DATE(created_at) <= ? ";

        $params[] = $to_date;
    }


    /*
    |--------------------------------------------------------------------------
    | SCORE FILTER
    |--------------------------------------------------------------------------
    */

    if ($min_score !== '') {

        $query .= " AND score >= ? ";

        $params[] = $min_score;
    }


    if ($max_score !== '') {

        $query .= " AND score <= ? ";

        $params[] = $max_score;
    }


    $query .= " ORDER BY id ASC ";


    /*
    |--------------------------------------------------------------------------
    | FETCH USERS
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare($query);

    $stmt->execute($params);

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | CSV HEADERS
    |--------------------------------------------------------------------------
    */

    header('Content-Type: text/csv');

    header('Content-Disposition: attachment; filename="ai-quiz-leads.csv"');


    /*
    |--------------------------------------------------------------------------
    | OUTPUT
    |--------------------------------------------------------------------------
    */

    $output = fopen('php://output', 'w');


    /*
    |--------------------------------------------------------------------------
    | CSV COLUMN HEADERS
    |--------------------------------------------------------------------------
    */

    fputcsv($output, [

        'ID',
        'Name',
        'Email',
        'Phone',
        'Score',
        'Result Type',
        'Created At'

    ]);


    /*
    |--------------------------------------------------------------------------
    | CSV DATA
    |--------------------------------------------------------------------------
    */

    foreach ($users as $user) {

        fputcsv($output, [

            $user['id'],
            $user['name'],
            $user['email'],
            $user['phone'],
            $user['score'],
            $user['result_type'],
            $user['created_at']

        ]);
    }


    fclose($output);

    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Export Leads</title>

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
            class="max-w-5xl mx-auto px-5 py-4 flex items-center justify-between">


            <!-- Left -->

            <div>

                <h1 class="text-3xl font-extrabold">

                    📤 Export Leads

                </h1>

                <p class="text-gray-400 mt-1">

                    Filter and export lead data as CSV

                </p>

            </div>


            <!-- Right -->

            <div class="flex gap-3">


                <a href="dashboard.php"

                    class="px-5 py-3 rounded-2xl
                           bg-cyan-500/20 hover:bg-cyan-500/30
                           border border-cyan-400/20 transition">

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

    <div class="relative z-10 max-w-5xl mx-auto px-5 py-10">


        <!-- Card -->

        <div
            class="bg-white/5 border border-white/10
                   rounded-3xl p-8 backdrop-blur-xl shadow-2xl">


            <!-- Heading -->

            <div class="mb-8">

                <h2 class="text-3xl font-bold">

                    🎯 Export Filters

                </h2>

                <p class="mt-2 text-gray-400">

                    Filter leads by date and score before exporting.

                </p>

            </div>


            <!-- Form -->

            <form method="GET" class="space-y-8">


                <!-- Date Filters -->

                <div>

                    <h3 class="text-xl font-bold text-cyan-300 mb-5">

                        📅 Date Range

                    </h3>


                    <div class="grid md:grid-cols-2 gap-5">


                        <!-- From -->

                        <div>

                            <label class="block mb-3 text-gray-300">

                                From Date

                            </label>

                            <input
                                type="date"
                                name="from_date"

                                class="w-full px-5 py-4 rounded-2xl
                                       bg-white/5 border border-white/10
                                       focus:border-cyan-400 focus:outline-none
                                       text-white">

                        </div>


                        <!-- To -->

                        <div>

                            <label class="block mb-3 text-gray-300">

                                To Date

                            </label>

                            <input
                                type="date"
                                name="to_date"

                                class="w-full px-5 py-4 rounded-2xl
                                       bg-white/5 border border-white/10
                                       focus:border-cyan-400 focus:outline-none
                                       text-white">

                        </div>

                    </div>

                </div>


                <!-- Score Filters -->

                <div>

                    <h3 class="text-xl font-bold text-cyan-300 mb-5">

                        🧠 Score Range

                    </h3>


                    <div class="grid md:grid-cols-2 gap-5">


                        <!-- Min -->

                        <div>

                            <label class="block mb-3 text-gray-300">

                                Minimum Score

                            </label>

                            <input
                                type="number"
                                name="min_score"
                                placeholder="0"

                                class="w-full px-5 py-4 rounded-2xl
                                       bg-white/5 border border-white/10
                                       focus:border-cyan-400 focus:outline-none
                                       text-white">

                        </div>


                        <!-- Max -->

                        <div>

                            <label class="block mb-3 text-gray-300">

                                Maximum Score

                            </label>

                            <input
                                type="number"
                                name="max_score"
                                placeholder="100"

                                class="w-full px-5 py-4 rounded-2xl
                                       bg-white/5 border border-white/10
                                       focus:border-cyan-400 focus:outline-none
                                       text-white">

                        </div>

                    </div>

                </div>


                <!-- Submit -->

                <button
                    type="submit"
                    name="export"
                    value="1"

                    class="w-full py-5 rounded-2xl
                           bg-gradient-to-r from-green-500 to-cyan-500
                           hover:scale-[1.01] transition duration-300
                           text-lg font-semibold shadow-2xl shadow-green-500/30">

                    📥 Export CSV

                </button>

            </form>

        </div>

    </div>

</body>

</html>