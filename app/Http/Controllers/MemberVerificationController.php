<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberVerificationController extends Controller
{
    public function verify($id)
    {
        $member = Member::findOrFail($id);
        
        if (!$member->is_active) {
            return response()->json([
                'status' => 'inactive',
                'message' => 'Member is not active',
            ], 403);
        }

        if ($member->membership_end_date->isPast()) {
            return response()->json([
                'status' => 'expired',
                'message' => 'Membership has expired',
            ], 403);
        }

        return response()->json([
            'status' => 'valid',
            'member' => [
                'name' => $member->full_name,
                'membership_number' => $member->membership_number,
                'email' => $member->email,
            ],
        ]);
    }
}
