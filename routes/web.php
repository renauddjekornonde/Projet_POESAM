<?php

use Illuminate\Support\Facades\Route;

// Route pour la page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route pour la page home (tableau de bord des victimes)
Route::get('/home', function (\Illuminate\Http\Request $request) {
    // Vérifier si l'utilisateur est connecté via les cookies
    if (isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true') {
        // Copier les données des cookies vers la session Laravel pour les rendre disponibles dans la vue
        session([
            'user_id' => $_COOKIE['user_id'] ?? null,
            'user_email' => $_COOKIE['user_email'] ?? null,
            'user_name' => $_COOKIE['user_name'] ?? null,
            'user_type' => $_COOKIE['user_type'] ?? null,
            'is_logged_in' => true
        ]);

        // Vérifier le type d'utilisateur
        if (isset($_COOKIE['user_type']) && $_COOKIE['user_type'] !== 'victime') {
            // Rediriger vers le tableau de bord approprié
            if ($_COOKIE['user_type'] === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($_COOKIE['user_type'] === 'organisation') {
                return redirect('/organisation/dashboard');
            }
        }

        // Afficher la page home avec les données de session
        return view('home');
    }

    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    return redirect('/direct-login.php');
})->name('home');

// Routes pour le tableau de bord admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
        // Vérifier si l'utilisateur est connecté en tant qu'admin
        if (isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true' && isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'admin') {
            // Copier les données des cookies vers la session Laravel
            session([
                'user_id' => $_COOKIE['user_id'] ?? null,
                'user_email' => $_COOKIE['user_email'] ?? null,
                'user_name' => $_COOKIE['user_name'] ?? null,
                'user_type' => $_COOKIE['user_type'] ?? null,
                'is_logged_in' => true
            ]);

            // Récupérer les organisations pour le tableau de bord
            try {
                $pdo = new PDO("mysql:host=db;dbname=poesam;charset=utf8mb4", "root", "rootpass", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);

                $stmt = $pdo->prepare("SELECT o.*, u.email, u.created_at as date_creation FROM organisations o JOIN users u ON o.id_user = u.id ORDER BY o.created_at DESC");
                $stmt->execute();
                $organisations = $stmt->fetchAll();

                return view('admin.dashboard', ['organisations' => $organisations]);
            } catch (\Exception $e) {
                return view('admin.dashboard', ['organisations' => [], 'error' => $e->getMessage()]);
            }
        }

        // Si l'utilisateur n'est pas connecté en tant qu'admin, rediriger vers la page de connexion
        return redirect('/direct-login.php');
    })->name('admin.dashboard');

    // Routes pour la gestion des organisations avec le contrôleur
    Route::get('/create-organisation', 'App\Http\Controllers\Admin\OrganisationController@create')->name('admin.create-organisation');
    Route::post('/create-organisation', 'App\Http\Controllers\Admin\OrganisationController@store');
    Route::get('/organisations', 'App\Http\Controllers\Admin\OrganisationController@index')->name('admin.organisations');
    Route::get('/show-organisation/{id}', 'App\Http\Controllers\Admin\OrganisationController@show')->name('admin.show-organisation');
    Route::get('/edit-organisation/{id}', 'App\Http\Controllers\Admin\OrganisationController@edit')->name('admin.edit-organisation');
    Route::match(['get', 'post'], '/update-organisation/{id}', 'App\Http\Controllers\Admin\OrganisationController@update')->name('admin.update-organisation');
    Route::get('/delete-organisation/{id}', 'App\Http\Controllers\Admin\OrganisationController@destroy')->name('admin.delete-organisation');
});

// Routes pour le tableau de bord des organisations
Route::prefix('organisation')->group(function () {
    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
        // Vérifier si l'utilisateur est connecté en tant qu'organisation
        if (isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true' && isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'organisation') {
            // Copier les données des cookies vers la session Laravel
            session([
                'user_id' => $_COOKIE['user_id'] ?? null,
                'user_email' => $_COOKIE['user_email'] ?? null,
                'user_name' => $_COOKIE['user_name'] ?? null,
                'user_type' => $_COOKIE['user_type'] ?? null,
                'is_logged_in' => true
            ]);

            return view('organisation.dashboard');
        }

        // Si l'utilisateur n'est pas connecté en tant qu'organisation, rediriger vers la page de connexion
        return redirect('/direct-login.php');
    })->name('organisation.dashboard');

    // Routes pour les cas
    Route::prefix('cases')->group(function () {
        Route::get('/', 'App\Http\Controllers\Organisation\CaseController@index')->name('organisation.cases.index');
        Route::get('/statistics', 'App\Http\Controllers\Organisation\CaseController@statistics')->name('organisation.cases.statistics');
        Route::get('/statistics/data', 'App\Http\Controllers\Organisation\CaseController@getStatistics')->name('organisation.cases.statistics.data');
        Route::post('/', 'App\Http\Controllers\Organisation\CaseController@store')->name('organisation.cases.store');
    });

    // Routes pour les ressources
    Route::prefix('resources')->group(function () {
        Route::post('/store', 'App\Http\Controllers\Organisation\ResourceController@store')->name('organisation.resources.store');
        Route::get('/', 'App\Http\Controllers\Organisation\ResourceController@index')->name('organisation.resources.index');
        Route::get('/{id}', 'App\Http\Controllers\Organisation\ResourceController@show')->name('organisation.resources.show');
        Route::put('/{id}', 'App\Http\Controllers\Organisation\ResourceController@update')->name('organisation.resources.update');
        Route::delete('/{id}', 'App\Http\Controllers\Organisation\ResourceController@destroy')->name('organisation.resources.destroy');
    });

    // Routes pour les consultations
    Route::prefix('consultations')->group(function () {
        Route::post('/store', 'App\Http\Controllers\Organisation\ConsultationController@store')->name('organisation.consultations.store');
        Route::get('/', 'App\Http\Controllers\Organisation\ConsultationController@index')->name('organisation.consultations.index');
        Route::get('/{id}', 'App\Http\Controllers\Organisation\ConsultationController@show')->name('organisation.consultations.show');
        Route::put('/{id}', 'App\Http\Controllers\Organisation\ConsultationController@update')->name('organisation.consultations.update');
        Route::delete('/{id}', 'App\Http\Controllers\Organisation\ConsultationController@destroy')->name('organisation.consultations.destroy');
    });

    // Routes pour les événements
    Route::prefix('events')->group(function () {
        Route::get('/', 'App\Http\Controllers\Organisation\EventController@index')->name('organisation.events.index');
        Route::post('/', 'App\Http\Controllers\Organisation\EventController@store')->name('organisation.events.store');
        Route::put('/{id}', 'App\Http\Controllers\Organisation\EventController@update')->name('organisation.events.update');
        Route::delete('/{id}', 'App\Http\Controllers\Organisation\EventController@destroy')->name('organisation.events.destroy');
    });

    // Routes pour le profil
    Route::prefix('profile')->group(function () {
        Route::get('/', 'App\Http\Controllers\Organisation\ProfileController@show')->name('organisation.profile.show');
        Route::put('/update', 'App\Http\Controllers\Organisation\ProfileController@update')->name('organisation.profile.update');
    });
});

// Route de redirection pour résoudre l'erreur 'Route [login] not defined'
Route::get('/login', function () {
    return redirect('/direct-login.php');
})->name('login');

// Les routes d'authentification Laravel ont été supprimées car nous utilisons maintenant direct-login.php et direct-register.php
