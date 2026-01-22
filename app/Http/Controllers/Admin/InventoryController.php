<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $items = \App\Models\InventoryItem::latest()->paginate(10);
        return view('admin.inventory.index', compact('items'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        \App\Models\InventoryItem::create($validated);

        return redirect()->route('inventory.index')->with('success', 'Item added to inventory.');
    }

    public function addMovement(\App\Models\InventoryItem $item)
    {
        return view('admin.inventory.movement', compact('item'));
    }

    public function storeMovement(Request $request, \App\Models\InventoryItem $item)
    {
        $validated = $request->validate([
            'movement_type' => 'required|in:In,Out,Damaged,Lost,Return',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string',
            'movement_date' => 'required|date',
        ]);

        $item->movements()->create([
            'movement_type' => $validated['movement_type'],
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'] ?? null,
            'movement_date' => $validated['movement_date'],
            'handled_by' => auth()->id(),
            'item_id' => $item->id
        ]);

        // Update Stock
        if ($validated['movement_type'] === 'In' || $validated['movement_type'] === 'Return') {
            $item->increment('quantity', $validated['quantity']);
        } else {
            $item->decrement('quantity', $validated['quantity']);
        }

        return redirect()->route('inventory.index')->with('success', 'Inventory movement recorded.');
    }

    public function destroy(\App\Models\InventoryItem $item)
    {
        $item->movements()->delete();
        $item->delete();
        return redirect()->route('inventory.index')->with('success', 'Item deleted successfully.');
    }
}
