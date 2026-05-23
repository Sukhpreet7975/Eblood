<?php

namespace App\Services;

use App\Mail\EmergencyRequestMail;
use App\Models\BloodRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use MongoDB\BSON\Regex;

class RequestService
{
    public function createEmergencyRequest(array $payload): BloodRequest
    {
        $request = BloodRequest::create(array_merge($payload, [
            'status' => 'Pending',
        ]));

        Mail::to('admin@eblood.com')->send(new EmergencyRequestMail($payload));

        return $request;
    }

    public function getRequesterHomeData(User $user): array
    {
        $requests = BloodRequest::where('user_id', $user->id)
            ->select(['_id', 'patient_name', 'blood_group', 'hospital', 'city', 'status', 'admin_message', 'created_at'])
            ->latest()
            ->get();

        $totalRequests = $requests->count();
        $pendingRequests = $requests->where('status', 'Pending')->count();
        $approvedRequests = $requests->where('status', 'Approved')->count();
        $completedRequests = $requests->where('status', 'Completed')->count();
        $rejectedRequests = $requests->where('status', 'Rejected')->count();
        $recentRequests = $requests->take(5);

        return compact(
            'user',
            'totalRequests',
            'pendingRequests',
            'approvedRequests',
            'completedRequests',
            'rejectedRequests',
            'recentRequests'
        );
    }

    public function getRequesterRequests(User $user)
    {
        return BloodRequest::where('user_id', $user->id)
            ->select(['_id', 'patient_name', 'blood_group', 'hospital', 'city', 'status', 'message', 'admin_message', 'created_at', 'status_updated_at'])
            ->latest()
            ->paginate(10);
    }

    public function getRequestDetail(string $id): ?BloodRequest
    {
        return BloodRequest::find($id);
    }

    public function cancelRequest(BloodRequest $request, User $user): bool
    {
        if ($request->user_id !== $user->id) {
            return false;
        }

        $request->delete();

        return true;
    }

    public function updateRequestStatus(string $id, array $payload): ?BloodRequest
    {
        $bloodRequest = BloodRequest::find($id);

        if (! $bloodRequest) {
            return null;
        }

        $bloodRequest->update($payload);

        return $bloodRequest;
    }

    public function buildRequestQuery(Request $request)
    {
        $query = BloodRequest::with('user');

        if ($request->filled('patient_name')) {
            $regex = new Regex(preg_quote($request->patient_name), 'i');
            $query->where('patient_name', 'regex', $regex);
        }

        $requesterEmail = $request->input('requester_email', $request->input('donor_email'));

        if (! empty($requesterEmail)) {
            $regex = new Regex(preg_quote($requesterEmail), 'i');
            $requesterIds = User::where('email', 'regex', $regex)
                ->pluck('_id')
                ->toArray();

            if (! empty($requesterIds)) {
                $query->whereIn('user_id', $requesterIds);
            } else {
                $query->where('user_id', null);
            }
        }

        if ($request->filled('blood_group')) {
            $query->where('blood_group', $request->blood_group);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query;
    }
}
