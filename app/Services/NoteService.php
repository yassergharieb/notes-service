<?php

namespace App\Services;

use App\Models\Note;
use App\Repository\NoteRepository;
use Illuminate\Support\Collection;
use App\Helpers\IPubSubPublisher;

class NoteService implements INoteService
{
    public function __construct(
        public NoteRepository $noteRepository,
        public IPubSubPublisher $pubSubPublisher
    ) {
    }

    public function getAllUserNotes(int $userId): Collection
    {
        return $this->noteRepository->getAllUserNotes($userId);
    }

    public function create(array $data): Note
    {
        $noteObj = $this->noteRepository->create($data);
        $count = $this->noteRepository->getAllUserNotesCount($noteObj->user_id);
        $this->pubSubPublisher->publish('user_added_note', [
            'type' => 'user_added_note',
            'note_id' => $noteObj->id,
            'title' => $noteObj->title,
            "notes_count" => $count,
        ]);

        return $noteObj;
    }

    public function get(int $noteId, int $userId): ?Note
    {
        return $this->noteRepository->get($noteId, $userId);
    }

    public function update(int $noteId, int $userId, array $data): ?Note
    {
        return $this->noteRepository->update($noteId, $userId, $data);
    }

    public function delete(int $noteId): bool
    {
        return $this->noteRepository->delete($noteId);
    }

    public function CreateWelcomeNoteForRegisterdUser(array $data): Note
    {
        $data['title'] = "welcome to our notes app";
        $data['content'] = 'terms and permissions';

        return $this->noteRepository->create($data);
    }

}