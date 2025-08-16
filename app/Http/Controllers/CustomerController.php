<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Resources\SearchResultCollection;
use App\Http\Requests\CustomerSearchRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Customer::all();
    }

    public function search(CustomerSearchRequest $request) {
        return SearchResultCollection::make(Customer::search($request->validated()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:customers,email',
        ]);

        $customer = Customer::create($validated);

        return response()->json($customer, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Customer::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);
        $customer = Customer::findOrFail($id);
        $customer->update($validated);
        return response()->json($customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json(['message' => 'Post deleted']);
    }
}
