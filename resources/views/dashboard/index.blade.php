@extends('layout')

@section('css')
   <style>
      .dt-layout-row:has(.dt-search),
      .dt-layout-row:has(.dt-length),
      .dt-layout-row:has(.dt-paging) {
         display: none !important;
      }
   </style>
   {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css"> --}}
@endsection

@section('content')
   <div class="pb-8">
      <div hidden>
         <button type="button" id="modal-loading-button"
            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
            aria-haspopup="dialog" aria-expanded="false" aria-controls="loading-modal" data-hs-overlay="#loading-modal">
            Open modal
         </button>
      </div>

      <div class="max-w-[85rem] px-0 py-3 mx-auto">
         <!-- Grid -->
         <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            {{-- Companies --}}
            @include('dashboard.components.stat-card', [
                'title' => 'Total Perusahaan',
                'value' => $companies->count() ?? 0,
                'tooltip' => 'Jumlah total perusahaan yang tergabung',
            ])
            {{-- End Companies --}}

            {{-- Division --}}
            @include('dashboard.components.stat-card', [
                'title' => 'Total Divisi',
                'value' => $divisions->count() ?? 0,
                'tooltip' => 'Jumlah total divisi yang dimiliki',
            ])
            {{-- End Division --}}

            {{-- Employee --}}
            @include('dashboard.components.stat-card', [
                'title' => 'Total Karyawan',
                'value' => $employees->count() ?? 0,
                'tooltip' => 'Jumlah total karyawan yang terdaftar',
            ])
            {{-- End Employee --}}

            {{-- Level --}}
            @include('dashboard.components.stat-card', [
                'title' => 'Total Jabatan',
                'value' => $levels->count() ?? 0,
                'tooltip' => 'Jumlah total jabatan yang tersedia',
            ])
            {{-- End Level --}}
         </div>
         <!-- End Grid -->
      </div>
      <!-- End Card Section -->

      <!-- Table and Chart Section -->
      <div class="max-w-[85rem] px-0 pt-4 mx-auto">
         <h2 class="text-2xl font-semibold text-gray-800 mb-4 sm:mb-6">Data Karyawan</h2>
         <!-- Filter Section -->
         <div class="flex items-center justify-between mb-4 sm:mb-6">
            <div class="flex w-full space-x-4">
               <!-- Company Filter -->
               <div class="flex-auto">
                  <label for="company-filter" class="block text-sm font-medium mb-2">Perusahaan</label>
                  <select id="company-filter" name="company"
                     class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                     <option value="">Semua Perusahaan</option>
                     @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                     @endforeach
                  </select>
               </div>

               <!-- Division Filter -->
               <div class="flex-auto">
                  <label for="division-filter" class="block text-sm font-medium mb-2">Divisi</label>
                  <select id="division-filter" name="division"
                     class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                     <option value="">Semua Divisi</option>
                     @foreach ($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                     @endforeach
                  </select>
               </div>

               <!-- Level Filter -->
               <div class="flex-auto">
                  <label for="level-filter" class="block text-sm font-medium mb-2">Jabatan</label>
                  <select id="level-filter" name="level"
                     class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                     <option value="">Semua Jabatan</option>
                     @foreach ($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->level_name }}</option>
                     @endforeach
                  </select>
               </div>

               <!-- Gender Filter -->
               <div class="flex-auto">
                  <label for="gender-filter" class="block text-sm font-medium mb-2">Jenis Kelamin</label>
                  <select id="gender-filter" name="gender"
                     class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                     <option value="">Semua Jenis Kelamin</option>
                     @foreach ($genders as $gender)
                        <option value="{{ $gender->id }}">{{ $gender->gender_name }}</option>
                     @endforeach
                  </select>
               </div>

               <!-- Period Filter -->
               <div class="flex-auto">
                  <label for="start-period-filter" class="block text-sm font-medium mb-2">Periode</label>
                  <div class="flex gap-x-2">
                     <div>
                        <select id="start-period-filter" name="start-period"
                           class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                           <option value="">Semua Periode</option>
                           @foreach ($employeePeriods as $period)
                              <option value="{{ $period['period'] }}">{{ $period['period'] }}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="flex items-center">
                        <span>
                            -
                        </span>
                     </div>
                     <div>
                        <select id="end-period-filter" name="end-period"
                           class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                           <option value="">Semua Periode</option>
                           @foreach ($employeePeriods as $period)
                              <option value="{{ $period['period'] }}">{{ $period['period'] }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>

               <!-- Button Filter -->
               <div class="flex-auto self-end">
                  <button id="filter-button"
                     class="w-full py-[12px] px-6 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:bg-blue-700 text-white font-semibold rounded-lg text-sm"
                     type="button">Filter</button>
               </div>
            </div>
         </div>
         <!-- End Filter Section -->

         <!-- Grid -->
         <div class="grid grid-cols-1 gap-4 sm:gap-6">
            <!-- Chart -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
               <div class="">
                  <div class="mb-3">
                     <h4 class="font-semibold text-lg">
                        Berdasarkan Perusahaan
                     </h4>
                  </div>
                  <div class="h-full">
                     <div id="chart" class="self-center"></div>
                  </div>
               </div>

               <div class="">
                  <div class="mb-3">
                     <h4 class="font-semibold text-lg">
                        Berdasarkan Divisi
                     </h4>
                  </div>
                  <div class="flex h-full justify-center">
                     <div id="pie-chart" class="self-center mb-14"></div>
                  </div>
               </div>
            </div>
            <!-- End Chart -->

            <!-- Table -->
            <div class="flex flex-col">
               <div id="employee-table" class="--prevent-on-load-init"
                  data-hs-datatable='{
                 "pageLength": 10,
                 "pagingOptions": {
                   "pageBtnClasses": "min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none"
                 },
                 "selecting": true,
                 "language": {
                   "zeroRecords": "<div class=\"py-10 px-5 flex flex-col justify-center items-center text-center\"><svg class=\"shrink-0 size-6 text-gray-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><circle cx=\"11\" cy=\"11\" r=\"8\"/><path d=\"M21 21l-4.3-4.3\"/></svg><div class=\"max-w-sm mx-auto\"><p class=\"mt-2 text-sm text-gray-600\">No search results</p></div></div>"
                 }
               }'>
                  <div class="py-3">
                     <div class="relative max-w-xs">
                        <label for="hs-table-input-search" class="sr-only">Search</label>
                        <input type="text" name="hs-table-search" id="hs-table-input-search"
                           class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                           placeholder="Search for items" data-hs-datatable-search="">
                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                           <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24"
                              height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round">
                              <circle cx="11" cy="11" r="8"></circle>
                              <path d="m21 21-4.3-4.3"></path>
                           </svg>
                        </div>
                     </div>
                  </div>

                  <div class="min-h-[521px] overflow-x-auto">
                     <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                           <table class="min-w-full">
                              <thead class="border-y border-gray-200">
                                 <tr>
                                    <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                                       <div
                                          class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200">
                                          No
                                          <svg class="size-3.5 ms-1 -me-0.5 text-gray-400"
                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                             <path class="hs-datatable-ordering-desc:text-blue-600" d="m7 15 5 5 5-5">
                                             </path>
                                             <path class="hs-datatable-ordering-asc:text-blue-600" d="m7 9 5-5 5 5">
                                             </path>
                                          </svg>
                                       </div>
                                    </th>

                                    <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                                       <div
                                          class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200">
                                          Nama
                                          <svg class="size-3.5 ms-1 -me-0.5 text-gray-400"
                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                             <path class="hs-datatable-ordering-desc:text-blue-600" d="m7 15 5 5 5-5">
                                             </path>
                                             <path class="hs-datatable-ordering-asc:text-blue-600" d="m7 9 5-5 5 5">
                                             </path>
                                          </svg>
                                       </div>
                                    </th>

                                    <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                                       <div
                                          class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200">
                                          Jabatan
                                          <svg class="size-3.5 ms-1 -me-0.5 text-gray-400"
                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                             <path class="hs-datatable-ordering-desc:text-blue-600" d="m7 15 5 5 5-5">
                                             </path>
                                             <path class="hs-datatable-ordering-asc:text-blue-600" d="m7 9 5-5 5 5">
                                             </path>
                                          </svg>
                                       </div>
                                    </th>

                                    <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                                       <div
                                          class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200">
                                          Divisi
                                          <svg class="size-3.5 ms-1 -me-0.5 text-gray-400"
                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                             <path class="hs-datatable-ordering-desc:text-blue-600" d="m7 15 5 5 5-5">
                                             </path>
                                             <path class="hs-datatable-ordering-asc:text-blue-600" d="m7 9 5-5 5 5">
                                             </path>
                                          </svg>
                                       </div>
                                    </th>

                                    <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                                       <div
                                          class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200">
                                          Perusahaan
                                          <svg class="size-3.5 ms-1 -me-0.5 text-gray-400"
                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                             <path class="hs-datatable-ordering-desc:text-blue-600" d="m7 15 5 5 5-5">
                                             </path>
                                             <path class="hs-datatable-ordering-asc:text-blue-600" d="m7 9 5-5 5 5">
                                             </path>
                                          </svg>
                                       </div>
                                    </th>

                                    <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                                       <div
                                          class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200">
                                          Periode
                                          <svg class="size-3.5 ms-1 -me-0.5 text-gray-400"
                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                             <path class="hs-datatable-ordering-desc:text-blue-600" d="m7 15 5 5 5-5">
                                             </path>
                                             <path class="hs-datatable-ordering-asc:text-blue-600" d="m7 9 5-5 5 5">
                                             </path>
                                          </svg>
                                       </div>
                                    </th>

                                    <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                                       <div
                                          class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200">
                                          Jenis Kelamin
                                          <svg class="size-3.5 ms-1 -me-0.5 text-gray-400"
                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                             <path class="hs-datatable-ordering-desc:text-blue-600" d="m7 15 5 5 5-5">
                                             </path>
                                             <path class="hs-datatable-ordering-asc:text-blue-600" d="m7 9 5-5 5 5">
                                             </path>
                                          </svg>
                                       </div>
                                    </th>
                                 </tr>
                              </thead>

                              <tbody id="employee-table-body" class="divide-y divide-gray-200">
                                 {{-- @foreach ($periods as $period)
                                    <tr>
                                       <td class="p-3 whitespace-nowrap text-sm text-gray-800">{{ ++$loop->index }}</td>
                                       <td class="p-3 whitespace-nowrap text-sm font-medium text-gray-800">
                                          {{ $period->employee->employee_name }}
                                       </td>
                                       <td class="p-3 whitespace-nowrap text-sm text-gray-800">
                                          {{ $period->level->level_name }}</td>
                                       <td class="p-3 whitespace-nowrap text-sm text-gray-800">
                                          {{ $period->division->division_name }}</td>
                                       <td class="p-3 whitespace-nowrap text-sm text-gray-800">
                                          {{ $period->company->company_name }}</td>
                                       <td class="p-3 whitespace-nowrap text-sm text-gray-800">{{ $period->period }}</td>
                                       <td class="p-3 whitespace-nowrap text-sm text-gray-800">
                                          {{ $period->gender?->gender_name }}</td>
                                       <td class="p-3 whitespace-nowrap text-end text-sm font-medium">
                                          <button type="button"
                                             class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Delete</button>
                                       </td>
                                    </tr>
                                 @endforeach --}}
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="py-1 px-4 hidden" data-hs-datatable-paging="">
                     <nav class="flex items-center space-x-1">
                        <button type="button"
                           class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                           data-hs-datatable-paging-prev="">
                           <span aria-hidden="true">«</span>
                           <span class="sr-only">Previous</span>
                        </button>
                        <div class="flex items-center space-x-1 [&>.active]:bg-gray-100"
                           data-hs-datatable-paging-pages="">
                        </div>
                        <button type="button"
                           class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                           data-hs-datatable-paging-next="">
                           <span class="sr-only">Next</span>
                           <span aria-hidden="true">»</span>
                        </button>
                     </nav>
                  </div>
               </div>
            </div>
            <!-- End Table -->
         </div>
      </div>
   </div>
@endsection

@section('modal')
   <div id="loading-modal"
      class="hs-overlay [--overlay-backdrop:static] hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
      role="dialog" tabindex="-1" aria-labelledby="loading-modal-label" data-hs-overlay-keyboard="false">
      <div
         class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
         <div class="w-full flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto">
            <div class="p-6 overflow-y-auto text-center">
               <div hidden>
                  <button type="button" id="modal-loading-close-button"
                     class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                     aria-label="Close" data-hs-overlay="#loading-modal" hidden>
                     <span class="sr-only">Close</span>
                     <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                     </svg>
                  </button>
               </div>
               <div
                  class="mb-4 animate-spin inline-block size-10 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"
                  role="status" aria-label="loading">
                  <span class="sr-only">Loading...</span>
               </div>
               <p class="mt-1 text-gray-800 font-semibold text-xl">
                  Sedang memuat data...
               </p>
            </div>
         </div>
      </div>
   </div>

   <div id="hs-vertically-centered-modal"
      class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
      role="dialog" tabindex="-1" aria-labelledby="hs-vertically-centered-modal-label">
      <div
         class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
         <div class="w-full flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto">
            <div class="flex justify-between items-center py-3 px-4 border-b">
               <h3 id="hs-vertically-centered-modal-label" class="font-bold text-gray-800">
                  Modal title
               </h3>
               <button type="button"
                  class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                  aria-label="Close" data-hs-overlay="#hs-vertically-centered-modal">
                  <span class="sr-only">Close</span>
                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                     <path d="M18 6 6 18"></path>
                     <path d="m6 6 12 12"></path>
                  </svg>
               </button>
            </div>
            <div class="p-4 overflow-y-auto">
               <p class="text-gray-800">
                  This is a wider card with supporting text below as a natural lead-in to additional content.
               </p>
            </div>
            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
               <button type="button"
                  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                  data-hs-overlay="#hs-vertically-centered-modal">
                  Close
               </button>
               <button type="button"
                  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                  Save changes
               </button>
            </div>
         </div>
      </div>
   </div>
@endsection

@section('js')
   <script>
      let gDataTable = null;
      let employees = [];
      let chartData = [];
      let tableBodyEl = document.getElementById('employee-table-body');
      let tableBodyHtml = '';

      let stackChart = null;
      let pieChart = null;

      function getData() {
         $("#modal-loading-button").click();
         $("#filter-button").prop('disabled', true);

         const params = {
            company: $('#company-filter').val(),
            division: $('#division-filter').val(),
            level: $('#level-filter').val(),
            period: {
                start: $('#start-period-filter').val(),
                end: $('#end-period-filter').val(),
            },
            gender: $('#gender-filter').val(),
         }

         $.ajax({
            url: @json(route('dashboard.getEmployeeData')),
            data: params,
            method: 'GET',
            success: function(data) {
               employees = data.employees;
               chartData = data.chart_data;
               tableBodyHtml = data.view_body;

               initDataTable();
               initStackedChart();
               initPieChart();
            },
            error: function(xhr, status, error) {
               console.error('Error fetching data:', error);
            },
            complete: function() {
               $("#modal-loading-close-button").click();
                $("#filter-button").prop('disabled', false);
            }
         });
      }

      function initDataTable() {
         // destroy if gDataTable already exists
         if (gDataTable) {
            gDataTable.destroy();
         }

         $("#hs-table-input-search").val('');

         // append data to table
         tableBodyEl.innerHTML = tableBodyHtml;

         const {
            dataTable
         } = new HSDataTable('#employee-table');
         gDataTable = dataTable;
      }

      function initStackedChart() {
         if (stackChart) {
            stackChart.destroy();
         }

         var options = {
            series: chartData.employee_stacked.series,
            chart: {
               type: 'bar',
               height: 350,
               stacked: true,
               toolbar: {
                  show: true
               },
               zoom: {
                  enabled: false
               }
            },
            responsive: [{
               breakpoint: 480,
               options: {
                  legend: {
                     position: 'bottom',
                     offsetX: -10,
                     offsetY: 0
                  }
               }
            }],
            plotOptions: {
               bar: {
                  horizontal: false,
                  borderRadius: 10,
                  borderRadiusApplication: 'end',
                  borderRadiusWhenStacked: 'last',
                  dataLabels: {
                     total: {
                        enabled: true,
                        style: {
                           fontSize: '13px',
                           fontWeight: 900
                        }
                     }
                  }
               },
            },
            xaxis: {
               categories: chartData.employee_stacked.categories,
            },
            fill: {
               opacity: 1
            }
         };

         var chart = new ApexCharts(document.querySelector("#chart"), options);
         chart.render();

         stackChart = chart;
      }

      function initPieChart() {
         if (pieChart) {
            pieChart.destroy();
         }

         var options = {
            series: chartData.division_pie.series,
            chart: {
               width: 380,
               type: 'pie',
            },
            labels: chartData.division_pie.labels,
            responsive: [{
               breakpoint: 480,
               options: {
                  chart: {
                     width: 200
                  },
                  legend: {
                     position: 'bottom'
                  }
               }
            }]
         };

         var chart = new ApexCharts(document.querySelector("#pie-chart"), options);
         chart.render();

         pieChart = chart;
      }

      function checkPeriodFilter(isInit = false) {
         const startPeriod = $('#start-period-filter').val();
         const endPeriodEl = $('#end-period-filter');

         if (startPeriod == '') {
            endPeriodEl.find('option').prop('disabled', false);
            endPeriodEl.val('');
            return;
         }

         endPeriodEl.find('option').each(function() {
            if ($(this).val() < startPeriod) {
               $(this).prop('disabled', true);
            } else {
               $(this).prop('disabled', false);
            }

            if ($(this).val() == startPeriod && (endPeriodEl.val() == '' || startPeriod > endPeriodEl.val())) {
               $(this).prop('selected', true);
            }
         });
      }

      $(document).ready(function() {
         getData();
         checkPeriodFilter(true);

         $("#filter-button").click(function() {
            getData();
         });

         $("#start-period-filter").change(function() {
            checkPeriodFilter();
         })
      });
   </script>
@endsection
