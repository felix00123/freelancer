<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\MemberScan;
use Livewire\Component;
use Livewire\Attributes\On;

class MemberScanner extends Component
{
    public $scannedData = '';
    public $verificationResult = [];
    public $error = '';

    public function mount()
    {
        $this->resetState();
    }

    public function resetState()
    {
        $this->scannedData = '';
        $this->verificationResult = [];
        $this->error = '';
    }

    public function render()
    {
        return view('filament.pages.member-scanner');
    }

    #[On('qr-code-scanned')]
    public function handleScannedData($data)
    {
        $this->scannedData = $data;
        $this->verifyMember($data);
    }

    public function verifyMember($data)
    {
        try {
            $member = Member::where('membership_number', $data)->first();

            if (!$member) {
                $this->verificationResult = [
                    'status' => 'invalid',
                    'message' => 'Member not found'
                ];
                return;
            }

            // Record the scan
            MemberScan::create([
                'member_id' => $member->id,
                'scanned_by' => auth()->id(),
                'scanned_at' => now(),
            ]);

            $this->verificationResult = [
                'status' => 'valid',
                'member' => [
                    'name' => $member->full_name,
                    'membership_number' => $member->membership_number,
                    'email' => $member->email,
                    'photo_url' => $member->photo_url,
                ]
            ];
        } catch (\Exception $e) {
            $this->error = 'Error verifying member: ' . $e->getMessage();
            $this->verificationResult = [];
        }
    }

    protected function extractMemberId($data)
    {
        // Extract the member ID from the URL
        if (preg_match('/\/member\/verify\/(\d+)/', $data, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function resetScanner()
    {
        $this->resetState();
        $this->dispatch('reset-scanner');
    }
}
