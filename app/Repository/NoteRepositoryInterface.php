<?php

namespace App\Repository;

interface NoteRepositoryInterface
{
    public function getAllUserNotes(int $userId);

    public function get(int $noteId, int $userId);

    public function create(array $data);

    public function update(int $noteId, int $userId, array $data);

    public function delete(int $noteId);
}
