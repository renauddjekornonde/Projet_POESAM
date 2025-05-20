<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrganisationController extends Controller
{
    /**
     * Afficher le formulaire de création d'une organisation
     */
    public function create()
    {
        if (!session('is_logged_in') || session('user_type') !== 'admin') {
            return redirect('/login');
        }

        return view('admin.create-organisation');
    }

    /**
     * Traiter le formulaire de création d'organisation
     */
    public function store(Request $request)
    {
        if (!session('is_logged_in') || session('user_type') !== 'admin') {
            return redirect('/login');
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'type' => 'required|string|in:ONG,Association,Fondation,Autre',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'adresse' => 'required|string',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Créer l'utilisateur
            $userId = DB::table('users')->insertGetId([
                'name' => $request->nom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Créer l'organisation
            DB::table('organisations')->insert([
                'id_user' => $userId,
                'nom' => $request->nom,
                'type' => $request->type,
                'telephone' => $request->telephone,
                'adresse' => $request->adresse,
                'description' => $request->description,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return redirect('/admin/organisations')
                ->with('success', 'L\'organisation a été créée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la création de l\'organisation.')
                ->withInput();
        }
    }

    /**
     * Afficher la liste des organisations
     */
    public function index()
    {
        if (!session('is_logged_in') || session('user_type') !== 'admin') {
            return redirect('/login');
        }

        $organisations = DB::table('organisations')
            ->join('users', 'organisations.id_user', '=', 'users.id')
            ->select('organisations.*', 'users.email', 'users.created_at as date_creation')
            ->orderBy('organisations.created_at', 'desc')
            ->get();

        return view('admin.organisations', ['organisations' => $organisations]);
    }

    /**
     * Afficher les détails d'une organisation
     */
    public function show($id)
    {
        if (!session('is_logged_in') || session('user_type') !== 'admin') {
            return redirect('/login');
        }

        $organisation = DB::table('organisations')
            ->join('users', 'organisations.id_user', '=', 'users.id')
            ->select('organisations.*', 'users.email', 'users.created_at as date_creation')
            ->where('organisations.id', $id)
            ->first();

        if (!$organisation) {
            return redirect('/admin/organisations')
                ->with('error', 'Organisation non trouvée.');
        }

        return view('admin.show-organisation', ['organisation' => $organisation]);
    }

    /**
     * Afficher le formulaire de modification d'une organisation
     */
    public function edit($id)
    {
        if (!session('is_logged_in') || session('user_type') !== 'admin') {
            return redirect('/login');
        }

        $organisation = DB::table('organisations')
            ->join('users', 'organisations.id_user', '=', 'users.id')
            ->select('organisations.*', 'users.email', 'users.created_at as date_creation')
            ->where('organisations.id', $id)
            ->first();

        if (!$organisation) {
            return redirect('/admin/organisations')
                ->with('error', 'Organisation non trouvée.');
        }

        return view('admin.edit-organisation', ['organisation' => $organisation]);
    }

    /**
     * Mettre à jour une organisation
     */
    public function update(Request $request, $id)
    {
        if (!session('is_logged_in') || session('user_type') !== 'admin') {
            return redirect('/login');
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'type' => 'required|string|in:ONG,Association,Fondation,Autre',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'telephone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'adresse' => 'required|string',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Mettre à jour l'organisation
            DB::table('organisations')
                ->where('id', $id)
                ->update([
                    'nom' => $request->nom,
                    'type' => $request->type,
                    'telephone' => $request->telephone,
                    'adresse' => $request->adresse,
                    'description' => $request->description,
                    'updated_at' => now()
                ]);

            // Mettre à jour l'utilisateur
            $userData = [
                'name' => $request->nom,
                'email' => $request->email,
                'updated_at' => now()
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            DB::table('users')
                ->where('id', $request->user_id)
                ->update($userData);

            DB::commit();

            return redirect('/admin/show-organisation/' . $id)
                ->with('success', 'Organisation mise à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour de l\'organisation.')
                ->withInput();
        }
    }

    /**
     * Supprimer une organisation
     */
    public function destroy($id)
    {
        if (!session('is_logged_in') || session('user_type') !== 'admin') {
            return redirect('/login');
        }

        try {
            DB::beginTransaction();

            $organisation = DB::table('organisations')->where('id', $id)->first();

            if (!$organisation) {
                return redirect('/admin/organisations')
                    ->with('error', 'Organisation non trouvée.');
            }

            // Supprimer l'organisation
            DB::table('organisations')->where('id', $id)->delete();

            // Supprimer l'utilisateur associé
            DB::table('users')->where('id', $organisation->id_user)->delete();

            DB::commit();

            return redirect('/admin/organisations')
                ->with('success', 'Organisation supprimée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/organisations')
                ->with('error', 'Une erreur est survenue lors de la suppression de l\'organisation.');
        }
    }
}
