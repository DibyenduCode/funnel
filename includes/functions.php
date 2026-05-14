<?php

/*
|--------------------------------------------------------------------------
| SANITIZE INPUT
|--------------------------------------------------------------------------
*/

function sanitize($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}


/*
|--------------------------------------------------------------------------
| REDIRECT FUNCTION
|--------------------------------------------------------------------------
*/

function redirect($url)
{
    header("Location: " . $url);
    exit;
}


/*
|--------------------------------------------------------------------------
| JSON RESPONSE
|--------------------------------------------------------------------------
*/

function jsonResponse($status, $message, $data = [])
{
    header('Content-Type: application/json');

    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| RESULT CATEGORY
|--------------------------------------------------------------------------
*/

function getResultCategory($score)
{

    /*
    |--------------------------------------------------------------------------
    | 13 QUESTIONS × 4 = 52 MAX
    |--------------------------------------------------------------------------
    */

    if ($score <= 20) {

        return "AI Risk Zone";

    } elseif ($score <= 32) {

        return "AI Awakening";

    } elseif ($score <= 44) {

        return "AI Explorer";

    } else {

        return "AI Future Ready";

    }

}


/*
|--------------------------------------------------------------------------
| PERSONAL ANALYSIS
|--------------------------------------------------------------------------
*/

function getPersonalAnalysis($score)
{

    if ($score <= 20) {

        return "You are highly vulnerable to AI disruption. Learning AI skills is important for your future.";

    } elseif ($score <= 32) {

        return "You are becoming aware of AI changes, but stronger adaptation is still needed.";

    } elseif ($score <= 49) {

        return "You are exploring AI opportunities and adapting well for the future.";

    } else {

        return "You are highly adaptable and prepared for the AI-powered future.";

    }

}