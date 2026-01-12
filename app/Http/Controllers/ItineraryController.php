<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    public function create(Trip $trip)
    {
        // 他人の旅行に追加できないようにチェック
        abort_if($trip->user_id !== Auth::id(), 403);

        return view('itineraries.create', compact('trip'));
    }

    /**
     * 旅程の作成（Trip に紐づけて）
     */
    public function store(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'nullable|string',
            'title' => 'required|string|max:255',
            'note' => 'nullable|string',
            'cost' => 'nullable|integer',
            'transport' => 'nullable|string',
            'from_place' => 'nullable|string',
            'to_place' => 'nullable|string',
            'duration_minutes' => 'nullable|integer',
            'distance_km' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $data['trip_id'] = $trip->id;

        Itinerary::create($data);

        return redirect()->route('trips.show', $trip);
    }

    /**
     * 編集画面
     */
    public function edit(Trip $trip, Itinerary $itinerary)
    {
        // itinerary がこの trip に属していなければ 404
        abort_if($itinerary->trip_id !== $trip->id, 404);
    
        // trip の所有者チェック
        abort_if($trip->user_id !== Auth::id(), 403);
    
        return view('itineraries.edit', compact('trip', 'itinerary'));
    }    

    /**
     * 更新処理
     */
    public function update(Request $request, Trip $trip, Itinerary $itinerary)
    {
        $validated = $request->validate([
            'date'  => 'required|date',
            'time'  => 'nullable|string',
            'title' => 'required|string',
            'note'  => 'nullable|string',
            'cost'  => 'nullable|integer',
        ]);
    
        $itinerary->update($validated);
    
        return redirect()->route('trips.show', $trip)
            ->with('success', 'Itinerary updated successfully.');
    }   

    /**
     * 削除
     */
    public function destroy(Trip $trip, Itinerary $itinerary)
    {
        abort_if($itinerary->trip->user_id !== Auth::id(), 403);

        $trip = $itinerary->trip;
        $itinerary->delete();

        return redirect()->route('trips.show', $trip);
    }

    /**
     * 並び順更新（ドラッグ&ドロップ）
     */
    public function updateOrder(Request $request)
    {
        $order = $request->input('order', []);
    
        foreach ($order as $index => $id) {
            $itinerary = Itinerary::find($id);
    
            if ($itinerary && $itinerary->trip->user_id === Auth::id()) {
                $itinerary->sort_order = $index + 1;
                $itinerary->save();
            }
        }
    
        return response()->json(['status' => 'success']);
    }    
}
