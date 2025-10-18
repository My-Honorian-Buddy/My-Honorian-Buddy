@props(['height'])

<div class="flex flex-col justify-center items-center md:flex-row h-full rounded-[16px] overflow-hidden w-[95%] sm:w-[90%] md:w-4/5 my-8 md:my-24 mx-auto">
  <div class="flex flex-col justify-center gap-0 w-full h-full shadow-md rounded-lg relative">

      <!-- Main content area -->
      <div {{ $attributes->class(['flex flex-col rounded-r-[16px]']) }}>
        <div class="flex items-center justify-center px-4 md:pl-[20px] bg-primary/90 h-1/4 border-primary/90 border rounded-t-[16px]">
          <x-header class="p-4 md:p-10">
            {{ $header }}
          </x-header>
        </div>
        <div class="font-poppins bg-secondary w-full h-3/4 border-2 border-t-0 rounded-b-[16px] border-primary/90 py-4 md:py-0">
          {{ $content }}
        </div>
      </div>
  </div>
</div>
