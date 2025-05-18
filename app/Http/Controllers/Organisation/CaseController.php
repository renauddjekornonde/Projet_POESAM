<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CaseController extends Controller
{
    public function index()
    {
        $cases = DB::table('cases')
            ->where('organisation_id', $_COOKIE['user_id'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('organisation.cases.index', compact('cases'));
    }

    public function statistics()
    {
        return view('organisation.cases.statistics');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:harcèlement,agression,discrimination,autre',
            'status' => 'required|in:en_cours,résolu,en_attente'
        ]);

        try {
            DB::table('cases')->insert([
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'status' => $request->status,
                'organisation_id' => $_COOKIE['user_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function getStatistics()
    {
        // Statistiques générales
        $stats = [
            'total' => DB::table('cases')
                ->where('organisation_id', $_COOKIE['user_id'])
                ->count(),
            'in_progress' => DB::table('cases')
                ->where('organisation_id', $_COOKIE['user_id'])
                ->where('status', 'en_cours')
                ->count(),
            'resolved' => DB::table('cases')
                ->where('organisation_id', $_COOKIE['user_id'])
                ->where('status', 'résolu')
                ->count(),
            'pending' => DB::table('cases')
                ->where('organisation_id', $_COOKIE['user_id'])
                ->where('status', 'en_attente')
                ->count(),
            'this_month' => DB::table('cases')
                ->where('organisation_id', $_COOKIE['user_id'])
                ->whereMonth('created_at', now()->month)
                ->count(),
            'by_type' => DB::table('cases')
                ->where('organisation_id', $_COOKIE['user_id'])
                ->select('type', DB::raw('count(*) as count'))
                ->groupBy('type')
                ->get()
        ];

        // Évolution mensuelle sur les 6 derniers mois
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = DB::table('cases')
                ->where('organisation_id', $_COOKIE['user_id'])
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyStats[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }
        $stats['monthly_evolution'] = $monthlyStats;

        // Statistiques par statut et type
        $stats['status_type_matrix'] = DB::table('cases')
            ->where('organisation_id', $_COOKIE['user_id'])
            ->select('type', 'status', DB::raw('count(*) as count'))
            ->groupBy('type', 'status')
            ->get();

        return response()->json($stats);
    }
}
