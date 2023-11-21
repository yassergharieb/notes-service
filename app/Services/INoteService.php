<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Support\Collection;

interface INoteService
{

    public function getAllUserNotes(int $userId): Collection;

    public function get(int $noteId, int $userId): ?Note;

    public function create(array $data): ?Note;

    public function update(int $noteId, int $userId, array $data): ?Note;

    public function delete(int $noteId): bool;

    public function CreateWelcomeNoteForRegisterdUser(array $data): Note;

}