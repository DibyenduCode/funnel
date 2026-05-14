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
| TOTAL USERS
|--------------------------------------------------------------------------
*/

$total_users_stmt = $pdo->query("
    SELECT COUNT(*) as total
    FROM users
");

$total_users = $total_users_stmt->fetch()['total'];


/*
|--------------------------------------------------------------------------
| AI READY USERS
|--------------------------------------------------------------------------
*/

$ai_ready_stmt = $pdo->query("
    SELECT COUNT(*) as total
    FROM users
    WHERE result_type = 'AI Ready'
");

$ai_ready = $ai_ready_stmt->fetch()['total'];


/*
|--------------------------------------------------------------------------
| PAGINATION
|--------------------------------------------------------------------------
*/

$limit = 10;

$page = isset($_GET['page'])
    ? (int) $_GET['page']
    : 1;

if ($page < 1) {

    $page = 1;
}


$offset = ($page - 1) * $limit;


/*
|--------------------------------------------------------------------------
| TOTAL ROWS
|--------------------------------------------------------------------------
*/

$total_stmt = $pdo->query("
    SELECT COUNT(*) as total
    FROM users
");

$total_rows = $total_stmt->fetch()['total'];

$total_pages = ceil($total_rows / $limit);


/*
|--------------------------------------------------------------------------
| GET USERS
|--------------------------------------------------------------------------
*/

$users_stmt = $pdo->prepare("
    SELECT *
    FROM users
    ORDER BY id DESC
    LIMIT :limit OFFSET :offset
");

$users_stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

$users_stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$users_stmt->execute();

$users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#050816] text-white min-h-screen">


    <!-- Topbar -->

    <div
        class="border-b border-white/10 bg-white/5 backdrop-blur-xl sticky top-0 z-50">

        <div
            class="max-w-7xl mx-auto px-5 py-4 flex items-center justify-between">


            <!-- Logo -->

            <div>

                <h1 class="text-2xl font-extrabold">

                    🤖 AI Quiz Admin

                </h1>

            </div>


            <!-- Actions -->

            <div class="flex items-center gap-3 flex-wrap">


                <!-- Questions -->

                <a href="questions.php"

                    class="px-5 py-3 rounded-2xl
                           bg-cyan-500/20 hover:bg-cyan-500/30
                           border border-cyan-400/20 transition">

                    Questions

                </a>


                <!-- Export CSV -->

                <a href="export-users.php"

                    class="px-5 py-3 rounded-2xl
                           bg-green-500/20 hover:bg-green-500/30
                           border border-green-400/20 transition">

                    Export CSV

                </a>


                <!-- Logout -->

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

    <div class="max-w-7xl mx-auto px-5 py-10">


        <!-- Stats -->

        <div class="grid md:grid-cols-3 gap-6">


            <!-- Total Leads -->

            <div
                class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl">

                <p class="text-gray-400">

                    Total Leads

                </p>

                <h2 class="mt-4 text-5xl font-extrabold text-cyan-300">

                    <?php echo $total_users; ?>

                </h2>

            </div>


            <!-- AI Ready -->

            <div
                class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl">

                <p class="text-gray-400">

                    AI Ready Users

                </p>

                <h2 class="mt-4 text-5xl font-extrabold text-green-300">

                    <?php echo $ai_ready; ?>

                </h2>

            </div>


            <!-- Funnel -->

            <div
                class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl">

                <p class="text-gray-400">

                    Conversion Funnel

                </p>

                <h2 class="mt-4 text-3xl font-bold text-purple-300">

                    Active

                </h2>

            </div>

        </div>


        <!-- Leads Table -->

        <div
            class="mt-10 bg-white/5 border border-white/10
                   rounded-3xl overflow-hidden backdrop-blur-xl">


            <!-- Header -->

            <div class="px-6 py-5 border-b border-white/10">

                <h2 class="text-2xl font-bold">

                    Recent Leads

                </h2>

            </div>


            <!-- Table -->

            <div class="overflow-x-auto">

                <table class="w-full min-w-[700px]">


                    <!-- Head -->

                    <thead>

                        <tr class="border-b border-white/10 text-left">

                            <th class="px-6 py-4 text-gray-400">

                                Name

                            </th>

                            <th class="px-6 py-4 text-gray-400">

                                Email

                            </th>

                            <th class="px-6 py-4 text-gray-400">

                                WhatsApp

                            </th>

                            <th class="px-6 py-4 text-gray-400">

                                Score

                            </th>

                            <th class="px-6 py-4 text-gray-400">

                                Result

                            </th>

                            <th class="px-6 py-4 text-gray-400">

                                Date

                            </th>

                        </tr>

                    </thead>


                    <!-- Body -->

                    <tbody>


                        <?php foreach ($users as $user): ?>


                            <tr class="border-b border-white/5 hover:bg-white/5">


                                <!-- Name -->

                                <td class="px-6 py-4">

                                    <?php echo htmlspecialchars($user['name']); ?>

                                </td>


                                <!-- Email -->

                                <td class="px-6 py-4 text-gray-300">

                                    <?php echo htmlspecialchars($user['email']); ?>

                                </td>


                                <!-- Phone -->

                                <td class="px-6 py-4 text-gray-300">

                                    <?php echo htmlspecialchars($user['phone']); ?>

                                </td>


                                <!-- Score -->

                                <td class="px-6 py-4">

                                    <?php echo $user['score']; ?>

                                </td>


                                <!-- Result -->

                                <td class="px-6 py-4">

                                    <span
                                        class="px-3 py-2 rounded-xl
                                               bg-cyan-500/20 text-cyan-300
                                               border border-cyan-400/20">

                                        <?php echo $user['result_type']; ?>

                                    </span>

                                </td>


                                <!-- Date -->

                                <td class="px-6 py-4 text-gray-400">

                                    <?php echo date('d M Y', strtotime($user['created_at'])); ?>

                                </td>

                            </tr>


                        <?php endforeach; ?>


                    </tbody>

                </table>

            </div>

        </div>


        <!-- Pagination -->

        <div class="mt-8 flex justify-center gap-3 flex-wrap">


            <?php if ($page > 1): ?>

                <a
                    href="?page=<?php echo $page - 1; ?>"

                    class="px-5 py-3 rounded-2xl
                           bg-white/10 hover:bg-white/20 transition">

                    Previous

                </a>

            <?php endif; ?>


            <?php for ($i = 1; $i <= $total_pages; $i++): ?>


                <a
                    href="?page=<?php echo $i; ?>"

                    class="px-5 py-3 rounded-2xl border

                    <?php echo $i == $page
                        ? 'bg-cyan-500/20 border-cyan-400/20 text-cyan-300'
                        : 'bg-white/10 border-white/10 hover:bg-white/20'; ?>">

                    <?php echo $i; ?>

                </a>


            <?php endfor; ?>


            <?php if ($page < $total_pages): ?>

                <a
                    href="?page=<?php echo $page + 1; ?>"

                    class="px-5 py-3 rounded-2xl
                           bg-white/10 hover:bg-white/20 transition">

                    Next

                </a>

            <?php endif; ?>


        </div>

    </div>

</body>

</html>