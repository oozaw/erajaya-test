<div id="hs-application-sidebar"
   class="hs-overlay  [--auto-close:lg]
    hs-overlay-open:translate-x-0
    -translate-x-full transition-all duration-300 transform
    w-[260px] h-full
    hidden
    fixed inset-y-0 start-0 z-[60]
    bg-white border-e border-gray-200
    lg:block lg:translate-x-0 lg:end-auto lg:bottom-0
   "
   role="dialog" tabindex="-1" aria-label="Sidebar">
   <div class="relative flex flex-col h-full max-h-full">
      <div class="px-2 pt-4">
         <!-- Logo -->
         <a class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-none focus:opacity-80"
            href="#" aria-label="Erajaya">
            <img class="h-16" src="{{ asset('images/Logo_Erajaya.png') }}" alt="Logo">
         </a>
         <!-- End Logo -->
      </div>

      <!-- Content -->
      <div
         class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
         <nav class="hs-accordion-group p-3 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
            <ul class="flex flex-col space-y-1">
               <li>
                  <a class="flex items-center gap-x-3.5 py-2 px-2.5 bg-gray-100 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                     href="#">
                     <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                     </svg>
                     Dashboard
                  </a>
               </li>
            </ul>
         </nav>
      </div>
      <!-- End Content -->
   </div>
</div>
