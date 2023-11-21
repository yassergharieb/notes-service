<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Services\INoteService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoteController extends Controller
{
    public function __construct(
        public INoteService $noteService
    ) {
    }

    public function index(Request $request)
    {
        $user_id = $request->headers->get('user_id');

        $data = $this->noteService->getAllUserNotes($user_id);

        return $this->successResponse($data, Response::HTTP_OK);
    }

    public function store(CreateNoteRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->headers->get('user_id');

        $result = $this->noteService->create($data);

        return $this->successResponse($result, Response::HTTP_CREATED);
    }

    public function show(Request $request, int $note_id)
    {
        $user_id = $request->headers->get('user_id');
        $data = $this->noteService->get($note_id, $user_id);

        return $this->successResponse($data, Response::HTTP_OK);
    }

    public function update(UpdateNoteRequest $request, string $note_id)
    {
        $data = $request->all();
        $user_id = $request->headers->get('user_id');
        $data = $this->noteService->update($note_id, $user_id, $data);

        return $this->successResponse($data, Response::HTTP_OK);
    }

    public function destroy(Request $request, int $id)
    {
        $request->all();
        $this->noteService->delete($id);

        return $this->successResponse([], Response::HTTP_OK);
    }

}
