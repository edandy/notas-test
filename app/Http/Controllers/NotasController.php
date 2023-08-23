<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Models\Nota;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotasController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $search = $request->has('search') ? $request->get('search') : null;
        $notas = Nota::when($search, function ($query) use ($search) {
                            $query->where('titulo', 'like', "%$search%");
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(10);

        return Inertia::render('Notas', [
            'notas' => $notas,
            'filters' => \Illuminate\Support\Facades\Request::all('search')
        ]);
    }

    /**
     * @param StoreNoteRequest $request
     * @return RedirectResponse
     */
    public function store(StoreNoteRequest $request): RedirectResponse
    {
        Nota::updateOrCreate([
            'id' => $request->input('id'),
        ],[
            'titulo' => $request->input('titulo'),
            'contenido' => $request->input('contenido'),
        ]);

        $message = $request->has('id') ? 'La nota se guardo correctamente' : 'La nota se creo correctamente';
        return to_route('nota')->with('message', $message);
    }

    /**
     * @param Nota $nota
     * @return RedirectResponse
     */
    public function delete(Nota $nota): RedirectResponse
    {
        $nota->delete();
        return to_route('nota')->with('message', "La nota <strong>$nota->titulo</strong> fue eliminada correctamente");
    }
}
