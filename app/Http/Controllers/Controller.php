<?php

namespace App\Http\Controllers;

/**
 * Base controller class for the application.
 * Extend this class to create specific controllers.
 */
abstract class Controller
{
    /**
     * Common functionality for all controllers can be added here.
     */
    protected function jsonResponse($data, $status = 200)
    {
        return response()->json($data, $status);
    }
}
