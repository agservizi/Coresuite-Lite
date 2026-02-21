<?php
use Core\Auth;

$pageTitle = 'Documenti';

$content = '';
if (Auth::isAdmin() || Auth::isOperator()) {
    $content .= '<div class="mb-4"><a href="/documents/upload" class="inline-flex items-center gap-2 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded"><span class="icon"><i class="fas fa-upload"></i></span><span>Carica documento</span></a></div>';
}

$content .= '
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome file</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MIME</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dimensione</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Azioni</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
';

foreach (($documents ?? []) as $doc) {
    $sizeKB = round(($doc['size'] ?? 0) / 1024, 1);
    $content .= '
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">' . (int)($doc['id'] ?? 0) . '</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">' . htmlspecialchars($doc['filename_original'] ?? '-') . '</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><span class="inline-block px-2 py-0.5 text-xs bg-gray-100 rounded">' . htmlspecialchars($doc['mime'] ?? '-') . '</span></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">' . $sizeKB . ' KB</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">' . htmlspecialchars($doc['created_at'] ?? '-') . '</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                <div class="flex items-center gap-2">
                    <a class="inline-flex items-center gap-2 px-3 py-1 bg-white border rounded text-blue-600 hover:bg-gray-50" href="/documents/' . (int)($doc['id'] ?? 0) . '/download"><span class="icon"><i class="fas fa-download"></i></span><span>Download</span></a>
                    ' . ((Auth::isAdmin() || Auth::isOperator()) ? '<form method="POST" action="/documents/' . (int)($doc['id'] ?? 0) . '/delete" onsubmit="return confirm(\'Eliminare il documento?\')">'.CSRF::field().'<button class="inline-flex items-center gap-2 px-3 py-1 bg-white border rounded text-red-600 hover:bg-gray-50" type="submit"><span class="icon"><i class="fas fa-trash"></i></span><span>Elimina</span></button></form>' : '') . '
                </div>
            </td>
        </tr>
    ';
}

if (empty($documents)) {
    $content .= '<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Nessun documento disponibile</td></tr>';
}

$content .= '
    </tbody>
</table>
</div>
';

// Paginazione (Tailwind styled)
$currentPage = $page ?? 1;
$totalPages = $totalPages ?? 1;
if ($totalPages > 1) {
    $content .= '<nav class="flex items-center justify-center mt-6" role="navigation">';
    $content .= '<div class="inline-flex -space-x-px">';
    $content .= ($currentPage <= 1) ? '<span class="px-3 py-1 bg-gray-200 text-gray-400">Precedente</span>' : '<a class="px-3 py-1 bg-white border text-blue-600" href="/documents?page=' . ($currentPage - 1) . '">Precedente</a>';
    for ($i = 1; $i <= $totalPages; $i++) {
        $content .= '<a class="px-3 py-1 ' . ($i === $currentPage ? 'bg-blue-600 text-white' : 'bg-white border text-gray-700') . '" href="/documents?page=' . $i . '">' . $i . '</a>';
    }
    $content .= ($currentPage >= $totalPages) ? '<span class="px-3 py-1 bg-gray-200 text-gray-400">Successiva</span>' : '<a class="px-3 py-1 bg-white border text-blue-600" href="/documents?page=' . ($currentPage + 1) . '">Successiva</a>';
    $content .= '</div></nav>';
}

include __DIR__ . '/layout.php';
