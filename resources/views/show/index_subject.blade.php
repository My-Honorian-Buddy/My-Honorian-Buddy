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
                                    Student_ID
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Subject_ID
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    First Name
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Last Name
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Subject Code
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Subject Name
                                </th>
                            </tr>                   

                            <tbody>
                                    @foreach ($students as $student)
                                        @foreach ($student->subject_student as $subjects)
                                        <tr>
                                            <td class="px-6 py-4 border-b border-gray-300 text-sm">
                                                {{$student->id}}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-300 text-sm">
                                                {{$subjects->id}}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-300 text-sm">
                                                {{$student->fname}}               
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-300 text-sm">
                                                {{$student->lname}}
                                            </td>
                                       
                                            <td class="px-6 py-4 border-b border-gray-300 text-sm">
                                                {{$subjects ? $subjects->subj_code : 'No Code' }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-300 text-sm">
                                                {{$subjects ? $subjects->subj_name : 'No Code' }}
                                            </td>
                                        </tr>
                                            @endforeach
                                    @endforeach 
                        </thead>
                    </table>
                </div>     
            </div>
        </x-slot>
    </x-folder>
</x-auth-layout>
