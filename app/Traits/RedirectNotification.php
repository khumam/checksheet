<?php

namespace App\Traits;

trait RedirectNotification
{
    /**
     * Return success sweetalert
     *
     * @param  string $route
     * @param  string $message
     * @return void
     */
    public function sendSuccess(string $message = null, string $route = null)
    {
        $message = $message != null ? $message : 'Berhasil';
        return ($route != null) ? redirect($route)->with('success', $message) : back()->with('success', $message);
    }

    /**
     * Return error sweetalert
     *
     * @param  string $route
     * @param  string $message
     * @return void
     */
    public function sendError(string $message = null, string $route = null)
    {
        $message = $message != null ? $message : 'Gagal';
        return ($route != null) ? redirect($route)->with('error', $message) : back()->with('error', $message);
    }

    public function sendUnauthorized()
    {
        # code...
    }

    /**
     * Send redirect based action
     *
     * @param  mixed $action
     * @param  string $successMessage
     * @param  string $errorMessage
     * @param  string $successRoute
     * @param  string $errorRoute
     * @return void
     */
    public function sendRedirectTo($action, string $successMessage = null, string $errorMessage = null, string $successRoute = null, string $errorRoute = null)
    {
        return $action ? $this->sendSuccess($successMessage, $successRoute) : $this->sendError($errorMessage, $errorRoute);
    }
}
