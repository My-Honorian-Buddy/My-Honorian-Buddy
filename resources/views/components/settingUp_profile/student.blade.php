<x-auth-layout>
    <x-folder>
        <x-slot name="header">
            Student 
        </x-slot>    
        <x-slot name="content">
            <div class="flex items-center justify-center">
                <div> 
                    <br> <br>
                    <div>
                        <form method="POST" action="{{ route('profile.student.store') }}"> 
                            @csrf 
                            <label class="block font-bold font-poppins text-secondary text-maroon text-lg">
                                First name: <input type="text" name="fname" class="input-field"> 
                            </label> <br>
                            
                            <label class="block font-bold font-poppins text-secondary text-maroon text-lg">
                                Last name:  <input type="text" name="lname" class="input-field"> 
                            </label> <br>
                            
                            <label class="block font-bold font-poppins text-secondary text-maroon text-lg">
                                Year level: <input type="text" name="year_level" class="input-field"> 
                            </label><br>
                            
                            <label class="block font-bold font-poppins text-secondary text-maroon text-lg">
                                Department: <input type="text" name="department" class="input-field"> 
                            </label><br>

                            <div class="flex items-center justify-between mt-4">
                                <input type="submit" value="Submit" class="btn-submit">
                                <a href="{{ route('dashboard') }}" class="btn-dashboard ml-4">
                                    Go to Dashboard
                                </a>
                            </div>
                        </form>  
                    </div>
                </div>
            </div>
        </x-slot>
    </x-folder>
</x-auth-layout>

<style>
    .input-field {
        border: 3px solid black; 
        border-radius: 4px; 
        padding: 8px;
        width: 100%; 
        transition: border-color 0.3s ease, transform 0.2s ease; 
    }

    .input-field:focus {
        border-color: maroon;
        transform: scale(1.02); 
        outline: none; 
    }

    .text-maroon {
        color: maroon;
    }
    .btn-submit, .btn-dashboard {
        background-color: maroon; 
        color: white; 
        padding: 10px 20px; 
        border: none; 
        border-radius: 5px; 
        font-weight: bold; 
        cursor: pointer;
        display: inline-block; 
        text-align: center; 
        transition: background-color 0.3s ease, transform 0.2s ease; 
    }

    .btn-submit:hover, .btn-dashboard:hover {
        background-color: darkred;
        transform: scale(1.05);
    }
</style>