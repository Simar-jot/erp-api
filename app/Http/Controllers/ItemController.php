<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = Item::query();

        if ($request->has('search')) {
            $search = $request->search;
            $items->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
        }

        $items = $items->paginate(10);

        return response()->json($items);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        $item = Item::create($request->all());

        return response()->json([
            'message' => 'Item created successfully',
            'item' => $item,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, string $id)
    {
        try {
            $item = Item::findOrFail($id);

            $item->update($request->all());

            return response()->json([
                'message' => 'Item updated successfully',
                'item' => $item,
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Item not found.'], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong. Please try again.',
                'error' => $th->getMessage()
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Item::findOrFail($id);
            $item->delete();
            return response()->json(['message' => 'Item deleted successfully.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Item not found.'], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong. Please try again.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
