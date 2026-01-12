<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TripController extends Controller
{
    /**
     * 旅行一覧
     */
    public function index(Request $request)
    {
        $trips = Trip::with('user')
            ->where('user_id', Auth::id())
            // 検索キーワードがある場合のみ実行
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('destination', 'like', "%{$search}%")
                      ->orWhere('memo', 'like', "%{$search}%");
                });
            })
            ->orderBy('start_date', 'desc')
            ->get();
    
        return view('trips.index', compact('trips'));
    }

    /**
     * 作成画面
     */
    public function create()
    {
        return view('trips.create');
    }

    /**
     * 保存
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'memo' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $data['user_id'] = Auth::id();

        Trip::create($data);

        return redirect()->route('trips.index');
    }

    /**
     * 詳細表示
     */
    public function show(Trip $trip)
    {
        // 旅程を日付と時間でソート
        $itineraries = $trip->itineraries()
            ->orderBy('date')
            ->orderByRaw('CASE 
                WHEN time IS NULL OR time = "" THEN "99:99"
                ELSE time 
            END')
            ->orderBy('display_order')
            ->get();
    
        // 日付ごとにグループ化
        $itinerariesByDate = $itineraries->groupBy('date');
    
        // 日別の合計金額を計算
        $dailyCosts = $itinerariesByDate->map(function ($items) {
            return $items->sum('cost');
        });
    
        return view('trips.show', compact('trip', 'itinerariesByDate', 'dailyCosts'));
    }

    /**
     * 編集画面
     */
    public function edit(Trip $trip)
    {
        if ($trip->user_id !== Auth::id()) {
            abort(403);
        }
    
        return view('trips.edit', compact('trip'));
    }    

    /**
     * 更新
     */
    public function update(Request $request, Trip $trip)
    {
        abort_if($trip->user_id !== Auth::id(), 403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'memo' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $trip->update($data);

        return redirect()->route('trips.show', $trip);
    }

    /**
     * 削除
     */
    public function destroy(Trip $trip)
    {
        abort_if($trip->user_id !== Auth::id(), 403);

        $trip->delete();

        return redirect()->route('trips.index');
    }


    public function exportPdf(Trip $trip)
    {
        // 旅程データを日付順・時間順に取得
        $itinerariesByDate = $trip->itineraries()
            ->orderBy('date')
            ->orderBy('time')
            ->get()
            ->groupBy('date');

        // PDF生成（A4サイズ・縦）
        $pdf = Pdf::loadView('trips.pdf', [
            'trip' => $trip,
            'itinerariesByDate' => $itinerariesByDate,
        ])->setPaper('a4', 'portrait');

        return $pdf->download($trip->title . '_itinerary.pdf');
    }
}
