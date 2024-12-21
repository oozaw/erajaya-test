<div class="flex flex-col bg-white border shadow-sm rounded-xl">
   <div class="p-4 md:p-5">
      <div class="flex items-center gap-x-2">
         <p class="text-xs uppercase tracking-wide text-gray-500">
            {{ $title }}
         </p>
         @if (isset($tooltip))
            <div class="hs-tooltip cursor-pointer">
               <div class="hs-tooltip-toggle">
                  <svg class="shrink-0 size-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24"
                     height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                     <circle cx="12" cy="12" r="10" />
                     <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                     <path d="M12 17h.01" />
                  </svg>
                  <span
                     class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                     role="tooltip">
                     {{ $tooltip }}
                  </span>
               </div>
            </div>
         @endif
      </div>

      <div class="mt-1 flex items-center gap-x-2">
         <h3 class="text-xl sm:text-2xl font-medium text-gray-800">
            {{ $value ?? 0 }}
         </h3>
         @if (isset($percentage))
            <span class="flex items-center gap-x-1 {{ $percentage > 0 ? 'text-green-600' : 'text-red-600' }}">
               <svg class="inline-block size-4 self-center" xmlns="http://www.w3.org/2000/svg" width="24"
                  height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="22 7 13.5 15.5 8.5 10.5 2 17" />
                  <polyline points="16 7 22 7 22 13" />
               </svg>
               <span class="inline-block text-sm">
                  {{ $percentage }}%
               </span>
            </span>
         @endif
      </div>
   </div>
</div>
