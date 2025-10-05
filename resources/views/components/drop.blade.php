@props(['tutor_id'])
<div class="flex items-center">

  <button class="bg-accent2 text-primary text-center font-poppins font-bold rounded-full px-5 py-3 mr-5 h-10 text-[12px] 
                border-2 border-black shadow-custom-button hover:bg-secondary hover:text-[#8B3A3A] flex items-center space-x-2" 
              onclick="showModal('reviews-and-feedback')"
              type="button"
              >
      <!--Main Content-->
      <span>REVIEW & FEEDBACK</span>
  </button>
  <x-bladewind.modal
      title="Reviews and Feedback"
      name="reviews-and-feedback"
      size="xl"
      ok_button_label=""
      cancel_button_label="">
      
      <form action="{{route('reviews.store')}}" method="post">
          @csrf
          <input type="hidden" id="tutor_id_input" name="tutor_id" value="{{$tutor_id}}">

          <div class="flex flex-col px-20"> 
              <div class="flex justify-center items-center mt-7">
                <img src="{{ asset('images/reviews.svg') }}">
              </div>

                  <!--Submit Your Feedback-->
                  <div class ="text-black font-poppins font-bold text-2xl text-center mt-4"> Submit Your Feedback </div>

                  <p class="text-black w-full text-center mt-4 text-[16px]">We value your voice! Submit your feedback to help us improve and create a better experience for everyone.</p>

                {{-- stars --}}
                <div class="flex justify-center items-center mt-4 mb-6">
                    <x-bladewind.rating
                        size="medium"
                        :rating="{{$rating}}"
                        rating="1"
                        color="yellow"
                        type="star"
                        clickable="true"/>
                  </div>

                  <div class="mb-4">
                    <textarea id="message" rows="7" class="w-full px-3 py-2 border border-black rounded-md bg-gray-300" placeholder="Type here.." name="comment"></textarea>
                  </div>

                  <div class="mt-0 w-full h-16 flex flex-col items-end">
                      <x-input-label class="invisible text-primary" for="first_name" :value="__('First Name:')" />
                      <button type="submit" class="inline-block mt-2 w-full h-full bg-accent2 text-primary rounded-md uppercase border-2 border-primary
                      hover:bg-primary hover:text-accent2 font-black">
                        SEND FEEDBACK
                      </button>
                  </div>
          </div>
      </form>
  </x-bladewind.modal>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Attach click event to all buttons inside .set-appointment-wrapper
  document.querySelectorAll('.set-appointment-wrapper').forEach(wrapper => {
      wrapper.addEventListener('click', function () {
          const userId = this.getAttribute('data-user-id');
          const tutorSubjects = JSON.parse(this.getAttribute('tutor-subjects' || '[]'));
          
          // Set the value of the hidden input in the modal
          document.getElementById('tutor_id_input').value = userId;

          const subjectContainer = document.getElementById('subject-container');
          subjectContainer.innerHTML = ''; 

          if (tutorSubjects.length > 0) {
              tutorSubjects.forEach(subject => {
                  // Create a checkbox for each subject
                  const checkbox = document.createElement('div');
                  checkbox.innerHTML = `
                      <x-bladewind.radio-button label_css="text-primary" color="black" name="subjects[]" label="${subject.subj_code} - ${subject.subj_name}" value="${subject.subj_code} - ${subject.subj_name}" />
                  `;
                  subjectContainer.appendChild(checkbox);
              });
          } else {
              subjectContainer.innerHTML = '<p>No Subjects</p>';
          }

          // Show the modal (assuming your modal logic is defined)
          showModal('set-appointment');
      });
    });
  });
</script>

        
        