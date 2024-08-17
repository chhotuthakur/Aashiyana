<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Clients::all();
        return response()->json($clients);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'referred_by' => 'nullable|exists:clients,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'address' => 'required|string|max:255',
            'pin' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'assign' => 'required|string|max:255',
            'earnings' => 'required|numeric|min:0',
            'wallet_balance' => 'required|numeric|min:0',
            'role' => 'required|string|max:255',
            'is_Active' => 'required|boolean',
        ]);

        $client = Clients::create($validated);

        return response()->json(['message' => 'Client created successfully.', 'client' => $client], 201);
    }

    public function show($id)
    {
        $client = Clients::findOrFail($id);
        return response()->json($client);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'referred_by' => 'nullable|exists:clients,id',
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255',
            'address' => 'sometimes|required|string|max:255',
            'pin' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'state' => 'sometimes|required|string|max:255',
            'country' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|required|string|max:255',
            'password' => 'sometimes|required|string|max:255',
            'assign' => 'sometimes|required|string|max:255',
            'earnings' => 'sometimes|required|numeric|min:0',
            'wallet_balance' => 'sometimes|required|numeric|min:0',
            'role' => 'sometimes|required|string|max:255',
            'is_Active' => 'sometimes|required|boolean',
        ]);

        $client = Clients::findOrFail($id);
        $client->update($validated);

        return response()->json(['message' => 'Client updated successfully.', 'client' => $client]);
    }

    public function destroy($id)
    {
        $client = Clients::findOrFail($id);
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully.']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $client = Clients::where('email', $credentials['email'])->first();

        if ($client && Hash::check($credentials['password'], $client->password)) {
            Session::put('client_id', $client->id);
            return redirect()->route('home'); // Assuming you have a home route after login
        } else {
            return redirect()->back()->withErrors('Invalid email or password.');
        }
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email',
            'password' => 'required|string|min:8|confirmed',
            
        ]);

        $client = Clients::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $request->input('phone', ''), // Add other fields as necessary
            'address' => $request->input('address', ''),
            'city' => $request->input('city', ''),
            'pin' => 'required|string|max:255',
            'state' => $request->input('state', ''),
            'country' => $request->input('country', ''),
            'role' => 'User',
            'is_Active' => true,
            
        ]);

        Session::put('client_id', $client->id);
        return redirect()->route('home'); // Assuming you have a home route after registration
    }

}
