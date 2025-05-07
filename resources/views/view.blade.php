<div class="container">
    <h2 class="text-lg font-semibold mb-4">Reviewed Tutors</h2>

    <!-- Display {success or error messages -->
    @foreach ($reviews as $review)
        <p>Tutor Name: {{$review->tutor->fname}} {{$review->tutor->lname}}</p>
        <p>Rating: {{$review->rating}}</p>
        <p>Comment: {{$review->comment}}</p>
        <p>Tutor Rating: {{$review->tutor->rating}}</p>
        <hr>
    @endforeach

    
</div>
