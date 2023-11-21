<?php

namespace App\Repository;

use App\Models\Note;

class NoteRepository implements NoteRepositoryInterface
{
    public function create(array $data)
    {
        return Note::create($data);
    }

    public function getAllUserNotes(int $userId)
    {
        return Note::where("user_id", $userId)->paginate(10);
    }

    public function getAllUserNotesCount(int $userId)
    {
        return Note::where("user_id", $userId)->count();
    }

    public function get(int $noteId, int $userId)
    {
        return Note::where('user_id', $userId)->whereId($noteId)->limit(1)->get()->first();
    }

    public function update(int $noteId, int $userId, array $data)
    {
        $note = $this->get($noteId, $userId);

        $note->update($data);

        return $note;
    }

    public function delete(int $noteId)
    {
        return Note::destroy($noteId);
    }
}