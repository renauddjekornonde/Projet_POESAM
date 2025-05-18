<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function show()
    {
        // Récupérer les informations de l'organisation
        $organisation = DB::table('users')
            ->join('organisations', 'users.id', '=', 'organisations.id_user')
            ->where('users.id', $_COOKIE['user_id'])
            ->select(
                'users.name',
                'users.email',
                DB::raw('DATE_FORMAT(users.created_at, "%d/%m/%Y") as created_at'),
                'organisations.telephone_organisation as phone',
                'organisations.adresse_organisation as address',
                'organisations.description_organisation as description',
                'organisations.logo_organisation as logo'
            )
            ->first();

        // Récupérer les statistiques
        $stats = [
            'total_cases' => DB::table('cases')
                ->where('organisation_id', $_COOKIE['user_id'])
                ->count(),
            'resolved_cases' => DB::table('cases')
                ->where('organisation_id', $_COOKIE['user_id'])
                ->where('status', 'résolu')
                ->count()
        ];

        return view('organisation.profile.show', compact('organisation', 'stats'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'new_password' => 'nullable|min:8|confirmed'
        ]);

        try {
            DB::beginTransaction();

            // Mettre à jour les informations de l'utilisateur
            $updateUser = [
                'name' => $request->name,
                'email' => $request->email,
                'updated_at' => now()
            ];

            if ($request->filled('new_password')) {
                $updateUser['password'] = Hash::make($request->new_password);
            }

            DB::table('users')
                ->where('id', $_COOKIE['user_id'])
                ->update($updateUser);

            // Mettre à jour les informations de l'organisation
            $updateOrg = [
                'telephone_organisation' => $request->phone,
                'adresse_organisation' => $request->address,
                'description_organisation' => $request->description,
                'updated_at' => now()
            ];

            // Gérer le téléchargement du logo
            if ($request->hasFile('logo')) {
                // Supprimer l'ancien logo s'il existe
                $oldLogo = DB::table('organisations')
                    ->where('id_user', $_COOKIE['user_id'])
                    ->value('logo_organisation');

                if ($oldLogo) {
                    Storage::delete('public/' . $oldLogo);
                }

                // Sauvegarder le nouveau logo
                $path = $request->file('logo')->store('organisations/logos', 'public');
                $updateOrg['logo_organisation'] = $path;
            }

            DB::table('organisations')
                ->where('id_user', $_COOKIE['user_id'])
                ->update($updateOrg);

            DB::commit();

            return redirect()
                ->route('organisation.profile.show')
                ->with('success', 'Profil mis à jour avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('organisation.profile.show')
                ->with('error', 'Une erreur est survenue lors de la mise à jour du profil');
        }
    }
}
