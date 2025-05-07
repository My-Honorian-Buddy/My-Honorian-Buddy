@props(['height'])

<div class="flex flex-col justify-center items-center md:flex-row h-full rounded-lg w-4/5 my-24 mx-auto">
  <div class=" flex flex-col justify-center gap-0 w-full h-full border-black rounded-lg relative">

      <!-- Tabs -->
      <div class="flex w-full">
        <div class="bg-primary w-[235px] h-[40px] rounded-t-[16px] mr-[-100px] border-4 border-black border-b-0 z-30"></div>
        <div class="bg-gray-300 w-[235px] h-[40px] rounded-t-[16px] mr-[-100px] border-4 border-black border-b-0 z-10"></div>
        <div class="bg-gray-200 w-[235px] h-[40px] rounded-t-[16px] border-4 border-black border-b-0 z-0"></div>
      </div>

      <!-- Main content area -->
      <div {{ $attributes->class(['flex flex-col rounded-r-[16px]']) }}>
        <div class="flex items-center pl-[20px] text-stroke-thick bg-primary h-1/4 border-black border-4 border-t-0 rounded-tr-[16px]">
          <x-header class="p-10">
            {{ $header }}
          </x-header>
        </div>
        <div class="font-poppins bg-secondary w-full h-3/4 border-4 border-t-0 rounded-b-[16px] border-black b-8">
          {{ $content }}
        </div>
      </div>
  </div>
</div>
