@foreach ($periods as $period)
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
   </tr>
@endforeach
