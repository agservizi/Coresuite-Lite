<?php
$pageTitle = 'Nuovo Ticket';

$content = '
<form method="POST" action="/tickets">
<form method="POST" action="/tickets" enctype="multipart/form-data">
    ' . CSRF::field() . '
    <div class="field">
        <label class="label">Categoria</label>
        <div class="control">
            <div class="select is-fullwidth">
                <select name="category" required>
                    <option value="">Seleziona categoria</option>
                    <option value="tecnico">Tecnico</option>
                    <option value="amministrativo">Amministrativo</option>
                    <option value="commerciale">Commerciale</option>
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Oggetto</label>
        <div class="control">
            <input class="input" type="text" name="subject" placeholder="Breve descrizione" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Priorità</label>
        <div class="control">
            <div class="select is-fullwidth">
                <select name="priority">
                    <option value="low">Bassa</option>
                    <option value="medium" selected>Media</option>
                    <option value="high">Alta</option>
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Descrizione</label>
        <div class="control">
            <textarea class="textarea" name="body" rows="6" required></textarea>
        </div>
    </div>
    
    <div class="field">
        <label class="label">Allega file (opzionale)</label>
        <div class="control">
            <input type="file" name="attachment">
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control"><button class="button is-primary" type="submit">Invia ticket</button></div>
        <div class="control"><a href="/tickets" class="button is-light">Annulla</a></div>
    </div>
</form>
';

include __DIR__ . '/layout.php';
