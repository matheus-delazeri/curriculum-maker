<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CurriculumController extends Controller
{
    /**
     * Join the current user to a curriculum as reviewer
     * or assembler.
     *
     * TODO: move logic from here to Service class.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function join(int $id)
    {
        $curriculum = Curriculum::findOrFail($id);
        if ($curriculum->customer->id == Auth::id()) {
            throw new \InvalidArgumentException("Unable to join user to it's own curriculum");
        }

        if ($curriculum->join(Auth::user())) {
            session()->flash('success-message', 'Successfully joined the curriculum creation!');
            return redirect()->route('curriculum.view', $curriculum->id);
        }

        session()->flash('error-message', 'Something went wrong while joining the curriculum!');
        return redirect()->route('dashboard');
    }
}
