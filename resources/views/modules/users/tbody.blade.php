 @foreach ($items as $item)
     <tr class="text-center">
         <td>{{ $item->email }}</td>
         <td>{{ $item->name }}</td>
         <td> {{ $item->role }}</td>
         <td>
             <a href="#" onclick="add_id_user({{ $item->id }})" class="btn btn-secondary" data-bs-toggle="modal"
                 data-bs-target="#update_password">
                 <i class="fa-solid fa-user-lock"></i></a>
         </td>
         <td class="text-center">
             <!-- $item->active -->
             <div class="form-check form-switch d-flex justify-content-center">
                 <input class="form-check-input" type="checkbox" id="{{ $item->id }}"
                     {{ $item->active ? 'checked' : '' }}>
             </div>
         </td>
         <td>
             <a href="{{ route('users.edit', $item->id) }}" class="btn btn-warning"><i
                     class="fa-solid fa-user-pen"></i></a>
         </td>
     </tr>
 @endforeach
