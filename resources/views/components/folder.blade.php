@props(['height'])

<div class="overflow-hidden flex flex-col lg:flex-row bg-accent rounded-md w-full max-w-7xl mx-auto">
  <div class=" flex flex-col justify-center gap-0 w-full h-full rounded-lg relative">

      <!-- Main content area -->
      <div {{ $attributes->class(['flex flex-col rounded-r-md']) }}>
        <div class=" flex items-center justify-center pl-[20px] bg-primary/90 h-1/4 border-charcoal border-4 rounded-t-md">
          <x-header class="font-dela p-10">
            {{ $header }}
          </x-header>
        </div>
        <div class="font-poppins bg-accent w-full h-3/4 border-4  border-t-0 rounded-b-md border-charcoal">
          {{ $content }}
        </div>
      </div>
  </div>
</div>
