<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function suggestions()
    {

        $currentUserId = auth()->user()->id;

        $suggestions = User::where('id', '!=', $currentUserId)
            ->whereNotIn('id', function ($query) use ($currentUserId) {
                $query->select('connection_user_id as id') // Alias 'connection_user_id' as 'id'
                    ->from('connections')
                    ->where('user_id', $currentUserId);
            })->whereNotIn('id', function ($query) use ($currentUserId) {
                $query->select('user_id as id') // Alias 'user_id' as 'id'
                    ->from('connections')
                    ->where('connection_user_id', $currentUserId);
            })
            ->get();

        return response()->json([
            'suggestions' => $suggestions
        ]);
    }
    public function connect(Request $request)
    {
        try {

            $connection = Connection::create([
                'user_id' => auth()->user()->id,
                'connection_user_id' => $request->user_id,
                'status' => 'pending'
            ]);
            return response()->json([
                'connection' => $connection
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function sent_requests()
    {
        $sent_requests = Connection::with('user')->where('user_id', auth()->user()->id)->where('status', 'pending')->get();
        return response()->json([
            'sent_requests' => $sent_requests
        ]);
    }
    public function withdraw_request(Request $request)
    {
        try {
            $connection = Connection::where('id', $request->id)->first();
            $connection->delete();
            return response()->json([
                'message' => 'Request withdrawn successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function received_requests()
    {
        $received_requests = Connection::with('user', 'connection')->where('connection_user_id', auth()->user()->id)->where('status', 'pending')->get();
        return response()->json([
            'received_requests' => $received_requests
        ]);
    }
    public function accept_request(Request $request)
    {
        try {
            $connection = Connection::where('id', $request->id)->first();
            $connection->status = 'accepted';
            $connection->save();
            return response()->json([
                'message' => 'Request accepted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function connections()
    {
        $connections = Connection::with('user', 'commonConnections', 'commonConnectionsOtherSide', 'connection')->where('status', 'accepted')->Where('user_id', auth()->user()->id)->where('status', 'accepted')->get();
        $connectionsOtherSide = Connection::with('user', 'connection', 'commonConnections', 'commonConnectionsOtherSide')->where('status', 'accepted')->Where('connection_user_id', auth()->user()->id)->where('status', 'accepted')->get();
        return response()->json([
            'connections' => $connections,
            'connectionsOtherSide' => $connectionsOtherSide,
        ]);
    }
    public function remove_connection(Request $request)
    {
        try {
            $connection = Connection::where('id', $request->id)->first();
            $connection->delete();
            return response()->json([
                'message' => 'Connection removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function show(Connection $connection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function edit(Connection $connection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Connection $connection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Connection $connection)
    {
        //
    }
}
