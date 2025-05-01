<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Quick Stats -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                <h3 class="text-lg font-semibold mb-2">Total Members</h3>
                <p class="text-2xl font-bold">{{ \App\Models\Member::count() }}</p>
            </div>
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                <h3 class="text-lg font-semibold mb-2">Active Members</h3>
                <p class="text-2xl font-bold">{{ \App\Models\Member::where('is_active', true)->count() }}</p>
            </div>
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                <h3 class="text-lg font-semibold mb-2">Expired Memberships</h3>
                <p class="text-2xl font-bold">{{ \App\Models\Member::where('membership_end_date', '<', now())->count() }}</p>
            </div>
        </div>

        <!-- Member Management and Scanner -->
        <div class="grid gap-4 md:grid-cols-2">
            <!-- Member Management -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                <h3 class="text-lg font-semibold mb-4">Member Management</h3>
                <div class="space-y-4">
                    <a href="{{ route('filament.admin.resources.members.index') }}" 
                       class="block w-full rounded-lg bg-blue-500 px-4 py-2 text-center text-white hover:bg-blue-600">
                        Manage Members
                    </a>
                    <a href="{{ route('filament.admin.resources.members.create') }}" 
                       class="block w-full rounded-lg bg-green-500 px-4 py-2 text-center text-white hover:bg-green-600">
                        Add New Member
                    </a>
                </div>
            </div>

            <!-- QR Scanner -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                <h3 class="text-lg font-semibold mb-4">Member Verification</h3>
                <a href="{{ route('member.scanner') }}" 
                   class="block w-full rounded-lg bg-purple-500 px-4 py-2 text-center text-white hover:bg-purple-600">
                    Open QR Scanner
                </a>
            </div>
        </div>

        <!-- Recent Members -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <h3 class="text-lg font-semibold mb-4">Recent Members</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Membership Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiry Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(\App\Models\Member::latest()->take(5)->get() as $member)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $member->full_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $member->membership_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $member->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $member->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $member->membership_end_date->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
