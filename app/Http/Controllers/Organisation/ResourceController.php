<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = DB::table('resources')
            ->where('organisation_id', $_COOKIE['user_id'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('organisation.resources.index', compact('resources'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:document,video,audio,image,link',
            'description' => 'required|string',
            'file' => 'nullable|file|max:10240', // 10MB max
            'url' => 'nullable|url',
            'tags' => 'nullable|string'
        ]);

        $data = [
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'organisation_id' => $_COOKIE['user_id'],
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Gérer le fichier uploadé
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . Str::slug($file->getClientOriginalName());
            $path = $file->storeAs('resources', $filename, 'public');
            $data['file_path'] = $path;
        }

        // Gérer l'URL
        if ($request->filled('url')) {
            $data['url'] = $request->url;
        }

        // Gérer les tags
        if ($request->filled('tags')) {
            $data['tags'] = $request->tags;
        }

        try {
            DB::table('resources')->insert($data);
            return redirect()->route('organisation.dashboard')
                ->with('success', 'Ressource ajoutée avec succès');
        } catch (\Exception $e) {
            return redirect()->route('organisation.dashboard')
                ->with('error', 'Erreur lors de l\'ajout de la ressource: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $resource = DB::table('resources')
            ->where('id', $id)
            ->where('organisation_id', $_COOKIE['user_id'])
            ->first();

        if (!$resource) {
            return redirect()->route('organisation.dashboard')
                ->with('error', 'Ressource non trouvée');
        }

        return view('organisation.resources.show', compact('resource'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:document,video,audio,image,link',
            'description' => 'required|string',
            'file' => 'nullable|file|max:10240',
            'url' => 'nullable|url',
            'tags' => 'nullable|string'
        ]);

        $resource = DB::table('resources')
            ->where('id', $id)
            ->where('organisation_id', $_COOKIE['user_id'])
            ->first();

        if (!$resource) {
            return redirect()->route('organisation.dashboard')
                ->with('error', 'Ressource non trouvée');
        }

        $data = [
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'updated_at' => now()
        ];

        if ($request->hasFile('file')) {
            // Supprimer l'ancien fichier s'il existe
            if ($resource->file_path) {
                Storage::disk('public')->delete($resource->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . Str::slug($file->getClientOriginalName());
            $path = $file->storeAs('resources', $filename, 'public');
            $data['file_path'] = $path;
        }

        if ($request->filled('url')) {
            $data['url'] = $request->url;
        }

        if ($request->filled('tags')) {
            $data['tags'] = $request->tags;
        }

        try {
            DB::table('resources')
                ->where('id', $id)
                ->update($data);

            return redirect()->route('organisation.dashboard')
                ->with('success', 'Ressource mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->route('organisation.dashboard')
                ->with('error', 'Erreur lors de la mise à jour de la ressource: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $resource = DB::table('resources')
            ->where('id', $id)
            ->where('organisation_id', $_COOKIE['user_id'])
            ->first();

        if (!$resource) {
            return redirect()->route('organisation.dashboard')
                ->with('error', 'Ressource non trouvée');
        }

        try {
            // Supprimer le fichier s'il existe
            if ($resource->file_path) {
                Storage::disk('public')->delete($resource->file_path);
            }

            DB::table('resources')
                ->where('id', $id)
                ->delete();

            return redirect()->route('organisation.dashboard')
                ->with('success', 'Ressource supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->route('organisation.dashboard')
                ->with('error', 'Erreur lors de la suppression de la ressource: ' . $e->getMessage());
        }
    }
}
