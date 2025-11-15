<aside class="w-60 h-screen bg-white border-r border-gray-200 flex flex-col justify-between fixed left-0 top-0">
    <div>
        <div class="p-6 font-bold text-sm text-blue-700">
            <span class="block text-xs">JAGA WARGA</span>
            <span class="text-gray-500 text-xs">ADMIN</span>
        </div>

        <nav class="mt-6">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-2 rounded-md 
                        {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-gray-900' : 'hover:bg-gray-100 text-gray-600' }}">
                        <span class="ml-2">🏠 Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.role') }}"
                        class="flex items-center px-4 py-2 rounded-md 
                        {{ request()->routeIs('admin.role') ? 'bg-gray-100 text-gray-900' : 'hover:bg-gray-100 text-gray-600' }}
                        <span class="ml-2">🧑‍💼 Role</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.report') }}"
                        class="flex items-center px-4 py-2 rounded-md 
                        {{ request()->routeIs('admin.report') ? 'bg-gray-100 text-gray-900' : 'hover:bg-gray-100 text-gray-600' }}">
                        <span class="ml-2">📋 Form Report</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.consultation') }}"
                        class="flex items-center px-4 py-2 rounded-md 
                        {{ request()->routeIs('admin.consultation') ? 'bg-gray-100 text-gray-900' : 'hover:bg-gray-100 text-gray-600' }}">
                        <span class="ml-2">💬 Consultation</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.information') }}"
                        class="flex items-center px-4 py-2 rounded-md 
                        {{ request()->routeIs('admin.information') ? 'bg-gray-100 text-gray-900' : 'hover:bg-gray-100 text-gray-600' }}">
                        <span class="ml-2">ℹ️ Information</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="p-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-gray-500 text-sm flex items-center space-x-2 hover:text-red-600">
                <span>🚪 Log out</span>
            </button>
        </form>
    </div>
</aside>