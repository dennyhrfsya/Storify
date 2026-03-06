<?php
namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse;

class CustomLoginResponse implements LoginResponse
{
    public function toResponse($request)
    {
        // Redirect user ke halaman dashboard
        // Jika sebelumnya ada intended URL (misalnya user mencoba akses halaman yang butuh login),
        // maka Laravel akan otomatis mengarahkan ke URL tersebut.
        // Jika tidak ada, fallback ke '/dashboard'.
        return redirect()->intended('/dashboard');
    }
}
