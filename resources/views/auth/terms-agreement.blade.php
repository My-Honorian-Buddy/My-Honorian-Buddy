<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Agreement - My Honorian Buddy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-poppins bg-mainbackground">
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header Section -->
        <div class="bg-primary text-accent rounded-t-xl border-2 border-black p-8 shadow-lg">
            <h1 class="text-4xl md:text-5xl font-dela font-bold mb-2">Terms and Agreement</h1>
            <p class="text-lg opacity-90">Please read and accept our terms to continue</p>
        </div>
        
        <!-- Content Section -->
        <div class="bg-accent rounded-b-xl border-2 border-t-0 border-black shadow-lg p-8 md:p-12">
            <div class="mb-8 bg-primary bg-opacity-10 border-l-4 border-primary p-4 rounded">
                <p class="text-gray-800 leading-relaxed">
                    <strong>Effective Date:</strong> {{ now()->format('F d, Y') }}<br>
                    Please read these terms and conditions and privacy policy carefully before using our platform.
                </p>
            </div>
            
            <!-- Tabs -->
            <div class="mb-6">
                <div class="border-b-2 border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button onclick="showTab('terms')" id="terms-tab" class="tab-button active border-b-4 border-primary text-primary font-bold py-4 px-1 font-poppins">
                            Terms & Conditions
                        </button>
                        <button onclick="showTab('privacy')" id="privacy-tab" class="tab-button border-b-4 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-bold py-4 px-1 font-poppins">
                            Privacy Policy
                        </button>
                    </nav>
                </div>
            </div>
            
            <!-- Scrollable Content Container -->
            <div class="max-h-96 overflow-y-auto border-2 border-gray-200 rounded-lg p-6 mb-8 bg-gray-50">
                <!-- Terms and Conditions Tab Content -->
                <div id="terms-content" class="tab-content">
                <!-- Introduction -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">1. Introduction</h2>
                    <p class="text-gray-700 leading-relaxed mb-4 text-base">
                        Welcome to My Honorian Buddy. These Terms and Conditions govern your access to and use of our website and services. By accessing or using My Honorian Buddy, you agree to be bound by these Terms. If you do not agree to abide by the above, please do not use this service.
                    </p>
                </section>

                <!-- Use License -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">2. Use License</h2>
                    <p class="text-gray-700 leading-relaxed mb-4 text-base">
                        Permission is granted to temporarily download one copy of the materials (information or software) on My Honorian Buddy for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 ml-6 mb-4">
                        <li>Modifying or copying the materials</li>
                        <li>Using the materials for any commercial purpose or for any public display</li>
                        <li>Attempting to decompile or reverse engineer any software contained on My Honorian Buddy</li>
                        <li>Removing any copyright or other proprietary notations from the materials</li>
                        <li>Transferring the materials to another person or "mirroring" the materials on any other server</li>
                        <li>Engaging in any automated data harvesting or scraping of the Service</li>
                    </ul>
                </section>

                <!-- User Accounts -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">3. User Accounts</h2>
                    <p class="text-gray-700 leading-relaxed mb-4 text-base">
                        When you create an account with My Honorian Buddy, you must provide accurate, complete, and current information. You are responsible for safeguarding the password and for all activities that occur under your account. You must notify us immediately of any unauthorized use of your account. We reserve the right to refuse service or terminate accounts at any time at our sole discretion.
                    </p>
                </section>

                <!-- User Responsibilities -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">4. User Responsibilities</h2>
                    <p class="text-gray-700 leading-relaxed mb-4 text-base">
                        You agree that you will not:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 ml-6 mb-4">
                        <li>Violate any applicable laws or regulations</li>
                        <li>Infringe on any intellectual property rights</li>
                        <li>Harass, abuse, defame, or threaten other users</li>
                        <li>Post offensive, explicit, or inappropriate content</li>
                        <li>Attempt to gain unauthorized access to the Service</li>
                        <li>Use the Service for any illegal or unethical purposes</li>
                        <li>Create multiple accounts to circumvent restrictions or penalties</li>
                    </ul>
                </section>

                <!-- Booking and Session Terms -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">5. Booking and Session Terms</h2>
                    <p class="text-gray-700 leading-relaxed mb-4 text-base">
                        By booking a session with a buddy through our platform:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 ml-6 mb-4">
                        <li>You agree to honor confirmed bookings and sessions</li>
                        <li>Cancellations must be made with appropriate notice as per our cancellation policy</li>
                        <li>The Company acts as a facilitator only and is not responsible for session outcomes</li>
                        <li>All session details must comply with our Community Guidelines</li>
                    </ul>
                </section>

                <!-- Governing Law -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">6. Governing Law</h2>
                    <p class="text-gray-700 leading-relaxed mb-4 text-base">
                        These terms and conditions are governed by and construed in accordance with the laws of the jurisdiction in which the Company is located, and you irrevocably submit to the exclusive jurisdiction of the courts in that location.
                    </p>
                </section>

                <!-- Links -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">7. Links</h2>
                    <p class="text-gray-700 leading-relaxed mb-4 text-base">
                        My Honorian Buddy has not reviewed all of the sites linked to its website and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by My Honorian Buddy of the site. Use of any such linked website is at the user's own risk.
                    </p>
                </section>

                <!-- Modifications -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">8. Modifications</h2>
                    <p class="text-gray-700 leading-relaxed mb-4 text-base">
                        My Honorian Buddy may revise these terms of service for its website at any time without notice. By using this website, you are agreeing to be bound by the then current version of these terms of service.
                    </p>
                </section>
            </div>

            <!-- Privacy Policy Tab Content -->
            <div id="privacy-content" class="tab-content hidden">
                <!-- Introduction -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">1. Introduction</h2>
                    <p class="text-gray-700 leading-relaxed mb-4 text-base">
                        This page informs you of our policies regarding the collection, use, and disclosure of personal data when you use our Service and the choices you have associated with that data.
                    </p>
                    <p class="text-gray-700 leading-relaxed text-base">
                        We use your data to provide and improve the Service. By using the Service, you agree to the collection and use of information in accordance with this policy.
                    </p>
                </section>

                <!-- Definitions -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">2. Definitions</h2>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 ml-6">
                        <li><strong>Personal Data:</strong> Any information relating to an identified or identifiable natural person</li>
                        <li><strong>Service Provider:</strong> Any natural or legal person who processes data on behalf of the Company</li>
                    </ul>
                </section>

                <!-- Information Collection -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">3. Information Collection and Use</h2>
                    <h3 class="text-xl font-semibold text-primary mt-6 mb-3">3.1 Personal Data Collected:</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 ml-6 mb-4">
                        <li>Email address, name, phone number</li>
                        <li>Profile picture and bio</li>
                        <li>Calendar and scheduling information</li>
                        <li>Session booking history and preferences</li>
                    </ul>
                </section>

                <!-- Use of Data -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">4. Use of Data</h2>
                    <p class="text-gray-700 leading-relaxed mb-4 text-base">We use your data to:</p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 ml-6">
                        <li>Provide and maintain the Service</li>
                        <li>Process payments and bookings</li>
                        <li>Send notifications and updates</li>
                        <li>Improve our Service and user experience</li>
                        <li>Detect and prevent security issues</li>
                    </ul>
                </section>

                <!-- Security -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">5. Security of Data</h2>
                    <p class="text-gray-700 leading-relaxed mb-4 text-base">
                        We implement SSL/TLS encryption, secure password hashing, regular security audits, and access controls to protect your data. However, no method of transmission over the Internet is 100% secure.
                    </p>
                </section>

                <!-- Your Rights -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">6. Your Rights</h2>
                    <p class="text-gray-700 leading-relaxed mb-4 text-base">You have the right to:</p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 ml-6">
                        <li>Access your personal data</li>
                        <li>Request correction of inaccurate data</li>
                        <li>Request deletion of your data</li>
                        <li>Withdraw consent for data processing</li>
                        <li>Request data portability</li>
                    </ul>
                </section>

                <!-- Contact -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-4 font-poppins">7. Contact Us</h2>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p class="text-gray-700"><strong>Email:</strong> romansmalakas4@gmail.com</p>
                        <p class="text-gray-700"><strong>Support:</strong> romansmalakas4@gmail.com</p>
                    </div>
                </section>
            </div>
        </div>

            <!-- Agreement Form -->
            <form method="POST" action="{{ route('terms.accept') }}" class="space-y-6">
                @csrf
                
                <!-- Agreement Radio Button -->
                <div class="flex items-start gap-3 p-4 bg-gray-50 border-2 border-gray-300 rounded-lg hover:border-primary transition-colors">
                    <input type="radio" 
                           id="agree" 
                           name="agree" 
                           value="1" 
                           required
                           class="mt-1 w-5 h-5 text-primary focus:ring-primary cursor-pointer">
                    <label for="agree" class="flex-1 text-base font-medium text-gray-800 cursor-pointer">
                        I have read and agree to the 
                        Terms and Conditions 
                        and 
                        Privacy Policy
                    </label>
                </div>

                @error('agree')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror

                <!-- Next Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-8 py-3 bg-primary text-white font-bold text-lg rounded-sm shadow-lg hover:bg-hover transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        Next →
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-primary', 'text-primary');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.add('active', 'border-primary', 'text-primary');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
}
</script>
</body>
</html>
