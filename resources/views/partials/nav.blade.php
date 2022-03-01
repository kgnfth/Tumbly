<nav x-data="{ open: false }" class="bg-gray-800 shadow-md">
    <div class="max-w-full px-2 mx-auto sm:px-6 lg:px-16">
      <div class="relative flex justify-between h-16">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
            <!-- Mobile menu button -->
            <button type="button" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                <span class="sr-only">Open main menu</span>
                <svg x-description="Icon when menu is closed. Heroicon name: outline/menu" x-state:on="Menu open" x-state:off="Menu closed" class="block w-6 h-6" :class="{ 'hidden': open, 'block': !(open) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-description="Icon when menu is open. Heroicon name: outline/x" x-state:on="Menu open" x-state:off="Menu closed" class="hidden w-6 h-6" :class="{ 'block': open, 'hidden': !(open) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex items-center justify-center flex-1 sm:items-stretch sm:justify-start">
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('home') }}" class="inline-block pt-1 pb-1 mr-6 text-xl text-gray-300 whitespace-no-wrap hover:text-white">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                <!-- Current: "border-indigo-500 text-gray-900", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
                <a href="{{ route('blog', $tumblr->getUserInfo()->user->name) }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-300 border-b-2 border-indigo-500 hover:text-white">My Blog</a>
            </div>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            <!-- Profile dropdown -->
            <div x-data="Components.menu({ open: false })" x-init="init()" @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="relative ml-3">
                <div>
                <button type="button" class="flex text-sm text-gray-300 hover:text-white" id="user-menu-button" x-ref="button" @click="onButtonClick()" @keyup.space.prevent="onButtonEnter()" @keydown.enter.prevent="onButtonEnter()" aria-expanded="false" aria-haspopup="true" x-bind:aria-expanded="open.toString()" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()">
                    <span class="sr-only">Open user menu</span>
                    {{ $tumblr->getUserInfo()->user->name }}
                </a>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-gray-800 rounded-md shadow-lg ring-1 ring-white ring-opacity-5 focus:outline-none" x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state." x-bind:aria-activedescendant="activeDescendant" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()" @keydown.tab="open = false" @keydown.enter.prevent="open = false; focusButton()" @keyup.space.prevent="open = false; focusButton()" style="display: none;">
                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white" :class="{ 'bg-gray-700': activeIndex === 2 }" role="menuitem" tabindex="-1" id="user-menu-item-2" @mouseenter="activeIndex = 2" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">Sign out</a>
                </div>
            </div>
        </div>
      </div>
    </div>
    <div x-description="Mobile menu, show/hide based on menu state." class="sm:hidden" id="mobile-menu" x-show="open" style="display: none;">
        <div class="pt-2 pb-4 space-y-1">
            <!-- Current: "bg-indigo-50 border-indigo-500 text-indigo-700", Default: "border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700" -->
            <a href="{{ route('blog', $tumblr->getUserInfo()->user->name) }}" class="block py-2 pl-3 pr-4 text-base font-medium text-indigo-700 border-l-4 border-indigo-500 bg-indigo-50">My Blog</a>
        </div>
    </div>
  </nav>