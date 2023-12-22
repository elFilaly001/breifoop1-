<?php

namespace App\Controllers\Core;

use App\Controllers\HomeController;

class guest
{
    public function handle()
    {
        if ($_SESSION['roleuser'] === "Candidat") {
            header("Location: ?route=denied");
            return false;
        } elseif (!isset($_SESSION['roleuser'])) {
            header("Location: ?route=login");
            return false;
        } else {
            return true;
        }
    }
}
