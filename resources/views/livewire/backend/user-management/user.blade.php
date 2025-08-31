 <section>
     <div class="glass-card rounded-2xl p-6 mb-6">
         <div class="flex items-center justify-between">
             <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Admin List') }}</h2>
             <div class="flex items-center gap-2">
                 <x-button href="#" icon="trash-2" type='secondary' permission="admin-trash">
                     {{ __('Trash') }}
                 </x-button>
                 <x-button href="#" icon="plus" permission="admin-create">
                     {{ __('Add') }}
                 </x-button>
             </div>
         </div>
     </div>
     <div class="glass-card rounded-2xl p-6">
         <table class="table datatable table-zebra">
             <thead>
                 <tr>
                     <th width="5%">{{ __('SL') }}</th>
                     <th>{{ __('Name') }}</th>
                     <th>{{ __('Email') }}</th>
                     <th>{{ __('Role') }}</th>
                     <th>{{ __('Verified') }}</th>
                     <th>{{ __('Created By') }}</th>
                     <th>{{ __('Created Date') }}</th>
                     <th width="10%">{{ __('Action') }}</th>
                 </tr>
             </thead>
             <tbody>
             </tbody>
         </table>
     </div>
 </section>
