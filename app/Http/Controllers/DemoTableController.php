<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class DemoTableController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Demotable');
    }

    public function users(): JsonResponse
    {
        return response()->json([
            'users' => $this->demoUsers(),
        ]);
    }

    /** @return array<int, array{id: int, user: string, email: string, role: string, active: bool}> */
    private function demoUsers(): array
    {
        return [
            ['id' => 1, 'user' => 'Giulia Bianchi', 'email' => 'giulia.bianchi@example.com', 'role' => 'Amministratore', 'active' => true],
            ['id' => 2, 'user' => 'Marco Rossi', 'email' => 'marco.rossi@example.com', 'role' => 'Editor', 'active' => true],
            ['id' => 3, 'user' => 'Sara Romano', 'email' => 'sara.romano@example.com', 'role' => 'Utente', 'active' => false],
            ['id' => 4, 'user' => 'Luca Ferrari', 'email' => 'luca.ferrari@example.com', 'role' => 'Utente', 'active' => true],
            ['id' => 5, 'user' => 'Elena Esposito', 'email' => 'elena.esposito@example.com', 'role' => 'Editor', 'active' => false],
            ['id' => 6, 'user' => 'Andrea Ricci', 'email' => 'andrea.ricci@example.com', 'role' => 'Utente', 'active' => true],
            ['id' => 7, 'user' => 'Francesca Marino', 'email' => 'francesca.marino@example.com', 'role' => 'Amministratore', 'active' => true],
            ['id' => 8, 'user' => 'Davide Greco', 'email' => 'davide.greco@example.com', 'role' => 'Utente', 'active' => false],
            ['id' => 9, 'user' => 'Alessia Conti', 'email' => 'alessia.conti@example.com', 'role' => 'Editor', 'active' => true],
            ['id' => 10, 'user' => 'Matteo Gallo', 'email' => 'matteo.gallo@example.com', 'role' => 'Utente', 'active' => false],
            ['id' => 11, 'user' => 'Chiara De Luca', 'email' => 'chiara.deluca@example.com', 'role' => 'Utente', 'active' => true],
            ['id' => 12, 'user' => 'Simone Moretti', 'email' => 'simone.moretti@example.com', 'role' => 'Editor', 'active' => true],
            ['id' => 13, 'user' => 'Valentina Barbieri', 'email' => 'valentina.barbieri@example.com', 'role' => 'Amministratore', 'active' => false],
            ['id' => 14, 'user' => 'Federico Fontana', 'email' => 'federico.fontana@example.com', 'role' => 'Utente', 'active' => true],
            ['id' => 15, 'user' => 'Martina Santoro', 'email' => 'martina.santoro@example.com', 'role' => 'Editor', 'active' => true],
        ];
    }
}
