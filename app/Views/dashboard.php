<?php
use Core\DB;
use Core\Auth;

// Dashboard data
$user = Auth::user();
$pageTitle = 'Dashboard';

// KPI
$stmt = DB::prepare("SELECT COUNT(*) as total FROM users WHERE role = 'customer'");
$stmt->execute();
$customers = $stmt->fetch()['total'];

$stmt = DB::prepare("SELECT COUNT(*) as total FROM tickets");
$stmt->execute();
$tickets = $stmt->fetch()['total'];

$stmt = DB::prepare("SELECT COUNT(*) as total FROM tickets WHERE status = 'open'");
$stmt->execute();
$openTickets = $stmt->fetch()['total'];

$stmt = DB::prepare("SELECT COUNT(*) as total FROM documents");
$stmt->execute();
$documents = $stmt->fetch()['total'];

$content = '
<div class="columns is-multiline">
    <div class="column is-3">
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <p class="title is-2">' . $customers . '</p>
                    <p class="subtitle">Clienti</p>
                </div>
            </div>
        </div>
    </div>
    <div class="column is-3">
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <p class="title is-2">' . $tickets . '</p>
                    <p class="subtitle">Totale Tickets</p>
                </div>
            </div>
        </div>
    </div>
    <div class="column is-3">
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <p class="title is-2">' . $openTickets . '</p>
                    <p class="subtitle">Tickets Aperti</p>
                </div>
            </div>
        </div>
    </div>
    <div class="column is-3">
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <p class="title is-2">' . $documents . '</p>
                    <p class="subtitle">Documenti</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <header class="card-header">
        <p class="card-header-title">Grafico Tickets (ultimi 30 giorni)</p>
    </header>
    <div class="card-content">
        <canvas id="ticketChart" width="400" height="200"></canvas>
    </div>
</div>

<div class="columns">
    <div class="column is-6">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">Ultime Richieste</p>
            </header>
            <div class="card-content">
                <div class="content">
                    <ul>
                        <li>Ticket #1 - Problema login</li>
                        <li>Ticket #2 - Richiesta supporto</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="column is-6">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">Ultimi Upload</p>
            </header>
            <div class="card-content">
                <div class="content">
                    <ul>
                        <li>Documento.pdf - Cliente A</li>
                        <li>Contratto.docx - Cliente B</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
?>