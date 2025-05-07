<x-auth-layout>
    <x-folder>
        <x-slot name="header">
            Users Table
        </x-slot>
        <x-slot name="content">
            <div class="overflow-x-auto">
                <div class="min-w-full shadow rounded-lg overflow-hidden">
                    <table class="min-w-full leading normal">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    User_ID
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Username
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Department
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Rate per Sessions
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Role
                                </th>
                            </tr>                            
                            <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="px-6 py-4 border-b border-gray-300 text-sm">
                                                {{$user->id}}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-300 text-sm">
                                                {{$user->name}}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-300 text-sm">
                                                {{$user->schedule ? implode(', ', $user->schedule->days_week) : 'No department' }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-300 text-sm">
                                                {{$user->schedule ?\Carbon\Carbon::createFromFormat('H:i:s', $user->schedule->start_time)->format('g:i A') : 'No department' }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-300 text-sm">
                                                {{$user->schedule ? \Carbon\Carbon::createFromFormat('H:i:s', $user->schedule->end_time)->format('g:i A') : 'No department' }}
                                            </td>
                                            <td>
                                                {{$user->role}}
                                            </td>
                                        </tr>
                                    @endforeach 
                            </tbody>
                        </thead>
                    </table>
                </div>    
            </div>
        </x-slot>
    </x-folder>
</x-auth-layout>
