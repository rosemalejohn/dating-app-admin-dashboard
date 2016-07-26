<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{

    public function update(Request $request, Note $note)
    {
        $note->update($request->all());
        return response()->json('Note updated!');
    }

    public function delete(Note $note)
    {
        $note->delete();
        return response()->json('Note deleted!');
    }
}
