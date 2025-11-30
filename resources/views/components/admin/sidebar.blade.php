<style>
    @font-face {
        font-family: 'Agrandir';
        src: url('https://muabtceunyjvfxfkclzs.supabase.co/storage/v1/object/public/fonts/Agrandir-Regular.otf') format('opentype');
        font-weight: normal;
        font-style: normal;
    }
    .font-agrandir {
        font-family: 'Agrandir', sans-serif;
    }
</style>

<aside class="w-64 h-screen bg-white border-r border-gray-200 flex flex-col justify-between fixed left-0 top-0 font-agrandir z-50">
    
    <div class="px-6 py-8">
        <img src="https://muabtceunyjvfxfkclzs.supabase.co/storage/v1/object/public/images/a-logojw-admin.png" 
             alt="Jaga Warga Admin" 
             class="h-8 w-auto object-contain">
    </div>

    <nav class="flex-1 px-4 overflow-y-auto">
        <ul class="space-y-2">
            
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors group
                   {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-custom-blue font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <img src="https://muabtceunyjvfxfkclzs.supabase.co/storage/v1/object/public/images/a-dashboard.png" 
                         class="w-5 h-5 object-contain mr-3 opacity-80 group-hover:opacity-100" alt="Icon">
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.role') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors group
                   {{ request()->routeIs('admin.role') ? 'bg-gray-100 text-custom-blue font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <img src="https://muabtceunyjvfxfkclzs.supabase.co/storage/v1/object/public/images/a-role.png" 
                         class="w-5 h-5 object-contain mr-3 opacity-80 group-hover:opacity-100" alt="Icon">
                    <span>Role</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.report') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors group
                   {{ request()->routeIs('admin.report') ? 'bg-gray-100 text-custom-blue font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <img src="https://muabtceunyjvfxfkclzs.supabase.co/storage/v1/object/public/images/a-form-report.png" 
                         class="w-5 h-5 object-contain mr-3 opacity-80 group-hover:opacity-100" alt="Icon">
                    <span>Form Report</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.consultation') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors group
                   {{ request()->routeIs('admin.consultation') ? 'bg-gray-100 text-custom-blue font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <img src="https://muabtceunyjvfxfkclzs.supabase.co/storage/v1/object/public/images/a-consultation.png" 
                         class="w-5 h-5 object-contain mr-3 opacity-80 group-hover:opacity-100" alt="Icon">
                    <span>Consultation</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.information') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors group
                   {{ request()->routeIs('admin.information') ? 'bg-gray-100 text-custom-blue font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    {{-- Saya asumsikan nama filenya a-information.png sesuai pola --}}
                    <img src="https://muabtceunyjvfxfkclzs.supabase.co/storage/v1/object/public/images/a-information.png" 
                         class="w-5 h-5 object-contain mr-3 opacity-80 group-hover:opacity-100" alt="Icon">
                    <span>Information</span>
                </a>
            </li>

        </ul>
    </nav>

    <div class="p-6 border-t border-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors group">
                <img src="https://muabtceunyjvfxfkclzs.supabase.co/storage/v1/object/public/images/a-logout.png" 
                     class="w-5 h-5 object-contain mr-3 opacity-80 group-hover:opacity-100" alt="Icon">
                <span class="font-medium">Log out</span>
            </button>
        </form>
    </div>

</aside>